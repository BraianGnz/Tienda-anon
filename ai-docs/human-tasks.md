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
4. revisar WooCommerce (shop, categorías, single product, breadcrumbs)
5. revisar responsive
6. revisar archive pages (blog categories, search, dates)
7. revisar H1 único por página

---

# QA para FASE 6B — Archive templates

Revisar manualmente:

* blog category archive (`/category/diseno/`) — título, descripción, posts, excerpt, fecha, pagination
* blog tag archive (si existe) — mismo comportamiento que category
* blog date archive (`/2026/`) — mismo comportamiento
* search results (`/?s=medias`) — resultados, pagination, "no results" message
* search without results (`/?s=xxxxxxxxx`) — mensaje "No encontramos resultados"
* pagination styles en archive y search (.pagination .nav-links) en desktop y mobile

---

# QA para FASE 6C.1 — WooCommerce catalog + breadcrumbs

Revisar manualmente:

* shop page (`/shop/`) — breadcrumbs "Inicio / Shop", H1 "Shop", productos, sorting, pagination
* shop page 2 (`/shop/page/2/`) — breadcrumbs con "Página 2"
* product category (`/?product_cat=medias`) — breadcrumbs "Inicio / Medias", H1 "Medias", description, productos
* product category with 1 product (`/?product_cat=uncategorized`) — breadcrumbs, H1, "Mostrando el único resultado"
* generic product archive (`/?post_type=product`) — breadcrumbs "Inicio / Shop", H1 "Shop"
* single product page — sigue funcionando (no roto por el cambio en woocommerce.php)
* exactamente 1 H1 por página (inspeccionar con DevTools)
* responsive: product grid 1/2/3/4 columnas según viewport
* mobile: breadcrumbs legibles, sin overflow

---

# QA para FASE 6C.2/A — Fix doble renderizado single product

Revisar manualmente:

* single product page de Medias Argentina Campeón (`/?product=medias-argentina-campeon`) — exactamente 1 `<div id="product-599">` en el HTML
* single product page de Perfume Ocean Breeze (`/?product=perfume-ocean-breeze`) — exactamente 1 `<div id="product-601">`
* single product page de Soquetes Minnie Pack (`/?product=soquetes-minnie-pack`) — exactamente 1 `<div id="product-611">`
* cualquier otro single product — sin cambios (sigue funcionando)
* shop page (`/shop/`) — 30 resultados (no 33)
* categoría Medias (`/?product_cat=medias`) — 10 resultados
* categoría Perfumes (`/?product_cat=perfumes`) — 5 resultados (no 6)
* add to cart en single product — botón y form funcionan
* related products en single product — se muestran correctamente
* homepage — product-minimal y product-grid siguen funcionando
* responsive: sin regresiones en mobile/tablet

---

# QA para FASE 6C.2/B — Single Product Template con breadcrumbs

Revisar manualmente:

* single product page (`/?product=medias-argentina-campeon`) — breadcrumbs "Inicio / Medias / Medias Argentina Campeón del Mundo"
* otro single product de categoría diferente (`/?product=perfume-ocean-breeze` o `/?product=gorra-mickey-mouse`) — breadcrumbs con categoría correcta
* gallery de imágenes — zoom al hacer clic (si hay imágenes)
* lightbox — clic en gallery abre lightbox
* add-to-cart — seleccionar cantidad, clic en "Añadir al carrito", ver notificación/toast
* product tabs — clic en "Descripción" y "Valoraciones (0)", contenido cambia
* reviews form — visible y funcional
* related products — sección visible con productos y add-to-cart buttons
* DevTools → inspeccionar HTML — exactamente 1 `<div id="product-*">`
* DevTools → inspeccionar HTML — exactamente 1 `<h1>`
* shop page (`/shop/`) — sin regresiones, breadcrumbs "Inicio / Shop", 30 resultados
* categoría (`/?product_cat=medias`) — sin regresiones, breadcrumbs "Inicio / Medias"
* homepage — todas las secciones siguen funcionando
* mobile responsive — sin overflow, layout correcto
* consola del navegador — sin errores JS

---

# QA para FASE 9A — Internacionalización (i18n)

Revisar manualmente:

* **Header**: texto promocional "Envío gratis ✓ Esta semana por pedidos mayores a $55", placeholder "Buscá tu producto...", menú móvil título "Menú"
* **Footer**: "Directorio de marcas", "Categorías populares", "Nuestra empresa", "Contacto", "Seguinos", payment img alt "método de pago", copyright "Todos los derechos reservados."
* **Sidebar**: título "Categorías", tooltip "Stock disponible", best sellers heading "Más vendidos"
* **Homepage sections**: testimonios "Testimonios", quotes img alt "comillas", "Nuestros servicios", banners "25% OFF" / "Colección de verano" / "Desde $10" / "Comprar ahora", CTA badge/title/text/button, "Novedades", "Oferta del día", "Nuevos productos", categories "Ver más", blog "Blog"/"Por", producto badge "% OFF"
* **Single post**: "por Autor", "← Anterior", "Siguiente →"
* **404**: "Página no encontrada", "La página que buscas no existe o ha sido movida.", "Ir al Inicio", "Ir a la Tienda"
* **Search**: "Resultados para: "X"", "No encontramos resultados para: "X""
* **Archive**: "No se encontraron publicaciones en este archivo."
* **Admin > Customizer**: Branding panel, Colores section, 6 color labels en español
* **Admin > Menús**: Primary Menu, Footer Menu, Footer Brand Directory, etc.
* **Admin > Widgets**: Sidebar widget area
* **POT file**: `languages/anon-theme.pot` — verificar que contiene 53 strings con encoding UTF-8 correcto (especialmente caracteres acentuados)

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
