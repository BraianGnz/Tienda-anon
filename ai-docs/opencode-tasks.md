# OpenCode Tasks

## REGLAS IMPORTANTES

SIEMPRE:

* cambios pequeños
* no romper frontend
* mantener responsive
* mantener compatibilidad WooCommerce
* explicar riesgos antes de cambios grandes

NUNCA:

* refactors masivos sin pedirlo
* cambiar diseño visual innecesariamente
* agregar dependencias pesadas
* modificar arquitectura completa sin validación

---

# Prioridad actual

## Estabilización WooCommerce

---

# Tareas pendientes

## ~~Alta prioridad~~ (COMPLETADO 2026-05-26)

### Shop page estabilizada

1. ✅ Desactivado CSS nativo WooCommerce (functions.php filter)
2. ✅ ul.products convertido a CSS grid con breakpoints responsive
3. ✅ li.product estilizado como card (border, radius, shadow, hover zoom)
4. ✅ .onsale badge estilizado (posición absolute, color ocean-green)
5. ✅ .star-rating estilizado (sandy-brown)
6. ✅ price-box con flex, ins/del
7. ✅ button integrado al card
8. ✅ toolbar (result-count + ordering) con float left/right
9. ✅ page title estilizado
10. ✅ breakpoints 480px/768px/1024px/1200px para ul.products

Decisión: NO crear overrides de templates WC.
Se mantiene ul.products/li.product default + CSS puro.
No hay nesting inválido (son contextos separados).

---

## ~~Media prioridad~~ (COMPLETADO 2026-05-26)

### Product cards consistency

1. ✅ Flexbox vertical en `li.product` (WooCommerce shop grid)
2. ✅ `aspect-ratio: 4/3 + object-fit: cover` en imágenes del shop
3. ✅ `.button` con `margin-top: auto` (siempre al fondo del card)
4. ✅ Flexbox vertical en `.product-grid .showcase` (homepage grid)
5. ✅ `aspect-ratio: 4/3` en `.showcase-banner`
6. ✅ `flex: 1 + flex-direction: column` en `.showcase-content`
7. ✅ `.price-box` con `margin-top: auto` (siempre al fondo)
8. ✅ Sin cambios en lógica WooCommerce, hooks, ni templates

---

## ~~Media prioridad~~ (COMPLETADO 2026-05-26)

### Layout audit — Estructura real, overflow y container fluido

1. ✅ Detectado: `position: fixed; left: -100%` en `.sidebar` y `.mobile-navigation-menu` causaban overflow horizontal (Chrome incluye fixed elements en scrollable area)
2. ✅ Corregido: `left: -100% → left: -9999px` en ambos
3. ✅ Container ahora fluido: `width: calc(100% - 60px)` + `max-width` en 768px/1024px/1200px/1400px — siempre mantiene márgenes consistentes
4. ✅ Sin cambios en diseño visual, paddings, gaps del template Anon
5. ✅ Documentados todos los wrappers y su estado en project-status.md

Causa raíz overflow: `position: fixed` con `left: -100%` (sidebar, mobile-nav).
Causa raíz espacio vacío: `max-width` fijo sin `width` fluido.

---

## ~~Media prioridad~~ (COMPLETADO 2026-05-27)

### Related/Upsells grid corregido

1. ✅ Eliminada regla base `repeat(4, 1fr)` para `.woocommerce .related ul.products` y `.woocommerce .upsells ul.products`
2. ✅ Eliminada regla 768px `repeat(4, 1fr)` para related/upsells — ahora heredan del main grid
3. ✅ Cambiado main grid 1024px de `repeat(4, 1fr)` a `repeat(3, 1fr)` — cards más anchas en laptops comunes
4. ✅ Agregado `@media (min-width: 1200px)` con `repeat(4, 1fr)` para main grid y related/upsells
5. ✅ Agregado `padding-bottom: 15px` a `.product-grid .showcase-content` para separar contenido del borde inferior

Decisión: Related/upsells heredan del main grid en lugar de tener reglas separadas.
Esto simplifica el mantenimiento y evita inconsistencias entre grids.

---

## ~~Alta prioridad~~ (COMPLETADO 2026-05-27)

### Modularización de front-page.php

1. ✅ Auditada estructura completa de front-page.php (988 líneas → 9 secciones lógicas)
2. ✅ Creado directorio `template-parts/home/` con 9 archivos:
   - `hero.php` — banner slider
   - `categories.php` — icon categories row
   - `sidebar.php` — category menu + best sellers
   - `product-minimal.php` — New Arrivals (WP_Query dinámico)
   - `product-featured.php` — Deal of the day (WP_Query + fallback)
   - `product-grid.php` — New Products grid + badge logic
   - `banners.php` — CTA banner
   - `testimonials.php` — testimonial + service sections
   - `blog.php` — blog cards
