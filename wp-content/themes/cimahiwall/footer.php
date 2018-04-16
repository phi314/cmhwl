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
</div><!-- #page -->

<?php if(!is_page_template( 'blank-page.php' ) && !is_page_template( 'blank-page-with-container.php' )): ?>
    <?php get_template_part( 'footer-widget' ); ?>
    <footer class="default-footer text-center">
        <div class="container">
            <span class="copy-right dis-blk">
                 <?php echo '<a href="'.home_url().'">'.get_bloginfo('name').'</a>'; ?> &copy; <?php echo date('Y'); ?>
                All rights reserved
            </span>
            <span class="social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-google-plus"></i></a>
            <a href="#"><i class="fa fa-pinterest"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="#"><i class="fa fa-dribbble"></i></a>
          </span>
        </div>
    </footer>
<?php endif; ?>


<?php echo get_num_queries(); ?> queries in <?php timer_stop(1); ?>

<?php wp_footer(); ?>
</body>
</html>
