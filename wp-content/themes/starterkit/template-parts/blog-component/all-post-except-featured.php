<?php
// Get all featured posts
$featured_posts = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 1,
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
$featured_posts_query = new WP_Query($featured_posts);
$featured_posts_ids = array();

if ($featured_posts_query->have_posts()) {
    while ($featured_posts_query->have_posts()) {
        $featured_posts_query->the_post();
        $featured_posts_ids[] = $post->ID;
    }
    wp_reset_query();
    wp_reset_postdata();
}
// get all post except featues posts
$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 3,
    'orderby' => 'date',
    'order'   => 'DESC',
    'post__not_in' => $featured_posts_ids,
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
    </div>
<?php } else {
    get_template_part('template-parts/content', 'none');
}
wp_reset_query();
wp_reset_postdata();
?>