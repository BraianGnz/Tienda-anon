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
| **Estado** | **Dinámico** ✅ (desde FASE 7C, 2026-06-23) |
| **Fuente de datos** | WooCommerce taxonomía `product_cat` via `get_terms()` |
| **Campos ACF** | `category_icon` (image) en taxonomía `product_cat` — registrado en `inc/homepage-sections.php`, grupo `group_category_icon` |
| **CPT** | N/A (taxonomía) |
| **Queries** | `get_terms('product_cat', hide_empty=true, orderby=count, order=DESC)` con `wp_list_filter` excluyendo 'uncategorized' |
| **Seed** | N/A |
| **Fallback** | Si no hay categorías, el bloque no se renderiza. Si una categoría no tiene icono ACF, usa `bag.svg` como fallback. |
| **Hardcoded restante** | ~~Array `$cat_icons` mapeando slugs a SVGs~~ -> **ELIMINADO**. ~~"Show all" en inglés~~ -> **TRADUCIDO** a "Ver más". |
| **Riesgos** | Resuelto: categorías nuevas usan fallback bag.svg. Admin puede subir icono desde el editor de categoría. |
| **Prioridad** | ~~MEDIA~~ -> **RESUELTA** (FASE 7C) |

---

## 3. Sidebar

| Campo | Valor |
|-------|-------|
| **Archivo** | `template-parts/home/sidebar.php` |
| **Estado** | **Dinámico** ✅ (desde FASE 7C, 2026-06-23) |
| **Fuente de datos** | WooCommerce taxonomía `product_cat` + WooCommerce productos via `WP_Query` |
| **Campos ACF** | `home_best_sellers_title` (text) en front page — registrado en `inc/homepage-sections.php`, grupo `group_homepage_sections` |
| **CPT** | N/A |
| **Queries** | Categorías: `get_terms('product_cat', hide_empty=true)`. Best sellers: `WP_Query(post_type=product, posts_per_page=4, meta_key=total_sales, orderby=meta_value_num, order=DESC)`. |
| **Seed** | N/A |
| **Fallback** | Best sellers: si hay menos de 4 con ventas, completa con últimos productos por fecha. Título: "Más vendidos" como fallback si ACF inactivo. |
| **Hardcoded restante** | ~~Título "best sellers"~~ -> **ELIMINADO**. ~~"Category"~~ -> **TRADUCIDO** a "Categorías". ~~"Available Stock"~~ -> **TRADUCIDO** a "Stock disponible". |
| **Riesgos** | Mínimo. |
| **Prioridad** | ~~BAJA~~ -> **RESUELTA** (FASE 7C) |

---

## 4. New Arrivals (product-minimal)

| Campo | Valor |
|-------|-------|
| **Archivo** | `template-parts/home/product-minimal.php` |
| **Estado** | **Dinámico** ✅ (desde FASE 7C, 2026-06-23) |
| **Fuente de datos** | WooCommerce productos via `WP_Query` |
| **Campos ACF** | `home_new_arrivals_title` (text, default "Novedades") en front page — registrado en `inc/homepage-sections.php`, grupo `group_homepage_sections` |
| **CPT** | N/A |
| **Queries** | `WP_Query(post_type=product, posts_per_page=8, orderby=date, order=DESC)`. Agrupados en contenedores de 4. |
| **Seed** | N/A |
| **Fallback** | Si no hay productos, el bloque no se renderiza. Título: "Novedades" como fallback si ACF inactivo. |
| **Hardcoded restante** | ~~Título "New Arrivals" en inglés~~ -> **ELIMINADO**. |
| **Riesgos** | Bajo. Fallback en español. Título configurable desde el admin. |
| **Prioridad** | ~~MEDIA~~ -> **RESUELTA** (FASE 7C) |

---

## 5. Deal of the Day (product-featured)

| Campo | Valor |
|-------|-------|
| **Archivo** | `template-parts/home/product-featured.php` |
| **Estado** | **Dinámico** ✅ (desde FASE 7C, 2026-06-23) |
| **Fuente de datos** | WooCommerce productos via `get_deal_of_the_day_query()` en `inc/product-deal.php` |
| **Campos ACF** | `deal_of_the_day` (true_false, UI checkbox en sidebar de producto). `home_deal_title` (text, default "Oferta del día") en front page — registrado en `inc/homepage-sections.php` |
| **CPT** | N/A |
| **Queries** | Query principal: `WP_Query(post_type=product, posts_per_page=1, meta_key=deal_of_the_day, meta_value=1)`. Fallback: último producto por fecha si no hay deal marcado. |
| **Seed** | N/A |
| **Fallback** | Último producto creado si ningún producto tiene `deal_of_the_day=1`. Título: "Oferta del día" como fallback si ACF inactivo. |
| **Hardcoded restante** | ~~Título "Deal of the day" en inglés~~ -> **ELIMINADO**. ~~"add to cart" en card~~ -> **TRADUCIDO** a "Agregar al carrito". |
| **Riesgos** | Bajo. Título configurable desde el admin. |
| **Prioridad** | ~~MEDIA~~ -> **RESUELTA** (FASE 7C) |

