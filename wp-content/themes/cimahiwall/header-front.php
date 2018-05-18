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

    <!-- Headers Start -->
    <div id="headers">

        <!-- Light header -->
        <header id="header-style-1" class="full-screen">

            <nav class="navbar navbar-expand-sm navbar-light">
                <div class="container">
                    <a class="navbar-brand" href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri() . '/inc/assets/images/cimahiwall_logo_white.png'; ?>" alt=""></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-bars"></i>
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
                    ?>
                </div>
            </nav>

            <div class="container">
                <div class="header-caption">
                    <div class="row justify-content-md-center">
                        <div class="col-md-12 header-content">
                            <h3 class="header-title animated fadeInDow">Coba apa yang lagi hype disekitarmu ?</h3>
                            <h5 class="header-text animated fadeIn">Ada cilok goang cuma jalan kaki 5 menit dari rumah.</h5>
                        </div>
                        <div class="col-md-8">
                            <form class="animated fadeInUp">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="s" placeholder="Cari tempat wisata, restoran, kafe dll" />
                                    <input type="hidden" value="place" name="mahiwal_type">
                                    <div class="input-group-append">
                                        <button class="btn btn-filled"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>

                            <div class="row mt-5">
                                <?php
                                $featured_event_categories = get_field('featured_event_categories');
                                foreach ($featured_event_categories as $featured_event_category) :
                                    $event_category = get_term( $featured_event_category );
                                    ?>
                                    <div class="col-6 col-sm-2">
                                        <a class="featured-box featured-center" href="<?php echo get_term_link($event_category->term_id, 'event_category'); ?>">
                                            <div class="featured-icon border-icon">
                                                <p class="text-primary"><i class="<?php echo get_category_icon($event_category->term_id, 'event_category'); ?>"></i></p>
                                            </div>
                                            <div class="featured-content">
                                                <p><?php echo $event_category->name; ?></p>
                                            </div>
                                        </a>
                                    </div>
                                <?php
                                endforeach;
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </header>
    </div>
    <!-- Headers End -->
