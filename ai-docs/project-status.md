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
* CTA banner dinámico con ACF fields desde front page meta + fallback hardcodeado
* Deal of the Day dinámico con ACF true/field en producto + fallback al último producto
* Testimonials homepage dinámico con CPT testimonial + ACF (city, product, show_on_home)
* Footer contacto y redes sociales dinámicos con ACF fields desde front page meta + fallback
* Footer menus (Brand Directory, Popular Categories, Our Company) dinámicos con wp_nav_menu + seeders automáticos + walkers custom

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
* cta banner: HTML estático con valores hardcodeados → ACF fields desde front page meta + fallback preservado
* footer brand directory: 57 enlaces `href="#"` con categorías fake → wp_nav_menu con 4 boxes (Medias, Calcetines, Parches, Accesorios)
* footer popular categories: 5 enlaces `href="#"` → wp_nav_menu (Tienda, Blog, Contacto)
* footer our company: 5 enlaces a páginas que no existen → wp_nav_menu (Sobre Nosotros, Términos, Delivery, Pago Seguro, Aviso Legal)
* deal of the day: WP_Query _featured + random fallback duplicado → ACF true/field seleccionable + single product + template-part reutilizable
* testimonials: HTML estático con datos ficticios + servicios estáticos → CPT testimonial + ACF fields + WP_Query dinámico con fallback image; servicios intactos
* footer contacto y redes sociales: HTML estático con datos ficticios y href="#" → ACF fields desde front page meta con 6 campos de contacto + 5 URLs de redes sociales + fallback preservado

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

# CTA Banner ACF Conversion — Phase 3F (2026-06-07)

## Cambio aplicado

El CTA banner de la homepage fue migrado de HTML estático con datos
hardcodeados (imagen cta-banner.jpg, "25% Discount", "Summer collection",
"Starting @ $10", "Shop now", `href="#"`) a campos ACF administrables desde
el admin de WordPress, con fallback completo al contenido original.

## Archivos creados/modificados

| Archivo | Cambio |
|---------|--------|
| `inc/cta-banner.php` | **Nuevo**: ACF field group + helper + seeder |
| `template-parts/home/banners.php` | **Reescrito**: get_field() con fallback |
| `functions.php` | `require_once` para `inc/cta-banner.php` |

## Seeder (`inc/cta-banner.php`)

- **ACF field group**: 6 campos registrados via `acf_add_local_field_group()`:
  - `cta_image` (image, return_format=url, required) — imagen de fondo
  - `cta_badge` (text, default "20% OFF") — badge/descuento
  - `cta_title` (text, default "Medias Personalizadas Premium", required) — título
  - `cta_text` (text, default "Diseños exclusivos para empresas, eventos y marcas") — texto
  - `cta_button_text` (text, default "Ver Colección") — texto botón
  - `cta_button_url` (url, default home_url('/shop/')) — URL botón
- **Location**: `post_type=page` (front page) — se muestra solo en la página de inicio
- **Position**: `normal` — meta box en el editor de página
- **Helper**: `cta_banner_get_front_page_id()` — lee `page_on_front` de `wp_options`
- **Seeding**: `cta_banner_seed_defaults()` se ejecuta en `after_switch_theme`, `admin_init`,
  y `acf/init` (priority 20). Verifica flag `cta_banner_defaults_created` en `wp_options`
  para ejecución única. Guarda defaults con `update_field()` sobre el front page ID.

## Template part (`template-parts/home/banners.php`)

- Llama a `cta_banner_get_front_page_id()` para obtener el front page ID
- Si ACF está activo y hay front page ID, lee los 6 campos con `get_field()`
- Si ACF no está activo o los campos están vacíos, usa fallback exacto:
  - Imagen: `cta-banner.jpg`
  - Badge: `"25% Discount"`
  - Título: `"Summer collection"`
  - Texto: `"Starting @ $10"`
  - Botón: `"Shop now"`
  - URL: `"#"`
