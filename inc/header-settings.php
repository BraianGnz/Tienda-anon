<?php

function header_settings_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key'    => 'group_header_settings',
        'title'  => 'Header Settings',
        'fields' => array(
            array(
                'key'           => 'field_header_promo_text',
                'label'         => 'Texto promocional del header',
                'name'          => 'header_promo_text',
                'type'          => 'text',
                'default_value' => 'Envíos a todo el país',
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
        'position'         => 'normal',
        'style'            => 'default',
        'label_placement'  => 'top',
        'instruction_placement' => 'label',
    ));
}
add_action('acf/init', 'header_settings_acf_fields');


function header_settings_seed_defaults() {
    if (get_option('header_settings_defaults_created')) {
        return;
    }

    if (!function_exists('get_field')) {
        return;
    }

    $post_id = (int) get_option('page_on_front');
    if (!$post_id) {
        return;
    }

    $existing = get_field('header_promo_text', $post_id);
    if (!empty($existing)) {
        update_option('header_settings_defaults_created', true);
        return;
    }

    update_field('header_promo_text', 'Envíos a todo el país', $post_id);

    update_option('header_settings_defaults_created', true);
}
add_action('after_switch_theme', 'header_settings_seed_defaults');
add_action('admin_init', 'header_settings_seed_defaults');
