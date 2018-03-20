<?php
/**
 * Template Name: My Favorites
 */

get_header(); ?>

    <section id="top-map"></section>

	<div id="primary" class="container">
        <div class="row">
            <div class="col-md-8">
                <main id="main" class="site-main container pt-4" role="main">

                    <?php
                    $place_favorites = get_user_favorites();

                    if ( ! empty($place_favorites) ) : ?>

                    <h3>
                        <?php _e("Lokasi", 'cimahiwall'); ?>
                    </h3>

                    <div class="mb-4"></div>

                    <div class="row mt-4 list-places">

                        <?php
                        /* Start the Loop */
                        $place_favorites = new WP_Query([
                            'post_type' => 'place',
                            'post__in' => $place_favorites
                        ]);

                        while ( $place_favorites->have_posts() ) : $place_favorites->the_post();

                            /*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            set_query_var( 'place_loop_column', 'col-md-6' );
                            get_template_part( 'template-parts/content', 'place-loop' );

                        endwhile;

                        wp_reset_postdata();

                        ?>


                        <?php

                        else :

                            get_template_part( 'template-parts/content', 'none-favorites' );

                        endif; ?>

                    </div>

                    <?php cimahiwall_pagination(); ?>

                </main><!-- #main -->
            </div>
            <div class="col-md-4 pt-4">
                <h3>
                    <?php _e("Event", 'cimahiwall'); ?>
                </h3>
            </div>
        </div>
	</div><!-- #primary -->

<?php
get_footer();
