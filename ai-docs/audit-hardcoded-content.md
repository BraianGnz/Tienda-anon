# Auditoría de contenido hardcodeado — Junio 2026

## Resumen

Se analizaron todos los archivos PHP del theme en busca de contenido estático,
enlaces `href="#"`, imágenes hardcodeadas, textos demo del template original
y datos no administrables desde WordPress.

---

## Hallazgos

### A. HEADER — `header.php`

| # | Líneas | Hallazgo | Riesgo | Prioridad |
|---|---|---|---|---|
| A1 | 26-28 | Imagen `newsletter.png` hardcodeada (modal) | Bajo | Baja |
| A2 | 32-48 | Newsletter form: título, descripción, `action="#"` sin procesamiento real | Bajo | Baja |
| A3 | 56-82 | Notification toast: imagen `jewellery-1.jpg`, texto "Someone in new just bought", "Rose Gold Earrings", "2 Minutes" (prueba social falsa) | Bajo | Baja |
| A4 | 90-116 | 4 iconos sociales (Facebook, Twitter, Instagram, LinkedIn) con `href="#"` | Medio | Alta |
| A5 | 118-123 | Banner "**Free Shipping** This Week Order Over — $55" hardcodeado | Medio | Alta |
| A6 | 125-142 | Selectores de moneda (USD/EUR) e idioma (EN/ES/FR) no funcionales, hardcodeados | Bajo | Baja |
| A7 | 181-184 | Botón wishlist con count "0", sin funcionalidad real | Bajo | Baja |
| A8 | 269-316 | Menú mobile: selector idioma (EN/ES/FR) + moneda (USD/EUR) con `href="#"` | Bajo | Baja |
| A9 | 316-344 | 4 iconos sociales en menú mobile con `href="#"` | Medio | Alta |

### B. FOOTER — `footer.php`

| # | Líneas | Hallazgo | Riesgo | Prioridad | Estado |
|---|---|---|---|---|---|
| B1 | 3-77 | ~~Footer Category "Brand directory": 4 categorías (Fashion, Footwear, Jewellery, Cosmetics) con ~57 subcategorías hardcodeadas, TODOS los enlaces `href="#"`~~ | ~~Alto~~ | ~~Alta~~ | ✅ RESUELTO — wp_nav_menu con Footer_Brand_Walker (4-box layout, enlaces a categorías reales) |
| B2 | 92-118 | ~~"Popular Categories": Fashion, Electronic, Cosmetic, Health, Watches — 5 enlaces `href="#"`~~ | ~~Alto~~ | ~~Alta~~ | ✅ RESUELTO — wp_nav_menu con Footer_Column_Walker (Tienda, Blog, Contacto) |
| B3 | 120-146 | ~~"Our Company": 5 enlaces a páginas que probablemente no existen~~ | ~~Medio~~ | ~~Alta~~ | ✅ RESUELTO v2 — 5 páginas reales creadas (Sobre Nosotros, Términos y Condiciones, Política de Privacidad, Aviso Legal, Envíos y Devoluciones) y vinculadas como Page Links |
| B4 | 279 | Imagen `payment.png` hardcodeada (métodos de pago ficticios) | Bajo | Media |

### C. SERVICIOS — `template-parts/home/testimonials.php`

| # | Líneas | Hallazgo | Riesgo | Prioridad |
|---|---|---|---|---|
| C1 | 57-140 | **Sección completa "Our Services"**: 5 items hardcodeados con `href="#"`: Worldwide Delivery, Next Day delivery, Best Online Support, Return Policy, 30% money back. Descripciones ficticias (For Order Over $100, UK Orders Only, Hours: 8AM-11PM, etc.) | Alto | Alta |
| C2 | 31 | Fallback de imagen testimonial: `testimonial-1.jpg` hardcodeado (usado cuando CPT no tiene thumbnail) | Bajo | Media |
| C3 | 45 | `quotes.svg` hardcodeado | Bajo | Baja |

### D. HERO SLIDER — `template-parts/home/hero.php`

| # | Líneas | Hallazgo | Riesgo | Prioridad |
|---|---|---|---|---|
| D1 | 33-61 | 3 fallback slides con contenido del template original: "Trending item", "Women's latest fashion sale", "starting at $20.00", "Modern sunglasses", "New fashion summer sale". Todos los botónes `href="#"` | Medio | Alta |

### E. CTA BANNER — `template-parts/home/banners.php`

| # | Líneas | Hallazgo | Riesgo | Prioridad |
|---|---|---|---|---|
| E1 | 18-23 | Fallback values con contenido del template original: "25% Discount", "Summer collection", "Starting @ $10", botón `href="#"`. **No coinciden con los defaults seed del negocio** (20% OFF, Medias Personalizadas Premium) | Medio | Alta |

### F. CATEGORÍAS — `template-parts/home/categories.php`

| # | Líneas | Hallazgo | Riesgo | Prioridad |
|---|---|---|---|---|
| F1 | 4-11 | SVG icons mapeados por slug de categoría (`shoes.svg`, `hat.svg`, `perfume.svg`, `tee.svg`, `bag.svg`). No administrables desde WordPress (archivos estáticos en el theme) | Bajo | Media |

### G. PRODUCT GRID — `template-parts/home/product-grid.php`

| # | Líneas | Hallazgo | Riesgo | Prioridad |
|---|---|---|---|---|
| G1 | 60-73 | Botones de acción (wishlist, quick view, compare, add-to-cart) son `<button>` sin funcionalidad real | Bajo | Baja |