- Output sanitizado con `esc_url()` y `esc_html()`
- Sin cambios en estructura HTML, clases CSS ni diseño visual

## Decisión técnica

- **Front page meta vs Options page**: ACF Free no soporta options pages.
  Se usa `get_option('page_on_front')` + `update_field()` con el post ID de la front page.
- **Admin UX**: Los campos se editan desde Pages > Home (editar página) > CTA Banner meta box.
- **Seeding**: No se importa la imagen a media library — se usa URL directa del theme.
  Esto es más simple pero crea dependencia de la ruta del theme.
- **Fallback**: Preserva exactamente el HTML y valores originales del template Anon,
  asegurando que desactivar ACF no rompe la homepage.

## Riesgos

- Si la front page cambia (Settings > Reading > Homepage), los fields seedeados
  quedan en la página anterior. El seeder solo se ejecuta si no hay datos en la
  nueva front page.
- La imagen default (cta-banner.jpg) no está en la media library — si el theme
  se renombra o reubica, la URL se rompe. El admin debe re-uploadear la imagen
  desde el meta box de ACF.
- `acf_add_local_field_group()` requiere ACF activo. Si ACF se desactiva,
  el field group no aparece y se usa el fallback (comportamiento seguro).

---

---

# Deal of the Day ACF Conversion — Phase 3G (2026-06-08)

## Cambio aplicado

La sección "Deal of the Day" de la homepage fue migrada de un query con
`meta_key=_featured` (productos destacados de WooCommerce, que no representa
un "deal" real) y un fallback random con HTML duplicado, a un sistema basado en
ACF true/field donde el admin puede marcar exactamente 1 producto desde el
sidebar del editor de producto.

El HTML del producto fue extraído a un template-part reutilizable, eliminando
la duplicación de ~30 líneas entre el main query y el fallback.

## Archivos creados/modificados

| Archivo | Cambio |
|---------|--------|
| `inc/product-deal.php` | **Nuevo**: ACF field group + query function |
| `template-parts/woocommerce/deal-product-card.php` | **Nuevo**: single product card reusable |
| `template-parts/home/product-featured.php` | **Reescrito**: usa `get_deal_of_the_day_query()` + template-part |
| `functions.php` | `require_once` para `inc/product-deal.php` |

## ACF field (`inc/product-deal.php`)

- **Field**: `deal_of_the_day` (true/false) con switch UI activado
- **Location**: `post_type=product`, position `side` — aparece como toggle en el sidebar del editor de producto
- **Label**: "Producto Destacado — Deal of the Day"
- **Instructions**: "Marcar este producto como el Deal of the Day (solamente 1 producto)"

## Query function

`get_deal_of_the_day_query()` (en `inc/product-deal.php`):

1. Query principal: `meta_key=deal_of_the_day`, `meta_value=1`, `posts_per_page=1`, `orderby=date`, `order=DESC`
2. Fallback: si no hay productos marcados, último producto publicado (`posts_per_page=1`, `orderby=date`, `order=DESC`)
3. Retorna siempre `WP_Query` con 1 post (o 0 si no hay productos en la tienda)

## Template part (`template-parts/woocommerce/deal-product-card.php`)

- HTML extraído exactamente del loop original de `product-featured.php`
- Misma estructura visual: `.showcase-container` > `.showcase` > `.showcase-banner` (imagen + badge descuento) + `.showcase-content` (rating, título, descripción corta, precio, add-to-cart form)
- Acepta `global $product` — no ejecuta query propia
- Reutilizable desde cualquier template part

## Template part (`template-parts/home/product-featured.php`)

- **Antes**: `WP_Query` con `meta_query(_featured => yes)`, 4 productos, fallback random que duplicaba ~30 líneas de HTML
- **Después**: llama `get_deal_of_the_day_query()`, loop single post, llama `get_template_part('template-parts/woocommerce/deal-product-card')`
- Título "Deal of the day" se mantiene hardcodeado

## Decisión técnica

