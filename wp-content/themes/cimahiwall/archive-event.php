<?php
/**
 * The template for displaying archive place
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */


get_header(); ?>
<!-- Header -->
<?php

$featured_events = new WP_Query([
    'post_type' => 'event',
    'posts_per_page' => -1,
    'tax_query' => [
        [
            'taxonomy' => 'event_category',
            'field'    => 'slug',
            'terms'    => 'promo-pilihan'
        ]
    ]
]);

if( $featured_events->have_posts() ) :

    $featured_event_count = $featured_events->post_count;
    ?>
    <div id="header-light-slider" class="carousel slide">
        <div id="carousel-area">
            <div id="carousel-slider" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php for ($i = 0; $i <= $featured_event_count; $i++) : ?>
                        <li data-target="#carousel-slider" data-slide-to="<?php echo $i; ?>" class="<?php echo $i == 0 ? 'active' : ''; ?>"></li>
                    <?php endfor;?>
                </ol>
                <div class="carousel-inner" role="listbox">
    <?php
    $i = 0;
    while( $featured_events->have_posts() ) : $featured_events->the_post();
        $event_id = get_the_ID();
        $locations = get_field('location');
        ?>
                    <div class="carousel-item active" style="background: url('<?php echo get_featured_post_image( $event_id, 'event'); ?>')">
                        <div class="carousel-caption">
                            <h3 class="slide-title animated fadeInDown"><?php the_title(); ?></h3>
                            <h5 class="slide-text animated fadeIn"><?php echo get_event_time(); ?></h5>
                            <a href="<?php echo get_term_link(116); ?>" class="btn btn-lg btn-default-filled animated fadeInUp">Cek Disini</a>
                        </div>
                    </div>
    <?php endwhile; ?>

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
<?php
endif;
wp_reset_postdata();
?>

    <!-- /. Header -->

	<div id="primary" class="bg-gray">
		<main id="main" class="site-main container pt-4" role="main">

            <div class="row">
                <div class="col-12">
                    <h3 class="text-center">
                        EVENT
                    </h3>
                    <?php
                    if ( have_posts() ) : ?>


                    <div class="row mt-4 list-events">

                        <?php
                        /* Start the Loop */
                        while ( have_posts() ) : the_post();

                            /*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            get_template_part( 'template-parts/content', 'event-loop' );

                        endwhile;

                        ?>

                        <?php

                    else :

                        get_template_part( 'template-parts/content', 'none-place' );
                    ?>


                    </div>

                    <?php endif; ?>

                </div>

                <?php cimahiwall_pagination(); ?>

            </div>

		</main><!-- #main -->

        <!-- All Category -->
        <section id="featured-category">
            <div class="container py-4">
                <div class="text-center mb-4">
                    <h3>BRANDS</h3>
                </div>
                <div class="row">
                    <?php
                    $place_categories = get_terms([
                        'taxonomy' => 'brand',
                        'hide_empty' => false,
                        'parent' => 0
                    ]);
                    foreach ($place_categories as $place_category) :
                        ?>

                        <div class="col-6 col-sm-3">
                            <a class="featured-box featured-center" href="<?php echo get_term_link($place_category->term_id); ?>">
                                <div class="featured-icon border-icon">
                                    <img src="<?php echo get_featured_post_image(1); ?>" class="img-fluid">
                                </div>
                            </a>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <!-- /. All Category -->

	</div><!-- #primary -->

<?php
get_footer();
