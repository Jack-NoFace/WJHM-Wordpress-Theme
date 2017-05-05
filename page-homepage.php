<?php /* Template Name: Index Page Template */ get_header(); ?>

<?php $paged = ( get_query_var('page') ) ? get_query_var('page') : 1;

$query = array(
	'post_type' => 'post',
	'posts_per_page' => 16,
	'paged' => $paged
);

$loop = new WP_Query( $query ); ?>

<section class="container">

<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

	<article id="post-<?php the_ID(); ?>" class="container__post background--primary background--cover gradient--<?php echo(rand(1,10));?>">
        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

			<h2><?php the_title(); ?></h2>

            <?php if ( has_post_thumbnail()) { ?>
            <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'custom-size' );?>
            <svg>
                <style>
                #post-<?php the_ID(); ?> {
				}

				@media screen and (min-width: 640px) {
                    #post-<?php the_ID(); ?> { background-image: url('<?php echo $thumb['0']; ?>'); }
				}

				@media screen and (min-width: 1024px) {
                    #post-<?php the_ID(); ?> { background-image: url('<?php echo $thumb['0']; ?>'); }
				}

				@media screen and (min-width: 1366px) {
					#post-<?php the_ID(); ?> { background-image: url('<?php echo $thumb['0']; ?>'); }
				}

				@media screen and (min-width: 1920px) {
					#post-<?php the_ID(); ?> { background-image: url('<?php echo $thumb['0'];?>'); }
				}
                </style>
            </svg>
            <?php } else { ?>
            <?php } ?>

        </a>
	</article>

	<?php endwhile; ?>

</section>

<?php if ($loop->max_num_pages > 1) { // check if the max number of pages is greater than 1  ?>
	<nav class="pagination background--secondary">
		<?php echo get_previous_posts_link( '<< Newer Entries' ); // display newer posts link ?>
		<span><?php echo get_next_posts_link( 'Older Entries >>', $loop->max_num_pages ); // display older posts link ?></span>
	</nav>
<?php } ?>

<?php wp_reset_query(); ?>

<?php get_footer(); ?>
