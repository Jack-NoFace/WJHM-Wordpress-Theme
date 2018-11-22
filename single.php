<?php get_header(); ?>
	<main role="main">
		<?php while (have_posts()) : the_post(); ?>
			<div class="wrapper post">
				<div class="post__meta text-align--center">
					<div class="padding--normal">
						<h1><?php the_title(); ?></h1>
						<?php $date = the_date('jS F Y'); if ($date) { echo '<span class="color-grey">Published: ' . $date . '</span>'; } ?>
						<?php $categories = get_the_category();	if ( ! empty( $categories ) ) { echo '<span class="color-grey"> | ' . esc_html( $categories[0]->name ) . '</span>'; } ?>
					</div>
				</div>
			<?php the_content(); // Dynamic Content ?>
			</div>
		<?php endwhile; ?>
	</main>
<?php get_footer(); ?>
