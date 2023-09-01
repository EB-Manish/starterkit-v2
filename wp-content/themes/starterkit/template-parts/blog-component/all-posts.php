<?php
// The Query
$posts_per_page = get_option('posts_per_page');
$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => $posts_per_page,
    'paged'          => get_query_var('paged'),
    'orderby' => 'date',
    'order'   => 'DESC',
);
$wp_query = new WP_Query($args);
?>

<?php if ($wp_query->have_posts()) { ?>
    <div class="blog-posts">
        <div class="row">
            <?php while ($wp_query->have_posts()) {
                $wp_query->the_post();
            ?>
                <div class="col-6 col-md-4">
                    <?php get_template_part('template-parts/content', get_post_type()); ?>
                </div>
            <?php } ?>
        </div>
        <?php
        $big = 999999999; // need an unlikely integer
        $pages = paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '/page/%#%',
            'current' => max(1, get_query_var('paged')),
            // 'total' => $wp_query->max_num_pages,
            'end_size' => 1,
            'mid_size' => 1,
            'next_text' => '<span class="next-icon"></span>',
            'prev_text' => '<span class="prev-icon"></span>',
            'type'     => 'array'
        ));

        // print_r($pages);

        if (is_array($pages)) :
            $paged = (get_query_var('paged') == 0) ? 1 : get_query_var('paged');
            echo '<div class="col-12"><div class="pagination">';
            foreach ($pages as $page) :
                echo "$page";
            endforeach;
            echo '</div></div>';
        endif;
        ?>
    </div>
<?php } else {
    get_template_part('template-parts/content', 'none');
}
wp_reset_query();
wp_reset_postdata();
?>