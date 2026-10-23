-- Google Business Profile scheduled posts (admin panel → GMB Posts).
-- Run this once in the Supabase SQL Editor.

create table if not exists public.gmb_posts (
  id uuid not null default gen_random_uuid(),
  "PostDate" date not null,
  "TimeSchedule" text not null,
  "Title" text not null,
  "Caption" text not null,
  "ImageURL" text not null,
  "CTAUrl" text not null,
  "Location" text not null default 'Ballygunge',
  "Status" text not null default 'Scheduled',
  "PostedAt" timestamp with time zone null,
  created_at timestamp with time zone not null default now(),
  updated_at timestamp with time zone not null default now(),
  constraint gmb_posts_pkey primary key (id),
  constraint gmb_posts_time_check check ("TimeSchedule" in ('10:00', '18:00')),
  constraint gmb_posts_caption_check check (char_length("Caption") <= 250),
  constraint gmb_posts_location_check check ("Location" in ('Ballygunge')),
  constraint gmb_posts_cta_check check ("CTAUrl" ~* '^https://')
);

create or replace function public.set_updated_at()
returns trigger
language plpgsql
set search_path = public
as $$
begin
  new.updated_at = now();
  return new;
end;
$$;

drop trigger if exists gmb_posts_set_updated_at on public.gmb_posts;
create trigger gmb_posts_set_updated_at
  before update on public.gmb_posts
  for each row execute function public.set_updated_at();

alter table public.gmb_posts enable row level security;

drop policy if exists "gmb posts authenticated can read" on public.gmb_posts;
drop policy if exists "gmb posts authenticated can insert" on public.gmb_posts;
drop policy if exists "gmb posts authenticated can update" on public.gmb_posts;
drop policy if exists "gmb posts authenticated can delete" on public.gmb_posts;

create policy "gmb posts authenticated can read"
  on public.gmb_posts for select to authenticated using (true);

create policy "gmb posts authenticated can insert"
  on public.gmb_posts for insert to authenticated with check (true);

create policy "gmb posts authenticated can update"
  on public.gmb_posts for update to authenticated using (true) with check (true);

create policy "gmb posts authenticated can delete"
  on public.gmb_posts for delete to authenticated using (true);

grant select, insert, update, delete on public.gmb_posts to authenticated;

-- Public bucket so Google / Make.com can fetch the JPG by URL.
insert into storage.buckets (id, name, public, file_size_limit, allowed_mime_types)
values ('gmb-posts', 'gmb-posts', true, 5242880, array['image/jpeg'])
on conflict (id) do update
  set public = true,
      file_size_limit = 5242880,
      allowed_mime_types = array['image/jpeg'];

drop policy if exists "gmb images authenticated can upload" on storage.objects;
drop policy if exists "gmb images authenticated can delete" on storage.objects;

create policy "gmb images authenticated can upload"
  on storage.objects for insert to authenticated
  with check (bucket_id = 'gmb-posts');

create policy "gmb images authenticated can delete"
  on storage.objects for delete to authenticated
  using (bucket_id = 'gmb-posts');

notify pgrst, 'reload schema';
