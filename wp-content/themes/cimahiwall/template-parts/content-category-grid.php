<?php
/**
 * Created by Customy.
 * User: Indosoft
 * Date: 5/17/2018
 * Time: 3:10 PM
 */
?>
<section id="featured-category">
    <div class="container py-4">
        <div class="text-center mb-4">
            <h4 class="section-heading">Here's come the category!</h4>
        </div>
        <div class="row">
            <?php
            $place_categories = get_terms([
                'taxonomy' => 'place_category',
                'hide_empty' => false,
                'parent' => 0
            ]);
            foreach ($place_categories as $place_category) :
                $place_count = $place_category->count;
                $place_category_childs = get_term_children( $place_category->term_id, 'place_category' );
                foreach( $place_category_childs as $place_category_child_temp) {
                    $place_category_child = get_term( $place_category_child_temp , 'place_category');
                    $place_count += $place_category_child->count;
                }
                ?>

                <div class="col-6 col-sm-2">
                    <a class="featured-box featured-center" href="<?php echo get_term_link($place_category->term_id, 'place_category'); ?>">
                        <div class="featured-icon border-icon">
                            <p class="timer text-primary" data-to="<?php echo $place_count; ?>" data-speed="3000"><?php echo $place_category->count; ?></p>
                        </div>
                        <div class="featured-content">
                            <p><?php echo $place_category->name; ?></p>
                        </div>
                    </a>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
</section>
