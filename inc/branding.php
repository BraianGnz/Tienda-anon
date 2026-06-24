<?php

function branding_get_defaults() {
    return array(
        'brand_primary' => '#f9a8b4',
        'brand_dark'    => '#212121',
        'brand_text'    => '#787878',
        'brand_success' => '#46c389',
        'brand_error'   => '#ff6666',
        'brand_rating'  => '#f0a050',
    );
}

add_action('customize_register', 'branding_customizer_register');

function branding_customizer_register($wp_customize) {

    $wp_customize->add_panel('anon_theme_branding', array(
        'title'    => __('Branding', 'anon-theme'),
        'priority' => 30,
    ));

    $wp_customize->add_section('anon_theme_branding_colors', array(
        'title'    => __('Colores', 'anon-theme'),
        'panel'    => 'anon_theme_branding',
        'priority' => 10,
    ));

    $colors = array(
        'brand_primary' => __('Color principal', 'anon-theme'),
        'brand_dark'    => __('Color oscuro', 'anon-theme'),
        'brand_text'    => __('Color de texto secundario', 'anon-theme'),
        'brand_success' => __('Color de éxito', 'anon-theme'),
        'brand_error'   => __('Color de error / descuento', 'anon-theme'),
        'brand_rating'  => __('Color de valoración', 'anon-theme'),
    );

    foreach ($colors as $setting_id => $label) {
        $wp_customize->add_setting($setting_id, array(
            'default'           => branding_get_defaults()[$setting_id],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            $setting_id,
            array(
                'label'    => $label,
                'section'  => 'anon_theme_branding_colors',
                'settings' => $setting_id,
            )
        ));
    }

}

function branding_get_custom_css() {
    $css = ':root {' . PHP_EOL;
    foreach (branding_get_defaults() as $setting_id => $default) {
        $var_name = '--' . str_replace('_', '-', $setting_id);
        $value    = get_theme_mod($setting_id, $default);
        $css     .= sprintf("  %s: %s;%s", $var_name, $value, PHP_EOL);
    }
    return $css . '}' . PHP_EOL;
}
