<?php

/**
 * Block Name: Hero Section Nine
 *
 * This is the template that displays the Hero section Nine
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$id = 'hero-section-nine-' . $block['id'];

//Check for section padding
$section_padding  = get_field('starter_kit_section_padding');
$padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');
$padding_type  = get_field('starter_kit_padding_type');

//Check if section is enable or disable
$section_enable = get_field('starter_kit_enable_section');
if ($section_enable) {
    $image = get_field('starter_kit_image');
    $title = get_field('starter_kit_title');
    $description = get_field('starter_kit_subtitle');
    $link = get_field('starter_kit_button');
    $enable_page_down = get_field('starter_kit_enable_page_down');
    $image_position = get_field('starter_kit_image_position');
    $newsletter_form = get_field('newsletter_form');
    $img_pos_class = '';
    if ($image_position == 'right') {
        $img_pos_class = 'order-md-1';
    }

?>
    <section id="<?php echo $id; ?>" class="section section-hero section-hero-nine <?php echo $padding_type . ' ' . $padding; ?>">
        <div class="container container-wrapper">
            <div class="row justify-content-between align-items-center">
                <?php if ($image != '') { ?>
                    <div class="col-12 col-md-6 section-col-img mb-3 mb-md-0 <?php echo $img_pos_class; ?>">
                        <div class="img-wrap">
                            <img class="w-100" src="<?php echo $image['url']; ?>" alt="<?php starterkit_alt($image) ?>">
                        </div>
                    </div>
                <?php } ?>
                <?php if ($title != '' || $description != '') { ?>
                    <div class="col-12 col-md-5 section-heading">
                        <div class="section-heading__title">
                            <?php if ($title != '') { ?>
                                <h1 class="title"><?php echo $title; ?></h1>
                            <?php } ?>
                        </div>
                        <?php if (!empty($newsletter_form)) {
                            $shortcode = '[gravityform id="' . $newsletter_form['id'] . '" title="false" description="false" ajax="true"]'; ?>
                            <div class="form-wrapper mt-md-0">
                                <?php echo do_shortcode($shortcode, false); ?>
                            </div>
                        <?php } else { ?>
                            <div class="form-wrapper">
                                <form>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">

                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
                                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                    </div>
                                    <button type="submit" class="btn btn-primary">SIGN IN</button>
                                    <div class="form-footer">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                            <label class="form-check-label" for="exampleCheck1">Remember me</label>
                                        </div>
                                        <a class="" href="#">Forgot password</a>
                                    </div>
                                </form>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>