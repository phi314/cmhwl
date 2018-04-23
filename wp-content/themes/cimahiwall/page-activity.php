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

    <!-- Nav tabs -->
    <div id="default-tab">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link <?php echo isset( $_GET['everyone'] ) ? '' : 'active'; ?>" href="<?php echo home_url('activity'); ?>" ><?php _e('Friends', 'cimahiwall'); ?></a></li>
            <li class="nav-item"><a class="nav-link <?php echo isset( $_GET['everyone'] ) ? 'active' : ''; ?>" href="<?php echo home_url('activity?everyone=true'); ?>"><?php _e('Everyone', 'cimahiwall'); ?></a></li>
        </ul>
    </div>

    <?php
        set_query_var('all_user', true);
        get_template_part('template-parts/content-social', 'activity');
    ?>
</div>

<?php
get_footer();
?>

