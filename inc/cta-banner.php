<?php

function cta_banner_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key'    => 'group_cta_banner',
        'title'  => 'CTA Banner',
        'fields' => array(
            array(
                'key'           => 'field_cta_image',
                'label'         => 'Imagen de fondo',
                'name'          => 'cta_image',
                'type'          => 'image',
                'return_format' => 'url',
                'required'      => 1,
                'instructions'  => 'Imagen del banner CTA (recomendado: 800x960px)',
            ),
            array(
                'key'           => 'field_cta_badge',
                'label'         => 'Badge / Descuento',
                'name'          => 'cta_badge',
                'type'          => 'text',
                'default_value' => '20% OFF',
            ),
            array(
                'key'           => 'field_cta_title',
                'label'         => 'Título principal',
                'name'          => 'cta_title',
                'type'          => 'text',
                'default_value' => 'Medias Personalizadas Premium',
                'required'      => 1,
            ),
            array(
                'key'           => 'field_cta_text',
                'label'         => 'Texto secundario',
                'name'          => 'cta_text',
                'type'          => 'text',
                'default_value' => 'Diseños exclusivos para empresas, eventos y marcas',
            ),
            array(
                'key'           => 'field_cta_button_text',
                'label'         => 'Texto del botón',
                'name'          => 'cta_button_text',
                'type'          => 'text',
                'default_value' => 'Ver Colección',
            ),
            array(
                'key'           => 'field_cta_button_url',
                'label'         => 'URL del botón',
                'name'          => 'cta_button_url',
                'type'          => 'url',
                'default_value' => home_url('/shop/'),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'page',
                ),
            ),
        ),
        'position' => 'normal',
        'style'    => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ));
}
add_action('acf/init', 'cta_banner_acf_fields');


function cta_banner_get_front_page_id() {
    $front_id = (int) get_option('page_on_front');
    return $front_id > 0 ? $front_id : null;
}


function cta_banner_seed_defaults() {
    if (get_option('cta_banner_defaults_created')) {
        return;
    }

    if (!function_exists('get_field')) {
        return;
    }

    $post_id = cta_banner_get_front_page_id();
    if (!$post_id) {
        return;
    }

    $existing = get_field('cta_title', $post_id);
    if (!empty($existing)) {
        update_option('cta_banner_defaults_created', true);
        return;
    }

    $img_url = get_template_directory_uri() . '/html-template/assets/images';

    update_field('cta_image', $img_url . '/cta-banner.jpg', $post_id);
    update_field('cta_badge', '20% OFF', $post_id);
    update_field('cta_title', 'Medias Personalizadas Premium', $post_id);
    update_field('cta_text', 'Diseños exclusivos para empresas, eventos y marcas', $post_id);
    update_field('cta_button_text', 'Ver Colección', $post_id);
    update_field('cta_button_url', home_url('/shop/'), $post_id);

    update_option('cta_banner_defaults_created', true);
}
add_action('after_switch_theme', 'cta_banner_seed_defaults');
add_action('admin_init', 'cta_banner_seed_defaults');
add_action('acf/init', 'cta_banner_seed_defaults', 20);
