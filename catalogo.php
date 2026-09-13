<?php
require_once __DIR__ . '/../includes/functions.php';

$roadmaps = load_roadmaps();
$title = 'Explorar roadmaps';
$active = 'catalogo';

require __DIR__ . '/../includes/header.php';
?>
<section class="page-intro">
	<div class="container narrow">
		<p class="eyebrow">Seu ponto de partida</p>
		<h1>O que você quer compreender melhor?</h1>
		<p>Escolha uma trilha e siga por uma sequência construída para fazer sentido. Você pode começar pelo básico, revisar ou avançar.</p>
	</div>
</section>

<section class="catalog-section">
	<div class="container">
		<div class="catalog-toolbar">
			<label class="search-field">
				<span aria-hidden="true">⌕</span>
				<span class="sr-only">Buscar roadmap</span>
				<input id="roadmap-search" type="search" placeholder="Buscar por tema, matéria ou competência..." autocomplete="off">
			</label>
			<div class="filter-group" role="group" aria-label="Filtrar por área">
				<button class="filter-button is-active" data-filter="all" type="button" aria-pressed="true">Todos</button>
				<button class="filter-button" data-filter="matematica" type="button" aria-pressed="false">Matemática</button>
				<button class="filter-button" data-filter="linguagens" type="button" aria-pressed="false">Linguagens</button>
				<button class="filter-button" data-filter="natureza" type="button" aria-pressed="false">Natureza</button>
				<button class="filter-button" data-filter="humanas" type="button" aria-pressed="false">Humanas</button>
			</div>
		</div>

		<div class="catalog-grid" id="roadmap-grid">
			<?php foreach ($roadmaps as $roadmap): ?>
				<article
					class="roadmap-card catalog-card accent-<?= e($roadmap['accent']) ?>"
					data-area="<?= e($roadmap['area_slug']) ?>"
					data-search="<?= e(roadmap_search_text($roadmap)) ?>"
				>
					<div class="card-topline">
						<span class="subject-tag"><?= e($roadmap['area']) ?></span>
						<span><?= e($roadmap['discipline'] ?? $roadmap['level']) ?></span>
					</div>
					<h2><?= e($roadmap['title']) ?></h2>
					<p><?= e($roadmap['description']) ?></p>
					<div class="competency-list">
						<?php foreach ($roadmap['competencies'] as $competency): ?>
							<span><?= e($competency) ?></span>
						<?php endforeach; ?>
					</div>
					<div class="card-footer">
						<span><?= count($roadmap['stages']) ?> etapas · <?= e($roadmap['duration']) ?></span>
						<a href="<?= e(roadmap_url($roadmap['slug'])) ?>">Explorar <span aria-hidden="true">↗</span></a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>

		<p class="empty-state" id="empty-state" hidden>Nenhum roadmap encontrado. Tente outro termo ou remova o filtro.</p>
	</div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
