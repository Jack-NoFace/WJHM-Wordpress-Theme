<?php get_header(); ?>

	<main role="main">
		<!-- section -->

			<h1><?php _e( 'Archives', 'html5blank' ); ?></h1>

			<section class="grid">

				<?php get_template_part('loop'); ?>

			</section>

			<?php get_template_part('pagination'); ?>

	</main>

<?php get_footer(); ?>
