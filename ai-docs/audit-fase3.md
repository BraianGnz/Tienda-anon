# AUDITORÍA COMPLETA — FASE 3

> Fecha: 2026-06-03
> Objetivo: Identificar secciones estáticas vs dinámicas para llegar a una tienda WooCommerce 100% administrable.

---

## 1. HERO (Banner principal)

**Archivo**: `template-parts/home/hero.php`
**Estado actual**: 100% ESTÁTICO
**Fuente de datos**: HTML plano + imágenes desde `/html-template/assets/images/banner-*.jpg`
**Usa**: `get_template_directory_uri()`, HTML, CSS
**Nivel integración WP**: **0%**
**Prioridad**: ALTA

**Hardcodeado**:
- 3 slides completos: imágenes (banner-1.jpg, banner-2.jpg, banner-3.jpg)
- Textos: "Trending item", "Women's latest fashion sale", "starting at $20.00"
- "Trending accessories", "Modern sunglasses", "starting at $15.00"
- "Sale Offer", "New fashion summer sale", "starting at $29.99"
- 3 botones "Shop now" con `href="#"`

**Para administrar**: Usar Customizer con repeatable banner sections, o ACF Flexible Content, o WP Query con un CPT "Banners".

---

## 2. CATEGORÍAS DESTACADAS ✅ RESUELTO (2026-06-03)

**Archivo**: `template-parts/home/categories.php`
**Estado actual**: 100% DINÁMICO
**Fuente de datos**: `get_terms('product_cat')` + SVG icons mapeados por slug
**Usa**: `get_terms()`, WooCommerce taxonomy, HTML
**Nivel integración WP**: **75%** (iconos SVG aún son archivos estáticos)
**Prioridad**: RESUELTA

**Cambios aplicados**:
- ✅ Reemplazadas 8 categorías hardcodeadas por `get_terms('product_cat')`
- ✅ Nombres reales de WooCommerce, contadores reales, links reales a archive pages
- ✅ Excluida "Uncategorized" del display
- ✅ Eliminados todos los `href="#"` — ahora apuntan a `get_term_link()`
- ✅ SVG icons mapeados por slug: shoes.svg (medias/calcetines), hat.svg (gorras), perfume.svg (perfumes), tee.svg (remeras), bag.svg (fallback)
- ✅ Sin cambios en CSS, JS, ni functions.php

**Pendiente**: Los SVG icons siguen siendo archivos estáticos. Se necesita campo ACF image en taxonomy product_cat para administrarlos desde WP.

---

## 3. SIDEBAR

**Archivo**: `template-parts/home/sidebar.php`
**Estado actual**: 25% DINÁMICO / 75% ESTÁTICO
**Fuente de datos**: `get_terms('product_cat')` (categorías dinámicas) + HTML plano (best sellers)
**Usa**: `get_terms()`, WooCommerce taxonomy, HTML
**Nivel integración WP**: **25%**
**Prioridad**: ALTA

**Ya es dinámico**:
- Lista de categorías con `get_terms('product_cat')` — nombres reales, contadores reales, links reales ✅

**Hardcodeado**:
- Título "best sellers"
- 4 productos con imágenes (1.jpg, 2.jpg, 3.jpg, 4.jpg), nombres, precios, ratings
- Todos los links "#"

**Para administrar**: Reemplazar best sellers con `WP_Query` ordenado por ventas (WooCommerce).

---

## 4. NEW ARRIVALS

**Archivo**: `template-parts/home/product-minimal.php`
**Estado actual**: 75% DINÁMICO
**Fuente de datos**: `WP_Query(post_type => 'product', orderby => 'date', posts_per_page => 8)`
**Usa**: `WP_Query`, WooCommerce functions (`woocommerce_get_product_thumbnail`, `$product->get_price_html()`)
**Nivel integración WP**: **75%**
**Prioridad**: MEDIA

**Ya es dinámico**:
- Query de productos reales ✅
- Thumbnails dinámicos ✅
- Precios reales de WooCommerce ✅
- Categorías reales ✅

**Hardcodeado**:
- Título "New Arrivals"
- Número de productos fijo (8)

