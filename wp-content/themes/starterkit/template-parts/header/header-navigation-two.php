<?php

/**
 * File Name: Header Navigation Two
 *
 * This is the template that displays the header veriation (Header with accessibility).
 * @param array       $args Additional arguments passed to the template.
 */
//var_dump( $args );

$fixed_header_class = '';
if ($args['fixed_header'] === true) {
    $fixed_header_class = ' site-header--fixed';
}
// if ($args['contact_number']) {
//     $phone_no_link = preg_replace('/\D+/', '', $args['contact_number']);
// }
$ham_icon_position = $args['hamburger_icon_position'];

?>
<header id="site-header" class="site-header<?php echo $fixed_header_class; ?> navigation-2">
    <div class="container">
        <div class="navbar navbar-expand-lg flex-wrap<?php echo $ham_icon_position === 'right' ? ' ham-icon-right' : ''; ?>">
            <div class="site-header-logo<?php echo $ham_icon_position === 'right' ? ' order-1 order-lg-1' : ' order-2 order-lg-1'; ?>">
                <a href="<?php echo home_url(); ?>">
                    <?php if ($args['logo']) : ?>
                        <img src="<?php echo $args['logo']['url']; ?>" />
                    <?php else :
                        bloginfo('name');
                    endif; ?>
                </a>
            </div>
            <button class="hamburger-icon<?php echo $ham_icon_position === 'right' ? ' order-2 order-lg-2 ' : ' order-1 order-lg-2 '; ?>" type="button" data-bs-toggle="offcanvas" data-bs-target="#headerMenuOffCanvas" aria-controls="headerMenuOffCanvas">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
    <div class="offcanvas offcanvas-end header-menu-offcanvas" tabindex="-1" id="headerMenuOffCanvas" aria-labelledby="headerMenuOffCanvasLabel">
        <div class="offcanvas-header">
            <div class="offcanvas-title" id="headerMenuOffCanvasLabel">
                <div class="site-header-logo order-2 order-lg-1">
                    <a href="<?php echo home_url(); ?>">
                        <?php if ($args['logo']) : ?>
                            <img src="<?php echo $args['logo']['url']; ?>" />
                        <?php else :
                            bloginfo('name');
                        endif; ?>
                    </a>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
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
    </div>
</header>