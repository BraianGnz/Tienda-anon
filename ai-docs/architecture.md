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
├── front-page.php          # Homepage: banner, categorías, 3 secciones producto
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
En desktop se centra con `margin: auto` y es fluido con `width: calc(100% - X)`:

| Breakpoint | width | max-width | Margen c/lado | Grid cols |
|---|---|---|---|---|---|
| 768px | `calc(100% - 48px)` | 750px | 24px | 3 |
| 1024px | `calc(100% - 60px)` | 1100px | 30px hasta 1160px vp | 3 |
| 1200px | `calc(100% - 60px)` | 1260px | 30px hasta 1320px vp | 4 |
| 1400px | `calc(100% - 60px)` | 1400px | 30px hasta 1460px vp | 4 |

Esto asegura que el container siempre use el ancho disponible (con márgenes
consistentes) hasta alcanzar el límite máximo de diseño.

`html { overflow-x: hidden }` previene scrollbar horizontal (safety net).
La causa raíz del overflow era `position: fixed; left: -100%` en `.sidebar`
y `.mobile-navigation-menu`, corregido a `left: -9999px`.

## `.product-container .container`

A 1024px+ tiene `display: flex; gap: 30px;` que sobreescribe el `padding` base.
Esto es intencional: permite que sidebar + product-box calculados con
`calc(25% - 15px)` / `calc(75% - 15px)` ocupen el 100% exacto del container.
Agregar padding rompería estos cálculos.

Objetivo futuro:
modularizar CSS por:

* components
* layout
* pages
* woocommerce

NO hacer todavía.

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