3. ✅ front-page.php reducido a orquestador de 27 líneas con `get_template_part()` calls
4. ✅ Sin cambios visuales — todo HTML/CSS/clases preservadas exactamente
5. ✅ Sin modificar CSS, JS, WooCommerce logic, ni functions.php
6. ✅ PHP syntax validado en los 10 archivos
7. ✅ Cada template part define su propio `$img` (get_template_directory_uri)
8. ✅ Wrappers estructurales preservados en front-page.php (main, .product-container, .product-box, .testimonials-box)

Decisión: La homepage ahora sigue el patrón WordPress estándar de template parts.
Cada sección es aislada, reutilizable y mantenible individualmente.
Próximo paso: fase 2 (dinamizar secciones restantes).

---

## ~~Media prioridad~~ (COMPLETADO 2026-05-27)

### Sidebar categories dinámicas

1. ✅ Detectadas todas las partes estáticas/fake del sidebar (7 accordion groups con subcategorías hardcodeadas, stock fake, links "#")
2. ✅ Reemplazado `ul.sidebar-menu-category-list` con loop PHP `get_terms('product_cat', 'hide_empty' => true)`
3. ✅ Cada categoría renderiza: nombre real, contador real de productos, link real a archive page
4. ✅ Mantenidas clases CSS existentes (`.sidebar-menu-category`, `.sidebar-accordion-menu`, `.menu-title-flex`, `.menu-title`, `.stock`)
5. ✅ Mantenido wrapper intacto (`.sidebar-category` > `.sidebar-top` + `ul.sidebar-menu-category-list`)
6. ✅ Mantenido `.product-showcase` (best sellers) sin cambios
7. ✅ Mantenido JS accordion existente (NodeList vacío, sin errores)
8. ✅ Sin modificaciones CSS
9. ✅ Excluidas categorías vacías (`hide_empty => true`)
10. ✅ Sin subcategorías (implementación plana)
11. ✅ Sin tocar otras secciones de front-page.php

Decisión: Implementación plana sin jerarquía padre-hijo por ahora.
El accordion JS queda sin efecto (no hay elementos `[data-accordion-btn]`).
Los iconos de categoría se mantienen pendientes para futura iteración.

---

# ~~Media prioridad~~ (COMPLETADO 2026-05-28)

### Responsive layout rebuild — calc()/float eliminados

1. ✅ Container simplificado: `width: 100%; max-width: 1400px; padding: 0 15px; margin: 0 auto` — breakpoints solo ajustan padding (24px/30px)
2. ✅ `.product-grid` convertido a `repeat(auto-fit, minmax(220px, 1fr))` — sin breakpoints de columnas fijas
3. ✅ `ul.products` convertido a `repeat(auto-fit, minmax(220px, 1fr))` — sin breakpoints de columnas fijas (solo gap 1200px ajusta minmax a 240px)
4. ✅ `.sidebar` + `.product-box` con clean flex: `width: 260px; flex-shrink: 0` / `flex: 1; min-width: 0` — elimina `min-width: calc(25%/75% - 15px)`
5. ✅ Toolbar floats reemplazados con flex scoped a `.woocommerce-shop .woocommerce`
6. ✅ `.category-item-container` convertido a grid `auto-fit/minmax(200px)` a 570px+ — elimina `min-width: calc(50%/33%/25% - gap)`
7. ✅ `.blog-container` convertido a grid `auto-fit/minmax(280px)` a 570px+ — elimina `min-width: calc(50%/33%/25% - gap)`
8. ✅ `.testimonials-box` convertido a grid con `1fr 1fr` (1024px) y `repeat(4, 1fr)` (1200px) con `.cta-container: span 2`
9. ✅ `.product-minimal .product-showcase` y `.showcase-content` usan `flex: 1` — elimina `width: calc(100% - X)`
10. ✅ `.product-featured .showcase-content` usa `flex: 1` — elimina `min-width: calc(100% - 345px)`
11. ✅ `.footer-nav-list` usa `flex: 1 1 30%/18%` con `min-width: 220px/180px` — elimina `min-width: calc(33%/20% - gap)`
12. ✅ `.toast-detail` usa `flex: 1` — elimina `width: calc(100% - 85px)`
13. ✅ `html { overflow-x: hidden }` eliminado — posiciones fixed con `left: -9999px` ya no generan overflow
14. ✅ Cero reglas `min-width: calc()` en style.css activo — solo quedan `translateX(calc())` para animaciones

Decisión: Todos los layouts responsivos se manejan con CSS Grid `auto-fit/minmax` o Flexbox limpio. Sin `calc()` con `min-width`, sin floats, sin breakpoints de columnas fijas.

---

# ~~Alta prioridad~~ (COMPLETADO 2026-05-31)

### Responsive product grid rebuild — breakpoints explícitos, sidebar fix, grids unificados

