<?php

function testimonials_register_post_type() {
    register_post_type('testimonial', array(
        'labels' => array(
            'name'               => 'Testimonials',
            'singular_name'      => 'Testimonial',
            'add_new_item'       => 'Add New Testimonial',
            'edit_item'          => 'Edit Testimonial',
            'new_item'           => 'New Testimonial',
            'view_item'          => 'View Testimonial',
            'search_items'       => 'Search Testimonials',
            'not_found'          => 'No testimonials found',
            'not_found_in_trash' => 'No testimonials found in Trash',
        ),
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_position' => 21,
        'menu_icon'    => 'dashicons-format-quote',
        'supports'     => array('title', 'editor', 'thumbnail', 'page-attributes'),
        'hierarchical' => false,
        'rewrite'      => false,
        'show_in_rest' => false,
    ));
}
add_action('init', 'testimonials_register_post_type');


function testimonials_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key'    => 'group_testimonial',
        'title'  => 'Testimonial Info',
        'fields' => array(
            array(
                'key'   => 'field_testimonial_city',
                'label' => 'Ciudad',
                'name'  => 'client_city',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_testimonial_product',
                'label' => 'Producto comprado',
                'name'  => 'product_name',
                'type'  => 'text',
            ),
            array(
                'key'           => 'field_testimonial_show',
                'label'         => 'Mostrar en Home',
                'name'          => 'show_on_home',
                'type'          => 'true_false',
                'ui'            => 1,
                'default_value' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'testimonial',
                ),
            ),
        ),
    ));
}
add_action('acf/init', 'testimonials_acf_fields');


function testimonials_seed_demo() {
    if (get_option('testimonials_seeded')) {
        return;
    }

    $existing = get_posts(array(
        'post_type'      => 'testimonial',
        'posts_per_page' => 1,
        'post_status'    => 'any',
    ));

    if (!empty($existing)) {
        update_option('testimonials_seeded', true);
        return;
    }

    $demos = array(
        array(
            'title'      => 'María García',
            'content'    => 'Las medias personalizadas superaron nuestras expectativas. La calidad del bordado y la fidelidad del color fueron impecables. Nuestro equipo las usa con orgullo.',
            'city'       => 'Buenos Aires',
            'product'    => 'Medias corporativas',
            'menu_order' => 1,
        ),
        array(
            'title'      => 'Carlos Mendoza',
            'content'    => 'Compramos parches termoadhesivos para un evento corporativo y el resultado fue espectacular. Aplicación sencilla y gran durabilidad. Muy recomendables.',
            'city'       => 'Córdoba',
            'product'    => 'Parches personalizados',
            'menu_order' => 2,
        ),
        array(
            'title'      => 'Lucía Fernández',
            'content'    => 'Los calcetines con el logo de nuestra marca fueron un éxito en la feria. Todos preguntaron dónde los habíamos encargado. Calidad premium sin duda.',
            'city'       => 'Rosario',
            'product'    => 'Calcetines personalizados',
            'menu_order' => 3,
        ),
    );

    foreach ($demos as $data) {
        $post_id = wp_insert_post(array(
            'post_type'   => 'testimonial',
            'post_title'  => $data['title'],
            'post_content'=> $data['content'],
            'post_status' => 'publish',
            'menu_order'  => $data['menu_order'],
        ));

        if ($post_id && !is_wp_error($post_id)) {
            update_field('client_city', $data['city'], $post_id);
            update_field('product_name', $data['product'], $post_id);
            update_field('show_on_home', false, $post_id);
        }
    }

    update_option('testimonials_seeded', true);
}
add_action('after_switch_theme', 'testimonials_seed_demo');
add_action('admin_init', 'testimonials_seed_demo');
