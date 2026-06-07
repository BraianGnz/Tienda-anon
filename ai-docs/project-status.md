# Project Status

## Proyecto

Starter theme ecommerce profesional reutilizable para WordPress + WooCommerce.

Objetivo:
Crear una base sólida, rápida, mantenible y reusable para futuros clientes de agencia web.

---

# Stack actual

* WordPress clásico
* Gutenberg (free)
* WooCommerce
* Theme custom: anon-theme
* Bootstrap template convertido manualmente
* LocalWP
* Warp terminal
* OpenCode
* OpenRouter
* Git + GitHub
* Windows

---

# Filosofía del proyecto

NO usar:

* Elementor
* builders pesados
* plugins premium innecesarios
* arquitectura headless
* sobreingeniería

SÍ priorizar:

* rendimiento
* SEO
* WooCommerce estable
* Gutenberg moderno
* arquitectura reusable
* frontend limpio
* responsive profesional

---

# Estado actual

## Funcional

* front-page.php OK
* header.php integrado
* footer.php integrado
* WooCommerce instalado
* productos reales WooCommerce funcionando
* queries dinámicas WooCommerce funcionando
* overlays/modals/sliders OK
* responsive OK
* mobile OK
* consola limpia
* assets correctamente cargados
* imágenes funcionando

---

# Integraciones actuales

* soporte WooCommerce
* menús WordPress
* logo dinámico
* búsqueda
* carrito WooCommerce básico
* grids WooCommerce básicos
* estilos WooCommerce personalizados básicos
* sidebar categories dinámicas con product_cat real
* categories destacadas dinámicas con product_cat real (homepage)
* sidebar best sellers dinámicos con WP_Query + total_sales
* hero slider dinámico con CPT hero_slide + ACF + fallback hardcodeado + Swiper.js 11 (CDN)
* blog homepage dinámico con WP_Query + fallback placeholders
* blog seeder automático en activación de theme (inc/blog-seeder.php)

---

# Problemas ya solucionados

* ionicons esm.js errors
* addEventListener null errors
* sidebars WooCommerce innecesarias
* wrappers WooCommerce básicos
* rutas hardcodeadas assets
* conflictos básicos del theme
* front-page.php monolítico → modularizado en template-parts/home/
* categories destacadas dinámicas con get_terms('product_cat')
* sidebar best sellers dinámicos con WP_Query + total_sales + fallback recent products
* hero slider: CSS scroll-snap → Swiper.js 11 con loop, autoplay, pagination, navigation
* blog: HTML estático con datos fake → WP_Query dinámico + seeder automático con featured images reales

---

# Hero Slider — Swiper.js conversion (2026-06-07)

## Cambio aplicado

El hero slider de la homepage fue migrado de CSS scroll-snap nativo a
Swiper.js 11. El slider ya era dinámico (CPT hero_slide + ACF), ahora
también tiene transiciones suaves, autoplay configurable, navegación
por flechas y pagination bullets clickables.

## Archivos modificados/creados

| Archivo | Cambio |
|---------|--------|
| `functions.php` | Enqueue de Swiper 11 CSS + JS desde CDN (jsdelivr) |
| `assets/js/hero-slider.js` | **Nuevo**: init Swiper con loop, autoplay 6000ms, pauseOnMouseEnter, grabCursor, pagination clickable, navigation arrows, visibilitychange handler |
| `template-parts/home/hero.php` | Atributo `data-hero-slider`, clases `swiper-wrapper`/`swiper-slide`, elementos pagination + navigation |
| `style.css` | Bloque `#SWIPER HERO OVERRIDES`: container overrides, fallback hidden, bullets, arrows, hide arrows <480px |

## Detalles técnicos

