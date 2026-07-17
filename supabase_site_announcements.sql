-- ============================================================================
-- Site-wide announcement bar settings
-- Run this once in Supabase SQL Editor or via psql/Supabase CLI.
-- ============================================================================

create table if not exists public.site_announcements (
  id text not null default 'global',
  message text not null default '',
  link_url text null,
  enabled boolean not null default false,
  created_at timestamp with time zone not null default now(),
  updated_at timestamp with time zone not null default now(),
  constraint site_announcements_pkey primary key (id),
  constraint site_announcements_singleton_check check (id = 'global'),
  constraint site_announcements_link_url_check check (
    link_url is null
    or link_url = ''
    or link_url ~* '^(https?://|/|#)'
  )
);

create index if not exists site_announcements_enabled_idx
  on public.site_announcements using btree (enabled);

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

drop trigger if exists site_announcements_set_updated_at on public.site_announcements;
create trigger site_announcements_set_updated_at
  before update on public.site_announcements
  for each row execute function public.set_updated_at();

insert into public.site_announcements (id, message, link_url, enabled)
values ('global', '', null, false)
on conflict (id) do nothing;

alter table public.site_announcements enable row level security;

drop policy if exists "site announcements public can read enabled" on public.site_announcements;
drop policy if exists "site announcements authenticated can read" on public.site_announcements;
drop policy if exists "site announcements authenticated can insert" on public.site_announcements;
drop policy if exists "site announcements authenticated can update" on public.site_announcements;
drop policy if exists "site announcements authenticated can delete" on public.site_announcements;

create policy "site announcements public can read enabled"
  on public.site_announcements
  for select
  to anon
  using (enabled = true and length(trim(message)) > 0);

create policy "site announcements authenticated can read"
  on public.site_announcements
  for select
  to authenticated
  using (true);

create policy "site announcements authenticated can insert"
  on public.site_announcements
  for insert
  to authenticated
  with check (id = 'global');

create policy "site announcements authenticated can update"
  on public.site_announcements
  for update
  to authenticated
  using (id = 'global')
  with check (id = 'global');

create policy "site announcements authenticated can delete"
  on public.site_announcements
  for delete
  to authenticated
  using (id = 'global');

grant select on public.site_announcements to anon, authenticated;
grant insert, update, delete on public.site_announcements to authenticated;

notify pgrst, 'reload schema';
