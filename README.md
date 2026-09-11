# RoadLearn

Protótipo de um website educacional que transforma uma dificuldade em um roadmap de aprendizagem progressivo, com foco em uma relação mais consciente entre tecnologia e educação.

## Stack

- PHP 8+ para templates e roteamento simples por query string.
- HTML semântico e CSS responsivo.
- JavaScript vanilla, sem dependências ou build obrigatório.
- JSON local para conteúdo e `localStorage` para progresso do estudante.

## Executar localmente

É necessário ter PHP instalado. Na raiz do projeto, execute:

```text
php -S localhost:8000
```

Depois acesse `http://localhost:8000`.

## Estrutura

- `index.php`: apresentação e roadmaps em destaque.
- `pages/catalogo.php`: busca e filtros por área.
- `pages/roadmap.php`: sequência completa de uma trilha.
- `pages/etapa.php`: objetivos, recursos e navegação entre etapas.
- `data/roadmaps.json`: conteúdo editável das trilhas.
- `includes/`: funções e layout compartilhado.
- `assets/`: estilos e interações.

O catálogo atual contém roadmaps de Matemática, Língua Portuguesa/interpretação, Redação, Literatura, Língua Inglesa, Física, Química, Biologia, História, Geografia, Sociologia e Filosofia. Os quatro exames usados como referência editorial são ENEM, FUVEST, Unicamp e Unesp.

## Como o JSON vira uma página

`data/roadmaps.json` é um arquivo de conteúdo, semelhante a um pequeno banco de dados editorial. Ele não precisa conter HTML e não é uma página acessada diretamente pelo estudante.

O PHP lê os dados e escolhe o conteúdo com parâmetros da URL:

- `http://roadlearn/` → `index.php` e os roadmaps em destaque.
- `http://roadlearn/pages/catalogo.php` → todos os roadmaps.
- `http://roadlearn/pages/roadmap.php?slug=equacao-2-grau` → o roadmap cujo `slug` é `equacao-2-grau`.
- `http://roadlearn/pages/etapa.php?slug=equacao-2-grau&stage=bhaskara` → a etapa cujo `id` é `bhaskara`.

O caminho interno é:

1. `load_roadmaps()` lê o JSON em `includes/functions.php`.
2. `find_roadmap()` e `find_stage()` localizam os dados solicitados.
3. Os arquivos em `pages/` percorrem os arrays com `foreach` e geram HTML.
4. `e()` escapa textos antes de colocá-los no HTML.
5. O navegador recebe uma página normal; o JavaScript apenas adiciona filtros e progresso.

Os links internos passam por helpers como `catalog_url()`, `roadmap_url()` e `stage_url()`. Isso é importante no WAMP, pois evita gerar caminhos duplicados como `/pages/pages/roadmap.php`.

## Adicionar conteúdo

Edite `data/roadmaps.json` respeitando o formato existente. Cada roadmap deve ter um `slug` único, `discipline`, `domain`, `exam_targets` e etapas com `id` único dentro da trilha. Links externos são curados manualmente e devem abrir com `https`.

Para uma trilha ser considerada completa, use pelo menos quatro etapas: fundamentos, aplicação guiada, prática independente e síntese/avaliação. A indicação de exame representa alinhamento de temas, não cobertura automática de um edital inteiro.

Consulte [`data/README.md`](data/README.md) para conhecer todos os campos e o fluxo de publicação.

O conteúdo interno é uma orientação de aprendizagem, não uma cópia de aulas de terceiros. Revise disponibilidade, qualidade e atribuição dos links antes de publicar.

## Próximos passos

O MVP ainda não possui autenticação, banco de dados ou sincronização entre dispositivos. Essas capacidades podem ser adicionadas depois sem alterar a estrutura principal de conteúdo.
