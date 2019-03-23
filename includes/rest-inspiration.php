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
            $the_content = convert_content(get_the_content());
            $the_content = get_the_content();
            array_push(
                $inspirationItems, array(
                    'category' => get_the_category(),
                    'content' => $the_content,
                    'date' => get_the_date('c'),
                    'excerpt' => get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true),
                    'id' => get_the_ID(),
                    'imageLargest' => get_the_post_thumbnail_url(get_the_ID(), 'largest'),
                    'imageDesktop' => get_the_post_thumbnail_url(get_the_ID(), 'desktop'),
                    'imageLaptop' => get_the_post_thumbnail_url(get_the_ID(), 'laptop'),
                    'imageTablet' => get_the_post_thumbnail_url(get_the_ID(), 'tablet'),
                    'imageMobile' => get_the_post_thumbnail_url(get_the_ID(), 'mobile'),
                    'thumbnailTall' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail-tall'),
                    'thumbnailDefault' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail-default'),
                    'thumbnailSmall' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail-small'),
                    'imageFull' => get_the_post_thumbnail_url(),
                    'link' => get_the_permalink(),
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
