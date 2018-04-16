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
            </h4>
            <div class="meta">
                <?php
                $place_categories = wp_get_post_terms($post->ID, 'place_category');
                if( ! empty($place_categories)) {
                    foreach ($place_categories as $place_category) :
                        ?>
                        <a href="<?php echo get_term_link($place_category->term_id); ?>" class="badge">
                            <?php echo $place_category->name; ?>
                        </a>
                        <?php
                    endforeach;
                }
                ?>
            </div>
        </div>
    </div>
</div>

