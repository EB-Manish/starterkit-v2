<?php
function starterkit_widgets_init()
{
    register_sidebar(
        array(
            'name'          => esc_html__('Sidebar', 'starter-kit'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add widgets here.', 'starter-kit'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );

    if (function_exists('get_field')) {
        $dynamic_widget_areas = array();
        $footer_type = get_field('footer_type', 'option');
        if ($footer_type === 'footer_two' || $footer_type == 'footer_three' || $footer_type == 'footer_four') {
            $dynamic_widget_areas = array(
                "Footer Widget 1",
                "Footer Widget 2",
                "Footer Widget 3"
            );
        }
        if ($footer_type === 'footer_three' || $footer_type === 'footer_four') {
            array_push(
                $dynamic_widget_areas,
                "Footer Widget 4"
            );
        }
        if ($footer_type === 'footer_three') {
            array_push(
                $dynamic_widget_areas,
                "Footer Widget 5"
            );
        }

        if (function_exists('register_sidebar')) {
            $index = 1;
            foreach ($dynamic_widget_areas as $widget_area_name) {
                register_sidebar(array(
                    'name' => $widget_area_name,
                    'id'            => 'footer-widget-' . $index,
                    'before_widget' => '<div id="%1$s" class="widget %2$s">',
                    'after_widget'  => '</div>',
                    'before_title' => '<h5 class="widget-title">',
                    'after_title' => '</h5>',
                ));
                $index++;
            }
        }
    }
}
add_action('widgets_init', 'starterkit_widgets_init');
