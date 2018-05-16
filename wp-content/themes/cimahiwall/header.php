<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="wrapper">

    <?php if( !is_user_logged_in()) : ?>
        <div class="top-menu">
            <p>
                <a href="mailto:info@cimahiwall.com"><i class="fa fa-envelope"></i> info@cimahiwall.com</a>
                <a href="<?php echo home_url('login'); ?>" class="d-block float-right"><i class="fa fa-lock"></i> Sign In</a>
                <a href="<?php echo home_url('login/?action=register'); ?>" class="d-block float-right"><i class="fa fa-pencil"></i> Register</a>
            </p>
        </div>
    <?php endif; ?>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-sm navbar-light bg-black">
        <div class="container">
            <a class="navbar-brand" href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri() . '/inc/assets/images/cimahiwall_logo_white.png'; ?>" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i>
            </button>
                <?php
                wp_nav_menu(array(
                    'theme_location'    => 'primary',
                    'container'       => 'div',
                    'container_id'    => 'navbarCollapse',
                    'container_class' => 'collapse navbar-collapse justify-content-end',
                    'menu_id'         => false,
                    'menu_class'      => 'navbar-nav',
                    'depth'           => 3,
                    'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
                    'walker'          => new wp_bootstrap_navwalker()
                ));

                $post_type = get_queried_object()->name;
                if( ! empty($_GET['mahiwal_type'])) {
                    $post_type = $_GET['mahiwal_type'];
                }
                elseif( is_tax() ) {
                    $post_type = get_queried_object()->taxonomy;
                    if( in_array($post_type, ['city', 'area', 'place_category']))
                        $post_type = 'place';
                }

                ?>
                <form action="<?php echo home_url(); ?>" class="form-inline d-none d-sm-block">
                    <div class="top_search_con">
                        <input name="s" class="form-control mr-sm-2" placeholder="Search Here ..." type="text">
                        <input name="mahiwal_type" type="hidden" value="<?php echo $post_type; ?>">
                    </div>
                </form>
        </div>
    </nav>
