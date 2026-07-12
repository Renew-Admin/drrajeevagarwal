-- Dr. Rajeev Agarwal website: Supabase Auth admin, blogs, leads, and blog images.
-- Run this in Supabase SQL Editor for project etwprdlmxirnuejxxuif.
--
-- Admin login rule:
--   Any confirmed user created in Supabase Dashboard -> Authentication -> Users
--   can log in at /admin and manage blogs/leads.

create extension if not exists pgcrypto;

create or replace function public.set_updated_at()
returns trigger
language plpgsql
as $$
begin
  new.updated_at = now();
  return new;
end;
$$;

grant execute on function public.submit_mian_website_lead(jsonb) to anon, authenticated;

-- ---------------------------------------------------------------------------
-- BLOGS
-- ---------------------------------------------------------------------------
create table if not exists public.blogs (
  id uuid primary key default gen_random_uuid(),
  slug text not null unique,
  title text not null,
  category text not null default 'Fertility Care',
  excerpt text not null default '',
  content text not null default '',
  cover_image text not null default '',
  read_mins integer not null default 2,
  tags text[] not null default '{}',
  published boolean not null default true,
  is_featured boolean not null default false,
  published_at timestamptz not null default now(),
  created_by uuid references auth.users(id) on delete set null default auth.uid(),
  created_at timestamptz not null default now(),
  updated_at timestamptz not null default now(),
  constraint blogs_slug_clean check (slug ~ '^[a-z0-9]+(?:-[a-z0-9]+)*$'),
  constraint blogs_read_mins_range check (read_mins between 1 and 60)
);

alter table public.blogs add column if not exists category text not null default 'Fertility Care';
alter table public.blogs add column if not exists excerpt text not null default '';
alter table public.blogs add column if not exists content text not null default '';
alter table public.blogs add column if not exists cover_image text not null default '';
alter table public.blogs add column if not exists read_mins integer not null default 2;
alter table public.blogs add column if not exists tags text[] not null default '{}';
alter table public.blogs add column if not exists published boolean not null default true;
alter table public.blogs add column if not exists is_featured boolean not null default false;
alter table public.blogs add column if not exists published_at timestamptz not null default now();
alter table public.blogs add column if not exists created_by uuid references auth.users(id) on delete set null default auth.uid();
alter table public.blogs add column if not exists created_at timestamptz not null default now();
alter table public.blogs add column if not exists updated_at timestamptz not null default now();

create index if not exists blogs_published_idx on public.blogs (published, published_at desc);
create index if not exists blogs_featured_idx on public.blogs (is_featured, published_at desc);
create index if not exists blogs_slug_idx on public.blogs (slug);

drop trigger if exists blogs_set_updated_at on public.blogs;
create trigger blogs_set_updated_at
before update on public.blogs
for each row execute function public.set_updated_at();

alter table public.blogs enable row level security;

drop policy if exists "blogs public can read published" on public.blogs;
drop policy if exists "blogs admins can insert" on public.blogs;
drop policy if exists "blogs admins can update" on public.blogs;
drop policy if exists "blogs admins can delete" on public.blogs;
drop policy if exists "blogs public read" on public.blogs;
drop policy if exists "blogs admin write" on public.blogs;

create policy "blogs public can read published"
on public.blogs
for select
to anon, authenticated
using (published = true or auth.role() = 'authenticated');

create policy "blogs authenticated can insert"
on public.blogs
for insert
to authenticated
with check (true);

create policy "blogs authenticated can update"
on public.blogs
for update
to authenticated
using (true)
with check (true);

create policy "blogs authenticated can delete"
on public.blogs
for delete
to authenticated
using (true);

-- ---------------------------------------------------------------------------
-- WEBSITE LEADS
-- ---------------------------------------------------------------------------
create table if not exists public.mian_website_leads (
  id uuid primary key default gen_random_uuid(),
  form_name text not null default 'Website Form',
  name text,
  lead_date text,
  contact_number text,
  whatsapp_number text,
  purpose_of_visit text,
  phone text,
  email text,
  service text,
  concern text,
  message text,
  preferred_date date,
  time_slot text,
  profile text,
  course text,
  page_path text,
  status text not null default 'new',
  payload jsonb not null default '{}'::jsonb,
  created_at timestamptz not null default now(),
  updated_at timestamptz not null default now(),
  constraint leads_status_check check (status in ('new', 'contacted', 'converted', 'closed'))
);

alter table public.mian_website_leads add column if not exists form_name text not null default 'Website Form';
alter table public.mian_website_leads add column if not exists name text;
alter table public.mian_website_leads add column if not exists lead_date text;
alter table public.mian_website_leads add column if not exists contact_number text;
alter table public.mian_website_leads add column if not exists whatsapp_number text;
alter table public.mian_website_leads add column if not exists purpose_of_visit text;
alter table public.mian_website_leads add column if not exists phone text;
alter table public.mian_website_leads add column if not exists email text;
alter table public.mian_website_leads add column if not exists service text;
alter table public.mian_website_leads add column if not exists concern text;
alter table public.mian_website_leads add column if not exists message text;
alter table public.mian_website_leads add column if not exists preferred_date date;
alter table public.mian_website_leads add column if not exists time_slot text;
alter table public.mian_website_leads add column if not exists profile text;
alter table public.mian_website_leads add column if not exists course text;
alter table public.mian_website_leads add column if not exists page_path text;
alter table public.mian_website_leads add column if not exists status text not null default 'new';
alter table public.mian_website_leads add column if not exists payload jsonb not null default '{}'::jsonb;
alter table public.mian_website_leads add column if not exists created_at timestamptz not null default now();
alter table public.mian_website_leads add column if not exists updated_at timestamptz not null default now();

