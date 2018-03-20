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
        $post_id = get_the_ID();
        $post_category = wp_get_post_terms($post_id, 'event_category' );
        $image = get_featured_post_image($post_id, 'event');
        $start_datetime = get_post_meta( $post_id, 'cimahiwall_field_start_datetime', 1);
        $end_datetime = get_post_meta( $post_id, 'cimahiwall_field_end_datetime', 1);

        ?>

    <!-- Headers Start -->
    <div id="headers">
        <!-- Light header -->
        <header id="header-style-1" style="background: url('<?php echo $image; ?>') fixed center;" class="header-single">
            <div class="container">
                <div class="header-caption">
                    <div class="row">
                        <div class="col-md-12 header-content">
                            <h3 class="header-title animated fadeInDown"><?php echo get_the_title(); ?></h3>
                            <h5 class="header-text animated fadeIn">
                                <?php echo get_event_time(); ?>
                                <?php if(! empty($post_category[0])) echo ' &centerdot; ' . $post_category[0]->name; ?>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </div>
    <!-- Headers End -->

    <div class="mb-60"></div>

    <div class="bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <section id="primary" class="content-area">
                        <main id="main" class="site-main p-4" role="main">

                            <?php

                            get_template_part( 'template-parts/content', get_post_format() );

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
                    <aside id="sidebar-post">
                        <?php dynamic_sidebar( 'sidebar-event' ); ?>
                    </aside>
                </div>

            </div>
        </div>
    </div>
<?php
    endif; // End of the loop.

get_footer();
?>

