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

    <div class="grid-item__details background--black-light color--white">
        <h2><?php the_title(); ?></h2>

        <?php
        $meta = get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true);

        if ($meta) {
            echo "<hr class='hr hr--grey'>";

            if ($meta) {
                echo "<p>" . $meta . "</p>";
            }

            if ($date) {
                echo '<span class="color--grey display--block">' . $date  . ', ';

                $categories = get_the_category();

                if ( ! empty( $categories ) ) {
                    echo esc_html( $categories[0]->name );
                }

                echo '</span>';

            }

        }
        ?>

    </div>

    <a class="link--cover" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">View Article</a>

    <?php
    if ( has_post_thumbnail()) {
        $thumbnailMobile = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'mobile' );
        $thumbnail = $thumbnailMobile['0'];
    } else {
        $thumbnail = get_template_directory_uri() . '/img/placeholder.png';
    }
    ?>

    <?php if ($thumbnail) { ?>

    <svg>
        <style>
        @media screen and (min-width: 640px) {
            #post-<?php the_ID(); ?> { background-image: url('<?php echo $thumbnail; ?>'); }
        }
        </style>
    </svg>

    <?php } ?>


</article>