- **CDN**: `https://cdn.jsdelivr.net/npm/swiper@11` — sin build step
- **Selectores scoped**: sufijo `-hero` en clases Swiper para evitar colisiones
- **Fallback**: Si no hay slides (sin Swiper), elementos de navegación no se renderizan en PHP; CSS los oculta si Swiper no está inicializado
- **Autoplay**: 6000ms, pausa en hover, pausa al cambiar de pestaña (visibilitychange)
- **Responsive**: Flechas ocultas en <480px (pantallas angostas no tienen espacio)
- **Sin cambios**: WooCommerce, ACF, CPT hero_slide, estructura del fallback, queries

## Decisión

Swiper 11 desde CDN sigue la filosofía "no build step" del proyecto. Es
la librería de sliders más popular y madura para JS vanilla. Los selectores
scoped con `-hero` permiten agregar otros sliders Swiper en el futuro sin
conflictos.

---

# Arquitectura WooCommerce actual

## Estado override templates

NO existen overrides en woocommerce/.
Se usa renderizado default WooCommerce (ul.products > li.product).

El front-page.php usa queries custom con .product-grid > .showcase.
Ambos conviven sin nesting inválido porque son contextos separados.

## Shop page estabilizada (2026-05-26)

Cambios aplicados:

1. Desactivados estilos CSS nativos de WooCommerce via filter en functions.php
   (woocommerce_enqueue_styles → array vacío). Esto evita que floats/widths
   del plugin rompan el CSS grid del theme.

 2. ul.products convertido a CSS grid con columnas responsive:
    - < 480px: 1 columna
    - 480px+: 2 columnas
    - 768px+: 3 columnas
    - 1024px+: 3 columnas
    - 1200px+: 4 columnas

3. li.product estilizado como card consistente:
   - border, border-radius, overflow hidden, box-shadow hover
   - position: relative (para badge absolute)
   - image hover zoom (scale 1.1)

4. Agregados estilos faltantes:
   - .onsale badge (position absolute, estilo .showcase-badge)
   - .star-rating (color sandy-brown, spacing)
   - price-box (flex, gap, ins/del)
   - .button (margin dentro de card)
   - page title
   - toolbar (result-count float left, ordering float right)

No se requirieron overrides de templates WC.
No se modificó front-page.php.
---

# Sistema de badges implementado

Badges WooCommerce estabilizados:

* descuento (% OFF)
* producto agotado
* producto nuevo

Características:

* badges responsive
* z-index corregido
* spacing consistente
* semántica mejorada usando <span>
* prioridad lógica:

  1. Out of stock
  2. Discount
  3. New

---

# Product Cards estabilizadas (2026-05-26)

Mejorada la consistencia visual de product cards en ambos contextos:

- **WooCommerce shop (`ul.products > li.product`)**:
  - `li.product` convertido a `display: flex; flex-direction: column;`
  - Imágenes con `aspect-ratio: 4/3; object-fit: cover;` — altura uniforme
  - Botón add-to-cart con `margin-top: auto` — siempre al fondo de la card

- **Homepage grid (`.product-grid > .showcase`)**:
  - `.showcase` convertido a `display: flex; flex-direction: column;`
  - `.showcase-banner` con `aspect-ratio: 4/3` — altura de imagen consistente
  - `.showcase-content` con `flex: 1; display: flex; flex-direction: column;`
  - `.price-box` con `margin-top: auto` — precio siempre al fondo

Ambos contextos ahora comparten misma estrategia de layout: flexbox vertical
con imágenes aspect-ratio 4:3 y último elemento (botón/precio) anclado al fondo.

Sin cambios en la lógica WooCommerce, hooks, add-to-cart, ni templates.

---

# Layout global estabilizado (2026-05-26 → 2026-05-28)

## Fase 1 (2026-05-26): Container fluido + overflow fix

### Causa raíz

El `.container` tenía `max-width: 980px` en el breakpoint 1024px.
En pantallas comunes (1280-1366px) esto dejaba 150-193px de espacio vacío
a cada lado, comprimiendo el grid de productos.

### Cambios aplicados (fase 1)

- Container fluido con `width: calc(100% - 48px/60px)` + `max-width`
- `position: fixed; left: -100%` en sidebar/mobile-nav → `left: -9999px`
- `html { overflow-x: hidden }` como safety net

