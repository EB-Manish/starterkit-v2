<?php
// The Query
$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order'   => 'DESC',
    'meta_query' => array(
        array(
            'key'     => 'is_featured',
            'value'   => true,
            'compare' => '=',
        )
    )
);
$wp_query = new WP_Query($args);
?>

<?php if ($wp_query->have_posts()) { ?>
    <div class="blog-posts">
        <div class="row">
            <?php while ($wp_query->have_posts()) {
                $wp_query->the_post();
                get_template_part('template-parts/content', get_post_type());
            } ?>
        </div>
    </div>
<?php } else {
    get_template_part('template-parts/content', 'none');
}
wp_reset_query();
wp_reset_postdata();
?>