- **ACF true/false con switch UI**: más simple que un meta box custom — el admin solo activa/desactiva en 1 click
- **Sidebar position**: el toggle está en el sidebar del editor de producto, siempre visible sin scroll
- **Single product**: cumple el requerimiento "solamente 1 producto marcado"
- **Fallback a latest product**: predecible, no random — siempre muestra el producto más reciente
- **Template-part reutilizable**: elimina la duplicación de HTML entre main query y fallback
- **Sin cambios en CSS, JS ni WooCommerce hooks**

## Riesgos

- `acf_add_local_field_group()` requiere ACF activo. Si ACF se desactiva, el field group desaparece y `get_field('deal_of_the_day')` retorna false/null, activando el fallback (comportamiento seguro)
- Si no hay productos en la tienda, `get_deal_of_the_day_query()` retorna 0 posts y la sección no se renderiza (edge case aceptable para un sitio vacío)
- El título "Deal of the day" sigue hardcodeado — pendiente de dinamizar via Customizer o ACF

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

# Testimonial CPT + ACF — Phase 3H (2026-06-08)

## Cambio aplicado

La sección de testimonios en la homepage fue migrada de HTML estático con datos
ficticios a un sistema dinámico basado en CPT + ACF. La sección de servicios
(Our Services) se mantiene intacta como HTML estático.

## Archivos creados/modificados

| Archivo | Cambio |
|---------|--------|
| `inc/testimonials.php` | **Nuevo**: CPT testimonial + ACF fields + seeder |
| `template-parts/home/testimonials.php` | **Reescrito**: WP_Query dinámico con ACF + fallback image |
| `functions.php` | `require_once` para `inc/testimonials.php` |

## CPT `testimonial`

- `show_ui=true`, `show_in_menu=true`, `menu_position=21`
- `menu_icon=dashicons-format-quote`
- `public=false`, `show_in_rest=false`
- `supports: title, editor, thumbnail, page-attributes`

## ACF fields

Registrados via `acf_add_local_field_group()` con location `post_type=testimonial`:

| Field | Type | Notes |
|---|---|---|
| `client_city` | text (label: Ciudad) | Se muestra en `.testimonial-title` |
| `product_name` | text (label: Producto comprado) | Se muestra junto a la ciudad |
| `show_on_home` | true_false (label: Mostrar en Home) | UI switch, default false |

## Template part (`template-parts/home/testimonials.php`)

- Query: `WP_Query(post_type=testimonial, posts_per_page=4, orderby=menu_order, meta_query=show_on_home=1)`
- Section completamente oculta si no hay testimonios visibles (`if ($testimonials_query->have_posts())`)
- Fallback image: `testimonial-1.jpg` del theme si no hay post thumbnail
- Ciudad + producto concatenados con " — " en `.testimonial-title`
- Servicios (`.service` con 5 items) siempre se renderizan, intactos

## Seeder (`inc/testimonials.php`)

- Crea 3 testimonios demo (María García, Carlos Mendoza, Lucía Fernández) con
  `show_on_home=false` — nunca aparecen en frontend
- `update_field()` para ACF fields
- **Guardias de ejecución única**:
  1. `get_option('testimonials_seeded')` — flag en wp_options
  2. `get_posts()` check — si ya existen testimonios, setea flag y retorna
- **Hooks**: `after_switch_theme` + `admin_init` — sin `init` para evitar
  ejecución en frontend y consultas innecesarias en cada request

## Decisión técnica

- `show_on_home=false` para demo testimonials asegura que el contenido de relleno
  nunca aparezca en la homepage
- El hook `init` fue eliminado después de la auditoría (2026-06-08) porque
  `after_switch_theme` + `admin_init` cubren todos los escenarios de activación
  sin overhead en cada request del frontend
- Sin importación de imágenes (`download_url`) — los testimonios sin thumbnail
  usan la imagen fallback del theme
- Sin cambios en CSS, JS ni estructura visual

## Riesgos

