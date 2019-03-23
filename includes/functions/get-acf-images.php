<?php

function getACFImages($content)
{
    if (!empty($content)):
        $replaces = array();

        $array = json_decode($content, true);

        $array = (array) $array;

        array_walk_recursive($array, function (&$v, $k) {
            if ($k == 'media') {
                $v = wp_get_attachment_url($v);
            }
        });

    endif;

    return $array;
}
