<?php
/**
 * Template Name: Front Page
 */

get_header('front'); ?>

    <!-- Featured Listing -->
    <section id="featured-listing">
        <div class="container">
            <div class="py-4 mx-auto text-center">
                <h4 class="section-heading">Hayu urang hardolin!</h4>
            </div>
        </div>
        <div class="container">

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

        <div class="mx-auto text-center pt-3">
            <a class="btn std-btn btn-xl btn-common" href="<?php echo home_url('place'); ?>">Explore Lokasi</a>
        </div>

    </section>
    <!-- /. Featured Listing -->

    <!-- Featured Listing Event -->
    <section id="featured-listing-event" class="">
        <div class="container py-4">
            <div class="mx-auto text-center">
                <h4 class="section-heading">Event!</h4>
            </div>
        </div>
        <div class="container">
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

        <div class="mx-auto text-center pt-3">
            <a class="btn std-btn btn-xl btn-common" href="<?php echo home_url('event'); ?>">Explore Event</a>
        </div>

    </section>
    <!-- /. Featured Listing -->

    <!-- Featured Category -->
    <section id="featured-category">
        <div class="container py-4">
            <div class="text-center">
                <h4 class="section-heading">Best things to do!</h4>
            </div>
            <div class="row">
                <?php
                    $featured_place_categories = get_field('featured_place_categories');

                    foreach ($featured_place_categories as $featured_place_category) :
                ?>

                    <div class="col-4">
                        <a class="featured-box featured-center" href="<?php echo get_term_link($featured_place_category->term_id, 'place_category'); ?>">
                            <div class="featured-icon border-icon">
                                <p class="timer text-primary" data-to="<?php echo $featured_place_category->count; ?>" data-speed="3000"><?php echo $featured_place_category->count; ?></p>
                            </div>
                            <div class="featured-content">
                                <h4><?php echo $featured_place_category->name; ?></h4>
                            </div>
                        </a>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- /. Featured Category -->

    <div class="mb-30"></div>

<?php
get_footer();
