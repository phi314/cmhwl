<?php
/**
 * The template for displaying archive place
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

get_header();

?>

    <section id="top-map"></section>

	<div id="primary" class="bg-gray">
		<main id="main" class="site-main container pt-4" role="main">

            <h3 class="text-center">
                <?php do_action('cimahiwall_place_archive_title'); ?>
            </h3>

            <div class="mb-4"></div>

            <?php get_template_part('template-parts/form', 'search-place'); ?>

            <?php
            if ( have_posts() ) : ?>


            <div class="row mt-4 list-places">

                    <?php
                    /* Start the Loop */
                    while ( have_posts() ) : the_post();

                        /*
                         * Include the Post-Format-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                         */
                        get_template_part( 'template-parts/content', 'place-loop' );

                    endwhile;

//                    the_posts_navigation();

                    ?>


                <?php

                else :

                    get_template_part( 'template-parts/content', 'none-place' );

                endif; ?>

            </div>

            <?php cimahiwall_pagination(); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
