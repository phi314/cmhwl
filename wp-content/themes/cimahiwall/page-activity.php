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

<div class="container mt-3">
    <?php
        set_query_var('all_user', true);
        get_template_part('template-parts/content-social', 'activity');
    ?>
</div>

<?php
get_footer();
?>

