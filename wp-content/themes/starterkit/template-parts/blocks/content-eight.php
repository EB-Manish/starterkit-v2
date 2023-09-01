<?php

/**
 * Block Name:  Content Eight
 *
 * This is the template that displays the Full width CTA  Content block.
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// Create id attribute allowing for custom "anchor" value.
$id = 'content-eight-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'section-content-eight';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

//Check for section padding
$section_padding  = get_field('starter_kit_section_padding');
$padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');

$padding_type  = get_field('starter_kit_padding_type');

//Check if section is enable or disable
$section_enable = get_field('starter_kit_enable_section');
if ($section_enable) {
    $mini_title = get_field('starter_kit_mini_title');
    $description = get_field('starter_kit_description');
    $link = get_field('starter_kit_link');

?>
    <section id="<?php echo $id; ?>" class="section section-content-eight <?php echo $padding_type . ' ' . $padding; ?>">
        <div class="container text-center content">
            <?php if ($mini_title != '') { ?>
                <h5><?php echo $mini_title; ?></h5>
            <?php } ?>
            <?php if ($description != '') { ?>
                <div class="content-box mx-auto"><?php echo $description; ?></div>
            <?php } ?>
            <?php if ($link != '') { ?>
                <div class="btn-wrap mb-5 mt-4">
                    <a href="<?php echo $link['url'] ?>" class="btn btn-outline-primary " <?php if ($link['target']) { ?>target="_blank" <?php } ?>>
                        <?php echo $link['title']; ?>
                    </a>
                </div>
            <?php } ?>
        </div>
    </section>
<?php } ?>