<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */

?>
<?php if(!is_page_template( 'blank-page.php' ) && !is_page_template( 'blank-page-with-container.php' )): ?>
    <?php get_template_part( 'footer-widget' ); ?>
	<footer id="colophon" class="site-footer bg-white" role="contentinfo">
		<div class="container-fluid p-3 p-md-5">
            <div class="site-info">
                <?php echo '<a href="'.home_url().'">'.get_bloginfo('name').'</a>'; ?> &copy; <?php echo date('Y'); ?>
                All rights reserved
            </div><!-- close .site-info -->
		</div>
	</footer><!-- #colophon -->
<?php endif; ?>
</div><!-- #page -->

<?php echo get_num_queries(); ?> queries in <?php timer_stop(1); ?>

<?php wp_footer(); ?>
</body>
</html>
