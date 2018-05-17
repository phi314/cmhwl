<?php
/**
 * Created by Customy.
 * User: Indosoft
 * Date: 5/17/2018
 * Time: 2:35 PM
 */

?>

<div class="col-md-3">
    <h3 class="text-center mb-5">
        Brand
    </h3>
    <div class="row brand-list">
        <?php
        $place_categories = get_terms([
            'taxonomy' => 'brand',
            'hide_empty' => false,
            'parent' => 0
        ]);
        foreach ($place_categories as $place_category) :
            ?>

            <div class="col-12">
                <a class="featured-box featured-center" href="<?php echo get_term_link($place_category->term_id); ?>">
                    <div class="featured-icon border-icon">
                        <img src="<?php echo get_category_image( $place_category->term_id, 'brand'); ?>" class="img-brand">
                    </div>
                </a>
            </div>

        <?php endforeach; ?>
    </div>
</div>
