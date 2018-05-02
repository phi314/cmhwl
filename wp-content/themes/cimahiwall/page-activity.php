<?php
/**
 * Template Name: Activity Page
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
        set_query_var('user_id', get_current_user_id());
        set_query_var('activity_mode', (isset($_GET['everyone']) ? 'everyone' : 'friend') );
        get_template_part('template-parts/content-social', 'activity-list');
    ?>
</div>

<?php
get_footer();
?>