**Para administrar**: Permitir configurar título y cantidad desde Customizer o un filtro.

---

## 5. DEAL OF THE DAY

**Archivo**: `template-parts/home/product-featured.php`
**Estado actual**: 70% DINÁMICO
**Fuente de datos**: `WP_Query(post_type => 'product', meta_query => _featured => yes)`
**Usa**: `WP_Query`, WooCommerce functions
**Nivel integración WP**: **70%**
**Prioridad**: ALTA

**Ya es dinámico**:
- Query de productos destacados (WooCommerce _featured) ✅
- Precios, thumbnails, ratings, descripciones reales ✅
- Add-to-cart form funcional ✅
- Fallback query (random si no hay destacados)

**Hardcodeado**:
- Título "Deal of the day"
- Usa _featured como proxy (no es un "deal" real)
- Límite fijo: 4 productos

**Problemas**:
- Fallback query duplica ~30 líneas de HTML del loop principal
- El concepto "Deal of the Day" debería ser 1 producto seleccionable, no 4 featured

**Para administrar**: Crear meta box para marcar un producto como "Deal of the Day", o usar un ACF para seleccionar producto específico.

---

## 6. NEW PRODUCTS

**Archivo**: `template-parts/home/product-grid.php`
**Estado actual**: 75% DINÁMICO
**Fuente de datos**: `WP_Query(post_type => 'product', orderby => 'date', posts_per_page => 12)`
**Usa**: `WP_Query`, WooCommerce functions, badge logic PHP
**Nivel integración WP**: **75%**
**Prioridad**: MEDIA

**Ya es dinámico**:
- Query de productos reales (últimos 12) ✅
- Thumbnails + hover image (gallery) ✅
- Badge system (out-of-stock > discount > new) ✅
- Precios, ratings, categorías reales ✅
- Gallery image hover funcional ✅

**Hardcodeado**:
- Título "New Products"
- Número de productos fijo (12)

**Para administrar**: Customizer para título y cantidad. Opcionalmente permitir elegir entre "new", "best sellers", "on sale", o "categoría específica".

---

## 7. TESTIMONIALS

**Archivo**: `template-parts/home/testimonials.php`
**Estado actual**: 100% ESTÁTICO
**Fuente de datos**: HTML plano
**Usa**: `get_template_directory_uri()`, HTML, CSS
**Nivel integración WP**: **0%**
**Prioridad**: MEDIA

**Hardcodeado**:
- 1 testimonial: imagen testimonial-1.jpg, "Alan Doe", "CEO & Founder Invision", texto Lorem Ipsum
- Quotes icon: icons/quotes.svg

**Para administrar**: CPT "Testimonial" o plugin de testimonials. O Customizer si solo se necesita 1.

---

## 8. SERVICES

**Archivo**: `template-parts/home/testimonials.php` (mismo archivo que testimonials)
**Estado actual**: 100% ESTÁTICO
**Fuente de datos**: HTML plano + Ionicons
**Usa**: HTML, CSS, Ionicons
**Nivel integración WP**: **0%**
**Prioridad**: BAJA

**Hardcodeado**:
- 5 servicios: "Worldwide Delivery", "Next Day delivery", "Best Online Support", "Return Policy", "30% money back"
- Todos con `href="#"` e iconos Ionicons hardcodeados
- Descripciones: "For Order Over $100", "UK Orders Only", "Hours: 8AM - 11PM", "Easy & Free Return"

**Para administrar**: Widget area en footer o Customizer con repeatable group.

---

## 9. BANNERS (CTA)

**Archivo**: `template-parts/home/banners.php`
**Estado actual**: 100% ESTÁTICO
**Fuente de datos**: HTML plano
**Usa**: `get_template_directory_uri()`, HTML, CSS
**Nivel integración WP**: **0%**
**Prioridad**: ALTA

**Hardcodeado**:
- Imagen: cta-banner.jpg
- Texto: "25% Discount", "Summer collection", "Starting @ $10"
- Botón "Shop now" con `href="#"`

**Para administrar**: Customizer con imagen, texto, descuento, link, o ACF Flexible Content.

---

## 10. BLOG

