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
    ?>

<div class="container-place">

    <!-- Top Slider -->
    <div class="top-slider">
        <div class="top-slider-item"><img src="<?php echo get_template_directory_uri() . '/inc/assets/images/category/1.jpg'; ?>"></div>
        <div class="top-slider-item"><img src="<?php echo get_template_directory_uri() . '/inc/assets/images/category/2.jpg'; ?>"></div>
        <div class="top-slider-item"><img src="<?php echo get_template_directory_uri() . '/inc/assets/images/category/3.jpg'; ?>"></div>
        <div class="top-slider-item"><img src="<?php echo get_template_directory_uri() . '/inc/assets/images/category/4.jpg'; ?>"></div>
    </div>

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
                            <div class="badge badge-success">4.5</div> dari 10 Reviews
                        </div>
                        <div class="col-md-3">
                            <i class="fa fa-phone"></i> 085722019188
                        </div>
                        <div class="col-md-3">
                            <i class="fa fa-instagram"></i> lorem ipsum
                        </div>
                        <div class="col-md-3">
                            <i class="fa fa-eye"></i> 10k
                        </div>
                    </div>
                    <div class="row text-center mt-4">
                        <div class="col-md-4">
                            <a href="#comments"><i class="fa fa-star-o"></i> Tulis Review </a>
                        </div>
                        <div class="col-md-4">
                            <a href="#favorite"><i class="fa fa-heart-o"></i> Tambah ke Favorit</a>
                        </div>
                        <div class="col-md-4">
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
                    <h2>Lokasi</h2>
                    <input type="hidden" name="google_place_id" value="<?php echo get_field('google_place_id'); ?>">
                    <div class="map">
                        <img src="https://blogbysid.files.wordpress.com/2013/09/google-maps-custom-marker.jpg">
                    </div>

                    <div class="mt-4">
                        <a href="#" class="h5"><i class="fa fa-building"></i> Apartment</a>
                    </div>

                    <div class="mt-4">
                        <a href="#" class="h6"><i class="fa fa-link"></i> http://www.cimahiwall.com</a>
                    </div>

                    <div class="mt-4">
                        Mon - Sun: 00:00 - 24:00
                    </div>

                    <h2>Lihat juga</h2>
                    <div class="row sidebar-culinary">
                        <a href="#" class="col-12 culinary">
                            <div class="row">
                                <div class="col-4">
                                    <img class="img-responsive" src="https://placeimg.com/640/480/nature">
                                </div>
                                <div class="col-8">
                                    <strong>Lorem Ipsum</strong>
                                    <br>
                                    <div class="badge badge-success">3.6</div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="col-12 culinary">
                            <div class="row">
                                <div class="col-4">
                                    <img class="img-responsive mt-auto" src="https://placeimg.com/640/480/nature">
                                </div>
                                <div class="col-8">
                                    <strong>Lorem Ipsum</strong>
                                    <br>
                                    <div class="badge badge-success">3.6</div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="col-12 culinary">
                            <div class="row">
                                <div class="col-4">
                                    <img class="img-responsive mt-auto" src="https://placeimg.com/640/480/nature">
                                </div>
                                <div class="col-8">
                                    <strong>Lorem Ipsum</strong>
                                    <br>
                                    <div class="badge badge-success">3.6</div>
                                </div>
                            </div>
                        </a>
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
                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">List group item heading</h5>
                            <small>3 days ago</small>
                        </div>
                        <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                        <small>Donec id elit non mi porta.</small>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">List group item heading</h5>
                            <small class="text-muted">3 days ago</small>
                        </div>
                        <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                        <small class="text-muted">Donec id elit non mi porta.</small>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">List group item heading</h5>
                            <small class="text-muted">3 days ago</small>
                        </div>
                        <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                        <small class="text-muted">Donec id elit non mi porta.</small>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
<?php

    endif; // End of the loop.

get_footer();
?>

