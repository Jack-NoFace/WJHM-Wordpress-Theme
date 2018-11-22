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
            $primary_cat_id = get_post_meta(get_the_ID(), '_yoast_wpseo_primary_product_cat', true);
            if ($primary_cat_id) {
                $product_cat = get_term($primary_cat_id, 'product_cat');
                if (isset($product_cat->name)) {
                    $category = $product_cat->slug;
                }
            } else {
                $categories = get_the_category();
                if (!empty($categories)) {
                    $category =  esc_html($categories[0]->slug);
                }
            }

            $related = get_field('related_posts');
            $related_array = null;

            if ($related) {
                $related_array = [];
                foreach( $related as $p):
                    $id = $p->ID;
                    $related_array[] = (object) array(
                        'excerpt' => get_post_meta($id, '_yoast_wpseo_metadesc', true),
                        'id' => $id,
                        'image' => get_the_post_thumbnail_url($id, 'mobile'),
                        'slug' => get_post_field('post_name', $id)
                    );
                endforeach;
                wp_reset_postdata();
            }


			array_push(
				$insightItems, array(
                    'category' => $category,
                    'content' => get_the_content(),
                    'excerpt' => get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true),
                    'id' => get_the_ID(),
                    'image' => get_the_post_thumbnail_url(get_the_ID(), 'mobile'),
					'imageFull' => get_the_post_thumbnail_url(),
                    'link' => get_the_permalink(),
                    'related' => $related_array,
                    'slug' => get_post_field('post_name'),
                    'title' => get_the_title()
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