## Fase 2 (2026-05-28): Rebuild completo responsive — sin calc, sin floats, sin columnas fijas

### Objetivo

Eliminar todo uso de `min-width: calc()` y `float` para layout responsivo.
Reemplazar con CSS Grid `auto-fit/minmax` y Flexbox limpio.

### Cambios aplicados

#### Container simplificado
Antes: `width: calc(100% - 48px/60px); max-width: 750/1100/1260/1400px` en cada breakpoint
Después: `width: 100%; max-width: 1400px; padding: 0 15px; margin: 0 auto` — breakpoints solo cambian padding (24px/30px)

#### Product grids
| Grid | Antes | Después |
|---|---|---|
| `.product-grid` | 1fr → 2fr(480px) → 3fr(1024px) → 4fr(1200px) | `auto-fit, minmax(220px, 1fr)` — adaptable |
| `ul.products` | 1fr → 2fr(480px) → 3fr(768px) → 3fr(1024px) → 4fr(1200px) | `auto-fit, minmax(220px, 1fr)` — adaptable |

#### Sidebar + product-box (≥1024px)
Antes: `min-width: calc(25% - 15px)` / `calc(75% - 15px)`
Después: `width: 260px; flex-shrink: 0` / `flex: 1; min-width: 0`

#### Toolbar
Antes: `float: left/right` en result-count y ordering
Después: Flex scoped a `.woocommerce-shop .woocommerce` con `margin-left: auto` en ordering

#### Section grids
| Sección | Reemplazo |
|---|---|
| `category-item-container` | Flex scroll → Grid `auto-fit/minmax(200px)` a ≥570px |
| `blog-container` | Flex scroll → Grid `auto-fit/minmax(280px)` a ≥570px |
| `testimonials-box` | Flex wrap con `min-width: calc()` → Grid `1fr 1fr` (1024px) / `repeat(4, 1fr)` (1200px) |

#### Flex items
| Item | Reemplazo |
|---|---|
| `product-minimal .product-showcase` → `flex: 1 1 45%/30%` | Elimina `min-width: calc(50%/33% - gap)` + `width: calc()` |
| `product-featured .showcase-content` → `flex: 1` | Elimina `min-width: calc(100% - 345px)` |
| `footer-nav-list` → `flex: 1 1 30%/18%; min-width: 220px/180px` | Elimina `min-width: calc(33%/20% - gap)` + `width: calc()` |
| `sidebar .showcase-content` → `flex: 1` | Elimina `width: calc(100% - 90px)` |
| `product-minimal .showcase-content` → `flex: 1` | Elimina `width: calc(100% - 85px)` |
| `toast-detail` → `flex: 1` | Elimina `width: calc(100% - 85px)` |

#### Overflow safety net removed
`html { overflow-x: hidden }` eliminado — todos los `position: fixed` usan `left: -9999px`.

### Resultado
- `min-width: calc()`: 0 reglas en style.css activo
- `width: calc()`: 0 reglas en style.css activo (solo `translateX(calc())` para animación)
- `float`: 0 reglas en WooCommerce toolbar
- CSS Grid `auto-fit/minmax`: grids adaptables sin breakpoints de columnas
- Flexbox limpio: sin width calc forzado
- Las animaciones `translateX(calc())` no afectan layout ni overflow

---

# Layout audit — Estructura real y corrección de overflow (2026-05-26 → 2026-05-28)

## Problemas estructurales encontrados

### 1. Overflow horizontal (causa raíz real)

Tres elementos `position: fixed` usaban `left: -100%` para ocultarse fuera
de pantalla. En Chrome, los elementos `position: fixed` con box model que
excede el viewport son incluidos en el cálculo del área scrolleable,
generando scrollbar horizontal:

