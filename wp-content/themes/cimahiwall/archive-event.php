<?php
/**
 * The template for displaying archive place
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */


get_header(); ?>

<?php

    $sticky = get_option( 'sticky_posts' );
    $featured_events = new WP_Query([
            'post_type' => 'event',
            'posts_per_page' => -1,
            'post__in' => $sticky
    ]);

    if( $featured_events->have_posts() ) :

        $featured_event_count = $featured_events->post_count;
?>

    <div id="header-light-slider">
        <div id="carousel-area">
            <div id="carousel-slider" class="carousel slide" data-ride="carousel" data-interval="3000" data-pause="false">
                <?php if( $featured_event_count > 1 ) : ?>
                <ol class="carousel-indicators">
                    <?php for ($i = 0; $i <= $featured_event_count; $i++) : ?>
                    <li data-target="#carousel-slider" data-slide-to="<?php echo $i; ?>" class="<?php echo $i == 0 ? 'active' : ''; ?>"></li>
                    <?php endfor;?>
                </ol>
                <?php endif; ?>

                <div class="carousel-inner" role="listbox">
                    <?php
                    $i = 0;
                    while( $featured_events->have_posts() ) : $featured_events->the_post();
                        $event_id = get_the_ID();
                        $locations = get_field('location');
                        ?>
                    <div class="carousel-item <?php echo $i++ == 0 ? 'active' : ''; ?>" style="background: url('<?php echo get_featured_post_image( $event_id, 'event'); ?>')">
                        <div class="row text-white">
                            <div class="col-xs-12 col-sm-6">
                            </div>
                            <div class="col-xs-12 col-sm-5">
                                <div class="hero-content-v2">
                                    <small class="badge bg-success">
                                        <?php echo get_event_price(); ?>
                                    </small>
                                    <div class="mb-2"></div>
                                    <h5><?php echo get_event_time(); ?> </h5>
                                    <h3><strong><?php echo get_the_title(); ?></strong></h3>

                                    <?php if (! empty($locations)) : ?>
                                        <!-- Event Location -->
                                        <h5>

                                            <ul class="list-inline mx-auto justify-content-center" id="inline-category">
                                            <?php foreach ($locations as $location) : ?>
                                                <li class="list-inline-item">
                                                    <a href="<?php echo get_permalink($location->ID); ?>"><?php echo $location->post_title; ?></a>
                                                </li>
                                            <?php endforeach; ?>
                                            </ul>
                                        </h5>
                                    <?php endif; ?>
                                    <!-- /. Event Location -->

                                    <p class="label bg-danger">
                                        <a href="<?php echo get_permalink( $event_id ); ?>" class="text-white">
                                            Detail <i class="fa fa-arrow-right"></i>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>

                </div>


                <?php if( $featured_event_count > 1 ) : ?>
                    <a class="carousel-control-prev" href="#carousel-slider" role="button" data-slide="prev">
                        <span class="carousel-control carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel-slider" role="button" data-slide="next">
                        <span class="carousel-control carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php
    endif;
    wp_reset_postdata();
?>

	<div id="primary" class="bg-gray">
		<main id="main" class="site-main container pt-4" role="main">

            <div class="row">
                <!-- List Month -->
                <div class="col-12 col-md-3">
                    <?php
                    $archive_month = ! empty($_GET['month']) ? $_GET['month'] : date('m');
                    for( $i = 1; $i <= 12; $i++ ) :
                        $month = date('F', mktime(0,0,0,$i, 1, date('Y')));
                        $month_number = sprintf("%02d", $i);
                        ?>
                        <?php if( $archive_month != $month_number ) : ?>
                                <a class="btn btn-sm btn-common btn-block" href="<?php echo home_url('event/?month=' . $month_number); ?>">
                                    <?php echo $month; ?>
                                </a>
                        <?php else: ?>
                            <span class="btn btn-sm  btn-block btn-filled"><?php echo $month; ?></span>
                         <?php endif; ?>
                    <?php endfor; ?>

                    <div class="mb-3"></div>
                </div>
                <!-- /. List Month -->

                <div class="col-12 col-md-9">
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

                    <?php cimahiwall_pagination(); ?>
                </div>
            </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
