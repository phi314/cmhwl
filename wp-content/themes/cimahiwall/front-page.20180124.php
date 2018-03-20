<?php
/**
 * Template Name: Front Page
 */

get_header(); ?>

    <header class="masthead text-center text-white d-flex">
        <div class="container my-auto">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <h1 class="text-uppercase">
                        Photoeverygraph
                    </h1>
                </div>
                <div class="col-lg-10 mx-auto">
                    <p>Take a pic !</p>
                </div>
                <div class="col-lg-6 mx-auto">
                    <form action="" id="custom-search-input">
                        <div class="input-group col-md-12">
                            <input type="text" class="form-control input-lg" name="s" placeholder="Mulai dari sini . . ." />
                            <span class="input-group-btn">
                                <button class="btn btn-info btn-lg">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <input type="hidden" value="place" name="mahiwal_type">
                    </form>
                </div>
            </div>
        </div>
    </header>

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

    <!-- Featured Listing -->
    <section class="" id="featured-listing">
        <div class="container">
            <div class="mx-auto">
                <h1 class="section-heading">// We've got what you need!</h1>
                <p class="mb-4">Start Bootstrap has everything you need to get your new website up and running in no time! All of the templates and themes on Start Bootstrap are open source, free to download, and easy to use. No strings attached!</p>
            </div>
        </div>
        <div class="container-fluid">

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
            <nav aria-label="Featured Listing Navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a href="#" class="page-link featured-listing-prev-btn"><i class="fa fa-chevron-left"></i></a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link featured-listing-next-btn"><i class="fa fa-chevron-right"></i></a>
                    </li>
                </ul>
            </nav>
        </div>
    </section>
    <!-- /. Featured Listing -->

    <!-- Featured Category -->
    <section class="bg-gray" id="portfolio">
        <div class="container">
            <div class="mx-auto">
                <h1 class="section-heading">// Best things to do!</h1>
                <p class="mb-4">
                    Find great places to stay, eat, shop or visit from local experts.
                </p>
            </div>
            <div class="row">

                <?php

                    $featured_place_categories = get_field('featured_place_categories');

                    foreach ($featured_place_categories as $featured_place_category) :
                        $place_category_image = get_term_image_url('place_category', $featured_place_category->term_id);


                ?>

                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="<?php echo get_term_link($featured_place_category->term_id, 'place_category'); ?>" style="background: url('<?php echo $place_category_image; ?>');">
                            <div class="portfolio-box-caption">
                                <div class="portfolio-box-caption-content">
                                    <div class="project-name">
                                        <!-- The Icon -->
                                        <?php the_term_icon('place_category', $featured_place_category->term_id); ?>
                                        <br>
                                        <?php echo $featured_place_category->name; ?>
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


    <section class="full-width-background text-white" style="background: url('<?php echo get_template_directory_uri() . '/inc/assets/images/category/1.jpg'; ?>');">
        <div class="container text-center">
            <h1 class="mb-4 text-white">Kelurahan Kecamatan</h1>
            <p class="mb-4">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
            <a class="btn btn-primary text-white btn-xl sr-button" href="http://startbootstrap.com/template-overviews/creative/">Kelurahan Kecamatan Explorer</a>
        </div>
    </section>

    <section class="bg-gray no-pb">
        <div class="container">
            <div class="mx-auto">
                <h1 class="section-heading">// Baru nemu nih!</h1>
                <p class="mb-4">Start Bootstrap has everything you need to get your new website up and running in no time! All of the templates and themes on Start Bootstrap are open source, free to download, and easy to use. No strings attached!</p>
            </div>
        </div>
        <!-- Instagram Image -->
        <div class="container">
            <div id="instafeed" class="row instagram-slider"></div>
        </div>
    </section>

    <section class="" id="blog">
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
                <a class="btn btn-primary text-white btn-xl sr-button" href="<?php echo home_url('blog'); ?>">Lihat Semua</a>
            </div>

        </div>
    </section>


<?php
get_footer();