| Elemento | Problema | Fix |
|---|---|---|
| `.sidebar` | `left: -100%` → box de 100vw se extiende fuera del viewport | `left: -9999px` |
| `.mobile-navigation-menu` | mismo caso | `left: -9999px` |
| `.notification-toast` | `position: fixed` + `left/right: 20px` + `transform: translateX(...)` — el box model permanece en el viewport aunque esté transformado off-screen | se mantiene, `overflow-x: hidden` era safety net |

**El `overflow-x: hidden` en `html` fue eliminado (2026-05-28)**
tras verificar que los elementos fixed con `left: -9999px` no generan
overflow horizontal y el notification-toast (translateX) no contribuye
al document scroll width por ser `position: fixed`.

### 2. Container simplificado (2026-05-28)

El `.container` fue simplificado de `width: calc(100% - Xpx)` con múltiples
`max-width` por breakpoint a un único sistema:

- Base: `width: 100%; max-width: 1400px; padding: 0 15px; margin: 0 auto`
- 768px: `padding: 0 24px`
- 1024px+: `padding: 0 30px`

Ya no necesita `width: calc()` — el padding interno asegura márgenes consistentes
y el `max-width: 1400px` limita el ancho máximo.

### 3. `.product-container .container` sin padding

A 1024px+, `.product-container .container` tiene `display: flex; gap: 30px; margin-bottom: 30px`
que sobreescribe el `padding: 0 15px` del `.container` base. Esto hace que
el contenido de la sección de productos arranque pegado al borde del container,
mientras que otras secciones (banner, categorías) tienen 15px de padding interno.

Esto es intencional del diseño original — permite que el grid de productos
aproveche el ancho completo. A diferencia del diseño anterior, ahora sidebar
y product-box usan flex puro sin calc (sidebar: 260px fijo, product-box: flex: 1).

## Wrappers analizados y estado

| Wrapper | Estado | Notas |
|---|---|---|
| `body` | ✅ Ok | Sin width fijo, overflow natural |
| `main` | ✅ Ok | Sin estilo propio, ok |
| `.container` | ✅ Simplificado | `width: 100%; max-width: 1400px; margin: auto; padding: 0 15px` — breakpoints solo padding |
| `.banner > .container` | ✅ Ok | Hereda container |
| `.category > .container` | ✅ Ok | Hereda container |
| `.product-container > .container` | ⚠️ Sin padding | Intencional — permite flex sidebar+product-box sin calc |
| `.product-box` | ✅ Ok | `flex: 1; min-width: 0` |
| `.product-main` | ✅ Ok | margin-bottom solo |
| `.product-grid` | ✅ Ok | `repeat(auto-fit, minmax(220px, 1fr))` — sin breakpoints de cols |
| `.product-minimal > .showcase-wrapper` | ✅ Ok | overflow-x: auto controlado |
| `.product-featured > .showcase-wrapper` | ✅ Ok | overflow-x: auto controlado |
| `.sidebar (base)` | ✅ Corregido | left: -9999px |
| `.sidebar (1024px+)` | ✅ Ok | `width: 260px; flex-shrink: 0; position: sticky` |
| `.mobile-navigation-menu` | ✅ Corregido | left: -9999px |
| `.notification-toast` | ✅ Ok | `position: fixed` + `translateX` — no afecta document scroll |
| `.footer-category > .container` | ✅ Ok | Hereda container |
| `.footer-nav > .container` | ✅ Ok | Hereda container |
| `.footer-bottom > .container` | ✅ Ok | Hereda container |
| `.blog > .container` | ✅ Ok | Hereda container |
| `.testimonials-box` | ✅ Corregido | Grid 1fr 1fr (1024px) / repeat(4,1fr) (1200px) — sin calc

## Resultado visual

- Shop usa ancho completo disponible con márgenes consistentes
- Homepage sin scrollbar horizontal (safety net eliminada)
- Container se adapta a cualquier resolución
- Layout consistente entre secciones (misma alineación base)
- Grids adaptables sin breakpoints de columnas fijas
- Sin cambios en el diseño visual del template Anon
- Sin `min-width: calc()`, sin `width: calc()`, sin `float` para layout

