<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

global $post;

$featured_post_category = wp_get_post_terms( get_the_ID(), 'category' );
$featured_post_author = get_the_author_meta('display_name');

?>

<div class="col-md-4">
    <a class="portfolio-box portfolio-box-blog" href="<?php echo get_permalink(); ?>" style="background: url('<?php echo get_the_post_thumbnail_url($post->ID); ?>');">
        <div class="portfolio-box-caption">
            <div class="portfolio-box-caption-content">
                <?php if(! empty($featured_post_category[0])) echo $featured_post_category[0]->name; ?>
                <h5 class="d-block py-2"><?php echo $post->post_title; ?></h5>
                <sup><i class="fa fa-user"></i> <?php echo $featured_post_author; ?></sup>
            </div>
        </div>
    </a>
</div>