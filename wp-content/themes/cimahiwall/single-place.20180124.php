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
        $google_place = get_post_meta(get_the_ID(), 'google_place_json', true);
        $google_place = $google_place->result;

//        echo "<pre>";
//        var_dump($google_place);
//        echo "</pre>"


        ?>

<div class="container-place">

    <!-- Top Slider -->
    <?php if( ! empty($google_place->photos) ) : ?>
        <div class="top-slider">

            <!-- Featured Image -->
            <?php
            if( $featured_image_url = get_the_post_thumbnail_url() ) :
                ?>
                <div class="top-slider-item"><img title="Featured Image" src="<?php echo $featured_image_url; ?>"></div>
                <?php
            endif;
            ?>

            <!-- Image From Google -->
            <?php foreach ($google_place->photos as $key => $google_place_photo) : ?>
                <div class="top-slider-item"><img title="Photo by Google" src="https://maps.googleapis.com/maps/api/place/photo?maxwidth=600&photoreference=<?php echo $google_place_photo->photo_reference; ?>&key=<?php echo cmb2_get_option('cimahiwall_theme_options', 'google_map_api_key'); ?>"></div>
            <?php
                if($key == 3) break;
            endforeach;
            ?>


        </div>
    <?php else: ?>
        <section class="full-width-background" style="background: url('<?php echo get_template_directory_uri() . '/inc/assets/images/category/1.jpg'; ?>');">
            <div class="container text-center">
                <h1 class="mb-4 text-white"><?php echo get_the_title(); ?></h1>
            </div>
        </section>
    <?php endif; ?>

    <!-- Main Content -->
    <div class="bg-gray">
        <div class="container">
            <div class="row">
                <div id="main" class="col-md-8" role="main">
                    <div class="row">
                        <div class="col-md-12">
                            <h1><?php the_title(); ?></h1>
                        </div>
                        <div class="col-md-3">
                            <?php if (function_exists( 'cimahiwall_get_average_rating' )) : ?>
                            <div class="badge badge-success">
                                <?php
                                    echo cimahiwall_get_average_rating( get_the_ID(), 'all' );
                                ?>
                            </div>
                            <?php endif; ?>
                            <small>
                                <?php
                                $comment_count = get_comment_count(get_the_ID());
                                ?>
                                <?php echo $comment_count['approved'] ; ?> Review(s)
                            </small>
                        </div>
                        <div class="col-md-3">
                            <i class="fa fa-eye"></i> 10k
                        </div>
                        <div class="col-md-3">
                            <a href="#favorite"><i class="fa fa-heart-o"></i> Favorit</a>
                        </div>
                        <div class="col-md-3">
                            <a href="#share"><i class="fa fa-share"></i> Share</a>
                        </div>
                    </div>

                    <?php if( !empty( get_the_content() )) : ?>

                        <article id="place-<?php the_ID(); ?>" <?php post_class(); ?>>

                            <div class="entry-content p-4 card">
                                <?php
                                    the_content();
                                ?>
                            </div><!-- .entry-content -->

                        </article><!-- #post-## -->

                    <?php endif; ?>

                    <footer class="entry-footer">
                        <?php wp_bootstrap_starter_entry_footer(); ?>
                    </footer><!-- .entry-footer -->

                    <h1>// Fasilitas</h1>
                    <div class="row amenities">
                        <div class="col-md-6"><i class="fa fa-wifi"></i> Free Wifi</div>
                        <div class="col-md-6"><i class="fa fa-hand-peace-o"></i> Peace & Calm</div>
                        <div class="col-md-6"><i class="fa fa-smile-o"></i> Smile on Face</div>
                        <div class="col-md-6"><i class="fa fa-reddit"></i> Share</div>
                    </div>

                </div><!-- #main -->

                <div class="col-md-4">

                    <div class="mt-4">
                        <a href="#comments" class="btn btn-primary btn-block"><i class="fa fa-star-o"></i> Tulis Review </a>
                    </div>

                    <h2>Lokasi</h2>
                    <input type="hidden" name="google_place_id" value="<?php echo get_field('google_place_id'); ?>">
                    <div class="map" id="place-map"></div>
                    <div class="location">
                        <div class="marker" data-lat="<?php echo $google_place->geometry->location->lat; ?>" data-lng="<?php echo $google_place->geometry->location->lng; ?>"></div>
                    </div>
                    <small class="text-center">
                        <?php echo trim($google_place->formatted_address); ?>
                    </small>

                    <div class="mt-4 card p-3">

                        <div class="">
                        <?php
                        $place_categories = wp_get_post_terms($post->ID, 'place_category');
                        if( ! empty($place_categories[0])) {
                            ?>
                            <a class="h5" href="<?php echo get_term_link($place_categories[0]->term_id); ?>">
                                <?php the_term_icon('place_category', $place_categories[0]->term_id); ?> <?php echo $place_categories[0]->name; ?>
                            </a>
                            <?php
                        }
                        ?>
                        </div>

                        <?php if( ! empty($google_place->formatted_phone_number)) : ?>
                            <small class="mt-4">
                                <a href="tel: <?php echo $google_place->formatted_phone_number; ?>">
                                    <i class="fa fa-phone"></i> <?php echo $google_place->formatted_phone_number; ?>
                                </a>
                            </small>
                        <?php endif; ?>

                        <?php if( ! empty($google_place->website) ) : ?>
                        <small class="mt-4">
                            <a href="<?php echo $google_place->website; ?>"><i class="fa fa-link"></i> <?php echo $google_place->website; ?></a>
                        </small>
                        <?php endif; ?>

                        <?php if($instagram_tag = get_field('instagram_tag', get_the_ID())) : ?>
                        <small class="mt-4">
                            <i class="fa fa-instagram"></i>
                            <?php
                                    echo "<a href='https://www.instagram.com/explore/tags/" . $instagram_tag . "' target='_blank'>#" . $instagram_tag . '</a>';
                            ?>
                        </small>
                        <?php endif; ?>
                        <div class="mt-4">

                            <?php
                            if( ! empty($google_place->opening_hours->weekday_text)) {
                                foreach ($google_place->opening_hours->weekday_text as $google_place_weekday_text) echo "<small>" . $google_place_weekday_text . "</small><br>";
                            }?>
                        </div>
                    </div>

                    <h2>Lihat juga</h2>
                    <?php
                        $place_categories_id_only = terms_id_only( $place_categories );

                        $cities = get_the_terms( get_the_ID(), 'city' );
                        $cities_id_only = terms_id_only( $cities );
                    ?>
                    <div class="row sidebar-related">
                        <?php
                            $related_places_by_tag = get_posts([
                                'post_type' => 'place',
                                'numberposts' => 5,
                                'exclude' => get_the_ID(),
                                'tax_query' => [
                                        'relation' => 'OR',
                                        [
                                            'taxonomy' => 'place_category',
                                            'field' => 'term_id',
                                            'terms' => $place_categories_id_only
                                        ],
                                        [
                                            'taxonomy' => 'city',
                                            'field' => 'term_id',
                                            'terms' => $cities_id_only
                                        ]
                                ]
                            ]);

                            foreach ($related_places_by_tag as $related_place) :
                        ?>
                        <a href="<?php echo get_permalink( $related_place->ID ); ?>" class="col-12 place">
                            <div class="row">
                                <div class="col-4 sidebar-image" style="background: url('<?php echo get_featured_post_image($related_place->ID, 'place'); ?>')">
                                </div>
                                <div class="col-8">
                                    <strong><?php echo $related_place->post_title; ?></strong>
                                    <br>
                                    <span class="badge badge-success">
                                        <?php echo cimahiwall_get_average_rating($related_place->ID, 'place'); ?>
                                    </span>
                                    <small class="text-faded">
                                        <?php
                                            $place_categories = wp_get_post_terms($related_place->ID, 'place_category');
                                            if( ! empty($place_categories[0])) {
                                                echo  $place_categories[0]->name;
                                            }
                                        ?>
                                    </small>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>

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
                <h2>Blog terbaru</h2>
                <div class="list-group">
                    <?php
                    $latest_posts = get_posts([
                        'post_type' => 'post',
                        'numberposts' => 5
                    ]);

                    foreach ($latest_posts as $latest_post) :
                    ?>
                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                        <sub class="text-faded">
                            <?php
                            $latest_post_categories = get_the_category($latest_post->ID);

                            if( ! empty($latest_post_categories[0]))
                                echo $latest_post_categories[0]->name;
                            ?>
                        </sub>
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><?php echo $latest_post->post_title; ?></h5>
                        </div>
                        <small class="mb-1">
                            <?php limit_text(get_the_excerpt($latest_post->ID), 120); ?>
                        </small>
                    </a>
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

