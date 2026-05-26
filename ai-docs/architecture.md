# Architecture

## Theme

anon-theme

Theme custom WordPress orientado a ecommerce reusable.

---

# Objetivo arquitectónico

Construir un starter theme WooCommerce:

* modular
* mantenible
* reusable
* compatible con Gutenberg
* agency-ready

---

# Estructura actual aproximada

```txt
anon-theme/
│
├── assets/
│   ├── css/
│   ├── js/
│   ├── images/
│
├── ai-docs/
│
├── front-page.php          # Homepage: banner, categorías, 3 secciones producto
├── woocommerce.php          # Thin wrapper → woocommerce_content()
├── header.php
├── footer.php
├── functions.php
├── style.css                # Monolítico, incluye #WOOCOMMERCE section
```

NOTA: No existe directorio woocommerce/ con overrides.
El shop usa templates default de WooCommerce.
Los estilos WC están en style.css (#WOOCOMMERCE section).

---

# Objetivo futuro de estructura

```txt
anon-theme/
│
├── assets/
│   ├── css/
│   ├── js/
│   ├── images/
│
├── inc/
│   ├── setup/
│   ├── enqueue/
│   ├── woocommerce/
│   ├── gutenberg/
│   ├── helpers/
│
├── template-parts/
│
├── woocommerce/
│
└── ai-docs/
```

---

# Filosofía de desarrollo

Priorizar:

* estabilidad
* compatibilidad WooCommerce
* bajo riesgo
* commits pequeños
* cambios incrementales

Evitar:

* refactors agresivos
* cambios visuales innecesarios
* features complejas prematuras

---

# WooCommerce

## Enfoque actual

Usar WooCommerce clásico sin overrides de templates:

* NO hay woocommerce/archive-product.php ni woocommerce/content-product.php
* Se usa renderizado default de WC (ul.products > li.product)
* Estilos CSS en style.css (#WOOCOMMERCE section)
* CSS plugin nativo desactivado (woocommerce_enqueue_styles filter)
* front-page.php usa queries custom con .product-grid > .showcase (contexto separado)

## Shop page vs Homepage

Ambos contextos conviven sin nesting inválido porque:

* Shop page: ul.products > li.product (default WC)
* Homepage: .product-grid > .showcase (custom query en front-page.php)

Visualmente alineados mediante CSS grid y mismas variables de diseño.

---

# Product Cards

Objetivo:
Una sola arquitectura reusable para:

* home
* shop
* categorías
* relacionados
* upsells

---

# Riesgo actual importante (RESUELTO 2026-05-26)

No existe archive-product.php en el theme.
No hay conflicto con ul.products/li.product porque no hay overrides.
El shop usa templates default WC + CSS del theme.

Ver: project-status.md → "Shop page estabilizada"

---

# CSS

Actualmente:

* CSS monolítico en style.css

Objetivo futuro:
modularizar CSS por:

* components
* layout
* pages
* woocommerce

NO hacer todavía.

---

# JavaScript

Mantener JS separado.
NO usar inline JS en templates PHP.

---

# Gutenberg

Objetivo futuro:

* soporte Gutenberg moderno
* theme.json
* block styles
* editor styles

Todavía NO implementado.
