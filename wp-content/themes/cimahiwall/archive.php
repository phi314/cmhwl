<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

if( locate_template( 'home.php' ) ) {

    // if so, load that template
    get_template_part('home');

    // and then exit out
    exit;
}
else {
    wp_redirect(404);
}
