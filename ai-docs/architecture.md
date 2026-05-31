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
│   ├── images/
│
├── ai-docs/
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
├── front-page.php          # Homepage orchestrator (get_template_part calls)
├── woocommerce.php          # Thin wrapper → woocommerce_content()
├── header.php
├── footer.php
├── functions.php
├── style.css                # Monolítico, incluye #WOOCOMMERCE section
```

NOTA: No existe directorio woocommerce/ con overrides.
El shop usa templates default de WooCommerce.
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

## Enfoque actual

Usar WooCommerce clásico sin overrides de templates:

* NO hay woocommerce/archive-product.php ni woocommerce/content-product.php
* Se usa renderizado default de WC (ul.products > li.product)
* Estilos CSS en style.css (#WOOCOMMERCE section)
* CSS plugin nativo desactivado (woocommerce_enqueue_styles filter)
* front-page.php usa queries custom con .product-grid > .showcase (contexto separado)

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

# Riesgo actual importante (RESUELTO 2026-05-26)

No existe archive-product.php en el theme.
No hay conflicto con ul.products/li.product porque no hay overrides.
El shop usa templates default WC + CSS del theme.

Ver: project-status.md → "Shop page estabilizada"

---

# CSS

Actualmente:

* CSS monolítico en style.css

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

Todos los product grids (`.product-grid`, `ul.products`, related, upsells) comparten **exactamente la misma lógica**:

| Breakpoint | Columnas | gap | Razón |
|---|---|---|---|
| Base (<480px) | 1 | 20px | Mobile angosto |
| 480px+ | 2 | 20px | Tablet chico / landscape |
| 1024px+ | 2 | 20px | Sidebar visible (~260px), espacio limitado |
| 1200px+ | 3 | 20px | Desktop amplio |
| 1400px+ | 4 | 20px | Ultra wide |

### Section grids

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
| `.product-minimal .product-showcase` (768px) | `flex: 1 1 45%` |
| `.product-minimal .product-showcase` (1024px) | `flex: 1 1 30%` |
| `.product-featured .showcase-content` (768px) | `flex: 1` |
| `.footer-nav-list` (768px) | `flex: 1 1 30%; min-width: 220px` |
| `.footer-nav-list` (1024px) | `flex: 1 1 18%; min-width: 180px` |

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

---

# Gutenberg

Objetivo futuro:

* soporte Gutenberg moderno
* theme.json
* block styles
* editor styles

Todavía NO implementado.