1. ✅ **Eliminado**: `auto-fit/minmax(220px, 1fr)` de todos los product grids
2. ✅ **Implementado**: breakpoints explícitos mobile-first: 1fr (<480px) → 2fr (480px+) → 2fr (1024px+) → 3fr (1200px+) → 4fr (1400px+)
3. ✅ **Unificado**: misma lógica de grid para `.product-grid`, `ul.products`, related y upsells
4. ✅ **Unificado**: `gap: 20px` en todos los product grids
5. ✅ **Corregido**: `height: auto` eliminado de imágenes `ul.products li.product a img` — ahora solo usa `aspect-ratio: 4/3` + `object-fit: cover`
6. ✅ **Reemplazado**: `left: -9999px` → `transform: translateX(-100%)` en sidebar y mobile-navigation-menu. Más suave, sin overflow.
7. ✅ **Simplificados**: badges sin overrides por breakpoint — un solo `line-height: 1; padding: 4px 10px` para todos
8. ✅ **Eliminados**: reglas legacy de related/upsells a 1200px (`repeat(4, 1fr)`) — ahora heredan del main grid
9. ✅ **Eliminado**: `ul.products` minmax override a 1200px — ahora usa el mismo breakpoint que el resto
10. ✅ **Eliminado**: `--fs-5: 0.941rem` en sidebar 1024px+
11. ✅ **Sidebar a 1024px+**: resetea `transform: none; opacity: 1` para funcionar con `position: sticky`
12. ✅ **Documentación actualizada**: architecture.md, project-status.md

Decisión: Los breakpoints explícitos mobile-first dan comportamiento predecible en todas las resoluciones. El sidebar a 1024px reduce espacio disponible, por lo que se mantienen 2 columnas hasta 1200px donde hay suficiente ancho para 3. El sistema unificado elimina inconsistencias visuales entre homepage, shop, related y upsells.

---

# ~~Alta prioridad~~ (COMPLETADO 2026-05-31 — segunda tanda)

### Post-rebuild fixes — shop page grid bug, product-minimal grid, overflow prevention

1. ✅ **Corregido**: base `ul.products` grid movido ANTES del bloque responsive en style.css — los overrides responsive (misma especificidad) ahora ganan por source order
2. ✅ **Migrado**: `.product-minimal` de carrusel horizontal a CSS Grid — `.showcase-wrapper` ahora es `display: grid`, `.showcase-container` usa `display: contents`, cards son verticales tipo shop
3. ✅ **Unificado**: `.product-minimal .showcase-wrapper` agregado al selector combinado de todos los product grids — comparte breakpoints: 1fr (<480px) → 2fr (480px+) → 2fr (1024px+) → 3fr (1200px+) → 4fr (1400px+)
4. ✅ **Añadido**: `img { max-width: 100%; height: auto; }` en reset CSS — previene overflow por imágenes sin width explícito
5. ✅ **Actualizados**: architecture.md, project-status.md, opencode-tasks.md

Decisión: La migración de product-minimal a grid elimina la dependencia de `overflow-x: auto` y unifica el layout de cards con el resto del sitio. `img { max-width: 100% }` es una regla de reset estándar que previene overflow sin causar regresiones visuales.

---

# ~~Alta prioridad~~ (COMPLETADO 2026-06-03)

### Categories destacadas dinámicas WooCommerce

1. ✅ Reemplazadas 8 categorías hardcodeadas (Dress & frock, Winter wear, etc.) con `get_terms('product_cat')`
2. ✅ Las categorías reales encontradas son: Medias (12), Gorras (6), Perfumes (6), Calcetines (4), Remeras (4) — ordenadas por cantidad de productos descendente
3. ✅ Eliminados: nombres falsos, contadores falsos, 8 links "#"
4. ✅ Cada categoría enlaza a su archive page real (`get_term_link()`)
5. ✅ Contadores muestran cantidad real de productos WooCommerce
6. ✅ Excluida categoría "Uncategorized" del display
7. ✅ Mantenidas exactamente las clases CSS y estructura HTML
8. ✅ SVG icons mapeados por slug (shoes.svg para medias/calcetines, hat.svg para gorras, perfume.svg para perfumes, tee.svg para remeras, bag.svg como fallback)
9. ✅ Sin cambios en CSS, JS ni functions.php

**Pendiente**: Los SVG icons siguen siendo archivos estáticos (no administrables desde WordPress). Se necesita un campo ACF image en la taxonomy product_cat para resolverlo.

---

# ~~Alta prioridad~~ (COMPLETADO 2026-06-03)

### Sidebar best sellers dinámicos WooCommerce

