<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WP_Bootstrap_Starter
 */
    get_header();

?>

    <div id="headers">
        <!-- Light header -->
        <header id="header-style-1" class="header-half" style="background-image: url('<?php echo get_template_directory_uri() . '/inc/assets/images/header.jpg'; ?>');">
            <div class="container">
                <div class="header-caption">
                    <div class="row">
                        <div class="col-md-12 header-content">
                            <h1 class="header-title animated fadeInDown"><?php echo single_cat_title(); ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </div>

    <div class="bg-gray pt-5">
        <div class="container">

            <?php if( have_posts() ) : ?>

            <div class="row">
                <?php
                while ( have_posts() ) : the_post();

                    set_query_var('event_loop_column', 'col-md-3');
                    get_template_part( 'template-parts/content', get_post_type() . '-loop' );

                endwhile; // End of the loop.

                wp_reset_postdata(); // Don't forget to reset

                ?>
            </div>

            <?php else :

                get_template_part( 'template-parts/content', 'none' );

            endif; ?>

        </div>
    </div>

    <?php cimahiwall_pagination(); ?>


<?php

get_footer();
?>

