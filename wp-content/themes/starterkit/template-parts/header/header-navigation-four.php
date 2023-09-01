<?php

/**
 * File Name: Header Navigation Four
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
$header_4 = get_field('header_4', 'option');
$ham_icon_position = $args['hamburger_icon_position'];

?>
<header id="site-header" class="site-header<?php echo $fixed_header_class; ?> navigation-4">
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


            <div id="menu-container" class="site-header-menu d-lg-flex flex-wrap align-items-center justify-content-center order-4 order-lg-3">
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
            <?php if (!empty($header_4)) { ?>
                <div class="site-header-action d-flex flex-wrap align-items-center justify-content-end <?php echo $ham_icon_position === 'right' ? '  order-2 order-lg-4' : ' order-3 order-lg-4'; ?>">
                    <?php
                    if (is_plugin_active('woocommerce/woocommerce.php')) {
                        // woocommerce is active
                    ?>
                        <div id="" class="site-header-action__item site-header-cart">
                            <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.45 11C5.7 11 5.04 10.59 4.7 9.97L1.12 3.48C0.75 2.82 1.23 2 1.99 2H16.79L17.73 0H21V2H19L15.4 9.59L16.75 12.03C17.48 13.37 16.52 15 15 15H3V13H15L13.9 11H6.45ZM15.84 4H3.69L6.45 9H13.47L15.84 4ZM15 16C16.1 16 16.99 16.9 16.99 18C16.99 19.1 16.1 20 15 20C13.9 20 13 19.1 13 18C13 16.9 13.9 16 15 16ZM5 16C6.1 16 6.99 16.9 6.99 18C6.99 19.1 6.1 20 5 20C3.9 20 3 19.1 3 18C3 16.9 3.9 16 5 16Z" fill="#242424" />
                            </svg>
                            <?php echo starterkit_woocommerce_header_cart();
                            ?>
                        </div>
                    <?php } ?>
                    <?php $header_cta = $header_4['header_cta'];
                    foreach ((array)$header_cta  as $cta_item) {
                        if ($cta_item) {

                            $icon = $cta_item['cta_icon'];
                            $link = $cta_item['page_link'];

                    ?>
                            <div class="site-header-action__item">
                                <a href="<?php echo $link['url']; ?>" <?php echo starterkit_target($link); ?> title="<?php echo $link['title']; ?>">
                                    <img src="<?php echo $icon['url']; ?>" alt="<?php starterkit_alt($icon); ?>">
                                </a>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            <?php } ?>
        </div>
    </div>
</header>