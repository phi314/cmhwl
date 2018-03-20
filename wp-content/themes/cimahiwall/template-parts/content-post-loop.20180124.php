<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

$featured_post_category = wp_get_post_terms( get_the_ID(), 'category' );
$featured_post_author = get_the_author_meta('nicename');

?>

<div class="col-lg-4 col-sm-6">
    <a class="portfolio-box portfolio-box-blog" href="<?php echo get_permalink(); ?>" style="background: url('<?php echo get_the_post_thumbnail_url($featured_post->ID); ?>');">
        <div class="portfolio-box-caption">
            <div class="portfolio-box-caption-content">
                <small>
                    <?php if(! empty($featured_post_category[0])) echo $featured_post_category[0]->name; ?>
                    <?php if( is_sticky() ) : ?>
                        <div class="badge text-white p-2"><i class="fa fa-leaf"></i> Featured</div>
                    <?php endif; ?>
                </small>
                <h3><?php echo get_the_title(); ?></h3>
                <p>
                    <?php echo get_the_excerpt(); ?>
                </p>
                <sup><i class="fa fa-user"></i> <?php echo $featured_post_author; ?></sup>
            </div>
        </div>
    </a>
</div>