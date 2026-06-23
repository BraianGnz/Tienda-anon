<?php

function homepage_sections_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key'    => 'group_homepage_sections',
        'title'  => 'Secciones del Home',
        'fields' => array(
            array(
                'key'           => 'field_home_new_arrivals_title',
                'label'         => 'Título: Novedades',
                'name'          => 'home_new_arrivals_title',
                'type'          => 'text',
                'default_value' => 'Novedades',
            ),
            array(
                'key'           => 'field_home_deal_title',
                'label'         => 'Título: Oferta del día',
                'name'          => 'home_deal_title',
                'type'          => 'text',
                'default_value' => 'Oferta del día',
            ),
            array(
                'key'           => 'field_home_new_products_title',
                'label'         => 'Título: Nuevos productos',
                'name'          => 'home_new_products_title',
                'type'          => 'text',
                'default_value' => 'Nuevos productos',
            ),
            array(
                'key'           => 'field_home_best_sellers_title',
                'label'         => 'Título: Más vendidos',
                'name'          => 'home_best_sellers_title',
                'type'          => 'text',
                'default_value' => 'Más vendidos',
            ),
            array(
                'key'           => 'field_home_blog_title',
                'label'         => 'Título: Blog',
                'name'          => 'home_blog_title',
                'type'          => 'text',
                'default_value' => 'Blog',
            ),
            array(
                'key'           => 'field_home_blog_count',
                'label'         => 'Cantidad de posts en blog',
                'name'          => 'home_blog_count',
                'type'          => 'number',
                'default_value' => 4,
                'min'           => 1,
                'max'           => 20,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'page_type',
                    'operator' => '==',
                    'value'    => 'front_page',
                ),
            ),
        ),
        'position'       => 'normal',
        'style'          => 'default',
        'label_placement' => 'top',
    ));

    acf_add_local_field_group(array(
        'key'    => 'group_category_icon',
        'title'  => 'Icono de Categoría',
        'fields' => array(
            array(
                'key'           => 'field_category_icon',
                'label'         => 'Icono',
                'name'          => 'category_icon',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'thumbnail',
                'instructions'  => 'Sube un icono SVG para esta categoría',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'taxonomy',
                    'operator' => '==',
                    'value'    => 'product_cat',
                ),
            ),
        ),
        'position'       => 'normal',
        'style'          => 'default',
        'label_placement' => 'top',
    ));
}
add_action('acf/init', 'homepage_sections_acf_fields');


function homepage_sections_get_front_id() {
    $front_id = (int) get_option('page_on_front');
    return $front_id > 0 ? $front_id : null;
}
