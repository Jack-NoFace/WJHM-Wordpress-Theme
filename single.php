<?php get_header(); ?>

	<main role="main">
	<!-- section -->
	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<div class="wrapper post">

				<div class="post__meta text-align--center">

					<div class="post__meta__image">
						<picture>
							<source srcset="<?php echo get_template_directory_uri(); ?>/img/jack-davies-designer.webp" type="image/webp">
							<a href="/about-me/"><img class="border--circle" src="<?php echo get_template_directory_uri(); ?>/img/jack-davies-designer.jpg"></a>
						</picture>
					</div>

					<div class="post__meta__thumbnail post__meta__image">
						<?php the_post_thumbnail('tiny', ['class' => 'border--circle']); ?>
					</div>

					<div class="padding--normal">
						<h1><?php the_title(); ?></h1>
						<?php echo  '<span class="color-grey"> ' . do_shortcode('[rt_reading_time label="Reading Time:" postfix="minutes"]') . '  | </span>';  ?>
						<?php $date = the_date('jS F Y'); if ($date) { echo '<span class="color-grey">Published: ' . $date . '</span>'; } ?>
						<?php $categories = get_the_category();	if ( ! empty( $categories ) ) { echo '<span class="color-grey"> | ' . esc_html( $categories[0]->name ) . '</span>'; } ?>
					</div>

				</div>

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
