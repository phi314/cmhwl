<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WP_Bootstrap_Starter
 */

    get_header();


    if ( have_posts() ) : the_post();

        global $post;

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
        $location_lat = ! empty($location['lat']) ? $location['lat'] : '';
        $location_lng = ! empty($location['lng']) ? $location['lng'] : '';
        $website = get_field('cimahiwall_place_website');
        $phone = get_field('cimahiwall_place_phone_number');
        $address = get_field('cimahiwall_place_address');
        if( ! empty($google_place) ) {
            $location_lat = $google_place->geometry->location->lat;
            $location_lng = $google_place->geometry->location->lng;
            $address = $google_place->formatted_address;
            $website = $google_place->website;
            $phone = $google_place->formatted_phone_number;
        }

        $place_tags = wp_get_post_terms($post_id, 'place_tag');

        $is_hotel = get_field('is_hotel');

//        echo "<pre>";
//        var_dump($google_place);
//        echo "</pre>"

        /*
         * Initialize Tiket.com
         */
        $tiket_dot_com_url = get_field('tiket.com');
        $tiket_dot_com = new TiketDotCom();
        $tiket_dot_com->set_url($tiket_dot_com_url);

        /*
         * Initialize Booking.com
         */
        $booking_dot_com_url = get_field('booking.com');
        $booking_dot_com = new BookingDotCom();
        $booking_dot_com->set_url($booking_dot_com_url);

        /*
         * Initialize Zomato
         */
        $zomato_place = get_post_meta($post_id, 'zomato_place_json', true);

        /*
         * Place have food
         */
        $avg_cost_for_two = get_field('average_cost_for_two');
        $price_range = get_field('price_range');
        $cuisines = get_field('cuisines');
        if( ! empty( $zomato_place )) {
            $avg_cost_for_two = $zomato_place->average_cost_for_two;
            $price_range = $zomato_place->price_range;
            $cuisines = $zomato_place->cuisines;
        }

        ?>

