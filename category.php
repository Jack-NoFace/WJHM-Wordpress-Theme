<?php get_header(); ?>

	<main role="main">
		<!-- section -->
		<section>

			<h1><?php _e( 'Posts from ', 'html5blank' ); single_cat_title(); ?></h1>

			<section class="grid">

				<?php get_template_part('loop'); ?>

			</section>

			<?php get_template_part('pagination'); ?>

		</section>
		<!-- /section -->
	</main>

<?php get_footer(); ?>
