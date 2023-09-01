<?php
// The Query
$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 4,
    'paged'          => get_query_var('paged'),
    'orderby' => 'date',
    'order'   => 'DESC',
);
$wp_query = new WP_Query($args);

?>

<?php if ($wp_query->have_posts()) { ?>
    <div class="blog-posts">
        <div class="row">
            <?php
            $index = 0;
            $args = array(
                'grid_layout' => true,
            );
            while ($wp_query->have_posts()) {
                $wp_query->the_post();

            ?>
                <?php if ($index === 0) { ?>
                    <div class="col-lg-7 feature-blog-post">
                        <article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?>>
                            <div class="blog-post__thumb">
                                <?php if (!has_post_thumbnail()) { ?>
                                    <div class="ph-picture"></div>
                                <?php } else {
                                    the_post_thumbnail('blog-thumb-grid-large');
                                } ?>
                            </div>
                            <div class="blog-post__content">
                                <?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>'); ?>
                                <div class="excerpt"><?php echo wp_trim_words(get_the_excerpt(), 22); ?></div>
                            </div>
                            <div class="blog-post__link">
                                <a href="<?php echo esc_url(get_permalink()); ?>" class="btn-link bt-lg has-icon-right">
                                    VIEW ARTICLE
                                    <span class="icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </article>
                    </div>
                    <div class="col-lg-5 blog-post-side row">
                    <?php } else { ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?>>
                            <div class="d-flex align-items-center flex-sm-row  flex-column ">
                                <div class="blog-post__thumb">
                                    <?php if (!has_post_thumbnail()) { ?>
                                        <div class="ph-picture"></div>
                                    <?php } else {
                                        the_post_thumbnail('blog-thumb-small');
                                    } ?>
                                </div>
                                <div class="blog-post__content">
                                    <?php
                                    echo starterkit_get_category();
                                    ?>
                                    <?php the_title('<h6 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h6>'); ?>
                                    <div class="author">
                                        <?php echo get_the_author(); ?>
                                    </div>
                                </div>
                            </div>
                        </article>
                <?php }
                $index++;
            } ?>
                    </div>
        </div>
    <?php
} else {
    get_template_part('template-parts/content', 'none');
}
wp_reset_query();
wp_reset_postdata();
    ?>