# Homepage Administrability Audit

**Fecha**: 2026-06-20
**Propósito**: Documentar el estado de cada bloque de la homepage respecto a su capacidad de ser administrado desde WordPress sin modificar código.

---

## 1. Hero

| Campo | Valor |
|-------|-------|
| **Archivo** | `template-parts/home/hero.php` |
| **Estado** | **Dinámico** (desde FASE 7B, 2026-06-20) |
| **Fuente de datos** | CPT `hero_slide` (registrado en `inc/hero-slider.php`) |
| **Campos ACF** | `slide_image` (image, required), `slide_subtitle` (text, required), `slide_title` (text, required), `slide_price` (text), `slide_button_text` (text, default "Shop now"), `slide_button_url` (url, default "#") |
| **CPT** | `hero_slide` — no pública, show_ui, supports title + page-attributes, orden por menu_order |
| **Queries** | `WP_Query` con `post_type=hero_slide`, `posts_per_page=-1`, `orderby=menu_order`, `post_status=publish` |
| **Seed** | 3 slides con contenido real del negocio (español, URLs válidas) via `hero_slider_create_default_slides()` en `after_switch_theme` + `admin_init` |
| **Fallback** | ~~Array hardcodeado demo~~ -> **ELIMINADO en FASE 7B**. Si no hay slides: `return` temprano, sección no renderizada. |
| **Hardcoded restante** | ~~Fallback completo en inglés~~ -> **NINGUNO**. Hero 100% administrable. |
| **Riesgos** | ~~Si se desactiva ACF, fallback con demo~~ -> **RESUELTO**. Sin ACF o sin slides: sección oculta. Sin demo. |
| **Prioridad** | ~~ALTA~~ -> **RESUELTA** (FASE 7B) |

---

## 2. Categories

| Campo | Valor |
|-------|-------|
| **Archivo** | `template-parts/home/categories.php` |
| **Estado** | Parcial |
| **Fuente de datos** | WooCommerce taxonomía `product_cat` via `get_terms()` |
| **Campos ACF** | Ninguno |
| **CPT** | N/A (taxonomía) |
| **Queries** | `get_terms('product_cat', hide_empty=true, orderby=count, order=DESC)` con `wp_list_filter` excluyendo 'uncategorized' |
| **Seed** | N/A |
| **Fallback** | Si no hay categorías, el bloque no se renderiza (`if (!empty($product_cats))`) |
| **Hardcoded restante** | Array `$cat_icons` (líneas 5-11) mapea slugs a nombres de archivos SVG: `medias→shoes.svg`, `calcetines→shoes.svg`, `gorras→hat.svg`, `perfumes→perfume.svg`, `remeras→tee.svg`, `uncategorized→bag.svg`. Ruta base hardcodeada `$img/icons/`. Categorías nuevas sin mapeo usan `bag.svg` como fallback. |
| **Riesgos** | Categorías nuevas no tienen icono específico (fallback genérico). SVG demo puede no existir para categorías inesperadas. |
| **Prioridad** | MEDIA — funcional, visualmente aceptable. |

---

## 3. Sidebar

| Campo | Valor |
|-------|-------|
| **Archivo** | `template-parts/home/sidebar.php` |
| **Estado** | Dinámico |
| **Fuente de datos** | WooCommerce taxonomía `product_cat` + WooCommerce productos via `WP_Query` |
| **Campos ACF** | Ninguno |
| **CPT** | N/A |
| **Queries** | Categorías: `get_terms('product_cat', hide_empty=true)`. Best sellers: `WP_Query(post_type=product, posts_per_page=4, meta_key=total_sales, orderby=meta_value_num, order=DESC)`. |
| **Seed** | N/A |
| **Fallback** | Best sellers: si hay menos de 4 con ventas, completa con últimos productos por fecha. |
| **Hardcoded restante** | Título "best sellers" en minúsculas (línea 42). Título "Category" (línea 6). Ninguno crítico. |
| **Riesgos** | Bajo. Sin productos publicados, el sidebar se renderiza vacío. |
| **Prioridad** | BAJA — funcional al 100%. |

---

## 4. New Arrivals (product-minimal)

