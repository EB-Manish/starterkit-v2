<?php
$footer_logo = get_field('footer_logo', 'option');
$footer_type = get_field('footer_type', 'option');
$small_paragraph = get_field('small_paragraph', 'option');
$social_network_settings = get_field('social_network_settings', 'option');
$footer_1 = get_field('footer_1', 'option');
$copyright_text = get_field('copyright_text', 'option');
$menu_id = 'footer-top-menu';

$args = array(
    'footer_logo' => $footer_logo,
    'small_paragraph' => $small_paragraph,
    'social_network' => $social_network_settings,
    'copyright_text' => $copyright_text
);

switch ($footer_type) {

    case "footer_one":
        get_template_part('template-parts/footer/footer', 'one', $args);
        break;

    case "footer_two":
        get_template_part('template-parts/footer/footer', 'two', $args);
        break;

    case "footer_three":
        get_template_part('template-parts/footer/footer', 'three', $args);
        break;

    case "footer_four":
        get_template_part('template-parts/footer/footer', 'four', $args);
        break;

    case "footer_five":
        get_template_part('template-parts/footer/footer', 'five', $args);
        break;

    default:
        get_template_part('template-parts/footer/footer', 'one', $args);
}