---

## 6. New Products (product-grid)

| Campo | Valor |
|-------|-------|
| **Archivo** | `template-parts/home/product-grid.php` |
| **Estado** | **Dinámico** ✅ (desde FASE 7C, 2026-06-23) |
| **Fuente de datos** | WooCommerce productos via `WP_Query` |
| **Campos ACF** | `home_new_products_title` (text, default "Nuevos productos") en front page — registrado en `inc/homepage-sections.php` |
| **CPT** | N/A |
| **Queries** | `WP_Query(post_type=product, posts_per_page=12, orderby=date, order=DESC)` |
| **Seed** | N/A |
| **Fallback** | Si no hay productos, el bloque no se renderiza. Título: "Nuevos productos" como fallback si ACF inactivo. |
| **Hardcoded restante** | ~~Título "New Products" en inglés~~ -> **ELIMINADO**. ~~Action buttons decorativos (heart, eye, repeat, bag)~~ -> **ELIMINADOS DEL HTML**. |
| **Riesgos** | Ninguno. Título configurable. Botones decorativos removidos. |
| **Prioridad** | ~~MEDIA~~ -> **RESUELTA** (FASE 7C) |

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
| **Estado** | **Dinámico** ✅ (desde FASE 7C, 2026-06-23) |
| **Fuente de datos** | WordPress posts (`post_type=post`) |
| **Campos ACF** | `home_blog_title` (text, default "Blog"), `home_blog_count` (number, default 4) en front page — registrados en `inc/homepage-sections.php` |
| **CPT** | N/A |
| **Queries** | `WP_Query(post_type=post, posts_per_page=$blog_count, post_status=publish, orderby=date, order=DESC, no_found_rows=true)` |
| **Seed** | 4 posts demo creados por `inc/blog-seeder.php` con contenido real del negocio |
| **Fallback** | Si no hay posts, el template retorna early. Título: "Blog" como fallback. Cantidad: 4 como fallback. Imagen: placeholder cíclico si no hay thumbnail. |
| **Hardcoded restante** | Array de 4 nombres de placeholder images. Ruta base de imágenes hardcodeada. "By" -> **TRADUCIDO** a "Por". |
| **Riesgos** | Bajo. Título y cantidad configurables desde el admin. |
| **Prioridad** | ~~BAJA~~ -> **RESUELTA** (FASE 7C) |

---

## Resumen

| Bloque | Estado | Prioridad |
|--------|--------|-----------|
| Hero | **Dinámico** ✅ | RESUELTA (FASE 7B) |
| Categories | **Dinámico** ✅ | RESUELTA (FASE 7C) |
| Sidebar | **Dinámico** ✅ | RESUELTA (FASE 7C) |
| New Arrivals | **Dinámico** ✅ | RESUELTA (FASE 7C) |
| Deal of the Day | **Dinámico** ✅ | RESUELTA (FASE 7C) |
| New Products | **Dinámico** ✅ | RESUELTA (FASE 7C) |
| Testimonials | **Dinámico** ✅ | RESUELTA (FASE 7B) |
| CTA Banner | Dinámico | BAJA |
| Blog | **Dinámico** ✅ | RESUELTA (FASE 7C) |

**9 Dinámicos · 0 Parciales · 0 Hardcodeados puros**

---

## Estimación de administrabilidad

**Porcentaje actual**: ~97% administrable (actualizado post-FASE 7C)
(Ponderación: Hero 10%, Categories 10%, Sidebar 15%, New Arrivals 10%,
Deal of the Day 10%, New Products 15%, Testimonials 15%, CTA Banner 5%, Blog 10%).

El 3% restante corresponde a textos menores no críticos (ej: placeholder images array
en blog, ruta base de imágenes) que no afectan la operación del sitio y no requieren
intervención del admin.

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

## FASE 7C — Categories + Product Sections (Prioridad MEDIA) — ✅ COMPLETADO 2026-06-23

### Cambios aplicados

1. **Categories**: Eliminado array `$cat_icons` con mapeo slug→SVG. Agregado campo ACF `category_icon` (Image) en taxonomía `product_cat`. Fallback a `bag.svg` si no hay icono.

