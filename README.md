# Santa Cruz — Sitio web

Sitio web premium para la empresa constructora **Santa Cruz**.

**Stack:** Astro · Tailwind CSS · GSAP · Swiper · AOS — desplegado en **Netlify** desde GitHub.

---

## Estructura

```
santa-cruz/
├── src/
│   ├── content/        ← JSON editables (site, services, projects, stats)
│   ├── components/     ← Nav, Footer, Carousel, ContactForm, ...
│   ├── layouts/        ← BaseLayout
│   ├── pages/          ← index, proyectos, contacto, gracias, 404
│   ├── styles/         ← global.css (Tailwind + reglas custom)
│   └── lib/            ← utilidades (waLink, slugify)
├── public/
│   ├── favicon.svg
│   ├── scripts/main.js ← GSAP + Swiper + AOS (sin cursor custom)
│   └── uploads/        ← imágenes que subas
├── astro.config.mjs
├── tailwind.config.mjs
├── netlify.toml        ← config para deploy en Netlify
└── package.json
```

---

## Trabajar en local

Requisitos: **Node 20+**.

```bash
npm install
npm run dev     # http://localhost:4321
```

Build de producción:

```bash
npm run build   # genera /dist
npm run preview # sirve /dist localmente
```

---

## Editar contenido

Todo lo editable vive en `src/content/*.json`. Después de cambiar un JSON, **el dev server hace hot-reload automáticamente**.

| Archivo | Qué contiene |
|---|---|
| `site.json`     | Nombre, slogan, hero, contacto, redes, textos generales |
| `services.json` | Servicios (icono + título + descripción) |
| `projects.json` | Proyectos (imagen + título + año + ubicación) |
| `stats.json`    | Los 4 contadores animados |

### Iconos de servicios

El campo `icon` acepta uno de: `draft`, `hammer`, `wrench`, `beam`, `shield`, `doc`.
Para agregar más, edita `src/components/Icon.astro`.

### Imágenes locales

Coloca el archivo en `public/uploads/projects/` (ej. `casa-andina.jpg`)
y en `projects.json` pon `"image": "/uploads/projects/casa-andina.jpg"`.

---

## Desplegar en Netlify

1. Conecta el repo de GitHub a Netlify (una vez).
2. Netlify lee `netlify.toml` y detecta automáticamente:
   - Build command: `npm run build`
   - Publish directory: `dist`
3. **Cada `git push` a `main`** dispara un nuevo deploy.

### Formulario de contacto

El formulario usa **Netlify Forms** (atributo `data-netlify="true"`).
Los mensajes llegan a tu panel de Netlify → Forms.
Para recibirlos también por email: Netlify → Forms → Form notifications.

---

## Versionado

```bash
git add .
git commit -m "..."
git push           # Netlify rebuild automático
```
