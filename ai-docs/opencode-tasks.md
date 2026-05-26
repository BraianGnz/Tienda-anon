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

Estabilización shop page completada:

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
