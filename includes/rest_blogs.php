<?php
/* Register function to run at rest_api_init hook */
add_action('rest_api_init', function () {
    /* Setup siteurl/wp-json/bloggies/v2/all */
    register_rest_route('bloggies/v2', '/all', array(
        'methods' => 'GET',
        'callback' => 'rest_blogs',
        'args' => array(
            'id' => array(
                'validate_callback' => function ($param, $request, $key) {
                    return is_numeric($param);
                },
            ),
        ),
    ));
});

function rest_blogs($data)
{
	$args = array(
        'posts_per_page' => -1,
        'post_status' => 'publish',
	);

	$loop = new WP_Query( $args );

    if ($loop) {
    	$insightItems = array();

        while ($loop->have_posts()): $loop->the_post();
			array_push(
				$insightItems, array(
                    'excerpt' => get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true),
                    'id' => get_the_ID(),
					'image' => get_the_post_thumbnail_url(get_the_ID(), 'mobile'),
					'link' => get_the_permalink(),
					'title' => get_the_title(),
                    'content' => get_the_content(),
                    'slug' => get_post_field('post_name')
				)
			);
		endwhile;

		wp_reset_postdata();
    } else {
        return new WP_Error(
            'no_menus',
            'Could not find any cases',
            array(
                'status' => 404,
            )
        );
    }

    return $insightItems;
}
