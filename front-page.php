<?php

get_header();
the_post();

?>

    <div id="primary" class="content-area home-page">
        <main id="main" class="site-main" role="main">

            <article class="about-us">
                <div class="main-wrapper">
                    <p class="article-text">
                        <?php echo get_the_content() ?>
                    </p>
                </div>
            </article>

            <article class="video-gallery">
                <div class="title-wrapper">
                    <div class="main-wrapper">
                        <h2 class="main-wrapper">NEW MEDIA</h2>
                    </div>
                </div>

                <div class="gallery-wrapper main-wrapper">
                    <div class="video-post-gallery clearfix">
                        <?php
                        $args = array( 'post_type' => 'video_posts', 'posts_per_page' => 6 );
                        $loop = new WP_Query( $args );
                        while ( $loop->have_posts() ) : $loop->the_post(); ?>
                        <div class="video-post-item">

                            <div class="item-thumbnail">
                                <?php echo do_shortcode(get_the_content(), true); ?>
                            </div>

                            <div class="item-title">
                                <?php the_title(); ?>
                            </div>

                        </div>
                       <?php endwhile; ?>
                    </div>


                </div>
            </article>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php get_footer();
