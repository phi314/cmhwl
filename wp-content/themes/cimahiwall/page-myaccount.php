<?php
/**
 * Template Name: My Account
 * The template for displaying My Account
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

get_header();

global $current_user;
?>

<div class="">
    <!-- UI - X Starts -->
    <div class="ui-67">

        <!-- Head Starts -->
        <div class="ui-head bg-lblue">
            <!-- Details -->
            <div class="ui-details">
                <!-- Name -->
                <h3 id="name-header"><?php echo $current_user->display_name; ?></h3>
                <!-- Designation -->
                <div class="d-flex text-white">
                    <ul class="list-inline mx-auto justify-content-center" id="inline-category">
                        <li class="list-inline-item">
                            <a href="<?php echo home_url('my-account'); ?>">Profil</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="<?php echo home_url('my-favorites'); ?>">Favorites</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Image -->
            <div class="ui-image">
                <!-- User Image -->
                <?php echo get_avatar( $current_user->ID, 100, '', $current_user->display_name ); ?>
            </div>
        </div>
        <!-- Head Ends -->

        <!-- Content Starts -->
        <?php get_template_part('template-parts/content', 'edit_account'); ?>
        <!-- Content Ends -->
    </div>
    <!-- UI - X Ends -->
</div>

    <?php
    get_footer();
    ?>

