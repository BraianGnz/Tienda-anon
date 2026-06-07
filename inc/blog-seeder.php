<?php

function anon_blog_seeder_import_image($url, $post_id) {
    if (!function_exists('download_url')) {
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
    }

    $tmp = download_url($url);
    if (is_wp_error($tmp)) {
        return false;
    }

    $file_array = array(
        'name'     => basename($url),
        'tmp_name' => $tmp,
    );

    $attachment_id = media_handle_sideload($file_array, $post_id);
    if (is_wp_error($attachment_id)) {
        @unlink($tmp);
        return false;
    }

    return $attachment_id;
}

function anon_blog_seeder_cleanup_all() {
    $all = get_posts(array(
        'post_type'      => 'post',
        'post_status'    => 'any',
        'posts_per_page' => -1,
        'fields'         => 'ids',
    ));

    foreach ($all as $pid) {
        $thumb_id = get_post_thumbnail_id($pid);
        if ($thumb_id) {
            wp_delete_attachment($thumb_id, true);
        }
        wp_delete_post($pid, true);
    }

    delete_option('anon_blog_posts_seeded');
    delete_option('anon_blog_articles_created');
}

function anon_blog_seeder_create_defaults() {
    if (get_option('anon_blog_articles_created')) {
        return;
    }

    anon_blog_seeder_cleanup_all();

    $img_base = get_template_directory_uri() . '/html-template/assets/images';

    $categories = array(
        'Diseño'       => array('slug' => 'diseno'),
        'Corporativo'  => array('slug' => 'corporativo'),
        'Parches'      => array('slug' => 'parches'),
        'Merchandising' => array('slug' => 'merchandising'),
    );

    $cat_ids = array();
    foreach ($categories as $cat_name => $cat_data) {
        $cid = term_exists($cat_name, 'category');
        if ($cid && isset($cid['term_id'])) {
            $cat_ids[$cat_name] = (int) $cid['term_id'];
        } else {
            $new_cid = wp_insert_term($cat_name, 'category', array('slug' => $cat_data['slug']));
            if (!is_wp_error($new_cid)) {
                $cat_ids[$cat_name] = (int) $new_cid['term_id'];
            }
        }
    }

    $articles = array(
        array(
            'title'   => 'Cómo diseñar medias personalizadas para empresas',
            'slug'    => 'disenar-medias-personalizadas-empresas',
            'cat'     => 'Diseño',
            'excerpt' => 'Guía paso a paso para crear medias personalizadas con la identidad corporativa de tu empresa. Colores, tejidos, talles y acabados que marcan la diferencia.',
            'content' => 'Las medias personalizadas son una herramienta de branding poderosa. En esta guía te explicamos cómo elegir los colores corporativos, seleccionar el tejido adecuado según el uso, definir talles y acabar con detalles que marcan la diferencia. Desde el diseño inicial hasta la producción, cada paso cuenta para lograr un producto que represente fielmente a tu marca.',
            'image'   => $img_base . '/blog-1.jpg',
        ),
        array(
            'title'   => 'Ventajas de los calcetines corporativos personalizados',
            'slug'    => 'ventajas-calcetines-corporativos-personalizados',
            'cat'     => 'Corporativo',
            'excerpt' => 'Los calcetines personalizados fortalecen la identidad de marca, mejoran el sentido de pertenencia y son un regalo corporativo memorable.',
            'content' => 'Los calcetines corporativos personalizados van más allá de una simple prenda. Son una herramienta de cohesión de equipo, un regalo empresarial que perdura y una forma sutil pero efectiva de mantener tu marca presente en el día a día de colaboradores y clientes. Descubrí por qué cada vez más empresas eligen este formato para sus campañas de branding interno y externo.',
            'image'   => $img_base . '/blog-2.jpg',
        ),
        array(
            'title'   => 'Guía de parches termoadhesivos para ropa',
            'slug'    => 'guia-parches-termoadhesivos-ropa',
            'cat'     => 'Parches',
            'excerpt' => 'Todo lo que necesitás saber sobre parches planchados: tipos, aplicaciones, cuidados y cómo personalizar prendas de forma sencilla.',
            'content' => 'Los parches termoadhesivos son una solución versátil para personalizar ropa sin necesidad de coser. En esta guía completa repasamos los distintos tipos de parches disponibles, los materiales sobre los que funcionan mejor, cómo aplicarlos correctamente con plancha doméstica y los cuidados necesarios para que duren. Ideal para marcas que buscan una opción accesible y de alto impacto visual.',
            'image'   => $img_base . '/blog-3.jpg',
        ),
        array(
            'title'   => 'Ideas de merchandising premium para marcas',
            'slug'    => 'ideas-merchandising-premium-marcas',
            'cat'     => 'Merchandising',
            'excerpt' => 'Combiná estilo y funcionalidad con artículos personalizados que tus clientes realmente quieran usar y conservar.',
            'content' => 'El merchandising premium no se trata solo de regalar cosas con el logo: se trata de crear objetos que las personas deseen tener y usar. Desde medias de edición limitada hasta parches coleccionables, pasando por combos que integran varios productos personalizados, las posibilidades son infinitas. Acá te compartimos ideas probadas para que tu marca deje una impresión duradera.',
            'image'   => $img_base . '/blog-4.jpg',
        ),
    );

    foreach ($articles as $index => $article) {
        $post_id = wp_insert_post(array(
            'post_title'   => $article['title'],
            'post_name'    => $article['slug'],
            'post_content' => $article['content'],
            'post_excerpt' => $article['excerpt'],
            'post_status'  => 'publish',
            'post_author'  => 1,
        ));

        if ($post_id && !is_wp_error($post_id)) {
            if (isset($cat_ids[$article['cat']])) {
                wp_set_post_categories($post_id, array($cat_ids[$article['cat']]));
            }

            $attachment_id = anon_blog_seeder_import_image($article['image'], $post_id);
            if ($attachment_id) {
                set_post_thumbnail($post_id, $attachment_id);
            }
        }
    }

    update_option('anon_blog_articles_created', true);
}
add_action('after_switch_theme', 'anon_blog_seeder_create_defaults');
add_action('admin_init', 'anon_blog_seeder_create_defaults');
