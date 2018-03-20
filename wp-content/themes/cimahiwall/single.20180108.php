<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WP_Bootstrap_Starter
 */

    get_header();

    while ( have_posts() ) : the_post();


?>

    <section class="full-width-background text-white" style="background: url('<?php echo get_template_directory_uri() . '/inc/assets/images/category/1.jpg'; ?>');">
        <div class="container text-center">
            <p>28 Desember 2017 &centerdot; Traveling </p>
            <h1 class="mb-4 text-white">Kelurahan Kecamatan</h1>
        </div>
    </section>

    <div class="bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <section id="primary" class="content-area">
                        <main id="main" class="site-main p-4 card" role="main">

                            <?php

                            get_template_part( 'template-parts/content', get_post_format() );

                            the_post_navigation();

                            ?>

                        </main><!-- #main -->

                        <?php

                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;

                        ?>

                    </section><!-- #primary -->

                </div>
                <div class="col-md-4">

                    <h2>Di Posting oleh</h2>
                    <div class="avatar" style="background-image: url('<?php echo get_template_directory_uri() . '/inc/assets/images/header.jpg'; ?>')"></div>
                    <sub class="text-white">Posted by <a href="#"><strong>Arief Wibowo</strong></a></sub>
                    <p>
                        <a href="https://instagram.com/rriev" class="text-white"><i class="fa fa-instagram"></i></a>
                    </p>

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
    </div>
<?php
    endwhile; // End of the loop.

get_footer();
?>

