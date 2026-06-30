# Architecture

## Theme

anon-theme

Theme custom WordPress orientado a ecommerce reusable.

---

# Objetivo arquitectónico

Construir un starter theme WooCommerce:

* modular
* mantenible
* reusable
* compatible con Gutenberg
* agency-ready

---

# Estructura actual aproximada

```txt
anon-theme/
│
├── assets/
│   ├── css/
│   ├── js/
│   │   └── hero-slider.js     # Swiper.js hero slider init (enqueued from CDN)
│   ├── images/
│
├── inc/
│   ├── branding.php        # Customizer Branding panel — 6 brand colors + CSS vars bridge (wp_add_inline_style)
│   ├── hero-slider.php     # Hero Slide CPT + ACF fields + default slides
│   ├── cta-banner.php      # CTA Banner ACF fields + seeder (front page meta)
│   ├── homepage-sections.php # Homepage section titles ACF + category icon ACF
│   ├── blog-seeder.php     # Default blog posts + categories on theme activation
│   ├── product-deal.php    # Deal of the Day ACF true/false field + query function
│   ├── testimonials.php    # Testimonial CPT + ACF fields + demo seeder
│   ├── footer-contact.php  # Footer Contact + Social ACF fields + seeder
│   └── footer-menus.php    # Footer menus walkers (Footer_Brand_Walker, Footer_Column_Walker) + seeder
│
├── languages/
│   └── anon-theme.pot          # POT file — 54 theme strings, textdomain anon-theme
│
├── ai-docs/
│
├── template-parts/
│   ├── woocommerce/
│   │   └── deal-product-card.php  # Single product card HTML (reusable, accepts global $product)
│   └── home/
│       ├── hero.php
│       ├── categories.php
│       ├── sidebar.php
│       ├── product-minimal.php
│       ├── product-featured.php
│       ├── product-grid.php
│       ├── banners.php
│       ├── testimonials.php
│       └── blog.php
│
├── woocommerce/
│   └── archive-product.php  # Catalog template (shop + categories) with breadcrumbs
│
├── front-page.php              # Homepage orchestrator (get_template_part calls)
├── woocommerce.php            # Routing: single → woocommerce_content(), archive → archive-product.php
├── archive.php                # Blog archives (category, tag, date, author)
├── search.php                 # Search results with pagination
├── 404.php                    # 404 page
├── single.php                 # Single post
├── page.php                   # Pages
├── header.php
├── footer.php
├── functions.php
├── inc/
│   ├── branding.php           # Customizer Branding — 6 brand colors + CSS vars bridge
│   ├── hero-slider.php       # CPT hero_slide + ACF + seed
│   ├── testimonials.php       # CPT testimonial + ACF + seed
│   ├── services.php           # CPT service + ACF + seed
│   ├── homepage-sections.php  # Homepage titles + category icon ACF
│   ├── product-deal.php       # ACF deal_of_the_day + query
│   ├── cta-banner.php         # ACF CTA fields + seed
│   ├── blog-seeder.php        # Blog post seeder
│   ├── footer-contact.php     # Footer contact ACF
│   ├── footer-menus.php       # Footer menu fallbacks
│   └── header-settings.php    # Header settings ACF
├── style.css                  # Monolítico, incluye #WOOCOMMERCE section
└── index.php                  # Dead code — fallback solo si ningún otro template matchea
```

