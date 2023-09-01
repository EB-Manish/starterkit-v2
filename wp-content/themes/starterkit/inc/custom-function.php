<?php
// To upload SVG
function starterkit_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'starterkit_mime_types');

// To hide ACF field for sub level menu
function starterkit_acf_parent_menu_show()
{
    echo '<style>
    .acf-menu-item-fields {
	    display: none!important;
	}
	.menu-item-depth-0 .acf-menu-item-fields {
	    display: block!important;
	}
  </style>';
}
add_action('admin_head', 'starterkit_acf_parent_menu_show');


/**
 * debug helper
 */
function vr($data)
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}
function pr($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}


// add_action( 'pre_get_posts', 'set_posts_per_page_for_blog' );
// /* Change number of post per page for post */
// // global $ppp;
// $ppp = get_field( 'number_of_post_to_display', 'option' );

// function set_posts_per_page_for_blog( $query ) {
// 	 //$GLOBALS['ppp'] = $ppp;
//  if ( !is_front_page() && is_home() ) {

// 	$query->set( 'posts_per_page', $ppp );
//   }
// }

// render wrapper element for guttenburg core blocks

add_filter('render_block', 'starterkit_wrap_core_block', 10, 2);
function starterkit_wrap_core_block($block_content, $block)
{
    $blockslist = array(
        'archives',
        'audio',
        'buttons',
        'calendar',
        'categories',
        'code',
        'columns',
        'coverImage',
        'embed',
        'file',
        'freeform',
        'gallery',
        'heading',
        'html',
        'image',
        'latest-comments',
        'latestPosts',
        'list',
        'more',
        'media-text',
        'nextpage',
        'paragraph',
        'preformatted',
        'pullquote',
        'quote',
        'query',
        'navigation',
        'site-title',
        'site-logo',
        'loginout',
        'rss',
        'reusableBlock',
        'separator',
        'shortcode',
        'spacer',
        'subhead',
        'search',
        'tag-cloud',
        'table',
        'textColumns',
        'verse',
        'video',
        'form',
        'facebook',
        'youtube',
        'instagram',
        'twitter',
        'latest-posts',
        'page-list',
        'post-navigation-link',
        'social-links'
    );

    foreach ($blockslist as $item) {
        // pr($block['blockName']);

        if ('core/' . $item === $block['blockName'] || 'core-embed/' . $item === $block['blockName'] || 'gravityforms/' . $item === $block['blockName']) {

            $block_content = '<div class="wp-core-block block-' .  $item . '"><div class="container">' . $block_content . '</div></div>';
        }
    }

    return $block_content;
}

// Changes Gravity Forms Ajax Spinner (next, back, submit) to a transparent image
// this allows you to target the css and create a pure css spinner like the one used below in the style.css file of this gist.
add_filter('gform_ajax_spinner_url', 'starterkit_spinner_url', 10, 2);
function starterkit_spinner_url($image_src, $form)
{
    return  'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'; // relative to you theme images folder
}

// link target check
function starterkit_target($data)
{
    if ($data['target']) {
        echo ' target="' . $data['target'] . '"';
    }
}

// get alt from image check
function starterkit_alt($data)
{
    echo esc_attr($data['alt'] ? $data['alt'] : $data['title']);
}

// get the post category lists
function starterkit_get_category()
{
    $terms_list = get_the_category();
    if (!empty($terms_list)) { // Check $terms_list has value
        echo '<ul class="cat-lists">';
        foreach ($terms_list as $term) {
            $term_id = $term->term_id;
            $cat_name = $term->name;
            echo '<li class="cat-lists__item"><a href="' . get_term_link($term_id) . '">' . $cat_name . '</a></li>';
        }
        echo '</ul>';
    }
}

// Styles for backend preview
// add_action('admin_enqueue_scripts', 'backend_preview_style');
// function backend_preview_style() {
//     wp_enqueue_style( 'admin-style',  get_stylesheet_uri() );
// }
