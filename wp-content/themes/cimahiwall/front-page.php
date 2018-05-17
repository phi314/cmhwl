<?php
/**
 * Template Name: Front Page
 */

get_header('front'); ?>

    <!-- Header -->
    <div id="header-light-slider" class="carousel slide">
        <div id="carousel-area">
            <div id="carousel-slider" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carousel-slider" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-slider" data-slide-to="1"></li>
                    <li data-target="#carousel-slider" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active" style="background: url('https://picsum.photos/800/200?random')">
                        <div class="carousel-caption">
                            <h3 class="slide-title animated fadeInDown">Promo mingguan</h3>
                            <h5 class="slide-text animated fadeIn">Lotte Mart, Carefour, Hypermart, Superindo, Giant, Yogya, Indomaret, Alfamart</h5>
                            <a href="<?php echo get_term_link(116); ?>" class="btn btn-lg btn-default-filled animated fadeInUp">Cek Disini</a>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carousel-slider" role="button" data-slide="prev">
                    <span class="carousel-control carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel-slider" role="button" data-slide="next">
                    <span class="carousel-control carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
    <!-- /. Header -->

    <!-- Featured Listing Event -->
    <section id="featured-listing-event" class="">
        <div class="container py-4">
            <div class="mx-auto text-center">
                <h4 class="section-heading">Event!</h4>
            </div>

            <div class="row">
                <?php
                $featured_event_categories = get_field('featured_event_categories');
                foreach ($featured_event_categories as $featured_event_category) :
                    $event_category = get_term( $featured_event_category );
                    ?>
                    <div class="col-6 col-sm-2">
                        <a class="featured-box featured-center" href="<?php echo get_term_link($event_category->term_id, 'event_category'); ?>">
                            <div class="featured-icon border-icon">
                                <p class="text-primary"><i class="<?php echo get_category_icon($event_category->term_id, 'event_category'); ?>"></i></p>
                            </div>
                            <div class="featured-content">
                                <p><?php echo $event_category->name; ?></p>
                            </div>
                        </a>
                    </div>
                    <?php
                endforeach;
                ?>
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

                    get_template_part('template-parts/content', 'event-loop');

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


    <!-- All Category -->
    <?php get_template_part('template-parts/content', 'category-grid'); ?>
    <!-- /. All Category -->

    <div class="mb-30"></div>

<?php
get_footer();
