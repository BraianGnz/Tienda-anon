<?php

function anon_theme_setup() {

    add_theme_support('title-tag');

    add_theme_support('post-thumbnails');

    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 300,
        'gallery_thumbnail_image_width' => 150,
        'single_image_width' => 600,
    ));

    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    register_nav_menus(array(
        'primary' => __('Primary Menu', 'anon-theme'),
        'footer'  => __('Footer Menu', 'anon-theme'),
    ));

    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'anon_theme_setup');

function anon_theme_scripts() {

    wp_enqueue_style(
        'anon-theme-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get('Version')
    );

    wp_enqueue_style(
        'anon-theme-google-fonts',
        'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap',
        array(),
        null
    );

    if (is_front_page()) {
        wp_enqueue_style(
            'anon-theme-swiper-css',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
            array(),
            '11.2.6'
        );

        wp_enqueue_script(
            'anon-theme-swiper-js',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
            array(),
            '11.2.6',
            true
        );

        wp_enqueue_script(
            'anon-theme-hero-slider',
            get_template_directory_uri() . '/assets/js/hero-slider.js',
            array('anon-theme-swiper-js'),
            wp_get_theme()->get('Version'),
            true
        );
    }

    wp_enqueue_script(
        'anon-theme-ionicons',
        'https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js',
        array(),
        '5.5.2',
        true
    );

    wp_enqueue_script(
        'anon-theme-script',
        get_template_directory_uri() . '/html-template/assets/js/script.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('wp_enqueue_scripts', 'anon_theme_scripts');

function anon_theme_register_sidebars() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'anon-theme'),
        'id'            => 'sidebar-1',
        'description'   => __('Main sidebar area', 'anon-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'anon_theme_register_sidebars');

function anon_theme_fallback_menu() {
    echo '<nav class="desktop-navigation-menu">';
    echo '<ul class="desktop-menu-category-list">';
    echo '<li class="menu-category"><a href="' . esc_url(home_url('/')) . '" class="menu-title">Home</a></li>';
    echo '</ul>';
    echo '</nav>';
}

function anon_theme_wc_setup() {
    remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
}
add_action('wp', 'anon_theme_wc_setup');

function anon_theme_wc_disable_styles($enqueue_styles) {
    return array();
}
add_filter('woocommerce_enqueue_styles', 'anon_theme_wc_disable_styles');

require_once get_template_directory() . '/inc/hero-slider.php';
require_once get_template_directory() . '/inc/cta-banner.php';
require_once get_template_directory() . '/inc/blog-seeder.php';