---

# Related / Upsells grid corregido (2026-05-27)

## Problema

`.woocommerce .related ul.products` y `.woocommerce .upsells ul.products`
tenían `grid-template-columns: repeat(4, 1fr)` en base (sin media query)
y en 768px. Esto forzaba 4 columnas incluso en mobile/tablet donde el container
es pequeño (320-750px), produciendo cards de ~71px/card en mobile.

Además, estas reglas tienen **mayor especificidad** (3 clases `.woocommerce .related ul.products`)
que las reglas responsive del main grid (`.woocommerce ul.products` con 2 clases),
por lo que los breakpoints del main grid no se aplicaban a related/upsells.

## Cambios aplicados

| Breakpoint | Main grid | Related/Upsells |
|---|---|---|
| Base (<480px) | 1 columna | 1 columna (hereda de main) |
| 480px+ | 2 columnas | 2 columnas (hereda de main) |
| 768px+ | 3 columnas | 3 columnas (hereda de main) |
| 1024px+ | 3 columnas | 3 columnas (hereda de main) |
| 1200px+ | 4 columnas | 4 columnas |

La regla base `repeat(4, 1fr)` para related/upsells fue **eliminada**.
La regla de 768px `repeat(4, 1fr)` para related/upsells fue **eliminada**.
La regla de 1024px `repeat(4, 1fr)` para main grid fue cambiada a **3 columnas**.
La regla de 4 columnas para **main grid** y **related/upsells** se agregó solo
dentro de `@media (min-width: 1200px)`.

## Resultado

- Related/upsells ahora siguen el mismo responsive que el main grid
- En mobile/tablet: cards con tamaño adecuado (~140-230px) en lugar de 71px
- En laptop común (1280-1366px): 3 columnas (~280-300px/card) en lugar de 4 columnas (~210px)
- En desktop grandes (1400px+): 4 columnas (~305px/card)

---

# Modularización de front-page.php (2026-05-27)

## Cambio aplicado

`front-page.php` fue reestructurado de ~988 líneas monolíticas a un orquestador
de 27 líneas que incluye 9 `get_template_part()` calls.

### Estructura resultante

```
template-parts/home/
├── hero.php                # Banner slider (3 slides)
├── categories.php          # Horizontal icon categories (8 items)
├── sidebar.php             # Sidebar: category menu (product_cat dinámico) + best sellers
├── product-minimal.php     # New Arrivals (WP_Query dinámico)
├── product-featured.php    # Deal of the day (WP_Query featured + fallback)
├── product-grid.php        # New Products grid (12 productos con badge logic)
├── banners.php             # CTA banner (25% Discount Summer Collection)
├── testimonials.php        # Testimonial + Service sections
└── blog.php                # Blog cards (WP_Query dinámico + fallback placeholders)
```

### Reglas aplicadas

1. **Sin cambios visuales**: Todo el HTML/CSS/ clases existentes se preservan exactamente
2. **Cada sección define su propio `$img`**: `get_template_part()` corre en scope global, por lo que cada template part que necesita imágenes define `$img = get_template_directory_uri() . '/html-template/assets/images'` en su primera línea
3. **Wrappers estructurales preservados en front-page.php**: `<main>`, `.product-container > .container`, `.product-box`, `.testimonials-box`, `</main>` — todo lo que agrupa secciones permanece en el orquestador
4. **Sin tocar WooCommerce logic**: Las queries de productos (`WP_Query`, `global $product`, badge logic) están intactas dentro de sus respectivos template parts
5. **Sin modificar CSS, JS ni functions.php**

### Riesgos

- `get_template_part()` carga archivos en scope global → las variables definidas dentro de un template part NO están disponibles en front-page.php ni en otros template parts. Esto es correcto y evita contaminación.
- Si un template part no existe, WordPress silencia el error (`get_template_part()` no lanza warning). Verificar que los 9 archivos existen.
- Los template parts que usan `WP_Query` con `while (have_posts())` llaman a `wp_reset_postdata()` al final, restaurando el `$post` global correctamente.

