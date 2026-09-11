<?php
require_once __DIR__ . '/../includes/functions.php';

$roadmaps = load_roadmaps();
$roadmap = find_roadmap($roadmaps, (string) ($_GET['slug'] ?? ''));

if (!$roadmap) {
    http_response_code(404);
    $title = 'Roadmap não encontrado';
    require __DIR__ . '/../includes/header.php';
    ?>
    <section class="page-intro">
        <div class="container narrow">
            <p class="eyebrow">404</p>
            <h1>Esse caminho ainda não existe.</h1>
            <p>Volte ao catálogo e escolha um roadmap disponível.</p>
            <a class="button button-primary" href="<?= e(catalog_url()) ?>">Voltar ao catálogo</a>
        </div>
    </section>
    <?php
    require __DIR__ . '/../includes/footer.php';
    exit;
}

$title = $roadmap['title'];
$active = 'catalogo';
require __DIR__ . '/../includes/header.php';
?>
<section class="roadmap-header accent-bg-<?= e($roadmap['accent']) ?>">
    <div class="container roadmap-header-inner">
        <div>
            <a class="back-link" href="<?= e(catalog_url()) ?>">← Todos os roadmaps</a>
            <p class="eyebrow">
                <?= e($roadmap['area']) ?> <span class="eyebrow-dot">·</span> <?= e($roadmap['level']) ?>
            </p>
            <h1><?= e($roadmap['title']) ?></h1>
            <p><?= e($roadmap['description']) ?></p>
            <div class="roadmap-stats">
                <span><strong><?= count($roadmap['stages']) ?></strong> etapas</span>
                <span><strong><?= e($roadmap['duration']) ?></strong> de estudo</span>
            </div>
        </div>
        <div class="roadmap-mark"><span>R</span><small>seu<br>caminho</small></div>
    </div>
</section>

<section class="roadmap-content">
    <div class="container roadmap-layout">
        <div class="roadmap-main">
            <div class="content-heading">
                <div>
                    <p class="eyebrow">A sequência importa</p>
                    <h2>Seu caminho de aprendizagem</h2>
                </div>
                <div class="roadmap-progress" data-roadmap="<?= e($roadmap['slug']) ?>">
                    <span class="progress-label">0% concluído</span>
                    <div class="progress-track"><span class="progress-fill"></span></div>
                </div>
            </div>

            <div class="timeline">
                <?php foreach ($roadmap['stages'] as $index => $stage): ?>
                    <article class="timeline-item" data-stage-card="<?= e($stage['id']) ?>">
                        <div class="timeline-marker">
                            <span><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-meta">
                                <span>Etapa <?= $index + 1 ?></span>
                                <span><?= e($stage['duration']) ?></span>
                            </div>
                            <h3><?= e($stage['title']) ?></h3>
                            <p><?= e($stage['summary']) ?></p>
                            <div class="requires">
                                <span aria-hidden="true">↳</span>
                                <strong>Antes:</strong> <?= e($stage['requires']) ?>
                            </div>
                            <div class="timeline-actions">
                                <a class="button button-small" href="<?= e(stage_url($roadmap['slug'], $stage['id'])) ?>">
                                    Ver etapa <span aria-hidden="true">↗</span>
                                </a>
                                <label class="check-label">
                                    <input type="checkbox" data-stage="<?= e($stage['id']) ?>">
                                    <span>Marcar como concluída</span>
                                </label>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>

        <aside class="roadmap-aside">
            <div class="aside-card">
                <span class="aside-icon">✦</span>
                <p class="eyebrow">Uma pausa consciente</p>
                <h3>Você não precisa consumir tudo.</h3>
                <p>Escolha um recurso, estude com atenção e perceba se ele está ajudando. Mais abas não significam mais aprendizagem.</p>
            </div>
            <div class="aside-card tip-card">
                <p class="eyebrow">Dica para esta trilha</p>
                <p><?= e($roadmap['study_tip']) ?></p>
            </div>
        </aside>
    </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