| Campo | Valor |
|-------|-------|
| **Archivo** | `template-parts/home/product-minimal.php` |
| **Estado** | Parcial |
| **Fuente de datos** | WooCommerce productos via `WP_Query` |
| **Campos ACF** | Ninguno |
| **CPT** | N/A |
| **Queries** | `WP_Query(post_type=product, posts_per_page=8, orderby=date, order=DESC)`. Agrupados en contenedores de 4. |
| **Seed** | N/A |
| **Fallback** | Si no hay productos, el bloque no se renderiza. |
| **Hardcoded restante** | Título "New Arrivals" en inglés (línea 14). No administrable desde WP. |
| **Riesgos** | Bajo. El título en inglés es incongruente con un sitio en español. |
| **Prioridad** | MEDIA — texto visible, fácil de corregir. |

---

## 5. Deal of the Day (product-featured)

| Campo | Valor |
|-------|-------|
| **Archivo** | `template-parts/home/product-featured.php` |
| **Estado** | Parcial |
| **Fuente de datos** | WooCommerce productos via `get_deal_of_the_day_query()` en `inc/product-deal.php` |
| **Campos ACF** | `deal_of_the_day` (true_false, UI checkbox en sidebar de producto) |
| **CPT** | N/A |
| **Queries** | Query principal: `WP_Query(post_type=product, posts_per_page=1, meta_key=deal_of_the_day, meta_value=1)`. Fallback: último producto por fecha si no hay deal marcado. |
| **Seed** | N/A |
| **Fallback** | Último producto creado si ningún producto tiene `deal_of_the_day=1`. |
| **Hardcoded restante** | Título "Deal of the day" en inglés (línea 3). |
| **Riesgos** | Bajo. El fallback garantiza que siempre se muestre algo. |
| **Prioridad** | MEDIA — mismo caso que New Arrivals. |

---

## 6. New Products (product-grid)

| Campo | Valor |
|-------|-------|
| **Archivo** | `template-parts/home/product-grid.php` |
| **Estado** | Parcial |
| **Fuente de datos** | WooCommerce productos via `WP_Query` |
| **Campos ACF** | Ninguno |
| **CPT** | N/A |
| **Queries** | `WP_Query(post_type=product, posts_per_page=12, orderby=date, order=DESC)` |
| **Seed** | N/A |
| **Fallback** | Si no hay productos, el bloque no se renderiza. |
| **Hardcoded restante** | Título "New Products" en inglés (línea 3). Action buttons (líneas 61-73): `heart-outline`, `eye-outline`, `repeat-outline`, `bag-add-outline` son Ionicons decorativos SIN funcionalidad real (no conectados a wishlist, quick view, compare, ni add-to-cart). |
| **Riesgos** | Los action buttons crean expectativa de funcionalidad que no existe. El título en inglés. |
| **Prioridad** | MEDIA (título) — BAJA (action buttons decorativos, ya documentados como NO implementar en AGENTS.md). |

---

## 7. Testimonials

| Campo | Valor |
|-------|-------|
| **Archivo** | `template-parts/home/testimonials.php` |
| **Estado** | Parcial |
| **Fuente de datos** | CPT `testimonial` (registrado en `inc/testimonials.php`) + ACF fields |
| **Campos ACF** | `client_city` (text), `product_name` (text), `show_on_home` (true_false) |
| **CPT** | `testimonial` — no pública, show_ui, supports title + editor + thumbnail + page-attributes |
| **Queries** | `WP_Query(post_type=testimonial, posts_per_page=4, orderby=menu_order, meta_key=show_on_home, meta_value=1)` |
| **Seed** | 3 testimonios demo con contenido real del negocio (español), `show_on_home=false` por defecto |
| **Fallback** | Si no hay testimonios con `show_on_home=1`, el bloque no se renderiza (línea 18). Imagen fallback: `testimonial-1.jpg` si no hay thumbnail. |
| **Hardcoded restante** | ~~Services hardcodeados~~ -> **ELIMINADO en FASE 7B**. Ahora usa CPT `service` con ACF. |
| **Riesgos** | ~~Services no administrable~~ -> **RESUELTO**. CPT service con seed de contenido real. Enlaces funcionales. |
| **Prioridad** | ~~ALTA~~ -> **RESUELTA** (FASE 7B) |

---

## 8. CTA Banner

