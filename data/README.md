# Conteúdo dos roadmaps

O arquivo `roadmaps.json` é a fonte de conteúdo do RoadLearn. Ele não é uma página HTML e não deve ser acessado diretamente pelo estudante.

## Fluxo de renderização

1. `includes/functions.php` lê este arquivo com `load_roadmaps()`.
2. `index.php` e `pages/catalogo.php` percorrem a lista para criar os cards.
3. `pages/roadmap.php` recebe `?slug=...` e encontra um roadmap.
4. `pages/etapa.php` recebe `?slug=...&stage=...` e encontra uma etapa.
5. O PHP transforma os dados em HTML antes de enviá-los ao navegador.
6. `assets/js/app.js` adiciona busca, filtros, checklists e progresso local; ele não lê o JSON diretamente.

## Estrutura dos campos

### Roadmap

- `schema_version`: versão do formato, declarada na raiz de `roadmaps.json`.
- `slug`: identificador único usado na URL. Use letras minúsculas e hífens.
- `area`: nome exibido da matéria/área.
- `area_slug`: identificador usado pelos filtros do catálogo.
- `discipline`: disciplina curricular, como Matemática, Física ou Literatura.
- `domain`: domínio ou conjunto de temas cobertos pela trilha.
- `exam_targets`: exames para os quais a trilha foi alinhada; atualmente `ENEM`, `FUVEST`, `Unicamp` e `Unesp`.
- `title` e `short_title`: títulos completo e curto.
- `description`: apresentação do tema.
- `level`: nível sugerido.
- `duration`: duração estimada em texto.
- `competencies`: lista de competências exibidas no catálogo.
- `accent`: deve ser `mint`, `coral`, `blue` ou `gold` para combinar com o CSS.
- `featured`: define o roadmap destacado no conteúdo futuro da home.
- `study_tip`: dica exibida na lateral do roadmap.
- `last_reviewed`: data da última revisão editorial dos recursos, quando disponível.
- `stages`: lista ordenada de etapas.

### Etapa

- `id`: identificador único dentro do roadmap, usado na URL.
- `order`: ordem editorial; mantenha consistente com a posição no array.
- `title`: nome da etapa.
- `summary`: resumo exibido no roadmap e na página da etapa.
- `duration`: tempo estimado.
- `requires`: texto explicando o conhecimento anterior.
- `outcomes`: objetivos que o estudante pode marcar como concluídos.
- `resources`: links curados manualmente.

Cada recurso possui `type` (`aprender`, `revisar` ou `praticar`), `title`, `source` e `url`. Prefira URLs HTTPS e revise os links antes de publicar.

## Cobertura dos exames

`exam_targets` indica alinhamento temático, não garante que a trilha cubra todo o edital de uma edição. ENEM organiza a prova por áreas; FUVEST, Unicamp e Unesp podem variar por fase, carreira, edição e formato. Consulte sempre os editais e provas oficiais antes de afirmar cobertura completa.

## Adicionando um roadmap

Copie a estrutura de um roadmap existente, altere o `slug`, preencha os campos e adicione o objeto dentro da lista `roadmaps`. Não crie uma nova página PHP: as páginas existentes são genéricas e renderizam os dados automaticamente.
