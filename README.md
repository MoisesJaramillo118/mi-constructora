# Mi Constructora — Sitio web

Sitio web premium para empresa constructora.
Stack: **PHP + Tailwind CSS + GSAP + Swiper.js**.

> MVP: el contenido se edita por archivos JSON en `data/`.
> En una segunda fase agregaremos un panel admin visual.

---

## Estructura rápida

```
mi-constructora/
├── index.php          → Home
├── proyectos.php      → Galería de obras
├── contacto.php       → Formulario y datos
├── enviar.php         → Procesa el formulario
├── 404.php
├── data/              → Contenido editable (JSON)
├── includes/          → Parciales PHP (header, nav, footer, helpers)
├── assets/            → CSS, JS, imágenes estáticas
├── uploads/           → Imágenes subidas (cuando agreguemos el admin)
└── .htaccess          → URLs limpias + seguridad + cache
```

---

## Cómo trabajar en local

Requisitos: **PHP 8+** y **Node.js 18+** (solo para compilar Tailwind).

```bash
# 1. Instalar Tailwind
npm install

# 2. En una terminal, dejar Tailwind compilando los cambios:
npm run watch:css

# 3. En otra terminal, levantar el servidor PHP:
npm run serve
#   ↑ equivale a:  php -S localhost:8000

# 4. Abrir: http://localhost:8000
```

Cuando termines y vayas a subir a producción, compila el CSS minificado:

```bash
npm run build:css
```

---

## Cómo editar el contenido

Todo lo editable vive en `data/*.json`. Después de cambiar un JSON, **refresca el navegador** (no hay que reiniciar nada).

| Archivo | Qué contiene |
|---|---|
| `data/site.json`     | Nombre empresa, slogan, hero, contacto, redes, textos generales |
| `data/services.json` | Lista de servicios (icono + título + descripción) |
| `data/projects.json` | Lista de proyectos (imagen + título + año + ubicación + descripción) |
| `data/stats.json`    | Los 4 contadores animados |

### Iconos disponibles para servicios

En `services.json`, el campo `icon` acepta uno de: `draft`, `hammer`, `wrench`, `beam`, `shield`, `doc`.
Para agregar más, edita la función `icon()` en `includes/helpers.php`.

### Imágenes de proyectos

En el MVP usamos URLs (de Unsplash o tu propio CDN). Para usar imágenes locales:

1. Coloca el archivo en `uploads/projects/` (ej. `casa-andina.jpg`).
2. En `projects.json`, pon `"image": "/uploads/projects/casa-andina.jpg"`.

---

## Configurar el envío de email del formulario

El formulario de contacto intenta enviar emails en este orden:

1. **PHPMailer + SMTP** (recomendado en producción).
2. `mail()` nativo de PHP (suele funcionar en cPanel).
3. Si fallan los anteriores, **guarda el mensaje en `data/_inbox/`** como respaldo.

### Para activar SMTP con Gmail (gratis, ideal en InfinityFree):

1. Descarga PHPMailer: <https://github.com/PHPMailer/PHPMailer/releases>
2. Pon los archivos en `vendor/PHPMailer/src/` (estructura: `vendor/PHPMailer/src/PHPMailer.php`, etc.).
3. En `data/site.json` rellena:
   ```json
   "smtp_host": "smtp.gmail.com",
   "smtp_port": 587,
   "smtp_user": "tu-correo@gmail.com",
   "smtp_pass": "<contraseña-de-aplicación-de-Gmail>",
   "smtp_to":   "donde-quieres-recibir@gmail.com"
   ```
4. Para la `smtp_pass` usa **contraseña de aplicación** (no la normal):
   <https://myaccount.google.com/apppasswords>

### En Hosting Perú con correo @tudominio.com:

Misma configuración, pero con los datos SMTP que te dé Hosting Perú al crear la cuenta de correo en cPanel.

---

## Subir a hosting (FTP)

1. `npm run build:css` para tener el CSS minificado.
2. Conecta con FileZilla / Cyberduck al FTP del hosting.
3. Sube **TODA** la carpeta del proyecto a `public_html/` (Hosting Perú) o `htdocs/` (InfinityFree).
   Excluye: `node_modules/`, `.git/`, `package-lock.json`.
4. Verifica que la URL principal cargue.
5. Verifica que `/data/site.json` directo en navegador dé **403** (debe estar bloqueado por `.htaccess`).

---

## Versionado en GitHub

```bash
git init
git add .
git commit -m "Initial commit"

# Crea el repo en github.com (privado o público), copia la URL HTTPS.
git remote add origin <URL>
git branch -M main
git push -u origin main
```

A partir de ahí, cada cambio: `git add . && git commit -m "..." && git push`.

> ⚠ GitHub guarda **el código**, el hosting guarda **el sitio en vivo**. No están sincronizados — siempre que actualices código, debes (a) `git push` y (b) re-subir por FTP.

---

## Notas para el junior

- **Después de cambiar Tailwind** (`tailwind.config.js` o cualquier `.php` que use clases nuevas) ejecuta `npm run build:css` antes de subir, o usa `npm run watch:css` durante desarrollo.
- **No subas `node_modules/`** ni a GitHub ni al hosting — el `.gitignore` ya lo bloquea.
- **El botón flotante de WhatsApp** se activa automáticamente si `data/site.json` tiene el campo `whatsapp` con un número (formato internacional, ej. `"+51999888777"`).
- **Cursor custom** se desactiva solo en mobile y en pantallas táctiles.
- **404**: cualquier URL inexistente cae a `404.php` automáticamente.
