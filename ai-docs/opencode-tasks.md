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

# Media prioridad

* mini-cart dinámico
* add-to-cart AJAX
* modularizar front-page.php
* separar template-parts

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
