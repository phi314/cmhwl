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
        $post_category = wp_get_post_terms(get_the_ID(), 'category' );
        $image = get_featured_post_image(get_the_ID(), 'post');

        ?>

    <!-- Headers Start -->
    <div id="headers">
        <!-- Light header -->
        <header id="header-style-1" style="background: url('<?php echo $image; ?>') fixed center;" class="header-half">
            <div class="container">
                <div class="header-caption">
                    <div class="row">
                        <div class="col-md-12 header-content">
                            <h3 class="header-title animated fadeInDown"><?php echo get_the_title(); ?></h3>
                            <h5 class="header-text animated fadeIn">
                                <?php echo get_the_date(); ?> &centerdot; <?php if(! empty($post_category[0])) echo $post_category[0]->name; ?>
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

                            <div class="row border-top pt-3">
                                <div class="col-3">
                                    <?php echo get_avatar( get_the_author_meta('user_email'), 150); ?>
                                </div>
                                <div class="col-9">
                                    <a href="<?php echo home_url('profile/' . get_the_author_meta('user_nicename')); ?>">
                                        <h4><?php echo get_the_author_meta('display_name'); ?></h4>
                                    </a>
                                    <p><?php echo get_the_author_meta('description'); ?></p>
                                </div>
                            </div>

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
                        <?php dynamic_sidebar( 'sidebar-1' ); ?>
                    </aside>
                </div>

            </div>
        </div>
    </div>
<?php
    endif; // End of the loop.

get_footer();
?>

