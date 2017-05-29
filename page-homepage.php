<?php /* Template Name: Index Page Template */ get_header(); ?>

<?php $paged = ( get_query_var('page') ) ? get_query_var('page') : 1;

$query = array(
	'post_type' => 'post',
	'posts_per_page' => 15,
	'paged' => $paged
);

$pattern = 0;

$loop = new WP_Query( $query ); ?>

<main role="main">
	<!-- section -->

<section>

<h1>WhatJackHasMade - Latest Posts</h1>

<section class="grid">

<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

	<article class="grid-item">
		<?php

		if ($pattern != 5) {
			$pattern++;
		} else {
			$pattern = 1;
		}
		?>

		<div id="post-<?php the_ID(); ?>" class="grid-item__thumbnail background--primary pattern--<?php echo $pattern;?>">
		</div>

		<div class="grid-item__details">
			<h2 style="font-weight: 400;"><?php the_title(); ?></h2>
		</div>

        <a class="link--cover" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			<?php the_title(); ?>
		</a>

        <svg>
            <style>
			<?php if ( has_post_thumbnail()) { ?>
	        <?php
				$mobile = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'mobile' );
			?>

			@media screen and (min-width: 640px) {
                #post-<?php the_ID(); ?> { background-image: url('<?php echo $mobile['0']; ?>'); }
			}
            </style>
        </svg>
        <?php }?>

	</article>

	<?php endwhile; ?>

</section>

</section>


</main>

<?php if ($loop->max_num_pages > 1) { // check if the max number of pages is greater than 1  ?>
	<nav class="pagination background--secondary">
		<?php echo get_previous_posts_link( '<< Newer Entries' ); // display newer posts link ?>
		<span><?php echo get_next_posts_link( 'Older Entries >>', $loop->max_num_pages ); // display older posts link ?></span>
	</nav>
<?php } ?>

<?php wp_reset_query(); ?>

<?php get_footer(); ?>
