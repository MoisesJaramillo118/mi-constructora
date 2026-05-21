-- ============================================================
-- SETUP SUPABASE — Sitio Santa Cruz (mi-constructora)
-- ============================================================
-- Ejecuta este script completo en: Supabase Dashboard
--   → tu proyecto → SQL Editor → New query → pega esto → Run
-- ============================================================

-- ─────────────────────────────────────────────
-- 1) Tabla `projects` (reemplaza projects.json)
-- ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS projects (
  id           text PRIMARY KEY,                    -- slug ej: "edificio-las-orquideas"
  title        text NOT NULL,
  year         integer NOT NULL,
  location     text NOT NULL,
  image        text NOT NULL,                       -- URL pública de la imagen
  description  text NOT NULL,
  featured     boolean DEFAULT false,
  "order"      integer DEFAULT 0,
  created_at   timestamptz DEFAULT now(),
  updated_at   timestamptz DEFAULT now()
);

CREATE INDEX IF NOT EXISTS projects_order_idx ON projects("order");
CREATE INDEX IF NOT EXISTS projects_featured_idx ON projects(featured);

-- Trigger para actualizar updated_at automáticamente
CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
  NEW.updated_at = now();
  RETURN NEW;
END;
$$ language 'plpgsql';

DROP TRIGGER IF EXISTS update_projects_updated_at ON projects;
CREATE TRIGGER update_projects_updated_at
BEFORE UPDATE ON projects
FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

-- ─────────────────────────────────────────────
-- 2) Row Level Security (RLS)
-- ─────────────────────────────────────────────
-- Habilitamos RLS para que las políticas controlen el acceso.
-- Política: TODOS pueden leer (sitio público) y TODOS pueden escribir
-- (la "protección" del admin es por contraseña en el frontend).
-- IMPORTANTE: este nivel de seguridad es básico. Si necesitas seguridad
-- real, hay que migrar a Supabase Auth con usuarios reales.

ALTER TABLE projects ENABLE ROW LEVEL SECURITY;

DROP POLICY IF EXISTS "public_read_projects" ON projects;
CREATE POLICY "public_read_projects"
  ON projects FOR SELECT
  USING (true);

DROP POLICY IF EXISTS "public_write_projects" ON projects;
CREATE POLICY "public_write_projects"
  ON projects FOR ALL
  USING (true)
  WITH CHECK (true);

-- ─────────────────────────────────────────────
-- 3) Datos iniciales (los proyectos actuales del JSON)
-- ─────────────────────────────────────────────
INSERT INTO projects (id, title, year, location, image, description, featured, "order")
VALUES
  ('edificio-las-orquideas', 'Edificio Las Orquídeas', 2025, 'Miraflores, Lima',
   'https://images.unsplash.com/photo-1486325212027-8081e485255e?auto=format&fit=crop&w=1600&q=80',
   'Edificio multifamiliar de 8 pisos con áreas comunes premium. 24 departamentos entregados llave en mano.',
   true, 1),
  ('casa-de-playa-asia', 'Casa de playa en Asia', 2024, 'Asia, Cañete',
   'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1600&q=80',
   'Casa moderna de 420 m² con piscina infinita, integración con el paisaje y sistema fotovoltaico.',
   true, 2),
  ('oficinas-corporativas-san-isidro', 'Oficinas corporativas en San Isidro', 2024, 'San Isidro, Lima',
   'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1600&q=80',
   'Remodelación integral de 1,200 m² de oficinas: diseño biofílico, salas de reunión inteligentes y cocina gourmet.',
   true, 3),
  ('vivienda-unifamiliar-la-molina', 'Vivienda unifamiliar La Molina', 2023, 'La Molina, Lima',
   'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1600&q=80',
   'Casa de 3 niveles de 360 m² con doble altura, jardín interior y acabados de primera.',
   true, 4),
  ('local-comercial-arequipa', 'Local comercial Arequipa', 2023, 'Arequipa',
   'https://images.unsplash.com/photo-1565538810643-b5bdb714032a?auto=format&fit=crop&w=1600&q=80',
   'Diseño y construcción de local comercial de 600 m² con fachada de gran formato y estacionamiento subterráneo.',
   false, 5)
ON CONFLICT (id) DO NOTHING;

-- ─────────────────────────────────────────────
-- 4) Storage bucket `project-images` (para uploads)
-- ─────────────────────────────────────────────
-- Ejecutamos por separado en SQL Editor:
INSERT INTO storage.buckets (id, name, public)
VALUES ('project-images', 'project-images', true)
ON CONFLICT (id) DO NOTHING;

-- Políticas de Storage: lectura y escritura pública
DROP POLICY IF EXISTS "public_read_images" ON storage.objects;
CREATE POLICY "public_read_images"
  ON storage.objects FOR SELECT
  USING (bucket_id = 'project-images');

DROP POLICY IF EXISTS "public_write_images" ON storage.objects;
CREATE POLICY "public_write_images"
  ON storage.objects FOR INSERT
  WITH CHECK (bucket_id = 'project-images');

DROP POLICY IF EXISTS "public_delete_images" ON storage.objects;
CREATE POLICY "public_delete_images"
  ON storage.objects FOR DELETE
  USING (bucket_id = 'project-images');

DROP POLICY IF EXISTS "public_update_images" ON storage.objects;
CREATE POLICY "public_update_images"
  ON storage.objects FOR UPDATE
  USING (bucket_id = 'project-images');

-- ============================================================
-- LISTO. Ya puedes usar el panel /admin.
-- ============================================================
