<?php
/* Register function to run at rest_api_init hook */
add_action('rest_api_init', function () {
    /* Setup siteurl/wp-json/inspiration/v2/all */
    register_rest_route('inspiration/v2', '/all', array(
        'methods' => 'GET',
        'callback' => 'rest_inspirations',
        'args' => array(
            'slug' => array(
                'validate_callback' => function ($param, $request, $key) {
                    return is_string($param);
                },
            ),
        ),
    ));
});

function rest_inspirations($data)
{
    $params = $data->get_params();
    $slug = $params['slug'];

    if ($slug):
        $args = array(
            'name' => $slug,
            'numberposts' => 1,
            'post_status' => 'publish',
            'post_type' => 'inspiration',
        );
    else:
        $args = array(
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'post_type' => 'inspiration',
        );
    endif;

    $loop = new WP_Query($args);

    if ($loop) {
        $inspirationItems = array();
        while ($loop->have_posts()): $loop->the_post();
            array_push(
                $inspirationItems, array(
                    'category' => get_the_category(),
                    'content' => get_the_content(),
                    'date' => get_the_date('c'),
                    'excerpt' => get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true),
                    'id' => get_the_ID(),
                    'link' => get_the_permalink(),
                    'media' => get_field('media'),
                    'seoTitle' => get_post_meta(get_the_ID(), '_yoast_wpseo_title', true),
                    'slug' => get_post_field('post_name'),
                    'title' => html_entity_decode(get_the_title()),
                )
            );
        endwhile;

        wp_reset_postdata();
    } else {
        return new WP_Error(
            'no_menus',
            'Could not find any inspiration',
            array(
                'status' => 404,
            )
        );
    }

    return $inspirationItems;
}
