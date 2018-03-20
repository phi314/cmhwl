<?php
/**
 * Template Name: Front Page
 */

get_header('front'); ?>

    <div class="mb-60"></div>

    <!-- Featured Listing -->
    <section id="featured-listing">
        <div class="container">
            <div class="mx-auto text-center">
                <h1 class="section-heading">Hayu urang hardolin!</h1>
                <p class="mb-4">Dahar, Dolan <em>(ma enya mod*l (ma enya mah indungna si sidoel))</em> dan Ulin.</p>
            </div>
        </div>
        <div class="container-fluid full-screen-slider">
            <div class="row">

                <?php
                $featured_places = get_field('featured_places');
                $featured_places_query = new WP_Query([
                    'post__in' => $featured_places,
                    'post_type' => 'place',
                    'orderby' => 'post__in',
                    'ignore_sticky_posts' => 1
                ]);
                while ($featured_places_query->have_posts() ) : $featured_places_query->the_post();

                    get_template_part('template-parts/content', 'place-loop');

                endwhile;

                wp_reset_postdata(); // Don't forget to reset
                ?>
            </div>
        </div>

        <div class="mx-auto text-center">
            <a class="btn std-btn btn-xl btn-common btn-filled" href="<?php echo home_url('place'); ?>">Explore Lokasi</a>
        </div>

    </section>
    <!-- /. Featured Listing -->

    <div class="mb-60"></div>

    <!-- Featured Post -->
    <section class="bg-gray" id="spotlight">
        <div class="container">
            <div class="mx-auto text-center">
                <h1 class="section-heading">Spotlight</h1>
                <p class="mb-4">
                    Hot & Trending
                </p>
            </div>
            <div class="row">
                <?php

                    $featured_posts = get_field('featured_posts');
                    $featured_posts_query = new WP_Query([
                        'post__in' => $featured_posts,
                        'post_type' => 'post',
                        'orderby' => 'post__in',
                        'ignore_sticky_posts' => 1
                    ]);

                    while( $featured_posts_query->have_posts() ) : $featured_posts_query->the_post();

                        get_template_part('template-parts/content', 'post-loop');

                    endwhile;

                    wp_reset_postdata(); // Don't forget to reset
                ?>
            </div>
        </div>
    </section>
    <!-- /. Featured Post -->

    <div class="mb-60"></div>

    <!-- Featured Listing Event -->
    <section id="featured-listing-event" class="full-screen-slider">
        <div class="container">
            <div class="mx-auto text-center">
                <h1 class="section-heading">Event!</h1>
                <p class="mb-4">Start Bootstrap has everything you need to get your new website up and running in no time! All of the templates and themes on Start Bootstrap are open source, free to download, and easy to use. No strings attached!</p>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">

                <?php
                $featured_events = get_field('featured_events');
                $featured_events_query = new WP_Query([
                    'post__in' => $featured_events,
                    'post_type' => 'event',
                    'orderby' => 'post__in',
                    'ignore_sticky_posts' => 1
                ]);
                while ($featured_events_query->have_posts() ) : $featured_events_query->the_post();

                    get_template_part('template-parts/content', 'place-loop');

                endwhile;

                wp_reset_postdata(); // Don't forget to reset
                ?>
            </div>
        </div>

        <div class="mx-auto text-center">
            <a class="btn std-btn btn-xl btn-common btn-filled" href="<?php echo home_url('event'); ?>">Explore Event</a>
        </div>

    </section>
    <!-- /. Featured Listing -->

    <div class="mb-60"></div>

    <!-- Featured Category -->
    <section id="featured-category">
        <div class="container">
            <div class="text-center">
                <h1 class="section-heading">Best things to do!</h1>
                <p class="mb-4">
                    Find great places to stay, eat, shop or visit from local experts.
                </p>
            </div>
            <div class="row slick-mobile-gallery">
                <?php
                    $featured_place_categories = get_field('featured_place_categories');

                    foreach ($featured_place_categories as $featured_place_category) :
                        $place_category_image = get_term_image_url('place_category', $featured_place_category->term_id);
                ?>

                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box lazy" href="<?php echo get_term_link($featured_place_category->term_id, 'place_category'); ?>" style="background: url('<?php echo $place_category_image; ?>')">
                            <div class="portfolio-box-caption">
                                <div class="portfolio-box-caption-content">
                                    <div class="portfolio-box-caption-content-bottom">
                                        <h3 class="project-name">
                                            <?php echo $featured_place_category->name; ?>
                                        </h3>
                                        <p class="timer" data-to="<?php echo $featured_place_category->count; ?>" data-speed="3000"><?php echo $featured_place_category->count; ?></p> Listed
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- /. Featured Category -->

    <div class="mb-60"></div>

    <!-- Instagram -->
    <section>
        <div class="container">
            <div class="text-center">
                <h1 class="section-heading">Instagram <i class="fa fa-instagram"></i></h1>
                <p class="mb-4">Start Bootstrap has everything you need to get your new website up and running in no time! All of the templates and themes on Start Bootstrap are open source, free to download, and easy to use. No strings attached!</p>
            </div>
        </div>
        <!-- Instagram Image -->
        <div class="container-fluid">
            <div id="instafeed" class="row instagram-slider"></div>
        </div>
    </section>
    <!-- /. Instagram -->

    <div class="mb-30"></div>

    <!-- Recent Post -->
    <section id="spotlight-recent">
        <div class="container">
            <div class="mx-auto text-center">
                <h1 class="section-heading">Article & Tips</h1>
                <p class="mb-4">
                    Browse latest articles and tips from our blog
                </p>
            </div>
            <div class="row">
                <?php

                $recent_posts_query = new WP_Query([
                    'post_type' => 'post',
                ]);

                while( $recent_posts_query->have_posts() ) : $recent_posts_query->the_post();

                    get_template_part('template-parts/content', 'post-loop');

                endwhile;

                wp_reset_postdata(); // Don't forget to reset
                ?>
            </div>

            <div class="mx-auto text-center">
                <a class="btn std-btn btn-xl btn-common btn-filled" href="<?php echo home_url('blog'); ?>">Lihat Semua</a>
            </div>

        </div>
    </section>
    <!-- /. Recent Post -->


<?php
get_footer();
