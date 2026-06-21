<?php

function services_register_post_type() {
    register_post_type('service', array(
        'labels' => array(
            'name'               => 'Services',
            'singular_name'      => 'Service',
            'add_new_item'       => 'Add New Service',
            'edit_item'          => 'Edit Service',
            'new_item'           => 'New Service',
            'view_item'          => 'View Service',
            'search_items'       => 'Search Services',
            'not_found'          => 'No services found',
            'not_found_in_trash' => 'No services found in Trash',
        ),
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_position' => 22,
        'menu_icon'    => 'dashicons-star-filled',
        'supports'     => array('title', 'page-attributes'),
        'hierarchical' => false,
        'rewrite'      => false,
        'show_in_rest' => false,
    ));
}
add_action('init', 'services_register_post_type');


function services_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key'    => 'group_service',
        'title'  => 'Service Info',
        'fields' => array(
            array(
                'key'           => 'field_service_icon',
                'label'         => 'Icono (Ionicon name)',
                'name'          => 'service_icon',
                'type'          => 'text',
                'default_value' => 'boat-outline',
                'required'      => 1,
                'instructions'  => 'Nombre del icono Ionicon. Ej: boat-outline, rocket-outline, call-outline',
            ),
            array(
                'key'           => 'field_service_desc',
                'label'         => 'Descripción',
                'name'          => 'service_desc',
                'type'          => 'text',
                'required'      => 1,
            ),
            array(
                'key'           => 'field_service_url',
                'label'         => 'URL',
                'name'          => 'service_url',
                'type'          => 'url',
                'default_value' => home_url('/shop/'),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'service',
                ),
            ),
        ),
    ));
}
add_action('acf/init', 'services_acf_fields');


function services_seed_defaults() {
    if (get_option('services_defaults_created')) {
        return;
    }

    if (!function_exists('get_field')) {
        return;
    }

    $existing = get_posts(array(
        'post_type'      => 'service',
        'posts_per_page' => 1,
        'post_status'    => 'any',
    ));

    if (!empty($existing)) {
        update_option('services_defaults_created', true);
        return;
    }

    $defaults = array(
        array(
            'title'       => 'Envíos a todo el país',
            'desc'        => 'Entregas en 24-72 hs hábiles',
            'icon'        => 'boat-outline',
            'url'         => home_url('/shop/'),
            'menu_order'  => 1,
        ),
        array(
            'title'       => 'Envío Express',
            'desc'        => 'AMBA y principales ciudades',
            'icon'        => 'rocket-outline',
            'url'         => home_url('/shop/'),
            'menu_order'  => 2,
        ),
        array(
            'title'       => 'Soporte Online',
            'desc'        => 'Lun a Vie 9:00 - 18:00',
            'icon'        => 'call-outline',
            'url'         => home_url('/contacto/'),
            'menu_order'  => 3,
        ),
        array(
            'title'       => 'Cambios y Devoluciones',
            'desc'        => 'Hasta 30 días de realizada la compra',
            'icon'        => 'arrow-undo-outline',
            'url'         => home_url('/shipping-returns/'),
            'menu_order'  => 4,
        ),
        array(
            'title'       => 'Pago en Cuotas',
            'desc'        => 'Hasta 12 cuotas sin interés',
            'icon'        => 'ticket-outline',
            'url'         => home_url('/shop/'),
            'menu_order'  => 5,
        ),
    );

    foreach ($defaults as $data) {
        $post_id = wp_insert_post(array(
            'post_type'   => 'service',
            'post_title'  => $data['title'],
            'post_status' => 'publish',
            'menu_order'  => $data['menu_order'],
        ));

        if ($post_id && !is_wp_error($post_id)) {
            update_field('service_icon', $data['icon'], $post_id);
            update_field('service_desc', $data['desc'], $post_id);
            update_field('service_url', $data['url'], $post_id);
        }
    }

    update_option('services_defaults_created', true);
}
add_action('after_switch_theme', 'services_seed_defaults');
add_action('admin_init', 'services_seed_defaults');
