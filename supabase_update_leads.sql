-- ============================================================================
-- SQL Update script for public.mian_website_leads table and submit functions
-- Run this in your Supabase SQL Editor if you need to recreate or update the schema.
-- ============================================================================

-- 1. Create or ensure mian_website_leads table exists with all fields
create table if not exists public.mian_website_leads (
  id uuid not null default gen_random_uuid (),
  form_name text not null default 'Website Form'::text,
  name text null,
  phone text null,
  email text null,
  service text null,
  concern text null,
  message text null,
  preferred_date date null,
  time_slot text null,
  profile text null,
  course text null,
  page_path text null,
  status text not null default 'new'::text,
  payload jsonb not null default '{}'::jsonb,
  created_at timestamp with time zone not null default now(),
  updated_at timestamp with time zone not null default now(),
  lead_date text null,
  contact_number text null,
  whatsapp_number text null,
  purpose_of_visit text null,
  constraint mian_website_leads_pkey primary key (id),
  constraint leads_status_check check (
    status = any (
      array[
        'new'::text,
        'contacted'::text,
        'converted'::text,
        'closed'::text
      ]
    )
  )
) TABLESPACE pg_default;

-- 2. Create indexes for performance
create index if not exists mian_website_leads_created_idx 
  on public.mian_website_leads using btree (created_at desc) TABLESPACE pg_default;

create index if not exists mian_website_leads_status_idx 
  on public.mian_website_leads using btree (status, created_at desc) TABLESPACE pg_default;

-- 3. Create/update set_updated_at trigger
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

drop trigger if exists mian_website_leads_set_updated_at on public.mian_website_leads;
create trigger mian_website_leads_set_updated_at
  before update on public.mian_website_leads
  for each row execute function public.set_updated_at();

-- 4. Enable Row Level Security (RLS)
alter table public.mian_website_leads enable row level security;

-- 5. RLS Policies
drop policy if exists "leads authenticated can read" on public.mian_website_leads;
drop policy if exists "leads authenticated can update" on public.mian_website_leads;
drop policy if exists "leads authenticated can delete" on public.mian_website_leads;

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

-- 6. RPC Function to submit website leads securely
create or replace function public.submit_main_website_lead(payload jsonb)
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

-- Backward-compatible alias for older frontend builds that used the typo.
create or replace function public.submit_mian_website_lead(payload jsonb)
returns uuid
language sql
security definer
set search_path = public
as $$
  select public.submit_main_website_lead($1);
$$;

-- Grant execution privilege to anonymous and authenticated users
grant execute on function public.submit_main_website_lead(jsonb) to anon, authenticated;
grant execute on function public.submit_mian_website_lead(jsonb) to anon, authenticated;

-- Ask PostgREST/Supabase API to refresh its schema cache immediately.
notify pgrst, 'reload schema';
