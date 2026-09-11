(() => {
  const STORAGE_KEY = 'roadlearn-progress-v1';

  function readProgress() {
    try {
      return JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}');
    } catch {
      return {};
    }
  }

  function writeProgress(progress) {
    try {
      localStorage.setItem(STORAGE_KEY, JSON.stringify(progress));
    } catch {
      // O site continua utilizável mesmo se o navegador bloquear o storage.
    }
  }

  function getRoadmapProgress(slug, progress = readProgress()) {
    return progress[slug] || { stages: [], outcomes: [] };
  }

  function updateRoadmapProgress() {
    const progressElement = document.querySelector('[data-roadmap]');
    if (!progressElement) return;

    const slug = progressElement.dataset.roadmap;
    const checks = [...document.querySelectorAll('[data-stage]')];
    const completedStages = getRoadmapProgress(slug).stages;

    checks.forEach((check) => {
      const isComplete = completedStages.includes(check.dataset.stage);
      check.checked = isComplete;
      check.closest('.timeline-item')?.classList.toggle('is-complete', isComplete);
    });

    const percent = checks.length
      ? Math.round((completedStages.length / checks.length) * 100)
      : 0;

    progressElement.querySelector('.progress-label').textContent = `${percent}% concluído`;
    progressElement.querySelector('.progress-fill').style.width = `${percent}%`;
  }

  function bindStageProgress() {
    document.querySelectorAll('[data-stage]').forEach((check) => {
      check.addEventListener('change', () => {
        const progressElement = document.querySelector('[data-roadmap]');
        if (!progressElement) return;

        const slug = progressElement.dataset.roadmap;
        const progress = readProgress();
        progress[slug] = getRoadmapProgress(slug, progress);
        progress[slug].stages = [...document.querySelectorAll('[data-stage]:checked')]
          .map((item) => item.dataset.stage);

        writeProgress(progress);
        updateRoadmapProgress();
      });
    });

    updateRoadmapProgress();
  }

  function filterCatalog(cards, searchTerm, activeFilter) {
    const normalizedTerm = searchTerm.toLowerCase().trim();
    let visibleCards = 0;

    cards.forEach((card) => {
      const matchesArea = activeFilter === 'all' || card.dataset.area === activeFilter;
      const matchesText = !normalizedTerm || card.dataset.search.includes(normalizedTerm);
      const isVisible = matchesArea && matchesText;

      card.hidden = !isVisible;
      if (isVisible) visibleCards += 1;
    });

    return visibleCards;
  }

  function bindCatalogFilters() {
    const search = document.querySelector('#roadmap-search');
    const filters = [...document.querySelectorAll('[data-filter]')];
    const cards = [...document.querySelectorAll('[data-area]')];
    const emptyState = document.querySelector('#empty-state');

    if (!search || !cards.length) return;

    let activeFilter = 'all';

    function updateCatalog() {
      const visibleCards = filterCatalog(cards, search.value, activeFilter);
      if (emptyState) emptyState.hidden = visibleCards !== 0;
    }

    search.addEventListener('input', updateCatalog);
    filters.forEach((button) => {
      button.addEventListener('click', () => {
        activeFilter = button.dataset.filter;
        filters.forEach((item) => {
          const isActive = item === button;
          item.classList.toggle('is-active', isActive);
          item.setAttribute('aria-pressed', String(isActive));
        });
        updateCatalog();
      });
    });
  }

  function bindOutcomeProgress() {
    const slug = new URLSearchParams(window.location.search).get('slug');
    if (!slug) return;

    const progress = readProgress();
    const roadmapProgress = getRoadmapProgress(slug, progress);

    document.querySelectorAll('[data-outcome]').forEach((check) => {
      const value = `${check.dataset.outcome}:${check.nextElementSibling?.textContent}`;
      check.checked = roadmapProgress.outcomes.includes(value);

      check.addEventListener('change', () => {
        const currentProgress = readProgress();
        currentProgress[slug] = getRoadmapProgress(slug, currentProgress);
        const outcomes = currentProgress[slug].outcomes;

        currentProgress[slug].outcomes = check.checked
          ? [...new Set([...outcomes, value])]
          : outcomes.filter((item) => item !== value);

        writeProgress(currentProgress);
      });
    });
  }

  function bindFocusMode() {
    const button = document.querySelector('[data-focus-toggle]');
    if (!button) return;

    button.addEventListener('click', () => {
      document.body.classList.toggle('focus-mode');
      const isActive = document.body.classList.contains('focus-mode');

      button.textContent = isActive ? 'Sair do foco' : 'Ativar foco';
      button.classList.toggle('is-active', isActive);
      button.setAttribute('aria-pressed', String(isActive));
    });
  }

  function bindMobileMenu() {
    const button = document.querySelector('.menu-toggle');
    const navigation = document.querySelector('.main-nav');
    if (!button || !navigation) return;

    button.addEventListener('click', () => {
      const isOpen = button.getAttribute('aria-expanded') === 'true';
      button.setAttribute('aria-expanded', String(!isOpen));
      navigation.classList.toggle('is-open', !isOpen);
    });
  }

  bindStageProgress();
  bindCatalogFilters();
  bindOutcomeProgress();
  bindFocusMode();
  bindMobileMenu();
})();
