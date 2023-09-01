<?php
// The Query
$args = array(
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
$wp_query = new WP_Query($args);
?>

<?php if ($wp_query->have_posts()) { ?>
    <div class="blog-posts featured-posts">
        <?php while ($wp_query->have_posts()) {
            $wp_query->the_post();
        ?>
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="blog-post__thumb">
                        <?php if (!has_post_thumbnail()) { ?>
                            <div class="ph-picture"></div>
                        <?php } else starterkit_post_thumbnail(); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="blog-post__content">
                        <?php the_title('<h4 class="entry-title"><a href="' .    esc_url(get_permalink()) . '" rel="bookmark">', '</a></h4>'); ?>
                        <div class="excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 22); ?>
                        </div>
                        <div class="entry-meta">
                            <?php
                            starterkit_posted_by();
                            ?>
                        </div><!-- .entry-meta -->
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } else {
    get_template_part('template-parts/content', 'none');
}
wp_reset_query();
wp_reset_postdata();
?>