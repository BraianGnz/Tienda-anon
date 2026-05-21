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
├── woocommerce/
│   ├── archive-product.php
│   └── content-product.php
│
├── ai-docs/
│
├── front-page.php
├── header.php
├── footer.php
├── functions.php
├── style.css
```

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

Usar WooCommerce clásico:

* templates override mínimos
* compatibilidad estándar
* evitar copiar templates innecesarios

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

# Riesgo actual importante

archive-product.php puede estar entrando en conflicto con:

* ul.products
* li.product
* woocommerce_product_loop_start()

Necesario validar:

* HTML final renderizado
* nesting válido
* compatibilidad WooCommerce

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
