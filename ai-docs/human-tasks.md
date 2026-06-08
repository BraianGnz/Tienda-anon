# Human Tasks

## QA visual obligatorio

Revisar manualmente después de cada cambio:

* homepage
* blog section (verificar 4 posts, categorías reales, autores, fechas, imágenes)
* blog fallback (desactivar los posts seed y confirmar que se ven placeholders)
* blog seeder (reactivar theme y verificar que se crean 4 posts + 4 categorías)
* CTA banner (verificar imagen, badge, título, texto, botón, URL desde admin)
* CTA banner fallback (desactivar ACF y confirmar que se ven valores originales)
* shop page
* categorías
* mobile
* tablet
* responsive
* overlays
* hover effects
* console browser
* imágenes
* badges
* spacing
* botones
* **Deal of the Day**: marcar un producto como "Deal of the Day" en el editor de producto (sidebar, switch) y verificar que aparece en homepage
* **Deal of the Day fallback**: desmarcar todos los productos y verificar que se muestra el último producto publicado
* **Deal of the Day sin ACF**: desactivar ACF y verificar que el fallback (último producto) funciona

---

# Revisiones WooCommerce importantes

Verificar:

* add-to-cart
* pagination
* ordering dropdown
* result count
* related products
* sale badges
* stock badges

---

# Validar HTML

Inspeccionar DevTools:

Buscar posibles problemas:

* div dentro de ul
* nesting inválido
* wrappers duplicados
* hooks WooCommerce rotos

---

# Git Workflow

Mantener:

* commits pequeños
* commits descriptivos
* una tarea por commit

Evitar:

* commits gigantes
* múltiples features mezcladas

---

# Antes de mergear cambios

Siempre:

1. revisar frontend
2. revisar mobile
3. revisar consola
4. revisar WooCommerce
5. revisar responsive

---

# Aprendizaje prioritario actual

Estudiar:

* WooCommerce template hierarchy
* hooks WooCommerce
* template overrides
* Gutenberg básico
* arquitectura WordPress

NO estudiar todavía:

* headless
* React avanzado
* microservicios
* optimización extrema

---

# Prioridad actual del proyecto

Estabilidad > nuevas features
