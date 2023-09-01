<?php

/**
 * File Name: Header Navigation Three
 *
 * This is the template that displays the header veriation (Header with accessibility).
 * @param array       $args Additional arguments passed to the template.
 */

$fixed_header_class = '';
if ($args['fixed_header'] === true) {
    $fixed_header_class = ' site-header--fixed';
}
// if ($args['contact_number']) {
//     $phone_no_link = preg_replace('/\D+/', '', $args['contact_number']);
// }
$ham_icon_position = $args['hamburger_icon_position'];

?>
<header id="site-header" class="site-header<?php echo $fixed_header_class; ?> navigation-3">
    <div class="container">
        <div class="navbar navbar-expand-lg<?php echo $ham_icon_position === 'right' ? ' ham-icon-right' : ''; ?>">
            <button class="hamburger-icon d-lg-none<?php echo $ham_icon_position === 'right' ? ' order-3' : ' order-1'; ?>" id="site-header-menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <div class="site-header-logo<?php echo $ham_icon_position === 'right' ? ' order-1' : ' order-2'; ?>">
                <a href="<?php echo home_url(); ?>">
                    <?php if ($args['logo']) : ?>
                        <img src="<?php echo $args['logo']['url']; ?>" />
                    <?php else :
                        bloginfo('name');
                    endif; ?>
                </a>
            </div>


            <div id="menu-container" class="site-header-menu d-lg-flex flex-wrap align-items-center justify-content-center order-4">
                <nav id="site-header-naviation" class="site-header-menu__item site-header-naviation">
                    <?php
                    if (has_nav_menu($args['theme_location'])) {
                        wp_nav_menu(array(
                            'theme_location' => $args['theme_location'],
                            'menu_id'        => $args['menu_id'],
                            'container_class' => 'primary-menu'
                        ));
                    } else {
                    ?>
                        <div class="primary-menu">
                            <ul id="primary-menu" class="menu nav-menu">
                                <li class="menu-item">
                                    <a href="<?php echo home_url(); ?>">Home</a>
                                </li>
                            </ul>
                        </div>
                    <?php } ?>
                </nav>
            </div>
            <button class="search-icon d-lg-none<?php echo $ham_icon_position === 'right' ? ' order-2' : ' order-3'; ?>" id="site-header-search-toggle">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M20.9999 21L16.6499 16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <div class="site-header-search order-5">
                <?php echo get_search_form(); ?>
            </div>
        </div>
    </div>
</header>