- `update_field()` requiere ACF activo. Si ACF se desactiva, los ACF fields de
  testimonios existentes retornan null y `.testimonial-title` queda vacío
- Si `show_on_home` se corrompe o falta, el meta_query no lo encuentra y el
  testimonio no se renderiza (comportamiento seguro — no se muestran testimonios
  con datos incompletos)

---

# Footer Contact + Social Links — Phase 3I (2026-06-09)

## Cambio aplicado

La sección de contacto y redes sociales del footer fue migrada de HTML
estático con datos ficticios a campos ACF administrables desde la front page.

## Archivos creados/modificados

| Archivo | Cambio |
|---------|--------|
| `inc/footer-contact.php` | **Nuevo**: 2 ACF field groups + helpers + seeder |
| `footer.php` | Modificado: contacto y redes sociales dinámicos |
| `functions.php` | `require_once` para `inc/footer-contact.php` |

## ACF fields — Contacto

Registrados via `acf_add_local_field_group()` con location `post_type=page`:

| Field | Type | Default seed |
|---|---|---|
| `contact_address` | text | "Av. Corrientes 1234" |
| `contact_city` | text | "CABA" |
| `contact_region` | text | "Buenos Aires" |
| `contact_country` | text | "Argentina" |
| `contact_phone` | text | "+54 11 5678-9012" |
| `contact_email` | text | "info@mediaspersonalizadas.com.ar" |

## ACF fields — Redes Sociales

| Field | Type | Default seed |
|---|---|---|
| `social_facebook` | url | `https://facebook.com/mediaspersonalizadas` |
| `social_instagram` | url | `https://instagram.com/mediaspersonalizadas` |
| `social_linkedin` | url | `https://linkedin.com/company/mediaspersonalizadas` |
| `social_tiktok` | url | `https://tiktok.com/@mediaspersonalizadas` |
| `social_youtube` | url | `https://youtube.com/@mediaspersonalizadas` |

## Comportamiento

- **Dirección**: Siempre se renderiza (usa concatenación de address + city + region + country con `<br>`). Si ACF inactivo, fallback a valores originales.
- **Teléfono**: Solo se renderiza si el campo tiene valor. Fallback a "(607) 936-8058".
- **Email**: Solo se renderiza si el campo tiene valor. Fallback a "example@gmail.com".
- **Redes sociales**: Si ACF activo, renderiza solo las plataformas que tienen URL configurada. Si ningún campo tiene URL, no se renderiza nada (sin `href="#"`). Si ACF inactivo, renderiza las 4 originales (Facebook, Twitter, LinkedIn, Instagram) con `href="#"` como fallback.
- **Footer menus**: 3 menús administrables (Brand Directory con walker parent-child para 4 boxes, Popular Categories, Our Company). Seeders crean items iniciales adaptados al negocio con enlaces reales a categorías WooCommerce y páginas.
- **tel: format**: El teléfono se sanitiza automáticamente (solo dígitos y `+`).
- **Social links**: Incluyen `target="_blank"` y `rel="noopener noreferrer"`.

## Helpers (`inc/footer-contact.php`)

- `footer_contact_get_front_page_id()` — lee `page_on_front` de `wp_options`
- `footer_contact_get($field, $fallback)` — safe getter con fallback. Retorna fallback si ACF inactivo, front page no configurada, o campo vacío.

## Seeder

- Crea valores iniciales adaptados al negocio (medias personalizadas premium, CABA, Argentina)
- Flag `footer_contact_defaults_created` en `wp_options` para ejecución única
- Hooks: `after_switch_theme` + `admin_init`

## Decisión técnica

- Dos field groups separados (Contacto + Redes Sociales) para mejor organización en el admin
- Front page meta en lugar de options page (ACF Free)
- tel: link formado automáticamente desde el mismo campo de display
- Sin cambios en CSS, JS ni estructura visual del footer

## Riesgos