create index if not exists mian_website_leads_created_idx on public.mian_website_leads (created_at desc);
create index if not exists mian_website_leads_status_idx on public.mian_website_leads (status, created_at desc);

drop trigger if exists mian_website_leads_set_updated_at on public.mian_website_leads;
create trigger mian_website_leads_set_updated_at
before update on public.mian_website_leads
for each row execute function public.set_updated_at();

alter table public.mian_website_leads enable row level security;

drop policy if exists "leads authenticated can read" on public.mian_website_leads;
drop policy if exists "leads authenticated can update" on public.mian_website_leads;
drop policy if exists "leads authenticated can delete" on public.mian_website_leads;
drop policy if exists "leads admin read" on public.mian_website_leads;
drop policy if exists "leads admin update" on public.mian_website_leads;
drop policy if exists "leads admin delete" on public.mian_website_leads;

create policy "leads authenticated can read"
on public.mian_website_leads
for select
to authenticated
using (true);

create policy "leads authenticated can update"
on public.mian_website_leads
for update
to authenticated
using (true)
with check (true);

create policy "leads authenticated can delete"
on public.mian_website_leads
for delete
to authenticated
using (true);

create or replace function public.submit_mian_website_lead(payload jsonb)
returns uuid
language plpgsql
security definer
set search_path = public
as $$
declare
  inserted_id uuid;
begin
  insert into public.mian_website_leads (
    form_name,
    name,
    lead_date,
    contact_number,
    whatsapp_number,
    purpose_of_visit,
    phone,
    email,
    service,
    concern,
    message,
    preferred_date,
    time_slot,
    profile,
    course,
    page_path,
    payload
  )
  values (
    coalesce(payload->>'form_name', 'Website Form'),
    nullif(trim(coalesce(payload->>'name', '')), ''),
    nullif(trim(coalesce(payload->>'lead_date', '')), ''),
    nullif(trim(coalesce(payload->>'contact_number', payload->>'phone', '')), ''),
    nullif(trim(coalesce(payload->>'whatsapp_number', payload->>'phone', '')), ''),
    nullif(trim(coalesce(payload->>'purpose_of_visit', payload->>'service', payload->>'course', payload->>'concern', '')), ''),
    nullif(trim(coalesce(payload->>'phone', '')), ''),
    nullif(trim(coalesce(payload->>'email', '')), ''),
    nullif(trim(coalesce(payload->>'service', payload->>'course', '')), ''),
    nullif(trim(coalesce(payload->>'concern', '')), ''),
    nullif(trim(coalesce(payload->>'message', payload->>'concern', '')), ''),
    nullif(payload->>'preferred_date', '')::date,
    nullif(trim(coalesce(payload->>'time_slot', '')), ''),
    nullif(trim(coalesce(payload->>'profile', '')), ''),
    nullif(trim(coalesce(payload->>'course', '')), ''),
    coalesce(payload->>'page_path', null),
    coalesce(payload, '{}'::jsonb)
  )
  returning id into inserted_id;

  return inserted_id;
end;
$$;

-- ---------------------------------------------------------------------------
-- STORAGE: public blog image bucket, WebP only, 200 KB limit.
-- ---------------------------------------------------------------------------
insert into storage.buckets (id, name, public, file_size_limit, allowed_mime_types)
values ('blog-images', 'blog-images', true, 204800, array['image/webp'])
on conflict (id) do update
set
  public = true,
  file_size_limit = 204800,
  allowed_mime_types = array['image/webp'];

drop policy if exists "blog images public read" on storage.objects;
drop policy if exists "blog images admins insert" on storage.objects;
drop policy if exists "blog images admins update" on storage.objects;
drop policy if exists "blog images admins delete" on storage.objects;
drop policy if exists "blog images authenticated insert" on storage.objects;
drop policy if exists "blog images authenticated update" on storage.objects;
drop policy if exists "blog images authenticated delete" on storage.objects;

create policy "blog images public read"
on storage.objects
for select
to anon, authenticated
using (bucket_id = 'blog-images');

create policy "blog images authenticated insert"
on storage.objects
for insert
to authenticated
with check (
  bucket_id = 'blog-images'
  and lower(name) like '%.webp'
);

create policy "blog images authenticated update"
on storage.objects
for update
to authenticated
using (bucket_id = 'blog-images')
with check (
  bucket_id = 'blog-images'
  and lower(name) like '%.webp'
);

create policy "blog images authenticated delete"
on storage.objects
for delete
to authenticated
using (bucket_id = 'blog-images');