**Archivo**: `template-parts/home/blog.php`
**Estado actual**: 100% ESTÁTICO
**Fuente de datos**: HTML plano
**Usa**: `get_template_directory_uri()`, HTML, CSS
**Nivel integración WP**: **0%**
**Prioridad**: ALTA

**Hardcodeado**:
- 4 blog cards: blog-1.jpg a blog-4.jpg
- Categorías: "Fashion", "Clothes", "Shoes", "Electronics"
- Títulos hardcodeados (2 repetidos: "Curbside fashion Trends...")
- Autores: "Mr Admin", "Mr Robin", "Mr Selsa", "Mr Pawar"
- Fechas: Apr 06, 2022 / Jan 18, 2022 / Feb 10, 2022 / Mar 15, 2022
- Todos los links "#"

**Para administrar**: Reemplazar con `WP_Query('post_type' => 'post', 'posts_per_page' => 4)`.

---

## 11. HEADER

**Archivo**: `header.php`
**Estado actual**: 50% DINÁMICO / 50% ESTÁTICO
**Nivel integración WP**: **50%**
**Prioridad**: MEDIA

**Ya es dinámico**:
- Logo: `has_custom_logo()` + `the_custom_logo()` ✅
- Menú primary: `wp_nav_menu('primary')` ✅ (desktop + mobile)
- Search form: `get_search_query()`, `home_url('/')` ✅
- Cart count: `WC()->cart->get_cart_contents_count()` ✅ (header + mobile)
- Cart link: `wc_get_cart_url()` ✅
- Login link: `wp_login_url()` ✅
- Language attributes, charset, bloginfo, body_class, wp_head, wp_body_open, wp_footer ✅

**Hardcodeado**:
- Social icons (4): Facebook, Twitter, Instagram, LinkedIn — `href="#"` — **duplicado** igual en mobile nav y footer
- "Free Shipping This Week Order Over - $55" — texto promocional
- Currency selector: USD/EUR en HTML estático
- Language selector: English/Español/Français en HTML estático
- Newsletter modal: imagen newsletter.png, título, descripción, form action "#"
- Notification toast: imagen jewellery-1.jpg, "Rose Gold Earrings", "Someone in new just bought", "2 Minutes ago"
- Mobile nav: language/currency/social links con `href="#"`

---

## 12. FOOTER

**Archivo**: `footer.php`
**Estado actual**: 30% DINÁMICO / 70% ESTÁTICO
**Nivel integración WP**: **30%**
**Prioridad**: MEDIA

**Ya es dinámico**:
- Footer menu: `wp_nav_menu('footer')` ✅
- Copyright: `date('Y')`, `bloginfo('name')` ✅
- "Our Company" links usan `home_url()` con slugs reales ✅

**Hardcodeado**:
- **Brand directory**: 4 columnas con 40+ categorías hardcodeadas, todos `href="#"` — el HTML más extenso del footer (~70 líneas)
- **Popular Categories**: Fashion, Electronic, Cosmetic, Health, Watches — `href="#"` — **duplicado** de conceptos del brand directory
- **Contacto**: dirección (419 State 414 Rte, Beaver Dams, NY 14812), teléfono ((607) 936-8058), email (example@gmail.com)
- **Follow Us**: Facebook, Twitter, LinkedIn, Instagram — `href="#"` — **mismo patrón que header**
- Imagen: payment.png

---

## 13. WOOCOMMERCE

**Archivos**: `woocommerce.php`, `functions.php`
**Estado actual**: 100% FUNCIONAL

**Lo que funciona**:
- WooCommerce support with thumbnail sizes ✅
- Gallery zoom, lightbox, slider ✅
- CSS plugin desactivado ✅
- Sidebar WC removido ✅
- Shop page con templates default WC + CSS ✅
- No existe `woocommerce/` override directory ✅
- No existe `archive-product.php` ni `single-product.php` en el theme ✅

**Nivel integración WP**: **100%** (delega todo a WooCommerce)

---

## 14. DETECCIÓN DE HTML REPETIDO

