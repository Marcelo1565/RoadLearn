<?php
declare(strict_types=1);

/**
 * Carrega o conteúdo editorial do site.
 *
 * Este caminho é do sistema de arquivos, não uma URL. Por isso ele continua
 * funcionando mesmo quando o projeto é acessado por http://roadlearn/.
 */
function load_roadmaps(): array
{
    $file = __DIR__ . '/../data/roadmaps.json';
    if (!is_readable($file)) {
        return [];
    }

    $content = file_get_contents($file);
    $data = json_decode($content ?: '', true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('RoadLearn: roadmaps.json contém JSON inválido.');
        return [];
    }

    $roadmaps = is_array($data['roadmaps'] ?? null) ? $data['roadmaps'] : [];
    $validRoadmaps = [];
    $slugs = [];

    foreach ($roadmaps as $roadmap) {
        if (!is_valid_roadmap($roadmap, $slugs)) {
            error_log('RoadLearn: roadmap inválido ignorado.');
            continue;
        }

        $validRoadmaps[] = $roadmap;
        $slugs[] = $roadmap['slug'];
    }

    return $validRoadmaps;
}

function is_valid_roadmap(mixed $roadmap, array $knownSlugs = []): bool
{
    if (!is_array($roadmap)) {
        return false;
    }

    $requiredFields = ['slug', 'area', 'area_slug', 'title', 'description', 'level', 'duration', 'stages'];
    foreach ($requiredFields as $field) {
        if (!isset($roadmap[$field]) || $roadmap[$field] === '') {
            return false;
        }
    }

    if (!is_string($roadmap['slug']) || in_array($roadmap['slug'], $knownSlugs, true) || !is_array($roadmap['stages'])) {
        return false;
    }

    $stageIds = [];
    foreach ($roadmap['stages'] as $stage) {
        if (!is_array($stage) || !is_string($stage['id'] ?? null) || in_array($stage['id'], $stageIds, true)) {
            return false;
        }

        foreach (['title', 'summary', 'duration', 'outcomes', 'resources'] as $field) {
            if (!array_key_exists($field, $stage)) {
                return false;
            }
        }

        if (!is_array($stage['outcomes']) || !is_array($stage['resources'])) {
            return false;
        }

        foreach ($stage['resources'] as $resource) {
            $url = is_array($resource) ? ($resource['url'] ?? '') : '';
            if (!is_string($url) || !filter_var($url, FILTER_VALIDATE_URL) || parse_url($url, PHP_URL_SCHEME) !== 'https') {
                return false;
            }
        }

        $stageIds[] = $stage['id'];
    }

    return true;
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function find_roadmap(array $roadmaps, string $slug): ?array
{
    foreach ($roadmaps as $roadmap) {
        if (($roadmap['slug'] ?? '') === $slug) {
            return $roadmap;
        }
    }
    return null;
}

function find_stage(array $roadmap, string $stageId): ?array
{
    foreach ($roadmap['stages'] ?? [] as $stage) {
        if (($stage['id'] ?? '') === $stageId) {
            return $stage;
        }
    }
    return null;
}

function roadmap_search_text(array $roadmap): string
{
    $parts = [
        $roadmap['title'] ?? '',
        $roadmap['area'] ?? '',
        $roadmap['discipline'] ?? '',
        $roadmap['domain'] ?? '',
        implode(' ', $roadmap['competencies'] ?? []),
        implode(' ', $roadmap['exam_targets'] ?? []),
    ];

    return strtolower(implode(' ', $parts));
}

function roadmap_url(string $slug): string
{
    return page_url('roadmap.php') . '?slug=' . rawurlencode($slug);
}

function stage_url(string $slug, string $stageId): string
{
    return page_url('etapa.php') . '?slug=' . rawurlencode($slug) . '&stage=' . rawurlencode($stageId);
}

function catalog_url(): string
{
    return page_url('catalogo.php');
}

function home_url(): string
{
    return base_path() . 'index.php';
}

function page_url(string $page): string
{
    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    return str_contains($script, '/pages/') ? $page : 'pages/' . $page;
}

function base_path(): string
{
    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    return str_contains($script, '/pages/') ? '../' : '';
}

function page_title(string $title = ''): string
{
    return $title === '' ? 'RoadLearn — Aprender com intenção' : $title . ' — RoadLearn';
}
