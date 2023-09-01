<?php
  $fixed_header_on_scroll = get_field('fixed_header_on_scroll', 'option');
	$navigation_type = get_field('navigation_type', 'option');
	$header_logo = get_field('header_logo', 'option');
	$contact_number = get_field('contact_number', 'option');
	$header_link = get_field('header_link', 'option');
	$hamburger_icon_position = get_field('hamburger_icon_position', 'option');
  $theme_location = 'header-menu';
  $menu_id = 'primary-menu';

      $args = array(
        'fixed_header' => $fixed_header_on_scroll,
        'logo' => $header_logo,
        'contact_number' => $contact_number,
        'header_link' => $header_link,
        'theme_location' => $theme_location,
        'hamburger_icon_position' => $hamburger_icon_position,
        'menu_id' => $menu_id,
      );

      // pr($navigation_type);
      
    switch ($navigation_type) {
      
      case "navigation_one":
      get_template_part( 'template-parts/header/header','navigation-one', $args );
      break;
      
      case "navigation_two":
      get_template_part( 'template-parts/header/header','navigation-two', $args );
      break;
      
      case "navigation_three":
      get_template_part( 'template-parts/header/header','navigation-three', $args );
      break;
      
      case "navigation_four":
      get_template_part( 'template-parts/header/header','navigation-four', $args );
      break;

      case "navigation_five":
      get_template_part( 'template-parts/header/header','navigation-five', $args );
      break;
      
      default:
      get_template_part( 'template-parts/header/header','navigation-one', $args );
      
    }