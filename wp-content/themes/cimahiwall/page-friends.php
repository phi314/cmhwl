<?php
/**
 * Template Name: Friends Page
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
        set_query_var('user_id', get_current_user_id());
        get_template_part('template-parts/content-social', 'friend-list');
    ?>
</div>

<?php
get_footer();
?>