| Patrón | Archivos | Severidad |
|--------|----------|-----------|
| Social icons (FB, TW, IG, LI) con `href="#"` | `header.php` (x2: desktop + mobile), `footer.php` | ALTA |
| Product card `.showcase` structure | `product-minimal.php`, `product-featured.php` (x2: main+fallback), `product-grid.php` | MEDIA |
| Category links con `href="#"` | `categories.php`, `footer.php` (brand directory + popular categories) | ALTA |
| Price display `<del>` + `<p class="price">` | `sidebar.php` (best sellers), patrón hardcodeado | BAJA |
| Language/Currency selectors | `header.php` (desktop + mobile nav) | BAJA |

---

## 15. DETECCIÓN DE WP_QUERY DUPLICADAS

1. **`product-minimal.php`** y **`product-grid.php`**: Ambas usan `WP_Query(post_type => 'product', orderby => 'date', order => 'DESC')` con solo diferencia en `posts_per_page` (8 vs 12). Son consultas casi idénticas.

2. **`product-featured.php`**: El main query (featured) y el fallback (random) duplican ~30 líneas de HTML de loop cada uno.

---

## 16. SECCIONES CANDIDATAS A TEMPLATE-PART REUTILIZABLE

| Sección actual | Posible template-part reutilizable |
|---------------|-----------------------------------|
| Product card `.showcase` (repetido en 3 archivos) | `template-parts/woocommerce/product-card.php` |
| Social icons (repetido en header + footer) | `template-parts/global/social-icons.php` |
| Category grid item (repetido en categories.php) | `template-parts/woocommerce/category-item.php` |
| Blog card (repetido 4 veces en blog.php) | `template-parts/home/blog-card.php` |

---

## 17. IMÁGENES HARDCODEADAS

| Archivo | Imagen | Ruta |
|---------|--------|------|
| `header.php` | newsletter.png | `html-template/assets/images/newsletter.png` |
| `header.php` | jewellery-1.jpg | `html-template/assets/images/products/jewellery-1.jpg` |
| `hero.php` | banner-1.jpg, banner-2.jpg, banner-3.jpg | `html-template/assets/images/banner-*.jpg` |
| `categories.php` | SVG icons (mapeados por slug, aún estáticos) | `html-template/assets/images/icons/*.svg` |
| `sidebar.php` | 1.jpg, 2.jpg, 3.jpg, 4.jpg | `html-template/assets/images/products/*.jpg` |
| `testimonials.php` | testimonial-1.jpg, quotes.svg | `html-template/assets/images/` |
| `banners.php` | cta-banner.jpg | `html-template/assets/images/cta-banner.jpg` |
| `blog.php` | blog-1.jpg, blog-2.jpg, blog-3.jpg, blog-4.jpg | `html-template/assets/images/blog-*.jpg` |
| `footer.php` | payment.png | `html-template/assets/images/payment.png` |

---

## 18. TEXTOS HARDCODEADOS (resumen)

| Archivo | Textos |
|---------|--------|
| `hero.php` | ~12 textos diferentes (títulos, subtítulos, precios) |
| `categories.php` | ~~8 nombres + 8 cantidades falsas~~ ✅ RESUELTO |
| `sidebar.php` | "best sellers", 4 nombres de producto, precios |
| `product-minimal.php` | "New Arrivals" |
| `product-featured.php` | "Deal of the day", "add to cart" |
| `product-grid.php` | "New Products" |
| `testimonials.php` | ~15 textos (testimonial + 5 servicios) |
| `banners.php` | 3 textos |
| `blog.php` | ~16 textos (4 títulos, 4 categorías, 4 autores, 4 fechas) |
| `header.php` | ~8 textos (promo, newsletter, toast) |
| `footer.php` | ~50+ textos (brand directory, popular categories, contacto) |

---

## 19. ENLACES "#" DETECTADOS

| Archivo | Cantidad |
|---------|----------|
| `header.php` | ~15 (social, currency, language, newsletter form) |
| `footer.php` | ~50+ (brand directory, popular categories, social) |
| `hero.php` | 3 (Shop now) |
| `categories.php` | 8 (Show all) |
| `sidebar.php` | 8 (product links en best sellers) |
| `testimonials.php` | 5 (service items) |
| `banners.php` | 1 (CTA link) |
| `blog.php` | 8 (blog post links + category links) |
| **TOTAL** | **~100+** |

