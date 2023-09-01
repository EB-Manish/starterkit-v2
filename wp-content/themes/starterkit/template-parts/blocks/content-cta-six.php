<?php
/**
 * Block Name: Call To Action Six 
 *
 * This is the template that displays the Call To Action Six  block.
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
  echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$id = 'cta-six-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';


//Check for section padding
$section_padding  = get_field( 'starter_kit_section_padding' );
$padding = ( !empty( $section_padding ) ? implode( ' ', $section_padding ) : '' );

$padding_type  = get_field( 'starter_kit_padding_type' );

//Check if section is enable or disable
$section_enable = get_field('starterkit_enable_section' );
if( $section_enable ) {
    $image = get_field('starterkit_contact_image');
    $title = get_field( 'starterkit_title' );
    $sub_title = get_field( 'starterkit_subtitle' );
    $starterkit_form = get_field('starterkit_form_shortcode');
    $image_position = get_field('starterkit_image_position');
    $form_type = get_field('starterkit_form_type');
    $img_pos_class = '';
    $no_offset='';
    if ($image_position == 'right') {
        $img_pos_class = 'order-lg-1 offset-xl-1';
        $no_offset=' offset-0';
    }

   $material_class = $form_type=='material-form' ? ' material-style' : ' normal-form';
   
?>
<section id="<?php echo $id; ?>" class="section section-cta section-cta--six <?php echo $padding_type . ' ' . $align_class . ' ' . $padding; ?>">
    <div class="container-fliud">
        <div class="row justify-content-center align-items-center ">
          <div class="col-lg-5 col-xl-4 <?php echo $img_pos_class ; ?>">
            <?php if( $image != '' ) { ?>
              <div class="contact-image">
                  <img src="<?php echo  $image['url'];?>" alt="<?php starterkit_alt($image); ?>" class="w-100">
              </div>
            <?php } ?>
          </div>
          <div class="col-lg-7 col-xl-6 col-xxl-5 offset-xl-1 <?php echo $no_offset ; ?>">
            <div class="section-heading">
              <?php if( $title != '' ) { ?>
    	    	      <h4 class="h1 section-heading__title"><?php echo $title; ?></h4>
        	    <?php } ?>
        	    <?php if( $sub_title != '' ) { ?>
        	    	  <div class="section-heading__desc "><?php echo $sub_title; ?></div>
        	    <?php } ?>
          	</div>
            <?php if (!empty($starterkit_form)) {
                $shortcode = '[gravityform id="' . $starterkit_form['id'] . '" title="false" description="false" ajax="true"]'; ?>
                <div class="form-wrapper<?php echo $material_class; ?> position-relative mt-md-0">
                    <?php echo do_shortcode($shortcode, false); ?>
                </div>
            <?php } ?>
          </div>
        </div>
    </div>
</section>
<?php } ?>

