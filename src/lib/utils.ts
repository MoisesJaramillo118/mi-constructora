/**
 * Utilidades compartidas para los componentes Astro.
 * Como Astro corre en build time, esto es solo TypeScript ejecutado en Node.
 */

/** Link a WhatsApp con mensaje pre-cargado. */
export function waLink(phone: string, message = ''): string {
  const clean = String(phone).replace(/\D+/g, '');
  const base = `https://wa.me/${clean}`;
  return message ? `${base}?text=${encodeURIComponent(message)}` : base;
}

/** Slug seguro. */
export function slugify(s: string): string {
  return s
    .toLowerCase()
    .normalize('NFD')
    .replace(/[̀-ͯ]/g, '')
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/^-|-$/g, '');
}