---

## 20. LISTA: LO QUE YA ES DINÁMICO ✅

1. **Logo**: Customizer (`has_custom_logo()` + `the_custom_logo()`)
2. **Menú primary**: `wp_nav_menu('primary')` en desktop + mobile
3. **Menú footer**: `wp_nav_menu('footer')`
4. **Search form**: query search con `get_search_query()`
5. **Cart**: count dinámico con `WC()->cart->get_cart_contents_count()`
6. **Login link**: `wp_login_url()`
7. **Sidebar categories**: `get_terms('product_cat')` con nombres reales, contadores, links
8. **Categories destacadas homepage**: `get_terms('product_cat')` con nombres reales, contadores, links, SVG icons mapeados
8. **New Arrivals**: `WP_Query` con productos reales (título hardcodeado)
9. **Deal of the Day**: `WP_Query` con productos featured + fallback (título hardcodeado)
10. **New Products grid**: `WP_Query` con productos reales + badge system (título hardcodeado)
11. **Shop page**: `woocommerce_content()` con templates default WC
12. **Single product**: Templates default WC
13. **WooCommerce**: Soporte completo (zoom, lightbox, gallery, slider)
14. **CSS**: WooCommerce styles desactivados, todo via style.css
15. **Copyright**: `date('Y')` + `bloginfo('name')`
16. **Our Company links**: `home_url()` con slugs reales (delivery, legal-notice, etc.)
17. **Google Fonts**: Enqueue correcto
18. **Ionicons**: CDN enqueue correcto
19. **Script.js**: Enqueue correcto
20. **HTML5 support**: search-form, comment-form, etc.

---

## 21. LISTA: LO QUE SIGUE ESTANDO HARDCODEADO ❌

### ALTA PRIORIDAD

1. **Hero slider** (`hero.php`): 3 slides completos (imágenes, textos, precios, links)
2. ~~**Categories destacadas** (`categories.php`)~~ ✅ RESUELTO (2026-06-03)
3. **Sidebar best sellers** (`sidebar.php`): 4 productos con imágenes, nombres, precios, ratings, links
4. **Banner CTA** (`banners.php`): imagen, descuento, título, precio, link
5. **Blog** (`blog.php`): 4 posts completos (imágenes, títulos, categorías, autores, fechas)
6. **Testimonials** (`testimonials.php`): 1 testimonial completo
7. **All `href="#"` links** (~100+ en todo el theme)

### MEDIA PRIORIDAD

8. **Services** (`testimonials.php`): 5 servicios con iconos, títulos, descripciones
9. **Social icons** (`header.php` + `footer.php`): Facebook, Twitter, Instagram, LinkedIn con `href="#"` — repetido 3 veces
10. **Footer brand directory** (`footer.php`): 40+ links de categorías hardcodeados
11. **Footer Popular Categories** (`footer.php`): 5 links hardcodeados
12. **Footer contacto** (`footer.php`): dirección, teléfono, email hardcodeados
13. **Header promo text** (`header.php`): "Free Shipping This Week Order Over - $55"
14. **Header newsletter modal** (`header.php`): imagen, título, descripción, form
15. **Header notification toast** (`header.php`): imagen, producto, mensaje
16. **Header currency/language selectors** (`header.php`): HTML estático
17. **Títulos de sección**: "New Arrivals", "Deal of the day", "New Products", "best sellers", "testimonial", "Our Services"
18. **Deal of the Day limit**: 4 productos fijo (debería ser 1 seleccionable)
19. **Fallback query duplicada** en `product-featured.php`

### BAJA PRIORIDAD

20. **Payment image** (`footer.php`): payment.png hardcodeada
21. **Header mobile nav**: language + currency duplicados del header top
22. **WP_Query duplicadas**: product-minimal.php y product-grid.php casi idénticas

---

## 22. RECOMENDACIÓN EXACTA PARA FASE 3

### Objetivo: Dinamizar todas las secciones de la homepage manteniendo diseño exacto

El orden recomendado abajo corresponde a la secuencia de implementación propuesta. La prioridad está determinada por: 1) impacto visual en homepage, 2) dependencias entre secciones, 3) facilidad de implementación.