| Campo | Valor |
|-------|-------|
| **Archivo** | `template-parts/home/banners.php` |
| **Estado** | Dinámico |
| **Fuente de datos** | ACF fields en la front page (`page_on_front`) |
| **Campos ACF** | `cta_image` (image, required), `cta_badge` (text, default "20% OFF"), `cta_title` (text, default "Medias Personalizadas Premium"), `cta_text` (text, default "Diseños exclusivos para empresas, eventos y marcas"), `cta_button_text` (text, default "Ver Colección"), `cta_button_url` (url, default home_url('/shop/')) |
| **CPT** | N/A (fields asociados a la página frontal) |
| **Queries** | `cta_banner_get_front_page_id()` obtiene ID de `page_on_front` |
| **Seed** | Via `cta_banner_seed_defaults()` en `after_switch_theme` + `admin_init` + `acf/init` con prioridad 20. 6 fields con contenido real del negocio. |
| **Fallback** | Array de valores por defecto (líneas 18-23) en inglés: "25% Discount", "Summer collection", "Starting @ $10", "Shop now", `#`. Solamente visibles si se eliminan los ACF fields. |
| **Hardcoded restante** | Fallback en inglés. No hay seed de imagen local (usa URL de placeholder demo). |
| **Riesgos** | Mínimo. El seed asegura datos reales. El fallback solo se ve si se borran fields ACF intencionalmente. |
| **Prioridad** | BAJA — funcional, administrable. Mejorable: seed de imagen local. |

---

## 9. Blog

| Campo | Valor |
|-------|-------|
| **Archivo** | `template-parts/home/blog.php` |
| **Estado** | Dinámico |
| **Fuente de datos** | WordPress posts (`post_type=post`) |
| **Campos ACF** | Ninguno |
| **CPT** | N/A |
| **Queries** | `WP_Query(post_type=post, posts_per_page=4, post_status=publish, orderby=date, order=DESC, no_found_rows=true)` |
| **Seed** | 4 posts demo creados por `inc/blog-seeder.php` con contenido real del negocio |
| **Fallback** | Si no hay posts, el template retorna early (línea 11-13). Imagen: si no hay thumbnail, usa placeholder cíclico `blog-1.jpg` a `blog-4.jpg` desde `$img`. |
| **Hardcoded restante** | Array de 4 nombres de placeholder images (línea 16). Ruta base de imágenes hardcodeada (línea 15). |
| **Riesgos** | Bajo. Los posts son reales. Los placeholders son solo fallback para posts sin thumbnail. |
| **Prioridad** | BAJA — funcional. Mejorable: placeholder más elegante o generado dinámicamente. |

---

## Resumen

| Bloque | Estado | Prioridad |
|--------|--------|-----------|
| Hero | **Dinámico** ✅ | RESUELTA (FASE 7B) |
| Categories | Parcial | MEDIA |
| Sidebar | Dinámico | BAJA |
| New Arrivals | Parcial | MEDIA |
| Deal of the Day | Parcial | MEDIA |
| New Products | Parcial | MEDIA |
| Testimonials | **Dinámico** ✅ | RESUELTA (FASE 7B) |
| CTA Banner | Dinámico | BAJA |
| Blog | Dinámico | BAJA |

**5 Dinámicos · 4 Parciales · 0 Hardcodeados puros**

---

## Estimación de administrabilidad

**Porcentaje actual**: ~73% administrable (actualizado post-FASE 7B)
(Ponderación: Hero 10%, Categories 10%, Sidebar 15%, New Arrivals 10%,
Deal of the Day 10%, New Products 15%, Testimonials 15%, CTA Banner 5%, Blog 10%)

**Porcentaje esperado post-FASE 7 completa**: ~95% administrable
(Quedarían solo action buttons decorativos en product-grid como no administrables
por decisión explícita del proyecto — ver AGENTS.md: NO implementar wishlist,
quick view ni compare.)

---

# ROADMAP FASE 7

## FASE 7B — Hero + Testimonials (Prioridad ALTA)

### Hero — Convertir fallback a contenido real del negocio

| Aspecto | Detalle |
|---------|---------|
| **Archivos afectados** | `template-parts/home/hero.php` |
| **Cambio** | Reemplazar array fallback (líneas 34-61) con 3 slides en español con contenido real del negocio, imágenes locales, enlaces válidos |
| **Complejidad** | Baja — solo editar un array PHP |
| **Riesgo** | Mínimo — el ACF query se evalúa primero; el fallback solo se ve si ACF no está disponible o no hay slides |
| **Beneficio** | Hero 100% administrable incluso sin ACF. Contenido en español coherente. Sin enlaces rotos. |

### Testimonials — Convertir Our Services a administrable

