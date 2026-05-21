# AGENTS.md — anon-theme

WordPress + WooCommerce starter theme. LocalWP on Windows.

## Repo facts

- **Path**: `wp-content/themes/anon-theme`
- **No build step**. Plain PHP + CSS. Edit files, refresh browser.
- **No `woocommerce/` overrides**. WooCommerce uses its default templates.
- **No JS framework**. Vanilla JS from `html-template/assets/js/script.js`.
- **No package manager**. No `package.json`, no `composer.json`.

## Key files

| File | Role |
|---|---|
| `functions.php` | Theme setup: WooCommerce support, menus, scripts, sidebars. Removes default WC sidebar. |
| `front-page.php` | Homepage: banner, categories, 3 product sections (minimal, featured, grid). Main place product cards are rendered. |
| `woocommerce.php` | Thin wrapper — calls `woocommerce_content()`. |
| `style.css` | Monolithic stylesheet. CSS custom properties at top. All component + WC styles here. |
| `header.php` / `footer.php` | Global header/footer with navigation, search, cart. |

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
- Product grid CSS targets `.product-grid .showcase` (front-page custom), NOT WooCommerce's default `ul.products li.product`.
- Potential conflict between `.product-grid` and `ul.products`/`li.product` selectors — validate HTML nesting in DevTools after WC changes.
- Uses Ionicons 5.5.2 from unpkg CDN.

## CSS custom properties

Theme uses design tokens in `:root` (see `style.css` top):
- Colors: `--ocean-green`, `--salmon-pink`, `--eerie-black`, `--davys-gray`, etc.
- Font sizes: `--fs-1` through `--fs-11`
- Weights: `--weight-300` through `--weight-700`
- Breakpoints: 480px, 570px, 768px, 1024px, 1200px, 1400px
