<?php

/**
 * Block Name: Blog Listing 3
 *
 * This is the template that displays the Blog Listing 3 block.
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$id = 'blog-listing-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';


//Check for section padding
$section_padding  = get_field('starter_kit_section_padding');
$padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');

$padding_type  = get_field('starter_kit_padding_type');

//Check if section is enable or disable
$section_enable = get_field('starterkit_enable_section');
if ($section_enable) {
?>
    <section id="<?php echo $id; ?>" class="section section-blog-listing section-blog-listing-3 <?php echo $padding_type . ' ' . $align_class . ' ' . $padding; ?>">
        <div class="container">
            <?php get_template_part('template-parts/blog-component/grid-layout'); ?>
        </div>
    </section>
<?php } ?>