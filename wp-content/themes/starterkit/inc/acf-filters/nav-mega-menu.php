<?php

add_filter('wp_nav_menu_objects', 'starterkit_wp_nav_menu_objects', 10, 2);
function starterkit_wp_nav_menu_objects( $items, $args ) {

	foreach( $items as &$item ) {
		// vars
		$enable_mega_menu = get_field('enable_mega_memu', $item);
		$col = get_field('sub_menu_column', $item);

		// append icon
		if( $enable_mega_menu ) {
			$item->classes[0] .= 'has-megamenu sub-menu-col-'.$col;
			// pr($item);
			// $item->title .= '<img src='."https://images.unsplash.com/photo-1593642634367-d91a135587b5?ixid=MnwxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80".'>';
		}

	}
	return $items;
}
