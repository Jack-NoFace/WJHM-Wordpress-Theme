<?php

function getACFImages($content)
{
    if (!empty($content)):

        $imageIDs = [];
        $mediaObjects = [];

        foreach ($content as $page) {
            if (isset($page["attrs"]["data"]["media"])) {
                $id = $page["attrs"]["data"]["media"];
                array_push($imageIDs, $id);
            }
        }

        foreach ($imageIDs as $media) {
            $sizes = (get_intermediate_image_sizes($media));
            foreach ($sizes as $size) {
                $media = wp_get_attachment_image_src($media, $size);
                array_push($mediaObjects, $media);
            }
        }

        print_r($mediaObjects);

    endif;

    return $content;
}
