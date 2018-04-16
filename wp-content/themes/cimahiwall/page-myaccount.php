<?php
/**
 * Template Name: My Account
 * The template for displaying My Account
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

get_header();

?>

    <!-- Content Starts -->
    <?php get_template_part('template-parts/content', 'edit_account'); ?>
    <!-- Content Ends -->

<?php
get_footer();
?>

