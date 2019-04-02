<?php

function getACFImages($content)
{
    if (!empty($content)):

        $imageIDs = [];

        $array_obj = new RecursiveIteratorIterator(new RecursiveArrayIterator($content));
        foreach ($array_obj as $key => $value) {
            if (is_numeric($value)):
                if (wp_get_attachment_image_src($value, 'full')):
                    echo "$key holds $value\n";
                    $imageIDs[] = $value;
                endif;
            endif;
        }

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

        print_r($links);

    endif;

    return $content;
}
