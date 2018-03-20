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
<div id="page" class="site">

    <!-- Navigation -->
    <?php
        $navbar_class = "navbar-light";
        if( !is_page_template('front-page.php') )
            $navbar_class = "navbar-inverse";
    ?>
    <nav class="navbar navbar-expand-lg <?php echo $navbar_class; ?>" id="mainNav">
        <a class="navbar-brand js-scroll-trigger" href="<?php echo esc_url( home_url( '/' )); ?>">
            <?php
                $logo = 'black.png';
                if( is_front_page() )
                    $logo = 'white.png';
            ?>
            <img src="<?php echo get_template_directory_uri() . '/inc/assets/images/cimahiwall_logo_' . $logo; ?>">
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php
        wp_nav_menu(array(
            'theme_location'    => 'primary',
            'container'       => 'div',
            'container_id'    => 'navbarResponsive',
            'container_class' => 'collapse navbar-collapse justify-content-end',
            'menu_id'         => false,
            'menu_class'      => 'navbar-nav',
            'depth'           => 3,
            'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
            'walker'          => new wp_bootstrap_navwalker()
        ));
        ?>
    </nav>
