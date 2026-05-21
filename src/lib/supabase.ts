import { createClient } from '@supabase/supabase-js';

const url = import.meta.env.PUBLIC_SUPABASE_URL;
const key = import.meta.env.PUBLIC_SUPABASE_ANON_KEY;

if (!url || !key) {
  console.warn(
    'Falta configurar PUBLIC_SUPABASE_URL y/o PUBLIC_SUPABASE_ANON_KEY. ' +
    'Crea un archivo .env basado en .env.example.'
  );
}

export const supabase = createClient(
  url ?? 'https://placeholder.supabase.co',
  key ?? 'placeholder-anon-key'
);

export type Project = {
  id: string;
  title: string;
  year: number;
  location: string;
  image: string;
  description: string;
  featured?: boolean;
  order?: number;
  created_at?: string;
  updated_at?: string;
};

// ─── Helpers de Projects ──────────────────────────────────────
export async function getProjects(): Promise<Project[]> {
  const { data, error } = await supabase
    .from('projects')
    .select('*')
    .order('order', { ascending: true });
  if (error) {
    console.error('Error cargando projects:', error);
    return [];
  }
  return data as Project[];
}

export async function createProject(p: Project) {
  return supabase.from('projects').insert([p]).select().single();
}

export async function updateProject(id: string, patch: Partial<Project>) {
  return supabase.from('projects').update(patch).eq('id', id).select().single();
}

export async function deleteProject(id: string) {
  return supabase.from('projects').delete().eq('id', id);
}

// ─── Helper de Storage ────────────────────────────────────────
export async function uploadImage(file: File): Promise<string | null> {
  const ext = file.name.split('.').pop() ?? 'jpg';
  const filename = `${Date.now()}-${Math.random().toString(36).slice(2, 8)}.${ext}`;
  const { data, error } = await supabase.storage
    .from('project-images')
    .upload(filename, file, { cacheControl: '3600', upsert: false });

  if (error) {
    console.error('Error subiendo imagen:', error);
    return null;
  }
  const { data: pub } = supabase.storage
    .from('project-images')
    .getPublicUrl(data.path);
  return pub.publicUrl;
}

export async function deleteImageByUrl(url: string): Promise<boolean> {
  // Solo intenta borrar si la URL es de nuestro bucket
  const marker = '/storage/v1/object/public/project-images/';
  if (!url.includes(marker)) return true;
  const path = url.split(marker)[1];
  if (!path) return true;
  const { error } = await supabase.storage.from('project-images').remove([path]);
  if (error) {
    console.warn('No se pudo borrar la imagen del storage:', error.message);
    return false;
  }
  return true;
}

// ─── Helpers de Site Settings (singleton id=1) ────────────────
export type SiteSettings = {
  id: number;
  about_image: string | null;
  updated_at?: string;
};

export async function getSiteSettings(): Promise<SiteSettings | null> {
  const { data, error } = await supabase
    .from('site_settings')
    .select('*')
    .eq('id', 1)
    .maybeSingle();
  if (error) {
    console.warn('Error cargando site_settings:', error);
    return null;
  }
  return data as SiteSettings | null;
}

export async function updateSiteSettings(patch: Partial<SiteSettings>) {
  return supabase
    .from('site_settings')
    .upsert({ id: 1, ...patch })
    .eq('id', 1)
    .select()
    .single();
}

// Genera un slug a partir del título (para el id de proyecto)
export function slugify(text: string): string {
  return text
    .toString()
    .toLowerCase()
    .normalize('NFD')
    .replace(/[̀-ͯ]/g, '')
    .replace(/[^a-z0-9\s-]/g, '')
    .trim()
    .replace(/\s+/g, '-')
    .replace(/-+/g, '-');
}
