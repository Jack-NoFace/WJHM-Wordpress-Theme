<?php
// // Setup postdata allowing get_field() to work.
// acf_setup_postdata($block['data'], $block['id'], true);
// // get_fields()
// acf_reset_postdata($block['id']);

function getACFImages($content)
{
    if (!empty($content)):

        $imageIDs = [];
        $videoIDs = [];

        $array_obj = new RecursiveIteratorIterator(new RecursiveArrayIterator($content));
        foreach ($array_obj as $key => $value) {
            if (is_numeric($value)):
                if (wp_get_attachment_image_src($value, 'full')):
                    $imageIDs[] = $value;
                endif;
                if (!wp_get_attachment_image_src($value, 'full') && wp_get_attachment_url($value)):
                    $videoIDs[] = $value;
                endif;
            endif;
        }

        $videoIDs = array_unique($videoIDs);

        /* Set up an empty array for the links. */
        $links = array();

        /* Get the intermediate image sizes and add the full size to the array. */
        $sizes = get_intermediate_image_sizes();
        $sizes[] = 'full';

        foreach ($imageIDs as $media) {
            /* Loop through each of the image sizes. */
            foreach ($sizes as $size) {

                /* Get the image source, width, height, and whether it's intermediate. */
                $image = wp_get_attachment_image_src($media, $size);

                /* Add the link to the array if there's an image and if $is_intermediate (4th array value) is true or full size. */
                if (!empty($image) && (true == $image[3] || 'full' == $size)) {
                    $links[$media][$size] = $image[0];
                }

            }
        }

        array_walk_recursive($content, function (&$value, $key) use ($links, $videoIDs) {
            if (!is_array($value) && $key === 'media') {
                foreach ($links as $imageKey => $imageValue) {
                    if ($value === $imageKey) {
                        $value = $imageValue;
                    }
                }
                foreach ($videoIDs as $videoKey => $videoValue) {
                    if ($value === $videoValue) {
                        $value = wp_get_attachment_url($videoValue);
                    }
                }
            }
        });

        return $content;

    endif;

    return $content;
}