---


# Sidebar categories dinámicas (2026-05-27)

## Cambio aplicado

Reemplazadas las categorías hardcodeadas del sidebar (7 grupos con subcategorías
fake, stock fake, links "#") por datos dinámicos de WooCommerce taxonomy
`product_cat`.

### Qué se reemplazó

Todo el contenido de `ul.sidebar-menu-category-list` en `front-page.php`
(originalmente ~350 líneas de HTML estático con 7 accordion groups + subcategorías)
fue reemplazado por un loop PHP con `get_terms()`.

### Cómo funciona

```php
$product_cats = get_terms(array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
));
```

- Trae todas las categorías de productos WooCommerce con al menos 1 producto
- Cada una se renderiza como `<a href="...">` con link real a la página de archivo
- Muestra nombre real de categoría + cantidad real de productos
- Excluye categorías vacías (`hide_empty => true`)

### Estructura visual mantenida

- Mismas clases CSS: `.sidebar-menu-category`, `.sidebar-accordion-menu`, `.menu-title-flex`, `.menu-title`, `.stock`
- Mismo wrapper: `.sidebar-category` > `.sidebar-top` + `.sidebar-menu-category-list`
- El accordion JS (`[data-accordion-btn]`) queda sin elementos target → NodeList vacío → sin errores
- Las subcategorías (ul.sidebar-submenu-category-list) se eliminaron porque ahora son categorías planas

### Lo que NO se tocó

- `.product-showcase` (best sellers) se mantiene intacto
- `.sidebar-top` (título + close button) intacto
- No se modificó CSS
- No se modificó JS
- No se modificaron otras secciones de front-page.php

---

# Riesgos técnicos actuales (2026-05-31)

## RESUELTOS

### Shop page estabilizada (2026-05-26)
* ✅ Se desactivó CSS nativo de WooCommerce
* ✅ li.product estilizado como card visualmente consistente
* ✅ No existe nesting inválido (front-page y shop son contextos separados)
* ✅ Sin overrides de templates WC — se mantiene compatibilidad máxima

### Layout estable (2026-05-28)
* ✅ Container simplificado: `width: 100%; max-width: 1400px; padding: 0 15px`
* ✅ Sin `min-width: calc()` en layout — grids con `repeat()` explícito, flex con `flex: 1`
* ✅ Sin `float` para layout — toolbar con flex
* ✅ `html { overflow-x: hidden }` eliminado

### Product grids unificados (2026-05-31)
* ✅ **Eliminado**: `auto-fit/minmax(220px, 1fr)` en product grids — causaba cards angostas impredecibles
* ✅ **Implementado**: breakpoints explícitos mobile-first — mismo sistema para `.product-grid`, `ul.products`, related, upsells, `.product-minimal .showcase-wrapper`
* ✅ **Unificados gaps**: todos los product grids usan `gap: 20px` (antes: 25px/30px/20px inconsistentes)
* ✅ **Corregido**: `height: auto` eliminado de imágenes de productos — ya no conflictúa con `aspect-ratio: 4/3`
* ✅ **Reemplazado**: `left: -9999px` → `transform: translateX(-100%)` en sidebar y mobile-navigation-menu — elimina overflow, animación más suave
* ✅ **Simplificados**: badges sin overrides por breakpoint — un solo estilo base para todos
* ✅ **Reglas legacy eliminadas**: `--fs-5: 0.941rem` en sidebar, badge micro-ajustes en 480/1024/1200px, grid separado para related/upsells a 1200px
* ✅ **Corregido bug**: base `ul.products` grid estaba DESPUÉS de las reglas responsive — movido antes para que overrides ganen por source order
* ✅ **Migrado product-minimal**: de carrusel horizontal (`overflow-x: auto`) a CSS Grid con `display: contents` en `.showcase-container` y cards verticales tipo shop
* ✅ **Añadido**: `img { max-width: 100%; height: auto }` en reset CSS — previene overflow de imágenes sin width explícito
* ✅ Sin cambios visuales respecto al template Anon original

