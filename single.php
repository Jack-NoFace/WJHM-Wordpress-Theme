<?php get_header(); ?>

	<main role="main">
	<!-- section -->
	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<div class="wrapper post">

			<!-- post title -->
			<h1><?php the_title(); ?></h1>
			<!-- /post title -->

			<span class="color-grey"><?php the_author(); ?> | </span>

			<?php
			$date = the_date('jS F Y');

			if ($date) { ?>
				<span class="color-grey">Published: <?php echo $date; ?></span>
			<?php
			}
			?>

			<?php the_content(); // Dynamic Content ?>

			<?php get_template_part( 'related' ); ?>

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
