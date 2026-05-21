-- ============================================================
-- MIGRATION 2 — Agrega tabla `site_settings`
-- ============================================================
-- Ejecuta este script en Supabase Dashboard → SQL Editor → New query
-- Crea una tabla singleton (id=1) para configuración global del sitio
-- (imagen del "Quiénes somos", etc.)
-- ============================================================

CREATE TABLE IF NOT EXISTS site_settings (
  id           integer PRIMARY KEY DEFAULT 1,
  about_image  text,
  updated_at   timestamptz DEFAULT now(),
  CONSTRAINT singleton_check CHECK (id = 1)
);

-- Trigger para updated_at
DROP TRIGGER IF EXISTS update_site_settings_updated_at ON site_settings;
CREATE TRIGGER update_site_settings_updated_at
BEFORE UPDATE ON site_settings
FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

-- RLS — lectura pública + escritura abierta (igual que projects)
ALTER TABLE site_settings ENABLE ROW LEVEL SECURITY;

DROP POLICY IF EXISTS "public_read_site_settings" ON site_settings;
CREATE POLICY "public_read_site_settings"
  ON site_settings FOR SELECT
  USING (true);

DROP POLICY IF EXISTS "public_write_site_settings" ON site_settings;
CREATE POLICY "public_write_site_settings"
  ON site_settings FOR ALL
  USING (true)
  WITH CHECK (true);

-- Insert inicial (singleton)
INSERT INTO site_settings (id, about_image)
VALUES (1, 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=1200&q=80')
ON CONFLICT (id) DO NOTHING;

-- ============================================================
-- LISTO.
-- ============================================================
