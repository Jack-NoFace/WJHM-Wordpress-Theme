<?php get_header(); ?>

	<main role="main">
	<!-- section -->
	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<div class="wrapper">

			<!-- post title -->
			<h1>
				<?php the_title(); ?>
			</h1>
			<!-- /post title -->

			<span class="breadcrumbs"><?php the_category(' ') ?></span>

			<?php the_content(); // Dynamic Content ?>

			</div>

	<?php endwhile; ?>

	<?php else: ?>

		<!-- article -->
		<article>

			<h1><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h1>

		</article>
		<!-- /article -->

	<?php endif; ?>

	</main>

<?php get_footer(); ?>
