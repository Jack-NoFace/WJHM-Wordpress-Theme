<?php if (have_posts()): while (have_posts()) : the_post(); ?>

	<!-- article -->
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
			<h2><?php the_title(); ?></h2>

			<?php $meta = get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true); ?>
			<?php

			if ($meta) {
				echo "<p>" . $meta . "</p>";
			}

			?>
		</div>

		<a class="link--cover" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">View Article</a>

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
	<!-- /article -->

<?php endwhile; ?>

<?php else: ?>

	<!-- article -->
	<article>
		<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
	</article>
	<!-- /article -->

<?php endif; ?>
