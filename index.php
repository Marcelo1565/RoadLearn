<?php
require_once __DIR__ . '/includes/functions.php';
$roadmaps = load_roadmaps();
$featured = array_values(array_filter($roadmaps, fn(array $item): bool => !empty($item['featured'])))[0] ?? ($roadmaps[0] ?? null);
$previewRoadmaps = array_values(array_filter($roadmaps, fn(array $item): bool => ($item['slug'] ?? '') !== ($featured['slug'] ?? '')));
$title = 'Aprender com intenção';
$active = 'inicio';
require __DIR__ . '/includes/header.php';
?>
<section class="hero-section">
    <div class="container hero-grid">
        <div class="hero-copy">
            <p class="eyebrow"><span class="eyebrow-line"></span> Tecnologia a serviço da aprendizagem</p>
            <h1>Seu próximo passo de aprendizagem, <em>com intenção.</em></h1>
            <p class="hero-lead">No meio de tantas abas, notificações e caminhos possíveis, o RoadLearn transforma uma dificuldade em um caminho claro — um passo de cada vez.</p>
            <div class="hero-actions"><a class="button button-primary" href="<?= e(catalog_url()) ?>">Encontrar meu roadmap <span aria-hidden="true">↗</span></a><a class="text-link" href="#como-funciona">Entenda a proposta <span aria-hidden="true">↓</span></a></div>
            <div class="hero-meta"><span><strong><?= count($roadmaps) ?></strong> roadmaps iniciais</span><span><strong>0</strong> distrações desnecessárias</span></div>
        </div>
        <div class="hero-visual" aria-label="Ilustração de um caminho de aprendizagem progressivo">
            <div class="visual-orbit orbit-one"></div><div class="visual-orbit orbit-two"></div>
            <div class="visual-card visual-card-main"><div class="mini-label">ROADMAP EM DESTAQUE</div><div class="visual-title"><?= e($featured['short_title'] ?? 'Seu próximo tema') ?></div><div class="visual-progress"><span style="width: 0%"></span></div><div class="visual-progress-label"><span><?= count($featured['stages'] ?? []) ?> etapas</span><span>comece agora</span></div></div>
            <div class="visual-node node-top"><span>01</span><b>Base</b></div><div class="visual-node node-right"><span>02</span><b>Prática</b></div><div class="visual-node node-bottom"><span>03</span><b>Contexto</b></div>
            <div class="visual-spark spark-one">✦</div><div class="visual-spark spark-two">+</div>
        </div>
    </div>
</section>
<section class="signal-section"><div class="container signal-grid"><div><p class="eyebrow">A pergunta que guia tudo</p><h2>Como construir uma relação mais consciente entre tecnologia e educação?</h2></div><div class="signal-answer"><span class="signal-icon">↗</span><p>Usando a tecnologia para <strong>clarear o caminho</strong>, não para adicionar mais ruído.</p></div></div></section>
<section class="section" id="como-funciona"><div class="container"><div class="section-heading"><div><p class="eyebrow">Comece pelo que importa</p><h2>Um mapa para cada desafio.</h2></div><a class="text-link" href="<?= e(catalog_url()) ?>">Ver todos os roadmaps <span aria-hidden="true">↗</span></a></div><div class="roadmap-preview-grid">
<?php foreach (array_slice($previewRoadmaps, 0, 3) as $roadmap): ?>
<article class="roadmap-card accent-<?= e($roadmap['accent']) ?>"><div class="card-topline"><span class="subject-tag"><?= e($roadmap['area']) ?></span><span><?= e($roadmap['duration']) ?></span></div><h3><?= e($roadmap['title']) ?></h3><p><?= e($roadmap['description']) ?></p><div class="card-footer"><span><?= count($roadmap['stages']) ?> etapas</span><a href="<?= e(roadmap_url($roadmap['slug'])) ?>" aria-label="Abrir roadmap <?= e($roadmap['title']) ?>">Abrir roadmap <span aria-hidden="true">↗</span></a></div></article>
<?php endforeach; ?></div></div></section>
<section class="principles-section"><div class="container principles-grid"><div><p class="eyebrow">Estudar também é escolher</p><h2>Menos impulso.<br><em>Mais presença.</em></h2></div><div class="principles-list"><div class="principle"><span>01</span><div><h3>Clareza antes da velocidade</h3><p>Você entende onde está, por que aquela etapa importa e qual é o próximo passo.</p></div></div><div class="principle"><span>02</span><div><h3>Progresso sem pressão</h3><p>Seu avanço fica salvo no dispositivo, sem ranking, streaks ou notificações que puxam sua atenção.</p></div></div><div class="principle"><span>03</span><div><h3>Curadoria, não excesso</h3><p>Cada etapa aponta para poucos recursos escolhidos para ajudar de verdade.</p></div></div></div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