| Aspecto | Detalle |
|---------|---------|
| **Archivos afectados** | `template-parts/home/testimonials.php`, opcionalmente nuevo `inc/services.php` |
| **Cambio** | Opción A: Crear CPT `service` con ACF (icono, título, descripción, enlace) + seed. Opción B: Usar un page con ACF repeater. Opción C: Repeater-free usando posts con categoría. |
| **Complejidad** | Media |
| **Riesgo** | Bajo — los services son independientes del resto del layout |
| **Beneficio** | Elimina ~80 líneas de HTML hardcodeado. Services editables desde WP. Enlaces funcionales. |

---

## FASE 7C — Categories + Product Sections (Prioridad MEDIA)

### Categories — Hacer iconos administrables

| Aspecto | Detalle |
|---------|---------|
| **Archivos afectados** | `template-parts/home/categories.php`, `functions.php` |
| **Cambio** | Agregar campo ACF `category_icon` (image) a taxonomía `product_cat`. En `categories.php`, usar `get_field('category_icon', 'product_cat_'.$cat->term_id)` como fuente primaria, mantener array hardcodeado como fallback. |
| **Complejidad** | Baja |
| **Riesgo** | Mínimo — fallback array existe para categorías sin icono ACF |
| **Beneficio** | Cada categoría puede tener su propio icono. Categorías nuevas pueden tener icono desde el admin. |

### Product Sections — Títulos administrables

| Aspecto | Detalle |
|---------|---------|
| **Archivos afectados** | `template-parts/home/product-minimal.php`, `product-featured.php`, `product-grid.php` |
| **Cambio** | Reemplazar strings hardcodeados con ACF option fields o con `get_theme_mod()` via Customizer. Ej: `get_theme_mod('home_section_title_new_arrivals', 'New Arrivals')` |
| **Complejidad** | Baja |
| **Riesgo** | Mínimo — el string hardcodeado es el default |
| **Beneficio** | Títulos en español configurables desde Customizer/ACF sin editar PHP. |

---

## FASE 7D — Limpieza final de contenido hardcodeado (Prioridad BAJA)

| Bloque | Cambio | Complejidad | Riesgo | Beneficio |
|--------|--------|-------------|--------|-----------|
| Blog fallback images | Reemplazar array de placeholders con placeholder generado dinámicamente (placeholder.com o CSS gradient) | Baja | Mínimo | Sin dependencia de archivos demo |
| CTA Banner seed de imagen | Agregar seed de imagen local al theme (copiar al activar) | Baja | Mínimo | Sin dependencia de ruta demo |
| Action buttons product-grid | Los action buttons decorativos se documentan como "no implementar" por restricción del proyecto (AGENTS.md) | N/A | N/A | Decisión consciente |
| Sidebar titles ("best sellers", "Category") | Reemplazar strings hardcodeados con ACF option | Baja | Mínimo | Títulos configurables |

---

## Estado esperado post-FASE 7

| Bloque | Estado antes de FASE 7B | Estado actual | Estado post-FASE 7C+D |
|--------|------------------------|---------------|----------------------|
| Hero | Parcial | **Dinámico** ✅ | Dinámico |
| Categories | Parcial | Parcial | **Dinámico** |
| Sidebar | Dinámico | Dinámico | Dinámico |
| New Arrivals | Parcial | Parcial | **Dinámico** |
| Deal of the Day | Parcial | Parcial | **Dinámico** |
| New Products | Parcial | Parcial | **Parcial** (action buttons decorativos) |
| Testimonials | Parcial | **Dinámico** ✅ | Dinámico |
| CTA Banner | Dinámico | Dinámico | Dinámico |
| Blog | Dinámico | Dinámico | Dinámico |

**5 Dinámicos · 4 Parciales · → 8 Dinámicos · 1 Parcial**

---

## Recomendación final

**La homepage actual es ~73% administrable desde WordPress** (actualizado post-FASE 7B).

Tras FASE 7 completa (~95%) quedaría únicamente el bloque `New Products` como
parcial debido a los action buttons decorativos (heart, eye, repeat, bag) que
el proyecto decidió NO implementar como funcionalidad real.

**Orden recomendado de ejecución:**

1. **FASE 7B** (Hero + Testimonials) — ✅ COMPLETADO
2. **FASE 7C** (Categories + Product Sections) — MEDIA prioridad, cambios simples
3. **FASE 7D** (Limpieza) — BAJA prioridad, puede postergarse

**Lo que NO se modificará** (por restricción explícita del proyecto):
- Action buttons en product-grid (wishlist, quick view, compare)
- Add-to-cart, AJAX, single product hooks
- Refactors estructurales (Tailwind, React, Vite)