- Si la front page se cambia (Settings > Reading), los fields seedeados quedan en la página anterior
- Los 5 ion-icons nuevos (logo-tiktok, logo-youtube) deben existir en la versión de Ionicons cargada (5.5.2). Verificar compatibilidad.
- Los 4 iconos originales de fallback (Facebook, Twitter, LinkedIn, Instagram) se preservan intactos con `href="#"`

---

# Fase 4 — Footer Menus Dinámicos (2026-06-11)

## Objetivo

Reemplazar 3 secciones hardcodeadas del footer con menús WordPress administrables vía `wp_nav_menu()`.

## Secciones convertidas

1. **Brand Directory** (`footer.php:3-22` → `inc/footer-menus.php:Footer_Brand_Walker`):
   - 4 boxes con parent-child: Medias (3 sub), Calcetines (3 sub), Parches (3 sub), Accesorios (3 sub)
   - Walkers custom: `Footer_Brand_Walker` (para estructura de boxes con h3 + enlaces)
   - Seed: 4 parents + 12 children con enlaces a categorías WooCommerce reales

2. **Popular Categories** (`footer.php:37-53` → `inc/footer-menus.php:Footer_Column_Walker`):
   - Walker custom: `Footer_Column_Walker` (para estructura li.footer-nav-item > a.footer-nav-link)
   - Seed: Tienda (/shop/), Blog (/blog/), Contacto (/contacto/)

3. **Our Company** (`footer.php:55-71` → `inc/footer-menus.php:Footer_Column_Walker`):
   - Seed: Sobre Nosotros, Términos y Condiciones, Delivery, Pago Seguro, Aviso Legal

## Archivos modificados

| Archivo | Cambio |
|---|---|
| `functions.php` | Registrados 3 nuevos theme locations: `footer_brand`, `footer_categories`, `footer_company`. Agregado `require_once inc/footer-menus.php`. |
| `footer.php` | 3 bloques hardcodeados reemplazados por `wp_nav_menu()` con walkers custom |
| `inc/footer-menus.php` | **NUEVO**: 2 walkers (`Footer_Brand_Walker`, `Footer_Column_Walker`), helper `footer_menus_get_cat_url()`, seeder `footer_menus_seed_defaults()` |

## Detalles técnicos

- `Footer_Brand_Walker`: depth=0 abre `div.footer-category-box > h3.category-box-title`, depth=1 enlace `a.footer-category-link`. Sin `<ul>/<li>` wrappers. `end_el` cierra el div solo en depth=0.
- `Footer_Column_Walker`: cada item es `li.footer-nav-item > a.footer-nav-link`. Sin `<ul>` wrapper (se usa `items_wrap => '%3$s'` dentro del ul del template).
- `footer_menus_get_cat_url()`: intenta `get_term_by('slug')` primero, fallback a `home_url('/product-category/{slug}/')`.
- Hooks seeder: `after_switch_theme` + `admin_init` (patrón estándar del proyecto).
- Flag: `footer_menus_defaults_created` en `wp_options`.

## QA

- ✅ Brand Directory: 4 boxes con títulos y enlaces a categorías reales
- ✅ Popular Categories: 3 enlaces (Tienda, Blog, Contacto)
- ✅ Our Company: 5 enlaces (Sobre Nosotros, Términos, Delivery, Pago Seguro, Aviso Legal)
- ✅ Cero `href="#"` en footer navigation
- ✅ Mismas clases CSS (`footer-category-box`, `category-box-title`, `footer-category-link`, `footer-nav-item`, `footer-nav-link`)
- ✅ Misma estructura HTML (divs, h3, ul, li preservados exactamente)
- ✅ Sin cambios en style.css
- ✅ Menús editables desde Apariencia > Menús

## Riesgos

- Si el usuario borra los menús seedeados, las secciones quedan vacías hasta que asigne/ cree nuevos menús (fallback_cb=false)
- `after_switch_theme` no se ejecuta si el theme ya está activo — `admin_init` cubre ese caso

---

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
