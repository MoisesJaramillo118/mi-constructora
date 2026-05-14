<?php
// Helpers genéricos del sitio.
// Filosofía: funciones cortas, predecibles. Nunca imprimen HTML por sí solas
// salvo las que terminan en _html().

if (!defined('SITE_ROOT')) {
    define('SITE_ROOT', dirname(__DIR__));
}

/** Escapa texto para HTML. Úsalo SIEMPRE al imprimir contenido editable. */
function e(?string $s): string {
    return htmlspecialchars($s ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Devuelve URL absoluta de un asset relativo a la raíz del sitio. */
function asset(string $path): string {
    return '/' . ltrim($path, '/');
}

/** Construye link de WhatsApp con mensaje pre-cargado. */
function wa_link(string $phone, string $message = ''): string {
    $clean = preg_replace('/\D+/', '', $phone);
    $url = 'https://wa.me/' . $clean;
    if ($message !== '') {
        $url .= '?text=' . rawurlencode($message);
    }
    return $url;
}

/** Convierte un string a slug seguro. */
function slugify(string $s): string {
    $s = strtolower(trim($s));
    $s = preg_replace('/[áàä]/u', 'a', $s);
    $s = preg_replace('/[éèë]/u', 'e', $s);
    $s = preg_replace('/[íìï]/u', 'i', $s);
    $s = preg_replace('/[óòö]/u', 'o', $s);
    $s = preg_replace('/[úùü]/u', 'u', $s);
    $s = preg_replace('/ñ/u', 'n', $s);
    $s = preg_replace('/[^a-z0-9]+/', '-', $s);
    return trim($s, '-');
}

/** Comprueba si la ruta actual coincide (para marcar nav activo). */
function is_current(string $path): bool {
    $current = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
    $current = rtrim($current, '/');
    $path    = rtrim($path, '/');
    if ($path === '' || $path === '/') {
        return $current === '' || $current === '/index.php';
    }
    return $current === $path || $current === $path . '.php';
}

/** Formatea número con separador de miles. */
function fmt_int(int $n): string {
    return number_format($n, 0, ',', '.');
}

/** Devuelve un SVG de icono inline. Stroke-current toma color del padre. */
function icon(string $name): string {
    $svgs = [
        'draft'  => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h11l5 5v13H3z"/><path d="M14 3v5h5"/><path d="M8 14h8M8 18h5"/></svg>',
        'hammer' => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M14 3l7 7-3 3-7-7zM5 21l7-7 3 3-7 7z"/></svg>',
        'wrench' => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18l3 3 6.3-6.3a4 4 0 0 0 5.4-5.4l-2.5 2.5-2.2-2.2z"/></svg>',
        'beam'   => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h18M3 17h18M7 7v10M17 7v10M3 7v10M21 7v10"/></svg>',
        'shield' => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l8 4v6c0 4.5-3.5 7.5-8 8-4.5-.5-8-3.5-8-8V7z"/><path d="M9 12l2 2 4-4"/></svg>',
        'doc'    => '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><path d="M14 3v6h6M8 13h8M8 17h6"/></svg>',
    ];
    return $svgs[$name] ?? $svgs['doc'];
}