1. ✅ Reemplazados 4 productos hardcodeados (baby fabric shoes, men's hoodies, girls t-shirt, woolen hat) con `WP_Query` real
2. ✅ Query principal: `meta_key => total_sales, orderby => meta_value_num, order => DESC, posts_per_page => 4`
3. ✅ Fallback: si hay menos de 4 productos con ventas, se complementa con productos recientes (`orderby => date, post__not_in => IDs mostrados`)
4. ✅ Eliminados: imágenes hardcodeadas (1.jpg-4.jpg), nombres falsos, precios falsos, ratings falsos, todos los `href="#"`
5. ✅ Cada producto muestra: imagen destacada real, nombre real, precio real (get_price_html), rating real (wc_get_rating_html), enlace real al producto
6. ✅ Mantenidas exactamente las clases CSS y estructura HTML (`.showcase`, `.showcase-img-box`, `.showcase-content`, `.showcase-title`, `.showcase-rating`, `.price-box`)
7. ✅ Excluidos productos no publicados (post_status => publish)
8. ✅ Sin cambios en CSS, JS ni functions.php

**Queries utilizadas**:
- Principal: `WP_Query(post_type => product, posts_per_page => 4, meta_key => total_sales, orderby => meta_value_num, order => DESC, post_status => publish, no_found_rows => true)`
- Fallback: `WP_Query(post_type => product, posts_per_page => N, post_status => publish, post__not_in => [IDs ya mostrados], orderby => date, order => DESC, no_found_rows => true)`

**Fallback**: Se activa cuando `post_count < 4` después de la query principal. Complementa con productos recientes hasta llegar a 4.

**Limitaciones**:
- HTML de producto duplicado entre query principal y fallback (misma estructura en 2 bloques). Refactor pendiente.
- Si ningún producto tiene ventas, se muestran los 4 más recientes (comportamiento correcto).
- Los ratings usan `wc_get_rating_html()` (distinto de los Ionicon stars originales, pero semánticamente correcto).

---

# ~~Alta prioridad~~ (COMPLETADO 2026-06-07)

### Hero Slider dinámico con ACF

1. ✅ Creado Custom Post Type `hero_slide` con soporte `page-attributes` (menu_order para orden manual)
2. ✅ Registrados campos ACF vía `acf_add_local_field_group()`: imagen desktop, título pequeño, título principal, texto precio/oferta, texto botón, URL botón
3. ✅ `inc/hero-slider.php` agrupa toda la lógica: CPT registration, ACF fields, creación de slides por defecto
4. ✅ 3 slides iniciales creados automáticamente via `after_switch_theme` con contenido adaptado al negocio (medias, calcetines, parches)
5. ✅ `hero.php` reescrito: primero intenta query dinámica con WP_Query → hero_slide; si no hay slides con imagen o ACF no está activo, muestra fallback hardcodeado original
6. ✅ Fallback preserva exactamente el HTML, clases y contenido original del template Anon
7. ✅ Sin cambios en CSS, JS ni estructura del frontend
8. ✅ Sin funciones de WooCommerce modificadas

**Decisión**: CPT + ACF fields evita depender del Repeater field (PRO). El orden de slides se maneja con `menu_order` (drag & drop nativo de WordPress). La imagen usa `return_format => 'url'` para compatibilidad con URLs del theme en los slides por defecto.

**Fix post-implementación (2026-06-07)**:
- Problema 1: `after_switch_theme` no se ejecutó porque el theme ya estaba activo cuando se agregó el código
- Solución 1: Se agregó `admin_init` como segundo hook + flag `hero_slider_defaults_created` en `wp_options`. Esto asegura que los slides se creen la primera vez que alguien entre al admin, sin importar cuándo se agregó el código
- Problema 2: `update_field('slide_image', $url, $post_id)` almacenaba `'0'` porque el campo ACF image espera un attachment ID, no una URL directa — las imágenes del theme no están en la media library
- Solución 2: Se agregó `hero_slider_import_image()` que descarga la imagen del theme a la media library via `download_url()` + `media_handle_sideload()`, y luego almacena el attachment ID resultante con `update_field()`
- El flag previene ejecución duplicada incluso si se desactiva/reactiva el theme

**Riesgos**:
- `media_handle_sideload()` puede fallar si el servidor no puede descargar la URL del theme (firewall, permisos de escritura en uploads)
- `acf_add_local_field_group()` en `acf/init` requiere ACF activo — si ACF se desactiva, los field groups no se registran (fallback funciona)

---

# Baja prioridad

* wishlist real
* compare real
* quick view real
* Gutenberg avanzado
* theme.json
* optimización avanzada

---

# Restricciones actuales

NO implementar todavía:

* React
* headless
* Tailwind migration
* Vite/Webpack complejo
* plugins premium pesados

---

# Objetivo técnico actual

Construir:

* starter theme WooCommerce reusable
* arquitectura estable
* componentes reutilizables
* frontend mantenible
* base agency-ready

Antes de agregar funcionalidades complejas.
