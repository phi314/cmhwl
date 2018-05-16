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
                            <h3 class="header-title animated fadeInDown">Article & Tips</h3>
                            <div class="mb-3"></div>
                            <div class="d-flex text-white">
                                <ul class="list-inline mx-auto justify-content-center" id="inline-category">
                                    <li class="list-inline-item">
                                        <a href="<?php echo home_url('blog'); ?>">Blog</a>
                                    </li>
                                    <?php
                                    $page_category = get_the_category();
                                    $page_category_id = [];
                                    if (! empty( $page_category[0]) ) {
                                        $page_category_id = $page_category[0]->term_id;
                                    }
                                    $categories = get_categories();
                                    $category_active = "";
                                    foreach ($categories as $category) :
                                        if( is_category() ) {
                                            $category_active = $category->term_id == $page_category_id ? 'active' : '';
                                        }
                                        ?>
                                        <li class="list-inline-item <?php echo $category_active; ?>">
                                            <a href="<?php echo get_term_link($category->term_id); ?>">
                                                <?php echo $category->name; ?>
                                            </a>
                                        </li>
                                        <?php
                                    endforeach;
                                    ?>
                                </ul>
                            </div>
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

