<?php

function footer_contact_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key'    => 'group_footer_contact',
        'title'  => 'Footer — Información de Contacto',
        'fields' => array(
            array(
                'key'           => 'field_contact_address',
                'label'         => 'Dirección',
                'name'          => 'contact_address',
                'type'          => 'text',
                'default_value' => 'Av. Corrientes 1234',
            ),
            array(
                'key'           => 'field_contact_city',
                'label'         => 'Ciudad',
                'name'          => 'contact_city',
                'type'          => 'text',
                'default_value' => 'CABA',
            ),
            array(
                'key'           => 'field_contact_region',
                'label'         => 'Provincia / Región',
                'name'          => 'contact_region',
                'type'          => 'text',
                'default_value' => 'Buenos Aires',
            ),
            array(
                'key'           => 'field_contact_country',
                'label'         => 'País',
                'name'          => 'contact_country',
                'type'          => 'text',
                'default_value' => 'Argentina',
            ),
            array(
                'key'           => 'field_contact_phone',
                'label'         => 'Teléfono',
                'name'          => 'contact_phone',
                'type'          => 'text',
                'default_value' => '+54 11 5678-9012',
            ),
            array(
                'key'           => 'field_contact_email',
                'label'         => 'Email',
                'name'          => 'contact_email',
                'type'          => 'text',
                'default_value' => 'info@mediaspersonalizadas.com.ar',
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
        'position'           => 'normal',
        'style'              => 'default',
        'label_placement'    => 'top',
        'instruction_placement' => 'label',
    ));

    acf_add_local_field_group(array(
        'key'    => 'group_footer_social',
        'title'  => 'Footer — Redes Sociales',
        'fields' => array(
            array(
                'key'   => 'field_social_facebook',
                'label' => 'Facebook URL',
                'name'  => 'social_facebook',
                'type'  => 'url',
            ),
            array(
                'key'   => 'field_social_instagram',
                'label' => 'Instagram URL',
                'name'  => 'social_instagram',
                'type'  => 'url',
            ),
            array(
                'key'   => 'field_social_linkedin',
                'label' => 'LinkedIn URL',
                'name'  => 'social_linkedin',
                'type'  => 'url',
            ),
            array(
                'key'   => 'field_social_tiktok',
                'label' => 'TikTok URL',
                'name'  => 'social_tiktok',
                'type'  => 'url',
            ),
            array(
                'key'   => 'field_social_youtube',
                'label' => 'YouTube URL',
                'name'  => 'social_youtube',
                'type'  => 'url',
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
        'position'           => 'normal',
        'style'              => 'default',
        'label_placement'    => 'top',
        'instruction_placement' => 'label',
    ));
}
add_action('acf/init', 'footer_contact_acf_fields');


function footer_contact_get_front_page_id() {
    $front_id = (int) get_option('page_on_front');
    return $front_id > 0 ? $front_id : null;
}


function footer_contact_get($field, $fallback = '') {
    if (!function_exists('get_field')) {
        return $fallback;
    }
    $post_id = footer_contact_get_front_page_id();
    if (!$post_id) {
        return $fallback;
    }
    $value = get_field($field, $post_id);
    return (!empty($value) || is_numeric($value)) ? $value : $fallback;
}


function footer_contact_acf_active() {
    return function_exists('get_field') && footer_contact_get_front_page_id();
}


function footer_contact_seed_defaults() {
    if (get_option('footer_contact_defaults_created')) {
        return;
    }

    if (!function_exists('get_field')) {
        return;
    }

    $post_id = footer_contact_get_front_page_id();
    if (!$post_id) {
        return;
    }

    $existing = get_field('contact_address', $post_id);
    if (!empty($existing)) {
        update_option('footer_contact_defaults_created', true);
        return;
    }

    update_field('contact_address', 'Av. Corrientes 1234', $post_id);
    update_field('contact_city', 'CABA', $post_id);
    update_field('contact_region', 'Buenos Aires', $post_id);
    update_field('contact_country', 'Argentina', $post_id);
    update_field('contact_phone', '+54 11 5678-9012', $post_id);
    update_field('contact_email', 'info@mediaspersonalizadas.com.ar', $post_id);

    update_field('social_facebook', 'https://facebook.com/mediaspersonalizadas', $post_id);
    update_field('social_instagram', 'https://instagram.com/mediaspersonalizadas', $post_id);
    update_field('social_linkedin', 'https://linkedin.com/company/mediaspersonalizadas', $post_id);
    update_field('social_tiktok', 'https://tiktok.com/@mediaspersonalizadas', $post_id);
    update_field('social_youtube', 'https://youtube.com/@mediaspersonalizadas', $post_id);

    update_option('footer_contact_defaults_created', true);
}
add_action('after_switch_theme', 'footer_contact_seed_defaults');
add_action('admin_init', 'footer_contact_seed_defaults');
