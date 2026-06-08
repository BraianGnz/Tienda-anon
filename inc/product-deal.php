<?php

function deal_of_the_day_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key'    => 'group_deal_of_the_day',
        'title'  => 'Deal of the Day',
        'fields' => array(
            array(
                'key'           => 'field_deal_of_the_day',
                'label'         => 'Marcar como Deal of the Day',
                'name'          => 'deal_of_the_day',
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
                    'value'    => 'product',
                ),
            ),
        ),
        'position' => 'side',
        'style'    => 'default',
        'label_placement' => 'top',
    ));
}
add_action('acf/init', 'deal_of_the_day_acf_fields');


function get_deal_of_the_day_query() {
    $deal_query = new WP_Query(array(
        'post_type'      => 'product',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'meta_query'     => array(
            array(
                'key'   => 'deal_of_the_day',
                'value' => '1',
            ),
        ),
    ));

    if ($deal_query->have_posts()) {
        return $deal_query;
    }

    $fallback_query = new WP_Query(array(
        'post_type'      => 'product',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ));

    return $fallback_query;
}