### H. TEMPLATES FALTANTES

| # | Archivo | Hallazgo | Riesgo | Prioridad |
|---|---|---|---|---|
| H1 | — | No existe `single.php` (usa `index.php` para single post) | Medio | Alta |
| H2 | — | No existe `page.php` (usa `index.php` para páginas) | Medio | Alta |
| H3 | — | No existe `archive.php` (usa `index.php` para archivos) | Medio | Alta |
| H4 | — | No existe `search.php` (usa `index.php`) | Medio | Media |
| H5 | — | No existe `404.php` (usa `index.php`) | Medio | Alta |

### I. ARCHIVOS LEGACY

| # | Archivo | Hallazgo | Riesgo | Prioridad |
|---|---|---|---|---|
| I1 | `html-template/` | Directorio completo con HTML original del template (no usado por WordPress) | Bajo | Baja |
| I2 | `website-demo-image/` | Directorio con imágenes demo del template original | Bajo | Baja |
| I3 | `html-template/index.html` | Página HTML estática del template original | Bajo | Baja |
| I4 | `html-template/README-template.md` | Readme del template original | Bajo | Baja |

---

## Estadísticas

- **Total enlaces `href="#"`**: ~~71~~ → **~56** (se eliminaron ~15 del footer)
- **Secciones 100% hardcodeadas**: Services, Newsletter modal, Notification toast
- **Secciones parcialmente hardcodeadas (fallbacks)**: Hero slides, CTA banner, categorías icons
- **Secciones dinámicas agregadas**: Footer Brand Directory, Popular Categories, Our Company (wp_nav_menu con páginas reales)
- **Páginas creadas automáticamente**: about-us, terms-and-conditions, privacy-policy, legal-notice, shipping-returns (5 páginas con placeholder content)
- **Templates faltantes**: single.php, page.php, archive.php, search.php, 404.php
- **Archivos legacy**: html-template/, website-demo-image/

---

## Prioridades de resolución

### Prioridad Alta (contenido visible que daña la experiencia)

1. ✅ ~~Footer "Brand directory" (~57 links `#`)~~ → Convertido a menú con 4 boxes (Medias, Calcetines, Parches, Accesorios)
2. ✅ ~~Footer "Popular Categories" (5 links `#`)~~ → Convertido a menú (Tienda, Blog, Contacto)
3. ✅ ~~Footer "Our Company" (5 links a páginas que no existen)~~ → Convertido a menú (Sobre Nosotros, Términos, Delivery, Pago Seguro, Aviso Legal) → v2: Ahora 5 páginas reales creadas: Sobre Nosotros, Términos y Condiciones, Política de Privacidad, Aviso Legal, Envíos y Devoluciones
4. Header top social icons (4 links `#`) → conectar con ACF footer social o menú
5. Header top "Free Shipping" banner → ACF field o widget administrable
6. Services section (5 items hardcodeados) → convertir a CPT o ACF repeater-free workaround
7. Hero fallback slides (3 slides con texto demo y `#`) → mejorar fallback con contenido del negocio
8. CTA banner fallback → alinear con valores seed del negocio
9. No existe 404.php → crear template con diseño del theme
10. No existe single.php → reemplazar index.php con template dedicado
11. No existe page.php → template dedicado
12. No existe archive.php → template dedicado

### Prioridad Media (mejorable, no urgente)

13. Categories SVG icons → campo ACF image en taxonomy product_cat
14. Payment image en footer → editable desde admin
15. No existe search.php → template con resultados de búsqueda estilizados

### Prioridad Baja (nice to have)

16. Newsletter modal → integrar con plugin real (Mailchimp, etc.)
17. Notification toast social proof → funcionalidad real o eliminarlo
18. Wishlist/quick view/compare buttons → funcionalidad real o eliminarlos
19. Currency/language selectors → plugin multi-idioma/divisa o eliminarlos
20. Archivos legacy → limpiar html-template/ y website-demo-image/

---

## Fases recomendadas

### Fase 4: Contenido del Footer ✅ COMPLETADO (2026-06-11)
- ✅ "Brand directory" convertido a menú con 4 boxes (parent-child) y enlaces a categorías WooCommerce
- ✅ "Popular Categories" convertido a menú (Tienda, Blog, Contacto)
- ✅ "Our Company" convertido a menú (Sobre Nosotros, Términos, Delivery, Pago Seguro, Aviso Legal) → v2: 5 páginas reales (Sobre Nosotros, Términos y Condiciones, Política de Privacidad, Aviso Legal, Envíos y Devoluciones)
- Pendiente: Hacer editable la imagen de métodos de pago

### Fase 5: Servicios
- Crear CPT "service" (icono, título, descripción, URL)
- Reemplazar sección hardcodeada con loop dinámico
- Seeder con defaults adaptados al negocio

### Fase 6: Header superior
- Hacer editable el banner "Free Shipping" (ACF field o widget)
- Conectar iconos sociales con datos existentes de ACF footer o menú

### Fase 7: Templates faltantes
- Crear single.php, page.php, archive.php, search.php, 404.php
- Index.php queda como fallback genérico

### Fase 8: Sistema de iconos
- Añadir campo ACF image a la taxonomía product_cat
- Permite subir iconos personalizados por categoría desde el admin

### Fase 9: Limpieza
- Eliminar html-template/ y website-demo-image/
- Evaluar si newsletter modal, toast notification, wishlist/compare/quick-view deben funcionalidad real o eliminarse