---

# Blog Dynamic Posts — Phase 3E (2026-06-07)

## Cambio aplicado

La sección de blog en la homepage fue migrada de HTML estático (4 cards
hardcodeadas con datos fake) a datos dinámicos con `WP_Query`. Además se
creó un sistema de seeding automático que provee contenido inicial relevante
al activar el theme.

## Archivos creados/modificados

| Archivo | Cambio |
|---------|--------|
| `inc/blog-seeder.php` | **Nuevo**: seeder que crea 4 categorías + 4 posts con featured images |
| `template-parts/home/blog.php` | **Reescrito**: WP_Query dinámico con fallback de placeholder images |
| `functions.php` | `require_once` para `inc/blog-seeder.php` |

## Seeder (`inc/blog-seeder.php`)

- **Categorías creadas**: Diseño (diseno), Corporativo (corporativo), Parches (parches), Merchandising (merchandising)
- **Posts creados**:
  1. "Cómo diseñar medias personalizadas para empresas" — categoría Diseño, image blog-1.jpg
  2. "Ventajas de los calcetines corporativos personalizados" — categoría Corporativo, image blog-2.jpg
  3. "Guía de parches termoadhesivos para ropa" — categoría Parches, image blog-3.jpg
  4. "Ideas de merchandising premium para marcas" — categoría Merchandising, image blog-4.jpg
- **Importación de imágenes**: `download_url()` + `media_handle_sideload()` almacena las imágenes del theme en la media library de WordPress
- **Limpieza**: Borra todos los posts existentes (v1 seed data, placeholders) antes de crear defaults
- **Flag único**: `update_option('anon_blog_articles_created', true)` previene ejecución duplicada
- **Hooks**: `after_switch_theme` + `admin_init` — asegura creación tanto al activar el theme como en el primer acceso al admin

## Template part (`template-parts/home/blog.php`)

- **Query**: `WP_Query(post_type => post, posts_per_page => 4, orderby => date, order => DESC, no_found_rows => true)`
- **Categorías**: `get_the_category()` → `$categories[0]->name` + `get_category_link()`
- **Thumbnails**: `has_post_thumbnail()` → `the_post_thumbnail('medium')` con fallback a placeholder (blog-1.jpg a blog-4.jpg)
- **Metadatos**: author con `the_author()`, fecha con `get_the_date()` + `<time datetime>`, permalink con `the_permalink()`
- **Sin inline seed**: no hay lógica de creación de posts en el template

## Decisión técnica

- `post_date` no se establece manualmente — se usa el default de `wp_insert_post` para evitar silent failures
- Las imágenes de los posts se importan a la media library, rompiendo la dependencia de URLs del theme
- El flag en `wp_options` previene recreación incluso si el theme se desactiva y reactiva
- `admin_init` en lugar de `init` asegura que las funciones de admin (`media_handle_sideload`, `wp_insert_post`) estén disponibles

## Riesgos

- `media_handle_sideload()` puede fallar por firewall, permisos de escritura en uploads, o `download_url()` timeouts
- Si se borran manualmente los posts seed, el flag persistente impide la recreación automática (hay que eliminar manualmente `anon_blog_articles_created` de `wp_options`)
- Los placeholders (blog-1.jpg a blog-4.jpg) siguen siendo archivos del theme — si el theme se renombra, el fallback de imágenes se rompe

---

# NO hacer todavía

* AJAX add-to-cart complejo
* fragments avanzados
* quick view real
* compare real
* wishlist real
* refactors masivos
* migraciones Tailwind
* React/headless

---

# Prioridad actual

Estabilizar:

* arquitectura WooCommerce
* product cards
* estructura reusable
* template hierarchy
* CSS reusable

Antes de agregar nuevas funcionalidades.
