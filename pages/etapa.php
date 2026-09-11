<?php
require_once __DIR__ . '/../includes/functions.php';

$roadmaps = load_roadmaps();
$roadmap = find_roadmap($roadmaps, (string) ($_GET['slug'] ?? ''));
$stage = $roadmap ? find_stage($roadmap, (string) ($_GET['stage'] ?? '')) : null;

if (!$roadmap || !$stage) {
    http_response_code(404);
    $title = 'Etapa não encontrada';
    require __DIR__ . '/../includes/header.php';
    ?>
    <section class="page-intro">
        <div class="container narrow">
            <p class="eyebrow">404</p>
            <h1>Esta etapa não foi encontrada.</h1>
            <a class="button button-primary" href="<?= e(catalog_url()) ?>">Voltar ao catálogo</a>
        </div>
    </section>
    <?php
    require __DIR__ . '/../includes/footer.php';
    exit;
}

$stageIndex = array_search($stage['id'], array_column($roadmap['stages'], 'id'), true);
$previous = $roadmap['stages'][$stageIndex - 1] ?? null;
$next = $roadmap['stages'][$stageIndex + 1] ?? null;
$title = $stage['title'];

require __DIR__ . '/../includes/header.php';
?>
<section class="stage-header">
    <div class="container narrow">
        <a class="back-link" href="<?= e(roadmap_url($roadmap['slug'])) ?>">
            ← Voltar para <?= e($roadmap['short_title']) ?>
        </a>
        <div class="stage-kicker">
            <span>Etapa <?= $stageIndex + 1 ?> de <?= count($roadmap['stages']) ?></span>
            <span><?= e($stage['duration']) ?></span>
        </div>
        <h1><?= e($stage['title']) ?></h1>
        <p class="stage-summary"><?= e($stage['summary']) ?></p>
    </div>
</section>

<section class="stage-section">
    <div class="container narrow stage-layout">
        <div class="stage-main">
            <div class="focus-banner">
                <span class="focus-symbol">◎</span>
                <div>
                    <strong>Modo de foco</strong>
                    <p>Reserve este tempo para uma coisa só. Você pode marcar os objetivos conforme avança.</p>
                </div>
                <button type="button" class="focus-toggle" data-focus-toggle>Ativar foco</button>
            </div>

            <section>
                <p class="eyebrow">Ao final desta etapa</p>
                <h2>Você deverá conseguir...</h2>
                <div class="outcome-list">
                    <?php foreach ($stage['outcomes'] as $outcome): ?>
                        <label class="outcome-item">
                            <input type="checkbox" data-outcome="<?= e($stage['id']) ?>">
                            <span><?= e($outcome) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </section>

            <section class="resources-section">
                <div class="section-heading">
                    <div>
                        <p class="eyebrow">Escolha um caminho</p>
                        <h2>Recursos selecionados</h2>
                    </div>
                    <span class="resource-note">Links externos abrem em nova aba</span>
                </div>
                <div class="resource-list">
                    <?php foreach ($stage['resources'] as $resource): ?>
                        <a class="resource-card" href="<?= e($resource['url']) ?>" target="_blank" rel="noopener noreferrer">
                            <span class="resource-type type-<?= e($resource['type']) ?>"><?= e($resource['type']) ?></span>
                            <span class="resource-title"><?= e($resource['title']) ?></span>
                            <span class="resource-source"><?= e($resource['source']) ?> <span aria-hidden="true">↗</span></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>

            <nav class="stage-navigation" aria-label="Navegação entre etapas">
                <?php if ($previous): ?>
                    <a href="<?= e(stage_url($roadmap['slug'], $previous['id'])) ?>">
                        ← <span>Anterior</span>
                        <strong><?= e($previous['title']) ?></strong>
                    </a>
                <?php else: ?>
                    <span></span>
                <?php endif; ?>

                <?php if ($next): ?>
                    <a class="next-stage" href="<?= e(stage_url($roadmap['slug'], $next['id'])) ?>">
                        <span>Próxima</span>
                        <strong><?= e($next['title']) ?> →</strong>
                    </a>
                <?php else: ?>
                    <a class="next-stage" href="<?= e(roadmap_url($roadmap['slug'])) ?>">
                        <span>Trilha concluída?</span>
                        <strong>Ver roadmap →</strong>
                    </a>
                <?php endif; ?>
            </nav>
        </div>
    </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
