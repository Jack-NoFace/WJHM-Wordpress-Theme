<div class="related">
    <?php
    $orig_post = $post;
    global $post;
    $categories = get_the_category($post->ID);
    if ($categories) {
        $category_ids = array();
        foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;

        $args=array(
            'category__in' => $category_ids,
            'post__not_in' => array($post->ID),
            'posts_per_page'=> 4, // Number of related posts that will be shown.
            'caller_get_posts'=>1
        );

        $my_query = new wp_query( $args );
        if( $my_query->have_posts() ) {

            if ($pattern != 5) {
                $pattern++;
            } else {
                $pattern = 1;
            }

            ?>

            <h2>Related Posts</h2>

            <section class="grid">

            <?php while( $my_query->have_posts() ) {
            $my_query->the_post();?>

            <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'mobile--small' );?>

            <article class="grid-item">

                <div class="grid-item__thumbnail background--cover" style="background-image: url('<?php echo $thumb['0'];?>')">
                </div>

                <div class="grid-item__details">
                    <h3><?php the_title(); ?></h3>
                </div>

                <a class="link--cover" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"></a>

            </article>

<?php
        }
    }
}
$post = $backup;
wp_reset_query();
?>

</section>

</div>
