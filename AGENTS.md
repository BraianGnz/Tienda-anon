# AGENTS.md — anon-theme

WordPress + WooCommerce starter theme. LocalWP on Windows.

## Repo facts

- **Path**: `wp-content/themes/anon-theme`
- **No build step**. Plain PHP + CSS. Edit files, refresh browser.
- **`woocommerce/`**: Existe con `archive-product.php` y `single-product.php` (breadcrumbs funcionales).
- **No JS framework**. Vanilla JS from `html-template/assets/js/script.js`.
- **No package manager**. No `package.json`, no `composer.json`.

## Key files

| File/Dir | Role |
|---|---|
| `inc/branding.php` | Customizer Branding panel — 6 brand colors (`--brand-primary` etc.) via `wp_add_inline_style()`. |
| `functions.php` | Theme setup: WooCommerce support, menus, scripts, sidebars, branding. Removes default WC sidebar. |
| `front-page.php` | Homepage layout — thin orchestrator. Uses `get_template_part()` for all sections. |
| `template-parts/home/` | Modular homepage sections: hero, categories, sidebar, product-minimal, product-featured, product-grid, banners, testimonials, blog. |
| `woocommerce.php` | Thin wrapper — calls `woocommerce_content()`. |
| `style.css` | Monolithic stylesheet. CSS custom properties at top (bridge layer `--salmon-pink: var(--brand-primary, hsl(...))`). All component + WC styles here. |
| `header.php` / `footer.php` | Global header/footer with navigation, search, cart. |
| `languages/anon-theme.pot` | POT file — 53 theme strings, textdomain `anon-theme`. Spanish (es) as default language. |

## Badge system (front-page.php product grid)

Badges use priority logic — only ONE per product:
1. **Out of stock** → `<span class="showcase-badge out-of-stock">Agotado</span>`
2. **Sale discount** → `<span class="showcase-badge discount">NN% OFF</span>`
3. **New** (≤30 days) → `<span class="showcase-badge new">Nuevo</span>`

CSS variants: `.discount`, `.sale`, `.out-of-stock`, `.new`, `.angle`, `.black`, `.pink` (legacy).

## Developer workflow

1. Edit PHP or CSS files directly.
2. Refresh LocalWP site in browser.
3. Manually QA: homepage, shop, mobile, tablet, browser console.

## Constraints

- **NO** refactors, Tailwind migration, React, headless, or Vite/Webpack.
- **NO** modify add-to-cart, AJAX, wishlist, quick view, or compare.
- **NO** aggressive visual changes. Stability > features.
- Keep commits small, one task per commit.
- CSS stays monolithic in `style.css` for now (modularization is future work).
- No inline JS in templates.

## Documentation rules

- **ALWAYS** read all files inside `ai-docs/` before making changes.
- **ALWAYS** update relevant `ai-docs/` files after modifying the project.
- **NEVER** delete, replace, or truncate existing `ai-docs/` content.
- Preserve historical context and append/update documentation incrementally.
- Document architectural decisions, risks, and pending tasks after relevant changes.

## AI docs

Detailed context lives in `ai-docs/`:
- `architecture.md` — current vs future structure, philosophy
- `project-status.md` — stack, what works, known risks
- `human-tasks.md` — QA checklist, git workflow, validation steps
- `opencode-tasks.md` — task priorities, restrictions

Read these before making structural changes.


## WooCommerce quirks

- Sidebar removed via `remove_action('woocommerce_sidebar', ...)` in `functions.php`.
- **CSS plugin nativo DESACTIVADO** via `woocommerce_enqueue_styles` filter en `functions.php`.
- Shop page usa `ul.products > li.product` default de WC, estilizado con CSS grid en `style.css` (#WOOCOMMERCE).
- Front-page.php usa `.product-grid > .showcase` (custom query). Son contextos separados, NO hay nesting inválido.
- Uses Ionicons 5.5.2 from unpkg CDN.

## Responsive layout system (2026-05-31)

- **Container**: `width: 100%; max-width: 1400px; padding: 0 15px; margin: 0 auto` — breakpoints solo cambian padding (24px at 768px, 30px at 1024px+).
- **Product grids — breakpoints explícitos mobile-first**: Todos los product grids (`.product-grid`, `ul.products`, related, upsells) comparten misma lógica: 1 col (<480px) → 2 cols (480px+) → 2 cols (1024px+, sidebar presente) → 3 cols (1200px+) → 4 cols (1400px+). Gap unificado: 20px. Sin `auto-fit/minmax`.
- **Section grids**: `.category-item-container`, `.blog-container` switch from horizontal scroll (mobile) to grid `auto-fit/minmax` at 570px+.
- **Sidebar + product-box** (≥1024px): sidebar `width: 260px; flex-shrink: 0`, product-box `flex: 1; min-width: 0`.
- **Sidebar/mobile-nav**: `position: fixed; transform: translateX(-100%)` en vez de `left: -9999px`. Sin overflow, animación GPU.
- **Toolbar**: flex scoped to `.woocommerce-shop .woocommerce`. No floats.
- **No `calc()` in layout**: All `min-width: calc()` and `width: calc()` removed. Only `translateX(calc())` remains for notification-toast animation.

## CSS custom properties

Theme uses design tokens in `:root` (see `style.css` top):
- Colors: `--ocean-green`, `--salmon-pink`, `--eerie-black`, `--davys-gray`, etc.
- Font sizes: `--fs-1` through `--fs-11`
- Weights: `--weight-300` through `--weight-700`
- Breakpoints: 480px, 570px, 768px, 1024px, 1200px, 1400px
