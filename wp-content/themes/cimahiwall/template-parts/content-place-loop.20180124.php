<?php
/**
 * Template part for displaying loop places
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

global $post;

$google_place = get_post_meta(get_the_ID(), 'google_place_json', true);
$google_place = $google_place->result;

if( ! empty( $google_place ))
{
    $lat = $google_place->geometry->location->lat;
    $lng = $google_place->geometry->location->lng;
}

?>

<div id="place-<?php the_ID(); ?>" class="place col-md-4 marker" data-lat="<?php echo $lat; ?>" data-lng="<?php echo $lng; ?>">
    <div class="d-none">
        <div class="place-permalink"><?php echo get_permalink(); ?>"</div>
        <div class="place-address"><?php echo $google_place->formatted_address; ?></div>
        <div class="place-phone"><?php echo $google_place->formatted_phone_number; ?></div>
    </div>
    <div class="card card-01">
        <?php
            $image = get_featured_post_image(get_the_ID(), 'place');
        ?>
        <a href="<?php echo get_permalink(); ?>" class="card-img-top" style="background: url('<?php echo $image; ?>')">
            <?php if( is_sticky() ) : ?>
                <div class="badge text-white p-2"><i class="fa fa-leaf"></i> Featured</div>
            <?php endif; ?>
        </a>
        <div class="card-body">
            <a href="<?php echo get_permalink(); ?>"><h2 class="card-title"><strong><?php echo get_the_title(); ?></strong></h2></a>
            <p class="card-text text-faded">
                <?php
                    $excerpt = get_the_excerpt();

                    if( empty($excerpt) )
                        $excerpt = get_the_content();

                    echo strlen($excerpt) < 65 ? $excerpt : substr($excerpt, 0, 65) . '...';
                ?>
            </p>
            <div class="badge badge-success" title="<?php echo get_comment_count(get_the_ID())['approved']; ?> Review"><?php echo cimahiwall_get_average_rating(get_the_ID()); ?></div>
            <small>
                <?php
                $place_categories = wp_get_post_terms($post->ID, 'place_category');
                if( ! empty($place_categories[0])) {
                ?>
                    <a class="text-faded" href="<?php echo get_term_link($place_categories[0]->term_id); ?>">
                        <?php echo $place_categories[0]->name; ?>
                    </a>
                <?php
                }
                ?>
            </small>
            <div class="card-tools pull-right">
                <a href="#" class="text-faded" data-toggle="tooltip" data-placement="top" title="Navigasi kesana"><i class="fa fa-road"></i></a>
                <a href="#" class="text-faded" data-toggle="tooltip" data-placement="top" title="Lihat map"><i class="fa fa-map-o"></i></a>
                <a href="#"><i class="fa fa-heart-o"></i></a>
            </div>
        </div>
    </div>
</div>
