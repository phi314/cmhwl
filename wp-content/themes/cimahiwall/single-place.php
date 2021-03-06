<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WP_Bootstrap_Starter
 */

get_header();

global $post, $current_user;

if (have_posts()) : the_post();

    $post_id = get_the_ID();
    $content = get_the_content();

    /*
     * Initialize Google Place
     */
    $google_place = get_post_meta($post_id, 'google_place_json', true);
    $google_place = $google_place->result;

    /*
     * Manual input
     */
    $location = get_field('cimahiwall_place_location');
    $location_lat = !empty($location['lat']) ? $location['lat'] : '';
    $location_lng = !empty($location['lng']) ? $location['lng'] : '';
    $website = get_field('cimahiwall_place_website');
    $phone = get_field('cimahiwall_place_phone_number');
    $address = get_field('cimahiwall_place_address');

    if (!empty($google_place)) {
        $location_lat = $google_place->geometry->location->lat;
        $location_lng = $google_place->geometry->location->lng;
        $address = $google_place->formatted_address;
        $website = $google_place->website;
        $phone = $google_place->formatted_phone_number;
    }


    $place_tags = wp_get_post_terms($post_id, 'place_tag');
    ?>

    <div class="container-place">

        <!-- Top Slider -->
        <?php
        $cloud_gallery = get_post_meta($post_id, 'cimahiwall_field_cloud_photos', 1);
        $featured_image_url = get_the_post_thumbnail_url();
        if (!empty($cloud_gallery)) : ?>
            <div class="top-slider">
                <?php
                // Featured image
                if (!empty($featured_image_url)) :
                    ?>
                    <a href="<?php echo $featured_image_url; ?>" data-featherlight="image" class="top-slider-item"><img
                                title="Featured Image" src="<?php echo $featured_image_url; ?>"></a>
                <?php
                endif;

                // Image from Cloud / Google
                if (!empty($cloud_gallery)) :
                    foreach ($cloud_gallery as $cloud_photo) :
                        ?>
                        <a href="<?php echo $cloud_photo['cloud_image_url']; ?>" data-featherlight="image"
                           class="top-slider-item"><img title="<?php echo $cloud_photo['cloud_image_source']; ?>"
                                                        src="<?php echo $cloud_photo['cloud_image_url']; ?>"></a>
                    <?php
                    endforeach;
                endif;
                ?>
            </div>
        <?php
        else:
            if (!empty($featured_image_url)) :
                ?>
                <div class="single-top-slider">
                    <a href="<?php echo $featured_image_url; ?>" data-featherlight="image" class="top-slider-item"><img
                                title="Featured Image" src="<?php echo $featured_image_url; ?>"></a>
                </div>
            <?php
            endif;
        endif;
        ?>
        <!-- /. Top Slider -->

        <div class="mb-3"></div>

        <!-- Main Content -->
        <div class="bg-gray">
            <div class="container">
                <section class="row mb-5">

                    <!-- Left content -->
                    <div id="main" class="col-md-8" role="main">

                        <!-- Main title -->
                        <div class="row">
                            <div class="col-sm-10">
                                <?php
                                $place_categories = wp_get_post_terms($post_id, 'place_category');
                                if (!empty($place_categories)) {
                                    foreach ($place_categories as $place_category) :
                                        ?>
                                        <a href="<?php echo get_term_link($place_category->term_id); ?>" class="badge">
                                            <i class="<?php echo get_category_icon($place_category->term_id, 'place_category'); ?>"></i> <?php echo $place_category->name; ?>
                                        </a>
                                    <?php
                                    endforeach;
                                }
                                ?>
                                <h1><?php the_title(); ?></h1>
                                <?php
                                $cities = wp_get_post_terms($post_id, 'city');
                                if (!empty($cities[0])) {
                                    ?>
                                    <a href="<?php echo get_term_link($cities[0]->term_id); ?>" class="text-muted">
                                        <?php echo $cities[0]->name; ?>
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <!-- /. Main title -->

                        <!-- Main three button -->
                        <div class="row pt-3">
                            <?php if (is_user_logged_in()) : ?>
                                <div class="col-12 text-center">
                                    <?php
                                    $activity = new CimahiwallSocialActivity($current_user->ID);
                                    $activity->set_object_id($post_id);

                                    if (!(bool)$activity->is_user_visited_place_today()) :
                                        ?>
                                        <form action="<?php echo admin_url('admin-post.php'); ?>" method="post">
                                            <input type="hidden" value="log_a_visit" name="action">
                                            <input type="hidden" value="<?php echo $post_id; ?>" name="place_id">
                                            <button type="submit" class="btn std-btn btn-sm btn-common btn-block">
                                                <i class="fas fa-calendar-check"></i> <?php _e('Visiting', 'cimahiwall'); ?>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <button type="button"
                                                class="btn std-btn btn-sm btn-common btn-block btn-filled">
                                            <i class="fas fa-calendar-check"></i> <?php _e('Visited', 'cimahiwall'); ?>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <div class="col-6 text-center">
                                <?php the_favorites_button(); ?>
                            </div>
                            <div class="col-6 text-center">
                                <button type="button" class="btn std-btn btn-sm btn-common btn-block">
                                    <i class="fa fa-share"></i> Share
                                </button>
                            </div>
                        </div>
                        <!-- /. Main three button -->

                        <!-- Summary -->
                        <section>
                            <small>
                                <?php $comment_count = get_comment_count($post_id); ?>
                                <?php echo $comment_count['approved']; ?> Tip(s)
                                <i class="fa fa-eye"></i> <?php echo pvc_get_post_views(); ?>
                            </small>
                        </section>
                        <!-- /. Summary -->

                        <?php if (!empty($post->post_content)) : ?>
                            <!-- Main content -->
                            <article id="place-<?php echo $post_id; ?>" <?php post_class(); ?>>
                                <div class="entry-content p-4 card">
                                    <?php
                                    the_content();
                                    ?>
                                </div>
                            </article>
                            <!-- /. Main content -->
                        <?php endif; ?>

                        <!-- Place Event List -->
                        <?php
                        $brands = wp_get_post_terms($post->ID, 'brand');
                        $brand = false;
                        if (!empty($brands[0])) {
                            $brand = $brands[0]->slug;
                        }
                        $place_events = new WP_Query([
                            'post_type' => 'event',
                            'posts_per_page' => -1,
                            'tax_query' => [
                                [
                                    'taxonomy' => 'brand',
                                    'field' => 'slug',
                                    'terms' => '"' . $brand . '"',
                                ]
                            ]
                        ]);
                        if ($place_events->have_posts()) :
                            ?>
                            <h6 class="pt-2">// <?php _e('Events', 'cimahiwall'); ?></h6>
                            <div class="row list-event">
                                <?php
                                while ($place_events->have_posts()) : $place_events->the_post();
                                    set_query_var('event_loop_column', 'col-md-4');
                                    get_template_part('template-parts/content', 'event-loop');
                                endwhile;
                                wp_reset_postdata();
                                ?>
                            </div>
                        <?php endif; ?>
                        <!-- /. Place Event List -->

                        <footer class="entry-footer">
                            <?php wp_bootstrap_starter_entry_footer(); ?>
                        </footer><!-- .entry-footer -->

                        <a href="https://goo.gl/4b7LZP"
                           target="_blank"><?php _e('Report location', 'cimahiwall'); ?></a>

                        <div class="mb-3"></div>

                        <!-- Comments -->
                        <div class="row">
                            <div class="col-12">
                                <?php

                                // If comments are open or we have at least one comment, load up the comment template.
                                if (comments_open() || get_comments_number()) :
                                    comments_template();
                                endif;

                                ?>
                            </div>
                        </div>
                        <!-- /. Comments -->

                    </div>
                    <!-- /. Left content -->

                    <!-- Sidebar -->
                    <div class="col-md-4">

                        <!-- Map -->
                        <section>
                            <h4><?php _e('Location', 'cimahiwall'); ?></h4>
                            <input type="hidden" name="google_place_id"
                                   value="<?php echo get_field('google_place_id'); ?>">
                            <div class="map" id="place-map"></div>
                            <div class="location">
                                <div class="marker" data-lat="<?php echo $location_lat; ?>"
                                     data-lng="<?php echo $location_lng; ?>"></div>
                            </div>
                            <small class="text-sm py-3">
                                <?php echo trim($address); ?>
                            </small>
                        </section>
                        <!-- /. Map -->

                        <!-- Place contact -->
                        <section>
                            <ul class="list-style social-list pl-0">
                                <li>
                                    <?php
                                    $direction_url = "https://maps.google.com/?q=$post->post_title";
                                    if (empty($google_place)) {
                                        $direction_url = "https://maps.google.com/?daddr=$location_lat,$location_lng";
                                    }
                                    ?>
                                    <a href="<?php echo $direction_url; ?>" target="_blank">
                                        <i class="fa fa-road"></i>
                                        <?php _e('Get direction', 'cimahiwall'); ?>
                                    </a>
                                </li>

                                <?php if (!empty($phone)) : ?>
                                    <li>
                                        <a href="tel: <?php echo $phone; ?>">
                                            <i class="fa fa-phone"></i> <?php echo $phone; ?>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if (!empty($website)) : ?>
                                    <li>
                                        <a href="<?php echo $website; ?>"><i
                                                    class="fa fa-link"></i> <?php _e('Website', 'cimahiwall'); ?></a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </section>
                        <!-- /. Place contact -->
                    </div>
                </section>

                <!-- Nearby places -->
                <section class="row mb-5">
                    <div class="col-12">
                        <!-- Nearby places -->
                        <h4><?php _e('Lokasi sekitar', 'cimahiwall'); ?></h4>
                        <div class="row">
                            <?php
                            $nearby_places = new WP_Query([
                                'post_type' => 'place',
                                'post__not_in' => [$post_id],
                                'posts_per_page' => 5,
                                'geo_query' => [
                                    'lat_field' => 'cimahiwall_latitude',
                                    'lng_field' => 'cimahiwall_longitude',
                                    'latitude' => $location_lat,
                                    'longitude' => $location_lng,
                                    'distance' => 100,
                                    'units' => 'km'
                                ]
                            ]);
                            while ($nearby_places->have_posts()) : $nearby_places->the_post();
                                set_query_var('show_distance', true);
                                get_template_part('template-parts/content-place', 'loop');
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                        <!-- /. Nearby places -->
                    </div>
                </section>
                <!-- /. Nearby places -->

                <!-- Related places -->
                <section class="row">
                    <div class="col-12">
                        <h4><?php _e('Lihat juga', 'cimahiwall'); ?></h4>
                        <div class="row">
                            <?php
                            $place_categories_id_only = terms_id_only($place_categories);
                            $place_tags_id_only = terms_id_only($place_tags);

                            $cities = get_the_terms(get_the_ID(), 'city');
                            $cities_id_only = terms_id_only($cities);

                            $related_places_by_tag = new WP_Query([
                                'post_type' => 'place',
                                'posts_per_page' => 5,
                                'post__not_in' => [get_the_ID()],
                                'tax_query' => [
                                    'relation' => 'OR',
                                    [
                                        'taxonomy' => 'place_category',
                                        'field' => 'term_id',
                                        'terms' => $place_categories_id_only
                                    ],
                                    [
                                        'taxonomy' => 'place_tag',
                                        'field' => 'term_id',
                                        'terms' => $place_tags_id_only
                                    ],
                                    [
                                        'taxonomy' => 'city',
                                        'field' => 'term_id',
                                        'terms' => $cities_id_only
                                    ]
                                ]
                            ]);

                            while ($related_places_by_tag->have_posts()) : $related_places_by_tag->the_post();
                                set_query_var('show_distance', false);
                                get_template_part('template-parts/content-place', 'loop');
                            endwhile;
                            wp_reset_postdata(); ?>
                        </div>
                    </div>
                </section>
                <!-- /. Related places -->

            </div>

        </div>
        <!-- ./ Main Content -->
    </div>
<?php

endif; // End of the loop.

get_footer();
?>

