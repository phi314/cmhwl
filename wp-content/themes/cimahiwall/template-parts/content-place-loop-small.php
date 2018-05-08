<?php
/**
 * Created by Customy.
 * User: Indosoft
 * Date: 5/8/2018
 * Time: 2:42 PM
 */

$show_distance = get_query_var('show_distance');
$post_id = get_the_ID();

?>

<div class="blog-post-small">
    <a href="<?php echo get_permalink(); ?>" class="blog-post-small-image" style="background: url('<?php echo get_featured_post_image(); ?>')"></a>
    <a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a>
    <br>
    <?php if( $show_distance ) : ?>
        <div class="badge badge-success"><?php echo format_distance(get_the_distance()); ?></div>
    <?php endif; ?>
    <p>
        <?php
        $place_categories = wp_get_post_terms($post_id, 'place_category');
        if( ! empty($place_categories[0])) {
            echo  $place_categories[0]->name;
        }
        ?>
    </p>
</div>
