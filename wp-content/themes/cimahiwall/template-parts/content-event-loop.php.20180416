<?php
/**
 * Template part for displaying loop places
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

global $post;

$event_loop_column = empty($event_loop_column) ? 'col-md-4' : $event_loop_column;
$image = get_featured_post_image(get_the_ID(), 'place');

/*
 * Initialize Zomato
 */
$zomato_place = get_post_meta($post->ID, 'zomato_place_json', true);

/*
 * Place have food
 */
$price_range = get_field('price_range');
$cuisines = get_field('cuisines');
if( ! empty( $zomato_place )) {
    $price_range = $zomato_place->price_range;
    $cuisines = $zomato_place->cuisines;
}

$locations = get_field('location');

?>

<div id="place-<?php the_ID(); ?>" class="place <?php echo $event_loop_column; ?>">
    <div class="card-2">
        <a href="<?php echo get_permalink(); ?>">
            <?php if( is_sticky() ) : ?>
                <div class="label label-featured"><i class="fa fa-leaf"></i> Featured</div>
            <?php endif; ?>
            <div class="image" style="background: url('<?php echo $image; ?>')"></div>
        </a>
        <div class="card-block">

            <small>
                <?php echo get_event_time( $post->ID ); ?>
            </small>

            <h3 class="card-title">
                <a href="<?php echo get_permalink(); ?>">
                    <?php echo get_the_title(); ?>
                </a>
                <small class="text-muted">
                    <?php if( ! empty($price_range)) for ($i = 1; $i <= $price_range; $i++) echo "$" ?>
                </small>
            </h3>
            <div class="meta">
                <?php
                $place_categories = wp_get_post_terms($post->ID, 'place_category');
                if( ! empty($place_categories[0])) {
                    ?>
                    <a href="<?php echo get_term_link($place_categories[0]->term_id); ?>">
                        <?php echo $place_categories[0]->name; ?>
                    </a>
                    <?php
                }
                ?>
            </div>
            <div class="description">
                <?php if (! empty($locations)) : ?>
                <!-- Event Location -->
                <div>
                    <ul class="list-style arrow-list arrow-list-four pl-0">
                        <?php
                        foreach ($locations as $location) :
                        ?>
                            <li>
                                <i class="fa fa-chevron-right" aria-hidden="true"></i><a href="<?php echo get_permalink($location->ID); ?>"><?php echo $location->post_title; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
                <!-- /. Event Location -->


                <?php the_favorites_button(); ?>

                <?php the_excerpt(); ?>
            </div>
        </div>
        <div class="extra">
            <span class="right">
                <a href="#" class="text-faded" data-toggle="tooltip" data-placement="top" title="Navigasi kesana"><i class="fa fa-road"></i></a>
                <a href="#" class="text-faded" data-toggle="tooltip" data-placement="top" title="Lihat map"><i class="fa fa-map-o"></i></a>
            </span>
            <span class="text-primary">
                <i class="fa fa-money"></i>
                <?php echo get_event_price(); ?>
            </span>
        </div>
    </div>
</div>