<div class="container-place">

    <?php if( ! empty( $content) ) : ?>

        <!-- Top Slider -->
        <?php if( ! empty($google_place->photos) ) : ?>
            <div class="top-slider">

                <!-- Featured Image -->
                <?php
                if( $featured_image_url = get_the_post_thumbnail_url() ) :
                    ?>
                        <a href="<?php echo $featured_image_url; ?>" class="top-slider-item"><img title="Featured Image" src="<?php echo $featured_image_url; ?>"></a>
                    <?php
                endif;
                ?>

                <!-- Image From Google -->
                <?php foreach ($google_place->photos as $key => $google_place_photo) : ?>
                    <a href="https://maps.googleapis.com/maps/api/place/photo?maxwidth=600&photoreference=<?php echo $google_place_photo->photo_reference; ?>&key=<?php echo cmb2_get_option('cimahiwall_theme_options', 'google_map_api_key'); ?>" class="top-slider-item"><img title="Photo by Google" src="https://maps.googleapis.com/maps/api/place/photo?maxwidth=600&photoreference=<?php echo $google_place_photo->photo_reference; ?>&key=<?php echo cmb2_get_option('cimahiwall_theme_options', 'google_map_api_key'); ?>"></a>
                <?php
                    if($key == 5) break;
                endforeach;
                ?>

                <?php
                // Image from Cloud / Google
                $cloud_gallery = get_post_meta($post_id, 'cimahiwall_field_cloud_photos', 1);
                if( ! empty($cloud_gallery) ) :
                    foreach ($cloud_gallery as $cloud_photo) :
                        ?>
                        <a href="<?php echo $cloud_photo['cloud_image_url']; ?>" class="top-slider-item"><img title="<?php echo $cloud_photo['cloud_image_source']; ?>" src="<?php echo $cloud_photo['cloud_image_url']; ?>"></a>
                        <?php
                    endforeach;
                endif;
                ?>


            </div>
        <?php else: ?>
            <section class="full-width-background" style="background: url('<?php echo get_template_directory_uri() . '/inc/assets/images/category/1.jpg'; ?>');">
                <div class="container text-center">
                    <h1 class="mb-4 text-white"><?php echo get_the_title(); ?></h1>
                </div>
            </section>
        <?php endif; ?>

    <?php endif; ?>

    <div class="mb-60"></div>

    <!-- Main Content -->
    <div class="bg-gray">
        <div class="container">
            <div class="row">
                <div id="main" class="col-md-8" role="main">
                    <div class="row">
                        <div class="col-sm-10">
                            <?php
                            $place_categories = wp_get_post_terms($post_id, 'place_category');
                            if( ! empty($place_categories[0])) {
                                ?>
                                <a href="<?php echo get_term_link($place_categories[0]->term_id); ?>">
                                    <?php the_term_icon('place_category', $place_categories[0]->term_id); ?> <?php echo $place_categories[0]->name; ?>
                                </a>
                                <?php
                            }
                            ?>

                            <?php if( get_field('is_hotel')) :
                                $rating = get_field('rating');
                                $is_selected = "selected='selected'";
                                ?>
                                <select class="cimahiwall_rating_only">
                                    <?php for( $i = 1; $i <= $rating; $i ++) : ?>
                                        <option <?php echo $rating == $i ? $is_selected : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>

                            <?php endif; ?>

                            <h1><?php the_title(); ?></h1>
                        </div>
                        <div class="col-sm-2">
                            <?php if (function_exists( 'cimahiwall_get_average_rating' )) : ?>
                                <div class="label label-success-filled">
                                    <i class="fa fa-star"></i>
                                    <?php
                                        echo cimahiwall_get_average_rating( get_the_ID(), 'all' );
                                    ?>
                                </div>
                            <?php endif; ?>
                            <small>
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <?php the_favorites_button(); ?>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn std-btn btn-sm btn-common">
                                <i class="fa fa-share"></i> Share
                            </button>
                        </div>
                    </div>

                    <!-- Have food Details -->
                    <section>
                        <?php if( ! empty($zomato_place)) : ?>
                            <a href="<?php echo $zomato_place->menu_url; ?>" target="_blank" class="btn std-btn btn-filled btn-block"><?php _e('Lihat daftar menu', 'cimahiwall'); ?></a>
                        <?php endif; ?>

                        <div class="row">

                            <?php if( ! empty( $avg_cost_for_two) ) : ?>
                                <div class="col-md-4 col-sm-6">
                                    <div class="service-box">
                                        <div class="service-icon">
                                            <i class="fa fa-credit-card"></i>
                                        </div>
                                        <div class="service-content">
                                            <h4>IDR <?php echo $avg_cost_for_two ?></h4>
                                            <p>
                                                Untuk Berdua (rata-rata)
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if( ! empty( $price_range) ) : ?>
                            <div class="col-md-4 col-sm-6">
                                <div class="service-box">
                                    <div class="service-icon">
                                        <i class="fa fa-dollar"></i>
                                    </div>
                                    <div class="service-content">
                                        <h4>
                                            <?php for ($i = 1; $i <= $price_range; $i++) echo "$" ?>
                                        </h4>
                                        <p>
                                            Range Harga
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if( ! empty( $cuisines) ) : ?>
                            <div class="col-md-4 col-sm-6">
                                <div class="service-box">
                                    <div class="service-icon">
                                        <i class="fa fa-cutlery"></i>
                                    </div>
                                    <div class="service-content">
                                        <h4>Masakan</h4>
                                        <p>
                                            <?php echo $cuisines; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </section>
                    <!-- /. Have food Details -->

                    <?php if( ! empty( get_the_content() )) : ?>

                        <article id="place-<?php echo $post_id; ?>" <?php post_class(); ?>>

                            <div class="entry-content p-4 card">
                                <?php
                                    the_content();
                                ?>
                            </div><!-- .entry-content -->

                        </article><!-- #post-## -->

                    <?php else :  ?>

                    <div class="card-columns">
                        <!-- Featured Image -->
                        <?php
                        if( $featured_image_url = get_the_post_thumbnail_url() ) :
                            ?>
                            <a href="<?php echo $featured_image_url; ?>" class="card"><img title="Featured Image" class="card-img" src="<?php echo $featured_image_url; ?>"></a>
                            <?php
                        endif;
                        ?>

                        <!-- Image From Google -->
                        <?php if ( ! empty($google_place->photos ) ) : ?>
                            <?php foreach ($google_place->photos as $key => $google_place_photo) : ?>
                                <a href="https://maps.googleapis.com/maps/api/place/photo?maxwidth=600&photoreference=<?php echo $google_place_photo->photo_reference; ?>&key=<?php echo cmb2_get_option('cimahiwall_theme_options', 'google_map_api_key'); ?>" class="card">
                                    <img class="card-img lazy" title="Photo by Google" data-src="https://maps.googleapis.com/maps/api/place/photo?maxwidth=600&photoreference=<?php echo $google_place_photo->photo_reference; ?>&key=<?php echo cmb2_get_option('cimahiwall_theme_options', 'google_map_api_key'); ?>">
                                </a>
                                <?php
                                if($key == 5) break;
                            endforeach;
                            ?>
                        <?php endif; ?>

                        <?php
                        // Image from Tiket.com
                        $photos = $tiket_dot_com->gallery;
                        foreach ($photos as $photo) :
                            ?>
                            <a href="<?php echo $photo; ?>" class="card"><img title="Hotel photo" class="card-img lazy" data-src="<?php echo $photo; ?>"></a>
                            <?php
                        endforeach;
                        ?>

                        <?php
                        // Image from Cloud / Google
                        $cloud_gallery = get_post_meta($post_id, 'cimahiwall_field_cloud_photos', 1);
                        if( ! empty($cloud_gallery) ) :
                            foreach ($cloud_gallery as $cloud_photo) :
                                ?>
                                <a href="<?php echo $cloud_photo['cloud_image_url']; ?>" class="card"><img title="<?php echo $cloud_photo['cloud_image_source']; ?>"  class="card-img lazy" data-src="<?php echo $cloud_photo['cloud_image_url']; ?>"></a>
                                <?php
                            endforeach;
                        endif;
                        ?>


                    </div>

                    <?php endif; ?>

                    <?php
                    $place_events = new WP_Query([
                        'post_type' => 'event',
                        'meta_query' => array(
                            array(
                                'key' => 'location', // name of custom field
                                'value' => '"' . $post->ID . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
                                'compare' => 'LIKE'
                            )
                        )
                    ]);

                    if( $place_events->have_posts() ) :
                    ?>
                        <!-- Place Event List -->
                        <h3>// Events</h3>
                        <div class="row mt-4 list-event">

                            <?php
                                while( $place_events->have_posts() ) : $place_events->the_post();
                                    set_query_var( 'event_loop_column', 'col-md-6' );
                                    get_template_part( 'template-parts/content', 'event-loop' );
                                endwhile;
                                wp_reset_postdata();
                            ?>
                        </div>
                        <!-- /. Place Event List -->
                    <?php endif; ?>


                    <footer class="entry-footer">
                        <?php wp_bootstrap_starter_entry_footer(); ?>
                    </footer><!-- .entry-footer -->


                </div><!-- #main -->

                <!-- Sidebar -->
                <div class="col-md-4">

                    <section>
                        <a href="#comments" class="btn btn-common btn-block"><i class="fa fa-star-o"></i> Tulis Review </a>
                        <small>
                            <?php $comment_count = get_comment_count($post_id); ?>
                            <?php echo $comment_count['approved'] ; ?> Review(s)
                            <i class="fa fa-eye"></i> <?php echo pvc_get_post_views(); ?>
                        </small>
                    </section>

                    <div class="mb-3"></div>

                    <!-- Hotel Details -->
                    <?php if( $is_hotel ) : ?>

                        <!-- Booking . com Ads -->
                        <section>
                            <?php
                            $city = wp_get_post_terms( $post_id, 'city');
                            if( ! empty($city[0])) {
                                $booking_dot_com_city_deals_finder = get_field('deals_finder', 'city_' . $city[0]->term_id);
                                echo $booking_dot_com_city_deals_finder;
                            }
                            ?>
                        </section>

                        <div class="mb-3"></div>


                        <!-- List hotel agent -->
                        <section class="text-center">
                            <em>Pesan kamar di <?php echo $post->post_title; ?> via:</em>

                            <div class="pb-3">
                                <a href="#">
                                    <img class="hotel-logo" src="https://cdn6.agoda.net/images/mvc/default/agoda-logo.svg">
                                </a>
                            </div>

                            <div class="pb-3">
                                <a href="<?php echo $tiket_dot_com->url; ?>">
                                    <img class="hotel-logo" src="https://www.tiket.com/assets_version/cardamom/dist/images/tiketcom.png">
                                </a>
                            </div>

                            <div class="pb-3">
                                <a href="<?php echo $booking_dot_com->url; ?>">
                                    <img class="hotel-logo" src="https://upload.wikimedia.org/wikipedia/en/thumb/b/be/Booking.com_logo.svg/1280px-Booking.com_logo.svg.png">
                                </a>
                            </div>

                        </section>

                        <div class="mb-3"></div>
                        <!-- End List hotel agent -->

                    <?php endif; ?>

                    <section>
                        <h2>Lokasi</h2>
                        <input type="hidden" name="google_place_id" value="<?php echo get_field('google_place_id'); ?>">
                        <div class="map" id="place-map"></div>
                        <div class="location">
                            <div class="marker" data-lat="<?php echo $location_lat; ?>" data-lng="<?php echo $location_lng; ?>"></div>
                        </div>
                        <p class="text-sm pt-2">
                            <?php echo trim($address); ?>
                        </p>
                    </section>

                    <section>
                        <div class="">

                            <ul class="list-style social-list pl-0">
                                <?php if( ! empty($phone)) : ?>
                                    <li>
                                        <a href="tel: <?php echo $phone; ?>">
                                            <i class="fa fa-phone"></i> <?php echo $phone; ?>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if( ! empty($website) ) : ?>
                                    <li>
                                        <a href="<?php echo $website; ?>"><i class="fa fa-link"></i> <?php limit_text($website, 70); ?></a>
                                    </li>
                                <?php endif; ?>

                                <?php if($instagram_tag = get_field('instagram_tag', get_the_ID())) : ?>
                                    <li>
                                        <i class="fa fa-instagram"></i>
                                        <?php
                                            echo "<a href='https://www.instagram.com/explore/tags/" . $instagram_tag . "' target='_blank'>#" . $instagram_tag . '</a>';
                                        ?>
                                    </li>
                                <?php endif; ?>

                            </ul>

                            <?php
                            if( ! empty($google_place->opening_hours->weekday_text)) : ?>
                                <ul class="list-featured space-bottom-20">
                                <?php foreach ($google_place->opening_hours->weekday_text as $google_place_weekday_text) echo "<li>" . $google_place_weekday_text . "</li>"; ?>
                                </ul>
                            <?php endif; ?>

                        </div>
                    </section>

                    <div class="mb-4"></div>

                    <section>
                        <h4>Lihat juga</h4>
                        <?php
                        $place_categories_id_only = terms_id_only( $place_categories );
                        $place_tags_id_only = terms_id_only( $place_tags );

                        $cities = get_the_terms( get_the_ID(), 'city' );
                        $cities_id_only = terms_id_only( $cities );
                        ?>
                        <div class="blog-posts-small">
                            <?php
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

                            while ($related_places_by_tag->have_posts() ) : $related_places_by_tag->the_post();
                                $related_places_by_tag_post_id = get_the_ID();
                                ?>
                                <div class="blog-post-small">
                                    <div class="blog-post-small-image" style="background: url('<?php echo get_featured_post_image($related_places_by_tag_post_id, 'place'); ?>')"></div>
                                    <a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a>
                                    <p>
                                        <?php
                                        $place_categories = wp_get_post_terms($related_places_by_tag_post_id, 'place_category');
                                        if( ! empty($place_categories[0])) {
                                            echo  $place_categories[0]->name;
                                        }
                                        ?>
                                    </p>
                                </div>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </div>

                    </section>


                </div>
            </div>
        </div>

        <!-- Instagram Image -->
        <div class="container mt-4">
            <div id="instafeed" class="row instagram-slider"></div>
        </div>

    </div>
    <!-- ./ Main Content -->

    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <?php

                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;

                ?>

            </div>
            <div class="col-md-4">
                <h4>Blog terbaru</h4>
                <div class="blog-posts-small">
                    <?php
                    $latest_posts = get_posts([
                        'post_type' => 'post',
                        'numberposts' => 5
                    ]);

                    foreach ($latest_posts as $latest_post) :
                    ?>
                        <div class="blog-post-small">
                            <div class="blog-post-small-image" style="background: url('<?php echo get_featured_post_image($latest_post->ID, 'place'); ?>')"></div>
                            <a href="<?php echo get_permalink($latest_post->ID); ?>">
                                <?php limit_text($latest_post->post_title, 37); ?>
                            </a>
                            <p>
                                <?php
                                $latest_post_categories = get_the_category($latest_post->ID);

                                if( ! empty($latest_post_categories[0]))
                                    echo $latest_post_categories[0]->name;
                                ?>
                            </p>
                            <p class="text-right">~ <?php echo get_the_date('F Y', $latest_post->ID); ?>
                            </p>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

</div>
<?php

    endif; // End of the loop.

get_footer();
?>

