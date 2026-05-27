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
10. ✅ breakpoints 480px/768px/1024px para ul.products

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

# Media prioridad

* mini-cart dinámico
* add-to-cart AJAX
* categorías dinámicas
* mejorar responsive WooCommerce
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