### ORDEN RECOMENDADO DE IMPLEMENTACIÓN

| # | Sección | Cambio necesario | Archivo | Prioridad |
|---|---------|-----------------|---------|-----------|
| 1 | **Hero slider** | Convertir a WP_Query con CPT "Banner" o ACF Flexible Content. Mantener HTML exacto. | `hero.php` | ALTA |
| 2 | **Blog section** | Reemplazar HTML estático con `WP_Query('post_type' => 'post', 'posts_per_page' => 4)`. | `blog.php` | ALTA |
| 3 | **Categories destacadas** | ✅ RESUELTO (2026-06-03). Pendiente: campo ACF image SVG en taxonomy. | `categories.php` | RESUELTA |
| 4 | **Sidebar best sellers** | Reemplazar HTML estático con `WP_Query` ordenado por `total_sales` meta. | `sidebar.php` | ALTA |
| 5 | **Banner CTA** | Customizer o ACF para imagen, texto, link. | `banners.php` | ALTA |
| 6 | **Testimonials** | ACF repeatable group o CPT Testimonial. | `testimonials.php` | MEDIA |
| 7 | **Services** | ACF repeatable group o Widget area. | `testimonials.php` | BAJA |
| 8 | **Deal of the Day** | Crear meta box en producto para marcar "Deal of the Day". Query single product. Eliminar fallback duplicado. | `product-featured.php` | ALTA |
| 9 | **Títulos de sección** | Customizer settings para títulos: "New Arrivals", "Deal of the day", "New Products", etc. | Varios | MEDIA |
| 10 | **Footer brand directory** | Reemplazar con menú WordPress o taxonomy links. | `footer.php` | MEDIA |
| 11 | **Footer contacto** | Customizer para dirección, teléfono, email. | `footer.php` | MEDIA |
| 12 | **Header social links** | Menú social o Customizer. Template-part reutilizable. | `header.php` | BAJA |
| 13 | **Header promo text** | Customizer text field. | `header.php` | BAJA |
| 14 | **Header newsletter** | Integrar con plugin newsletter real o desactivar. | `header.php` | BAJA |
| 15 | **Social icons footer** | Mismo template-part que header. | `footer.php` | BAJA |
| 16 | **Footer payment image** | Customizer media field. | `footer.php` | BAJA |
| 17 | **Refactor fallback duplicado** | Extraer loop HTML a template-part reutilizable. | `product-featured.php` | BAJA |
| 18 | **Refactor product card** | Template-part unificado para `.showcase` card. | Varios | BAJA |
| 19 | **Eliminar todos `href="#"`** | Reemplazar con links reales o eliminar. | Todo el theme | ALTA |

### Notas importantes

- **NO** crear overrides de templates WooCommerce (`woocommerce/`) todavía. El CSS en style.css es suficiente.
- **NO** modificar add-to-cart, AJAX, wishlist, quick view, compare.
- **NO** cambiar clases CSS ni estructura HTML — el diseño debe mantenerse exactamente igual.
- **SÍ** usar ACF (Advanced Custom Fields) para campos personalizados en lugar de Customizer cuando se necesiten grupos repetibles.
- **SÍ** crear template-parts reutilizables para eliminar HTML duplicado (product-card, social-icons).
- **Cada cambio** debe ser un commit separado y verificado visualmente.

---

## 23. PATRÓN DE IMPLEMENTACIÓN RECOMENDADO

Para cada sección a dinamizar, seguir este patrón:

1. Leer el HTML actual en el template-part
2. Identificar variables: imágenes, textos, links, números
3. Elegir fuente de datos:
   - **WP_Query** para lists (productos, posts, CPTs)
   - **get_terms()** para taxonomías
   - **Customizer** para textos simples (títulos, promo)
   - **ACF** para grupos complejos (testimonials, services, banners)
   - **Menú WP** para links de navegación (social, brand directory)
4. Preservar **exactamente** el HTML, clases CSS y estructura
5. Reemplazar solo los datos, no el markup
6. Verificar en browser: homepage, mobile, tablet
7. Commit: un cambio por sección

---

*Fin del reporte de auditoría — FASE 3*
