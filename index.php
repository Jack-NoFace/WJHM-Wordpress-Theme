<?php get_header(); ?>

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

	<?php get_template_part('partials/grid', 'item'); ?>

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
