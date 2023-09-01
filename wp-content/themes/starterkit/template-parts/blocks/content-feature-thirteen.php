<?php

/**
 * Block Name: Feature Thirteen
 *
 * This is the template that displays the Feature Thirteen Block.
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$id = 'feature-thirteen-' . $block['id'];

//Check for section padding
$section_padding = get_field('starter_kit_section_padding');
$padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');
$padding_type  = get_field('starter_kit_padding_type');


//Check if section is enable or disable
$section_enable = get_field('starter_kit_enable_section');
if ($section_enable) {

?>
    <section class="section section-features-13">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-md-5">
                    <?php if (have_rows('starter_kit_tab_content')) {
                        $tab_id = substr($block['id'], 6, 5);
                        $count = 1;
                    ?>
                        <div class="tab-lists d-flex flex-row flex-md-column nav-pills" id="v-pills-tab<?php echo $block['id']; ?>" role="tablist" aria-orientation="vertical">
                            <?php while (have_rows('starter_kit_tab_content')) {
                                the_row();
                                $title = get_sub_field('starter_kit_tab_content_title');
                                $content = get_sub_field('starter_kit_tab_content_desc');
                            ?>
                                <div class="tab-lists__item <?php if ($count === 1) { ?>active<?php } ?>" id="tab<?php echo $tab_id . '-' . $count; ?>-tab" data-bs-toggle="pill" data-bs-target="#tab<?php echo $tab_id . '-' . $count; ?>" role="tab" aria-controls="#tab<?php echo $tab_id . '-' . $count; ?>" aria-selected="true">
                                    <div class="tab-lists-content">
                                        <?php if ($title != '') { ?>
                                            <h6 class="tab-lists-content__title"><?php echo $title; ?></h6>
                                        <?php } ?>
                                        <?php if ($content != '') { ?>
                                            <div class="tab-lists-content__desc d-none d-md-block">
                                                <?php echo $content; ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php $count++;
                                ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-md-7">
                    <?php if (have_rows('starter_kit_tab_content')) {
                        $count = 1;
                    ?>
                        <div class="tab-content" id="v-pills-tab<?php echo $block['id']; ?>Content">
                            <?php while (have_rows('starter_kit_tab_content')) {
                                the_row();
                                $image = get_sub_field('starter_kit_image');
                                $desc = get_sub_field('starter_kit_tab_content_desc');
                            ?>
                                <div class="tab-pane fade <?php if ($count === 1) { ?>show active<?php } ?>" id="tab<?php echo $tab_id . '-' . $count; ?>" role="tabpanel" aria-labelledby="tab<?php echo $tab_id . '-' . $count; ?>-tab">
                                    <?php if ($desc != '') { ?>
                                        <div class="tab-pane__desc d-md-none">
                                            <?php echo $desc; ?>
                                        </div>
                                    <?php } ?>
                                    <?php if ($image != "") { ?>
                                        <figure class="m-0">
                                            <img class="w-100" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo starterkit_alt($image); ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" />
                                        </figure>
                                    <?php } ?>
                                </div>
                                <?php $count++; ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
<?php } ?>