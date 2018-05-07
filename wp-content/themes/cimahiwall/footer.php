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
                <a href="#"><i class="fa fa-instagram"></i></a>
            </span>

            <ul class="nav nav-inline  justify-content-center mt-3">
                <li class="nav-item">
                    <a class="nav-link active" href="#"><?php _e('Feedback', 'cimahiwall'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" target="__blank" href="https://goo.gl/xVZZ89"><?php _e('Submit a location'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><?php _e('Policy' ,'cimahiwall'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><?php _e('Blog' ,'cimahiwall'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><?php _e('Terms', 'cimahiwall'); ?></a>
                </li>
            </ul>

            <div class="clearfix"></div>
            <sub class="dis-blk pt-2">
                <?php echo get_num_queries(); ?> queries in <?php timer_stop(1); ?>
            </sub>

        </div>
    </footer>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