2. **Títulos administrables**: Creado `inc/homepage-sections.php` con grupo ACF `group_homepage_sections` (6 campos: `home_new_arrivals_title`, `home_deal_title`, `home_new_products_title`, `home_best_sellers_title`, `home_blog_title`, `home_blog_count`) + grupo `group_category_icon`.

3. **Templates actualizados**: `product-minimal.php`, `product-featured.php`, `product-grid.php`, `sidebar.php`, `blog.php` — títulos leen ACF con fallback en español.

4. **Traducciones**: "Show all" → "Ver más", "New Arrivals" → "Novedades", "Deal of the day" → "Oferta del día", "New Products" → "Nuevos productos", "best sellers" → "Más vendidos", "add to cart" → "Agregar al carrito", "Category" → "Categorías", "Available Stock" → "Stock disponible", "By" → "Por".

5. **Blog count**: `posts_per_page` ahora usa ACF `home_blog_count` (fallback 4). Título visible agregado.

6. **Action buttons decorativos**: Eliminados del HTML `heart-outline`, `eye-outline`, `repeat-outline` del `.showcase-actions` en `product-grid.php`.

### Archivos modificados

| Archivo | Cambio |
|---------|--------|
| `inc/homepage-sections.php` | **Nuevo**: ACF fields groups (homepage titles + category icon) |
| `functions.php` | `require_once` para `inc/homepage-sections.php` |
| `template-parts/home/categories.php` | Mapa PHP → ACF + traducción |
| `template-parts/home/product-minimal.php` | Título ACF + traducción |
| `template-parts/home/product-featured.php` | Título ACF + traducción |
| `template-parts/home/product-grid.php` | Título ACF + traducción + remove buttons |
| `template-parts/home/sidebar.php` | Título ACF + traducciones |
| `template-parts/home/blog.php` | Título ACF + blog count + traducción |
| `template-parts/woocommerce/deal-product-card.php` | Traducción |

### Riesgos

- **ACF dependency**: Si ACF se desactiva, los campos retornan vacío y se usan los fallbacks en español. Comportamiento seguro.
- **Front page ID**: Los campos ACF están ubicados en `page_type=front_page`. Si no hay front page configurada, los fallbacks se activan.
- **Category icon**: Si una categoría no tiene icono, usa `bag.svg`. El admin puede subir iconos desde el editor de categorías.

---

## FASE 7D — Limpieza final de contenido hardcodeado (Prioridad BAJA)

| Bloque | Cambio | Complejidad | Riesgo | Beneficio |
|--------|--------|-------------|--------|-----------|
| Blog fallback images | Reemplazar array de placeholders con placeholder generado dinámicamente (placeholder.com o CSS gradient) | Baja | Mínimo | Sin dependencia de archivos demo |
| CTA Banner seed de imagen | Agregar seed de imagen local al theme (copiar al activar) | Baja | Mínimo | Sin dependencia de ruta demo |
| Action buttons product-grid | Los action buttons decorativos se documentan como "no implementar" por restricción del proyecto (AGENTS.md) | N/A | N/A | Decisión consciente |
| Sidebar titles ("best sellers", "Category") | Reemplazar strings hardcodeados con ACF option | Baja | Mínimo | Títulos configurables |

---

## Estado post-FASE 7

| Bloque | Estado antes de FASE 7B | Estado post-FASE 7C |
|--------|------------------------|----------------------|
| Hero | Parcial | **Dinámico** ✅ |
| Categories | Parcial | **Dinámico** ✅ |
| Sidebar | Dinámico | **Dinámico** ✅ |
| New Arrivals | Parcial | **Dinámico** ✅ |
| Deal of the Day | Parcial | **Dinámico** ✅ |
| New Products | Parcial | **Dinámico** ✅ |
| Testimonials | Parcial | **Dinámico** ✅ |
| CTA Banner | Dinámico | Dinámico ✅ |
| Blog | Dinámico | **Dinámico** ✅ |

**9 Dinámicos · 0 Parciales**

---

## Recomendación final

**La homepage actual es ~97% administrable desde WordPress** (actualizado post-FASE 7C).

Todos los bloques de la homepage son ahora administrables desde WordPress sin tocar código.

**Próximos pasos recomendados:**

1. **FASE 7D** (Opcional) — Traducción de lugarholders y limpieza menor
2. **Single product template** — breadcrumbs ya implementados en FASE 6C.2/B
3. **WooCommerce emails** — personalización de emails transaccionales

**Lo que NO se modificará** (por restricción explícita del proyecto):
- Add-to-cart, AJAX, single product hooks
- Refactors estructurales (Tailwind, React, Vite)
