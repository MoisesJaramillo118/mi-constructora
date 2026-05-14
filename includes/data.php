<?php
// Capa de datos. Único punto que toca disco para leer/escribir JSON.
// Si en el futuro migramos a MySQL, solo cambian estas funciones.

require_once __DIR__ . '/helpers.php';

const DATA_DIR = SITE_ROOT . '/data';

/** Lee un archivo JSON de /data/ y devuelve array (o fallback). */
function read_json(string $name, array $fallback = []): array {
    $path = DATA_DIR . '/' . basename($name);
    if (!is_file($path)) return $fallback;
    $raw = file_get_contents($path);
    if ($raw === false) return $fallback;
    $data = json_decode($raw, true);
    return is_array($data) ? $data : $fallback;
}

/** Devuelve los datos del sitio (textos generales). */
function site_data(): array {
    static $cache = null;
    if ($cache === null) $cache = read_json('site.json');
    return $cache;
}

/** Lista de servicios ordenada. */
function services(): array {
    $items = read_json('services.json');
    usort($items, fn($a, $b) => ($a['order'] ?? 0) <=> ($b['order'] ?? 0));
    return $items;
}

/** Lista de proyectos, opcionalmente solo destacados, ordenada. */
function projects(bool $only_featured = false): array {
    $items = read_json('projects.json');
    if ($only_featured) {
        $items = array_values(array_filter($items, fn($p) => !empty($p['featured'])));
    }
    usort($items, fn($a, $b) => ($a['order'] ?? 0) <=> ($b['order'] ?? 0));
    return $items;
}

/** Estadísticas (contadores animados). */
function stats(): array {
    return read_json('stats.json');
}