NOTA: El directorio `woocommerce/` existe con `archive-product.php` (catálogo) y
`single-product.php` (producto individual). Ambos con breadcrumbs funcionales.
Los estilos WC están en style.css (#WOOCOMMERCE section).

---

# Objetivo futuro de estructura

```txt
anon-theme/
│
├── assets/
│   ├── css/
│   ├── js/
│   ├── images/
│
├── inc/
│   ├── seeder/             # Hero slides + blog posts seeders
│   ├── setup/
│   ├── enqueue/
│   ├── woocommerce/
│   ├── gutenberg/
│   ├── helpers/
│
├── template-parts/
│   └── home/
│       ├── hero.php
│       ├── categories.php
│       ├── sidebar.php
│       ├── product-minimal.php
│       ├── product-featured.php
│       ├── product-grid.php
│       ├── banners.php
│       ├── testimonials.php
│       └── blog.php
│
├── woocommerce/
│
└── ai-docs/
```

---

# Filosofía de desarrollo

Priorizar:

* estabilidad
* compatibilidad WooCommerce
* bajo riesgo
* commits pequeños
* cambios incrementales

Evitar:

* refactors agresivos
* cambios visuales innecesarios
* features complejas prematuras

---

# WooCommerce

## Homepage architecture

`front-page.php` ahora es un orquestador delgado. Cada sección de la homepage
vive en `template-parts/home/` y se incluye via `get_template_part()`.

Los wrappers estructurales que agrupan secciones se mantienen en el orquestador:
`<main>`, `.product-container > .container`, `.product-box`, `.testimonials-box`.

Cada template part que usa imágenes define su propio `$img` local.

## Enfoque actual (2026-06-19)

Uso de WooCommerce con override parcial:

* **`woocommerce/archive-product.php`**: override del catálogo (shop, categorías, tags) con breadcrumbs + H1 + loop completo
* **`woocommerce/single-product.php`**: override del producto individual con breadcrumbs + wrapper consistente
* **`woocommerce.php`**: routing condicional — single products → `wc_get_template('single-product.php')`, archives → `wc_get_template('archive-product.php')`
* NO hay woocommerce/content-product.php ni content-single-product.php (default WC)
* Se usa renderizado default de WC para product cards (ul.products > li.product)
* Todos los hooks nativos preservados (gallery, zoom, lightbox, add-to-cart, tabs, reviews, related)
* Estilos CSS en style.css (#WOOCOMMERCE section)
* CSS plugin nativo desactivado (woocommerce_enqueue_styles filter)
* front-page.php usa queries custom con .product-grid > .showcase (contexto separado)

### Breadcrumbs

`woocommerce_breadcrumb()` se llama directamente en `woocommerce/archive-product.php`
y `woocommerce/single-product.php` (no via hook `woocommerce_before_main_content`
porque ese hook también dispara wrappers div que rompen el layout del theme).

## Sidebar categories dinámicas (2026-05-27)

El sidebar de front-page.php ahora renderiza categorías WooCommerce reales:

- Reemplazado: HTML hardcodeado con datos fake → loop PHP con `get_terms('product_cat')`
- Cada categoría es un `<a>` directo a `get_term_link()` con nombre + contador real
- `hide_empty => true` excluye categorías sin productos
- Sin subcategorías (implementación plana por ahora)
- El accordion JS queda sin targets pero no genera errores (NodeList vacío)
- Las subcategorías anidadas (ul.sidebar-submenu-category-list) se removieron
- El product-showcase (best sellers) se mantiene intacto

## Related / Upsells

Related y upsells en single-product page usan `.woocommerce .related ul.products`
y `.woocommerce .upsells ul.products`. Tienen **mayor especificidad** (3 clases)
que el main grid (2 clases), por lo que los breakpoints del main grid no se
aplican automáticamente.

A partir de 2026-05-27, related/upsells siguen el mismo responsive que el main
grid porque se eliminaron sus reglas `repeat(4, 1fr)` específicas. Ahora heredan
las columnas del main grid en cada breakpoint, y comparten la regla de 4 columnas
solo dentro de `@media (min-width: 1200px)`.

## Shop page vs Homepage

Ambos contextos conviven sin nesting inválido porque:

* Shop page: ul.products > li.product (default WC)
* Homepage: .product-grid > .showcase (custom query en front-page.php)

Visualmente alineados mediante CSS grid y mismas variables de diseño.

---

# Product Cards

Objetivo:
Una sola arquitectura reusable para:

* home
* shop
* categorías
* relacionados
* upsells

## Estrategia de layout (2026-05-26)

Ambos contextos (shop y homepage) comparten:

- **Flexbox vertical** en la card (`display: flex; flex-direction: column`)
- **Imágenes con aspect-ratio 4:3** (`object-fit: cover`) para altura uniforme
- **Último elemento anclado al fondo** via `margin-top: auto`

Contextos:

| Contexto | Contenedor | Card | Imagen | Anclaje fondo |
|---|---|---|---|---|
| Shop | `ul.products` (CSS grid) | `li.product` | `a img` | `.button` |
| Homepage | `.product-grid` (CSS grid) | `.showcase` | `.showcase-banner` | `.price-box` |

No se requiere flexbox grid externo — el grid de columnas lo da el padre (CSS grid).
El flexbox es solo interno de la card para alinear contenido verticalmente.

---

# WooCommerce override parcial (RESUELTO 2026-06-19)

Existen `woocommerce/archive-product.php` y `woocommerce/single-product.php`.
Override controlado — catálogo (shop, categorías) + producto individual.
Breadcrumbs funcionales en todas las páginas WooCommerce.

Ver: project-status.md → "FASE 6C.1 — WooCommerce Catalog Template + Breadcrumbs"
Ver: project-status.md → "FASE 6C.2/B — Single Product Template con breadcrumbs"

---

# CTA Banner ACF (2026-06-07 — Fase 3F)

## Archivos creados/modificados

| Archivo | Cambio |
|---------|--------|
| `inc/cta-banner.php` | **Nuevo**: ACF field group (6 fields) registrado via `acf_add_local_field_group()` + seeder de defaults |
| `template-parts/home/banners.php` | **Reescrito**: lee ACF fields desde front page ID via `get_field()`, con fallback a valores originales hardcodeados |
| `functions.php` | `require_once` para `inc/cta-banner.php` |

## Seeder (`inc/cta-banner.php`)

- 6 campos ACF: imagen de fondo (image), badge/descuento (text), título principal (text), texto secundario (text), texto botón (text), URL botón (url)
- Location: `post_type=page` (front page) — no usa options page (no disponible en ACF Free)
- `cta_banner_get_front_page_id()` helper: lee `page_on_front` de `wp_options`
- `cta_banner_seed_defaults()`: seedea valores iniciales en `after_switch_theme` + `admin_init` + `acf/init` (priority 20)
- Defaults: imagen cta-banner.jpg, badge "20% OFF", título "Medias Personalizadas Premium", texto "Diseños exclusivos para empresas, eventos y marcas", botón "Ver Colección", URL home_url('/shop/')
- Flag `cta_banner_defaults_created` en `wp_options` para ejecución única
- Guardado con `update_field()` sobre el front page ID — no requiere ACF PRO

## Template part (`template-parts/home/banners.php`)

- Primero intenta `get_field()` desde front page ID via `cta_banner_get_front_page_id()`
- Si ACF no está activo o campos vacíos, fallback completo a valores originales:
  - Imagen: cta-banner.jpg
  - Badge: "25% Discount"
  - Título: "Summer collection"
  - Texto: "Starting @ $10"
  - Botón: "Shop now"
  - URL: "#"
- Usa `esc_url()` y `esc_html()` para output seguro

## Decisión técnica

- Usar meta de front page (`page_on_front`) en lugar de options page (ACF Free no soporta options pages)
- Campos editables en admin: Pages > Home > CTA Banner meta box
- `update_field()` con front page ID para seeding de defaults
- Fallback completo a HTML original si ACF no está disponible

---

# Deal of the Day ACF (2026-06-08 — Fase 3G)

## Archivos creados/modificados

| Archivo | Cambio |
|---------|--------|
| `inc/product-deal.php` | **Nuevo**: ACF true/false field `deal_of_the_day` on product post type (position: side, switch UI) + `get_deal_of_the_day_query()` function |
| `template-parts/woocommerce/deal-product-card.php` | **Nuevo**: extracted single product card HTML (showcase-container > showcase > showcase-banner + showcase-content with rating, title, description, price, add-to-cart form). Accepts global $product. |
| `template-parts/home/product-featured.php` | **Reescrito**: removed old _featured meta_query + random fallback. Uses `get_deal_of_the_day_query()`, loops once, calls `get_template_part('template-parts/woocommerce/deal-product-card')`. |
| `functions.php` | `require_once` para `inc/product-deal.php` |

## ACF field (`inc/product-deal.php`)

- **Field name**: `deal_of_the_day` (true/false)
- **Field type**: true/false con UI toggle (switch UI)
- **Location**: `post_type=product` — aparece en el sidebar de cada producto WooCommerce
- **Position**: `side` — meta box en el sidebar del editor de producto
- **Label**: "Producto Destacado — Deal of the Day"
- **Instructions**: "Marcar este producto como el Deal of the Day (solamente 1 producto)"

## Query function (`inc/product-deal.php`)

- `get_deal_of_the_day_query()`: WP_Query que:
  1. Primero busca productos con `meta_key=deal_of_the_day` y `meta_value=1`, `posts_per_page=1`, `orderby=date`, `order=DESC`
  2. Si no encuentra ningún producto marcado, **fallback** al último producto publicado (`posts_per_page=1`, `orderby=date`, `order=DESC`)
- Retorna `WP_Query` object — siempre tiene 1 post (o 0 si no hay productos en la tienda)

## Template part (`template-parts/woocommerce/deal-product-card.php`)

- HTML extraído exactamente del loop original de `product-featured.php`
- Misma estructura: `.showcase-container` > `.showcase` > `.showcase-banner` (imagen + badge descuento) + `.showcase-content` (rating, título, descripción corta, precio, add-to-cart form)
- No tiene query propia — espera `global $product` ya seteado
- Reutilizable desde cualquier template part que tenga `global $product` disponible

## Template part (`template-parts/home/product-featured.php`)

- Ya no usa `meta_query(_featured => yes)` — el old "featured" logic fue removida
- Ya no tiene fallback query duplicado con ~30 líneas de HTML repetido
- Ahora: llama `get_deal_of_the_day_query()`, entra al loop con `while(have_posts())`, y llama `get_template_part('template-parts/woocommerce/deal-product-card')`
- Título "Deal of the day" se mantiene hardcodeado (pendiente de dinamizar)
- Sin cambios en CSS, sin cambios visuales

## Decisión técnica

- ACF true/false con switch UI es más simple que un meta box custom — el admin solo activa/desactiva
- Ubicación en sidebar del producto: rápida de encontrar sin scroll
- Single product (no 4): cumple el requerimiento "solamente 1 producto marcado"
- Fallback a latest product (no random): predecible, siempre muestra el producto más reciente si no hay ninguno marcado
- Card HTML extraído a template-part reutilizable: elimina la duplicación de ~30 líneas que existía entre el main query y el fallback antiguo
- Sin cambios en CSS, JS ni WooCommerce hooks

---

# Blog Dinámico (2026-06-07 — Fase 3E)

## Archivos creados/modificados

| Archivo | Cambio |
|---------|--------|
| `inc/blog-seeder.php` | **Nuevo**: auto-crea 4 posts + 4 categorías en after_switch_theme + admin_init |
| `template-parts/home/blog.php` | **Reescrito**: WP_Query dinámico con has_post_thumbnail + fallback a placeholder |
| `functions.php` | `require_once` para `inc/blog-seeder.php` |

## Seeder (`inc/blog-seeder.php`)

- Crea categorías: Diseño, Corporativo, Parches, Merchandising
- Crea 4 posts con slugs, excerpt, contenido, featured image importada desde assets del theme
- Importa imágenes via `download_url()` + `media_handle_sideload()` — almacena en media library
- Limpia posts previos (v1 seed + placeholders) antes de crear defaults
- Usa flag `anon_blog_articles_created` en `wp_options` para ejecución única
- Hooks: `after_switch_theme` + `admin_init` (no `init`, para evitar issues de disponibilidad de funciones admin en frontend)
- NO establece `post_date` custom — usa defaults de `wp_insert_post` para evitar silent failures

## Template part (`template-parts/home/blog.php`)

- Query: `WP_Query(post_type=post, posts_per_page=4, orderby=date, order=DESC, no_found_rows=true)`
- Categorías dinámicas con `get_the_category()`, link a `get_category_link()`
- `has_post_thumbnail()` con fallback a placeholder images (blog-1.jpg a blog-4.jpg)
- Author dinámico, fecha real con `get_the_date()`, permalink con `the_permalink()`
- Sin inline seed logic

---

# Footer Contact + Social Links — Phase 3I

## Archivos

| Archivo | Rol |
|---------|-----|
| `inc/footer-contact.php` | **Nuevo**: 2 ACF field groups + helpers + seeder |
| `footer.php` | Contacto y redes sociales dinámicos |
| `functions.php` | `require_once` para `inc/footer-contact.php` |

## ACF fields — Contacto

6 campos registrados via `acf_add_local_field_group()` → `group_footer_contact`:
- `contact_address` (text), `contact_city` (text), `contact_region` (text), `contact_country` (text)
- `contact_phone` (text), `contact_email` (text)
- Location: `post_type=page` (front page)

## ACF fields — Redes Sociales

5 campos registrados via `acf_add_local_field_group()` → `group_footer_social`:
- `social_facebook` (url), `social_instagram` (url), `social_linkedin` (url)
- `social_tiktok` (url), `social_youtube` (url)
- Location: `post_type=page` (front page)

## Helpers (`inc/footer-contact.php`)

- `footer_contact_get_front_page_id()` — lee `page_on_front` de `wp_options`
- `footer_contact_get($field, $fallback)` — safe getter. Retorna fallback si ACF inactivo, front page no configurada, o campo vacío.

## Comportamiento

- **Dirección**: Siempre visible. Concatena address + city + region + country con `<br>`.
- **Teléfono**: Renderizado condicional. Enlace `tel:` sanitizado (solo dígitos y `+`).
- **Email**: Renderizado condicional. Enlace `mailto:` directo.
- **Redes sociales**: Si hay al menos una URL, renderiza solo las que tienen datos. Si todas vacías o ACF inactivo, fallback a 4 iconos originales (Facebook, Twitter, LinkedIn, Instagram) con `href="#"`.

## Seeder

- Hooks: `after_switch_theme` + `admin_init`
- Flag: `footer_contact_defaults_created` en `wp_options`
- Defaults adaptados al negocio (Av. Corrientes 1234, CABA, Argentina, +54 11 5678-9012, 5 redes sociales)

---

# CSS

Actualmente:

* CSS monolítico en style.css
* `img { max-width: 100%; height: auto; }` en reset (2026-05-31) — previene overflow por imágenes sin width explícito

## Container

El `.container` usa `padding: 0 15px` en mobile.
En desktop se centra con `margin: auto` y ancho fluido:

| Breakpoint | Padding | max-width |
|---|---|---|
| Base | `0 15px` | 1400px |
| 768px | `0 24px` | 1400px |
| 1024px | `0 30px` | 1400px |
| 1200px | `0 30px` | 1400px |
| 1400px | `0 30px` | 1400px |

Ya no usa `width: calc(100% - 60px)` — se simplificó a `width: 100%` + `padding`.

## Responsive grid system (2026-05-31 rebuild)

Todos los product grids usan **breakpoints explícitos mobile-first** con `repeat()`.

### Problema del sistema anterior

`auto-fit, minmax(220px, 1fr)` delega al browser la decisión de columnas. En resoluciones intermedias (480-600px) el browser forzaba 2 columnas de ~220px, comprimiendo cards que necesitan ~260px+ para mostrar imagen + título + precio + botón legibles. Además, los gaps eran inconsistentes entre homepage (25px), shop (20px) y related/upsells (sin gap propio).

### Sistema actual — breakpoints explícitos

Todos los product grids (`.product-grid`, `ul.products`, related, upsells, **`.product-minimal .showcase-wrapper`**) comparten **exactamente la misma lógica**:

| Breakpoint | Columnas | gap | Razón |
|---|---|---|---|
| Base (<480px) | 1 | 20px | Mobile angosto |
| 480px+ | 2 | 20px | Tablet chico / landscape |
| 1024px+ | 2 | 20px | Sidebar visible (~260px), espacio limitado |
| 1200px+ | 3 | 20px | Desktop amplio |
| 1400px+ | 4 | 20px | Ultra wide |

### Section grids

| Sección | Breakpoint | Grid rule |
|---|---|---|
| `.category-item-container` | ≥570px | `repeat(auto-fit, minmax(200px, 1fr))` gap 30px |
| `.blog-container` | ≥570px | `repeat(auto-fit, minmax(280px, 1fr))` gap 30px |
| `.testimonials-box` | ≥1024px | `1fr 1fr` gap 30px (`.service` spans full width) |
| `.testimonials-box` | ≥1200px | `repeat(4, 1fr)` (`.cta-container` spans 2) |

### Section flex items

| Item | Flex rule |
|---|---|
| `.product-featured .showcase-content` (768px) | `flex: 1` |
| `.footer-nav-list` (768px) | `flex: 1 1 30%; min-width: 220px` |
| `.footer-nav-list` (1024px) | `flex: 1 1 18%; min-width: 180px` |

### Product-minimal (New Arrivals) migration to grid (2026-05-31)

`.product-minimal` — la sección "New Arrivals" de la homepage — fue migrada de carrusel horizontal (`overflow-x: auto`, flex-row) a CSS Grid, unificando el layout con las shop cards.

**Antes:** Carrusel con scroll horizontal, batch containers de 4 productos, min-width: 100%, thumbnail 70px izquierda + contenido derecha.
**Después:** Grid con columnas responsivas, cards verticales iguales a shop, imagen 4/3 arriba, contenido abajo.

Detalles:
- `.showcase-wrapper`: `display: grid` (antes `overflow-x: auto`)
- `.showcase-container`: `display: contents` — wrappers PHP (cada 4 items) invisibles al grid
- `.showcase`: `flex-direction: column; border; border-radius; overflow: hidden` — igual que shop
- `.showcase-img-box`: `aspect-ratio: 4/3` (antes thumbnail 70px)
- `.showcase-title`: wrapping natural (antes `white-space: nowrap`)
- Responsive columns: hereda del sistema grid compartido con `.product-grid`, `ul.products`, etc.

### Toolbar

WooCommerce toolbar (`.woocommerce-result-count` + `.woocommerce-ordering`) usa flex layout scoped a `.woocommerce-shop .woocommerce`:
- Ambos con `flex: 0 0 auto`
- `.woocommerce-ordering` con `margin-left: auto` para alinear a la derecha
- Sin floats, sin calc

### Sidebar + product-box (≥1024px)

- `.sidebar`: `width: 260px; flex-shrink: 0; position: sticky`
- `.product-box`: `flex: 1; min-width: 0`

Reemplaza el anterior `min-width: calc(25% - 15px)` / `calc(75% - 15px)`.

### `overflow-x: hidden` eliminado + sidebar/mobile-nav mejorados (2026-05-31)

La safety net `html { overflow-x: hidden }` fue removida (2026-05-28).

Los elementos `position: fixed` (sidebar, mobile-nav) ahora usan `transform: translateX(-100%)`
en lugar de `left: -9999px` o `left: -100%`. Beneficios:

1. `transform` es solo visual — no afecta el document scroll width
2. Animación GPU-accelerated (más suave que animar `left`)
3. El box model permanece en `left: 0`, eliminando cualquier overflow

A 1024px+, sidebar resetea a `transform: none; position: sticky;` para su funcionamiento normal.

El `.notification-toast` usa `position: fixed` + `translateX` para animación,
que no contribuye al document scroll width.

## `.product-container .container`

A 1024px+ tiene `display: flex; gap: 30px; margin-bottom: 30px` — sobreescribe el
`padding` base del `.container`. Esto es intencional: permite que sidebar + product-box
ocupen el 100% del container con la flex gap en lugar de calc.

---

# JavaScript

Mantener JS separado.
NO usar inline JS en templates PHP.

## Swiper.js hero slider (2026-06-07)

El hero slider de la homepage (`hero.php`) usa Swiper.js 11 cargado desde CDN
(`functions.php` enqueue). El init vive en `assets/js/hero-slider.js`:
loop, autoplay 6000ms, pausa en hover, grabCursor, pagination bullets
clickables, navigation arrows, y handler de visibilitychange para pausar/reresumir.

Los estilos de Swiper override están en `style.css` dentro del bloque
`#SWIPER HERO OVERRIDES`.

---

# Branding System — Customizer colors (2026-06-24)

## Arquitectura

Sistema de 6 colores administrables vía WordPress Customizer, implementado con
Customizer API nativa + CSS custom properties bridge:

```
Customizer (panel "Branding" > "Colores")
    │
    ▼
get_theme_mod() defaults (HEX)
    │
    ▼
wp_add_inline_style('anon-theme-style')
    │
    ▼
:root { --brand-primary: #hex; ... }
    │  var() resolution
    ▼
style.css :root { --salmon-pink: var(--brand-primary, hsl(...)); }
    │
    ▼
349 CSS usages across the stylesheet
```

### Archivos

| Archivo | Rol |
|---------|-----|
| `inc/branding.php` | Customizer panel/section + 6 color controls + CSS output function |
| `style.css` (:root) | Bridge layer: `--salmon-pink: var(--brand-primary, hsl(353, 100%, 78%))` |
| `functions.php` | `require_once` + `wp_add_inline_style()` hook |

### Mapeo brand → theme

| Brand var | Theme var | Uso semántico | Default HEX |
|-----------|---|---|---|
| `--brand-primary` | `--salmon-pink` | Botones, enlaces, badges, hovers | `#f9a8b4` |
| `--brand-dark` | `--eerie-black` | Textos principales, fondos oscuros | `#212121` |
| `--brand-text` | `--sonic-silver` | Textos secundarios, iconos | `#787878` |
| `--brand-success` | `--ocean-green` | Iconos de servicio, éxito | `#46c389` |
| `--brand-error` | `--bittersweet` | Badges descuento, errores | `#ff6666` |
| `--brand-rating` | `--sandy-brown` | Estrellas, precios destacados | `#f0a050` |

### Decisiones técnicas

- **Dependencia cero**: Customizer nativo + `sanitize_hex_color()` — no requiere ACF PRO
- **Bridge layer**: Las variables originales `--salmon-pink` etc. se mantienen como
  `var(--brand-primary, hsl(...))`. El fallback HSL asegura funcionamiento incluso
  si el inline style no se genera (caching, error en PHP).
- **Scope `:root`**: Las `--brand-*` variables se declaran en `:root` via inline style
  (mayor especificidad que reglas en componentes). Las variables originales también
  están en `:root`, por lo que el cascade es directo.
- **transport refresh**: Los cambios en Customizer recargan la página.
- **Sin cambios visuales**: Los defaults HEX son equivalentes a los HSL actuales.

### Cómo usar

1. Ir a Apariencia > Personalizar > Branding > Colores
2. Cambiar cualquier color con el color picker
3. Publicar — la página se recarga con los nuevos colores

Para restaurar defaults, borrar el valor del color picker y publicar.

---

---

# Estrategia de internacionalización (i18n)

## Modelo híbrido

| Tipo de strings | Textdomain | Mecanismo |
|-----------------|-----------|-----------|
| Strings del theme | `anon-theme` | `load_theme_textdomain()` + `languages/anon-theme.pot` |
| Strings WooCommerce | `woocommerce` | `load_plugin_textdomain()` nativo de WC |
| Strings WordPress core | `default` | `load_default_textdomain()` nativo de WP |
| Add-to-cart button | `woocommerce` | `$product->add_to_cart_text()` — método nativo del producto |
| Product stock status | `woocommerce` | `__( 'Out of stock', 'woocommerce' )` |
| ACF field labels | — | NO traducidos (admin-facing) |
| CPT labels | — | NO traducidos (admin-facing) |
| Seed data | — | NO traducido (contenido, no strings del theme) |

## Flujo de carga

```
Site locale: es_ES (o it_IT, en_US)
    │
    ├── WP core       → wp-content/languages/es_ES.mo
    ├── WooCommerce   → wp-content/languages/plugins/woocommerce-es_ES.mo
    └── anon-theme    → wp-content/themes/anon-theme/languages/anon-theme-es_ES.mo
```

## Requisitos para traducción

- El POT (`languages/anon-theme.pot`) contiene 54 strings con textdomain `anon-theme`
- Los .mo/.po se generan desde el POT usando Poedit, Loco Translate o WP-CLI
- Los archivos deben nombrarse `anon-theme-{locale}.mo` (ej: `anon-theme-it_IT.mo`)
- El locale se detecta automáticamente de `WPLANG` (wp-config) o `site_locale` (DB)
- WooCommerce y WP core proveen sus propias traducciones oficiales

# Gutenberg

Objetivo futuro:

* soporte Gutenberg moderno
* theme.json
* block styles
* editor styles

Todavía NO implementado.
