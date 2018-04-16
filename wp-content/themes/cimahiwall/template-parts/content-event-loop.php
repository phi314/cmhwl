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
$locations = get_field('location');

?>

<div id="place-<?php the_ID(); ?>" class="place <?php echo $event_loop_column; ?>">
    <div class="row">
        <div class="col-4 col-md-12">
            <a href="<?php echo get_permalink(); ?>">
                <div class="image" style="background: url('<?php echo $image; ?>')"></div>
            </a>
        </div>
        <div class="col-8 col-md-12">
            <small>
                <?php echo get_event_time( $post->ID ); ?>
            </small>

            <h3 class="card-title">
                <a href="<?php echo get_permalink(); ?>">
                    <?php echo get_the_title(); ?>
                </a>
                <br>
                <small class="text-muted">
                    <i class="fa fa-money"></i> <?php echo get_event_price(); ?>
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
            <span class="text-primary">

            </span>

        </div>
    </div>
</div>

