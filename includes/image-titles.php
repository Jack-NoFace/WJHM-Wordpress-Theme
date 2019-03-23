<?php
// The filter runs when resizing an image to make a thumbnail or intermediate size.
add_filter('image_make_intermediate_size', 'wpse_123240_rename_intermediates');
function wpse_123240_rename_intermediates($image)
{
    // Split the $image path into directory/extension/name
    $info = pathinfo($image);
    $dir = $info['dirname'] . '/';
    $ext = '.' . $info['extension'];
    $name = wp_basename($image, "$ext");

    // Get image information
    // Image edtor is used for this
    $img = wp_get_image_editor($image);
    // Get image size, width and height
    $img_size = $img->get_size();

    // Image prefix for builtin sizes
    // Note: beware possible conflict with custom images sizes with the same width
    $widths = [];
    $size_based_img_name_prefix = '';
    foreach (get_intermediate_image_sizes() as $_size) {
        if (in_array($_size, ['thumbnail', 'medium', 'medium_large', 'large'])) {
            $width = get_option("{$_size}_size_w");
            if (!isset($widths[$width])) {
                $widths[$width] = $_size;
            }
        }
    }
    if (array_key_exists($img_size['width'], $widths)) {
        $size_based_img_name_prefix = $widths[$img_size['width']] . '-';
        $name_prefix = substr($name, 0, strrpos($name, '-'));
    } else {
        $name_prefix = $name;
    }

    // Build our new image name
    $new_name = $dir . $size_based_img_name_prefix . $name_prefix . $ext;

    // Rename the intermediate size
    $did_it = rename($image, $new_name);

    // Renaming successful, return new name
    if ($did_it) {
        return $new_name;
    }

    return $image;
}
