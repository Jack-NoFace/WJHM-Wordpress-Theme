<?php
/* THIS BEAUTY CONVERTS GUTENBERG BLOCKS TO JSON FOR THE API */
function convert_content($content)
{
    $content = str_replace('https://wjhm.noface.app/', '/', $content);
    $content = str_replace('http://local-whatjackhasmade.co.uk/', '/', $content);
    $ACFTitles = getACFTitles($content, 'field_', '"');

    foreach ($ACFTitles as $key => $value) {
        $content = str_replace($key, $value, $content);
    }

    $content = parse_blocks($content);

    $content = getACFImages($content);

    foreach ($content as &$block) {
        // Setup postdata allowing get_field() to work.
        acf_setup_postdata($block['attrs']['data'], $block['attrs']['id'], true);

        // get_fields()
        if ($block['blockName'] === "acf/testimonials") {
            $testimonials = $block['attrs']['data']['testimonials'];

            foreach ($testimonials as $value) {
                $valueObject = json_encode($value, true);
                $valueObject = json_decode($valueObject, true);
                $testimonialObjects[] = $valueObject;
            }

            $block['attrs']['data']['testimonials'] = $testimonialObjects;
        }

        // reset_loop()
        acf_reset_postdata($block['attrs']['id']);
    }

    unset($block);

    return $content;
}
