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

---

# Problemas ya solucionados

* ionicons esm.js errors
* addEventListener null errors
* sidebars WooCommerce innecesarias
* wrappers WooCommerce básicos
* rutas hardcodeadas assets
* conflictos básicos del theme

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

# Layout global estabilizado (2026-05-26)

Corregido el ancho del layout responsive:

## Causa raíz

El `.container` tenía `max-width: 980px` en el breakpoint 1024px.
En pantallas comunes (1280-1366px) esto dejaba 150-193px de espacio vacío
a cada lado, comprimiendo el grid de productos (4 columnas en ~950px =
~222px/card en shop).

## Cambios aplicados

| Breakpoint | Antes | Después |
|---|---|---|
| 768px | `max-width: 750px` | `width: calc(100% - 48px); max-width: 750px` |
| 1024px | `max-width: 980px` | `width: calc(100% - 60px); max-width: 1100px` |
| 1200px | `max-width: 1200px` | `width: calc(100% - 60px); max-width: 1260px` |
| 1400px | `max-width: 1350px` | `width: calc(100% - 60px); max-width: 1400px` |

- `html { overflow-x: hidden; }` — elimina scrollbar horizontal en homepage

## Resultado

- Shop: 3 columnas a ~332px/card en 1024px, 4 columnas a ~305px/card en 1200px
- Homepage: product-grid 3 columnas a ~240px/card en 1024px (vs ~220px antes)
- Sin scrollbar horizontal en homepage
- Sin cambios en márgenes, paddings ni gaps del diseño original

---

# Layout audit — Estructura real y corrección de overflow (2026-05-26)

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
| `.notification-toast` | `position: fixed` + `left/right: 20px` + `transform: translateX(...)` — el box model permanece en el viewport aunque esté transformado off-screen | se mantiene, el `overflow-x: hidden` de html lo contiene |

Al mover estos elementos a `-9999px`, se elimina la causa raíz del scrollbar
horizontal. El `overflow-x: hidden` en `html` se mantiene como safety net.

### 2. Container fijo en lugar de fluido

El `.container` usaba `max-width` fijos (980px, 1200px, 1350px) sin `width`.
En pantallas intermedias (1024-1200px), el container se quedaba en 980px
dejando 150-193px de espacio vacío a cada lado.

Fix: usar `width: calc(100% - 60px)` junto con `max-width`. Así el container
siempre mantiene 30px de margen a cada lado hasta llegar al límite máximo.

Ejemplo: en 1280px viewport → container = 1220px (30px margin) vs 980px antes.

### 3. `.product-container .container` sin padding

A 1024px+, `.product-container .container` tiene `display: flex; gap: 30px;`
que sobreescribe el `padding: 0 15px` del `.container` base. Esto hace que
el contenido de la sección de productos arranque pegado al borde del container,
mientras que otras secciones (banner, categorías) tienen 15px de padding interno.

Esto es intencional del diseño original — permite que el grid de productos
aproveche el ancho completo. No se corrige porque rompería los cálculos de
`.sidebar` y `.product-box` que usan `calc(25% - 15px)` / `calc(75% - 15px)`
contra el ancho del container sin padding.

## Wrappers analizados y estado

| Wrapper | Estado | Notas |
|---|---|---|
| `body` | ✅ Ok | Sin width fijo, overflow natural |
| `main` | ✅ Ok | Sin estilo propio, ok |
| `.container` | ✅ Corregido | Ahora fluido con calc + max-width |
| `.banner > .container` | ✅ Ok | Hereda container fluido |
| `.category > .container` | ✅ Ok | Hereda container fluido |
| `.product-container > .container` | ⚠️ Sin padding | Intencional, ok |
| `.product-box` | ✅ Ok | Flex child, min-width 75% |
| `.product-main` | ✅ Ok | margin-bottom solo |
| `.product-grid` | ✅ Ok | CSS grid interno |
| `.product-minimal > .showcase-wrapper` | ✅ Ok | overflow-x: auto controlado |
| `.product-featured > .showcase-wrapper` | ✅ Ok | overflow-x: auto controlado |
| `.sidebar (base)` | ✅ Corregido | left: -9999px elimina overflow |
| `.sidebar (1024px+)` | ✅ Ok | position: sticky normal |
| `.mobile-navigation-menu` | ✅ Corregido | left: -9999px elimina overflow |
| `.notification-toast` | ⚠️ Safety net | overflow-x: hidden lo contiene |
| `.footer-category > .container` | ✅ Ok | Hereda container fluido |
| `.footer-nav > .container` | ✅ Ok | Hereda container fluido |
| `.footer-bottom > .container` | ✅ Ok | Hereda container fluido |
| `.blog > .container` | ✅ Ok | Hereda container fluido |
| `.testimonials-box` | ✅ Ok | Flex layout dentro de container |

## Resultado visual

- Shop usa ancho completo disponible con márgenes consistentes de 30px
- Homepage sin scrollbar horizontal
- Container fluido se adapta a cualquier resolución
- Layout consistente entre secciones (misma alineación base)
- Sin cambios en el diseño visual del template Anon

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

# Riesgos técnicos actuales

## RESUELTO (2026-05-26)

Conflicto shop page estabilizado:

* ✅ Se desactivó CSS nativo de WooCommerce
* ✅ ul.products usa CSS grid con breakpoints consistentes
* ✅ li.product estilizado como card visualmente consistente
* ✅ No existe nesting inválido (front-page y shop son contextos separados)
* ✅ Sin overrides de templates WC — se mantiene compatibilidad máxima

La decisión arquitectónica es mantener ul.products/li.product default
y controlar todo via CSS. front-page.php sigue usando .product-grid > .showcase
como custom query independiente.

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
