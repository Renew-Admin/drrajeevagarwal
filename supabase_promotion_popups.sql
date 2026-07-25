-- Website promotion popup settings.
-- Run this once in the Supabase SQL Editor.

create table if not exists public.promotion_popups (
  id text not null default 'preconception',
  desktop_image_url text null,
  mobile_image_url text null,
  click_url text not null default '/preconception',
  enabled boolean not null default true,
  created_at timestamp with time zone not null default now(),
  updated_at timestamp with time zone not null default now(),
  constraint promotion_popups_pkey primary key (id),
  constraint promotion_popups_singleton_check check (id = 'preconception'),
  constraint promotion_popups_click_url_check check (
    click_url ~* '^(https?://|/|#)'
  )
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

drop trigger if exists promotion_popups_set_updated_at on public.promotion_popups;
create trigger promotion_popups_set_updated_at
  before update on public.promotion_popups
  for each row execute function public.set_updated_at();

insert into public.promotion_popups (id, desktop_image_url, mobile_image_url, click_url, enabled)
values (
  'preconception',
  null,
  null,
  '/preconception',
  true
)
on conflict (id) do nothing;

alter table public.promotion_popups enable row level security;

drop policy if exists "promotion popups public can read enabled" on public.promotion_popups;
drop policy if exists "promotion popups authenticated can read" on public.promotion_popups;
drop policy if exists "promotion popups authenticated can insert" on public.promotion_popups;
drop policy if exists "promotion popups authenticated can update" on public.promotion_popups;

create policy "promotion popups public can read enabled"
  on public.promotion_popups for select to anon
  using (enabled = true);

create policy "promotion popups authenticated can read"
  on public.promotion_popups for select to authenticated using (true);

create policy "promotion popups authenticated can insert"
  on public.promotion_popups for insert to authenticated
  with check (id = 'preconception');

create policy "promotion popups authenticated can update"
  on public.promotion_popups for update to authenticated
  using (id = 'preconception')
  with check (id = 'preconception');

grant select on public.promotion_popups to anon, authenticated;
grant insert, update on public.promotion_popups to authenticated;

notify pgrst, 'reload schema';
