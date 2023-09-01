<?php

/**
 * File Name: Header Navigation One
 *
 * This is the template that displays the header veriation (Header with accessibility).
 * @param array       $args Additional arguments passed to the template.
 */

$fixed_header_class = '';
if ($args['fixed_header'] === true) {
    $fixed_header_class = ' site-header--fixed';
}
$ham_icon_position = $args['hamburger_icon_position'];

?>
<header id="site-header" class="site-header<?php echo $fixed_header_class; ?> navigation-1">
    <div class="container">
        <div class="navbar navbar-expand-lg<?php echo $ham_icon_position === 'right' ? ' ham-icon-right' : ''; ?>">
            <button class="hamburger-icon d-lg-none<?php echo $ham_icon_position === 'right' ? ' order-2' : ''; ?>" id="site-header-menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <div class="site-header-logo<?php echo $ham_icon_position === 'right' ? ' order-1 ms-lg-0' : ''; ?>">
                <a href="<?php echo home_url(); ?>">
                    <?php if ($args['logo']) : ?>
                        <img src="<?php echo $args['logo']['url']; ?>" />
                    <?php else :
                        bloginfo('name');
                    endif; ?>
                </a>
            </div>


            <div id="menu-container" class="site-header-menu ms-md-auto d-lg-flex flex-wrap align-items-center justify-content-end<?php echo $ham_icon_position === 'right' ? ' order-3' : ''; ?>">
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
                <?php if ($args['header_link']) { ?>
                    <div class="site-header-menu__item site-header-action d-none d-lg-block">
                        <a class="btn btn-outline-dark" href="<?php echo $args['header_link']['url']; ?>" <?php starterkit_target($args['header_link']); ?>>
                            <?php echo $args['header_link']['title']; ?>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</header>