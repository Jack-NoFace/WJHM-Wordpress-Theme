<?php get_header(); ?>

	<main role="main" class="background--white">
		<!-- section -->
		<section>

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>


		<div class="wrapper post page">

			<div class="text-align--center padding--normal page__meta__thumbnail">
				<?php the_post_thumbnail('mobile--small', ['class' => 'border--circle']); ?>
			</div>

			<div>
				<h1 class="color--black padding--none"><?php the_title(); ?></h1>
			</div>

			<?php the_content(); // Dynamic Content ?>

			<?php get_template_part( 'related' ); ?>

		</div>

		<?php endwhile; ?>

		<?php else: ?>

			<!-- article -->
			<article>

				<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>

		</section>
		<!-- /section -->
	</main>

<?php get_footer(); ?>
