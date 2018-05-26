<?php
/**
 * Template Name: Front Page
 */

get_header('front'); ?>

    <!-- Featured Category -->
    <div class="container py-4">
        <div class="text-center mb-4">
            <h4 class="section-heading"><?php _e('Featured category', 'cimahiwall'); ?></h4>
        </div>
        <div class="row mt-5">
            <?php
            $featured_place_categories = get_field('featured_place_categories');
            foreach ($featured_place_categories as $featured_place_category) :
                $place_category = get_term($featured_place_category);
                ?>
                <div class="col-6 col-sm-2 mt-2">
                    <a class="featured-box featured-center"
                       href="<?php echo get_term_link($place_category->term_id, 'place_category'); ?>">
                        <div class="featured-icon border-icon">
                            <p class="text-primary">
                                <i class="<?php echo get_category_icon($place_category->term_id, 'place_category'); ?>"></i>
                            </p>
                        </div>
                        <div class="featured-content">
                            <p><?php echo $place_category->name; ?></p>
                        </div>
                    </a>
                </div>
            <?php
            endforeach;
            ?>
        </div>
    </div>

    <!-- All Category -->
    <?php get_template_part('template-parts/content', 'category-grid'); ?>
    <!-- /. All Category -->

    <div class="mb-30"></div>

<?php
get_footer();
