<?php
/**
 * Template part for displaying loop places
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

global $post;

$location = get_field('cimahiwall_place_location');
$location_lat = ! empty($location['lat']) ? $location['lat'] : '';
$location_lng = ! empty($location['lng']) ? $location['lng'] : '';
$google_place = get_post_meta(get_the_ID(), 'google_place_json', true);
$google_place = $google_place->result;
if( ! empty( $google_place ))
{
    $location_lat = $google_place->geometry->location->lat;
    $location_lng = $google_place->geometry->location->lng;
}

$place_loop_column = empty($place_loop_column) ? 'col-md-4' : $place_loop_column;
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

?>

<div id="place-<?php the_ID(); ?>" class="place <?php echo $place_loop_column; ?> marker" data-lat="<?php echo $location_lat; ?>" data-lng="<?php echo $location_lng; ?>">
    <div class="row">
        <div class="col-4 col-md-12">

            <div class="d-none">
                <div class="place-permalink"><?php echo get_permalink(); ?>"</div>
                <div class="place-address"><?php echo $google_place->formatted_address; ?></div>
                <div class="place-phone"><?php echo $google_place->formatted_phone_number; ?></div>
            </div>

            <a href="<?php echo get_permalink(); ?>">
                <div class="image" style="background: url('<?php echo $image; ?>')"></div>
            </a>
        </div>
        <div class="col-8 col-md-12 place-desc">

            <h4 class="card-title">
                <a href="<?php echo get_permalink(); ?>" class="text-secondary">
                    <?php echo get_the_title(); ?>
                </a>
                <br>
                <small class="text-muted">
                    <?php if( ! empty($price_range)) for ($i = 1; $i <= $price_range; $i++) echo "$" ?>
                </small>
            </h4>
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
        </div>
    </div>
</div>

