<?php
/**
 * WP Bootstrap Starter functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WP_Bootstrap_Starter
 */

if ( ! function_exists( 'wp_bootstrap_starter_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wp_bootstrap_starter_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on WP Bootstrap Starter, use a find and replace
	 * to change 'cimahiwall' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'cimahiwall', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'cimahiwall' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'wp_bootstrap_starter_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

    function wp_boostrap_starter_add_editor_styles() {
        add_editor_style( 'custom-editor-style.css' );
    }
    add_action( 'admin_init', 'wp_boostrap_starter_add_editor_styles' );

    /*
     * Customy add Logo
     */
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    ) );

}
endif;
add_action( 'after_setup_theme', 'wp_bootstrap_starter_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wp_bootstrap_starter_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wp_bootstrap_starter_content_width', 1170 );
}
add_action( 'after_setup_theme', 'wp_bootstrap_starter_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wp_bootstrap_starter_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'cimahiwall' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'cimahiwall' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
    register_sidebar( array(
        'name'          => esc_html__( 'Footer 1', 'cimahiwall' ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'Add widgets here.', 'cimahiwall' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => esc_html__( 'Footer 2', 'cimahiwall' ),
        'id'            => 'footer-2',
        'description'   => esc_html__( 'Add widgets here.', 'cimahiwall' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => esc_html__( 'Footer 3', 'cimahiwall' ),
        'id'            => 'footer-3',
        'description'   => esc_html__( 'Add widgets here.', 'cimahiwall' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    /*
     * Customy
     */
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar Place', 'cimahiwall' ),
        'id'            => 'sidebar-place',
        'description'   => esc_html__( 'Add widgets here.', 'cimahiwall' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'wp_bootstrap_starter_widgets_init' );



/**
 * Enqueue scripts and styles.
 */
function wp_bootstrap_starter_scripts() {

    wp_enqueue_script('jquery');

    // load bootstrap css
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/inc/assets/css/bootstrap.min.css' );
	wp_enqueue_style( 'jasny-bootstrap-css', get_template_directory_uri() . '/inc/assets/css/jasny-bootstrap.min.css' );

    // load css init
    wp_enqueue_style( 'animate-css', get_template_directory_uri() . '/inc/assets/css/animate.css' );
    wp_enqueue_style( 'responsive-css', get_template_directory_uri() . '/inc/assets/css/responsive.css' );

    // load tether
    wp_enqueue_script('tether-js', get_template_directory_uri() . '/inc/assets/js/tether.min.js', array() );

    // load select2
    wp_enqueue_style( 'select2-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css' );
    wp_enqueue_script('select2-js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js', array(), '', true );

    if(get_theme_mod( 'preset_style_setting' ) && get_theme_mod( 'preset_style_setting' ) !== 'default') {
        wp_enqueue_style( 'cimahiwall-'.get_theme_mod( 'preset_style_setting' ), get_template_directory_uri() . '/inc/assets/css/presets/typography/'.get_theme_mod( 'preset_style_setting' ).'.css', false, '' );
    }

    // load Main styles
    wp_enqueue_style( 'cimahiwall-style', get_stylesheet_uri() );

    // Internet Explorer HTML5 support
    wp_enqueue_script( 'html5hiv',get_template_directory_uri().'/inc/assets/js/html5.js', array(), '3.7.0', false );
    wp_script_add_data( 'html5hiv', 'conditional', 'lt IE 9' );

	// load bootstrap js
    wp_enqueue_script('popper-js', get_template_directory_uri() . '/inc/assets/js/popper.min.js', array() );
	wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/inc/assets/js/bootstrap.min.js', array() );
	wp_enqueue_script('-skip-link-focus-fix-js', get_template_directory_uri() . '/inc/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

    // load Font Awesome
    wp_enqueue_style( 'cimahiwall-font-awesome', get_template_directory_uri() . '/inc/assets/css/font-awesome.min.css', false, '4.1.0' );

    // load slickjs
    wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/inc/assets/css/slick.css' );
    wp_enqueue_style( 'slick-theme-css', get_template_directory_uri() . '/inc/assets/css/slick-theme.css' );
    wp_enqueue_script('slick-js', get_template_directory_uri() . '/inc/assets/js/slick.min.js', array(), '1.8.1', true );

    // load Owl
//    wp_enqueue_style( 'owl-carousel-css', get_template_directory_uri() . '/inc/assets/css/owl.carousel.css' );
//    wp_enqueue_style( 'owl-theme-css', get_template_directory_uri() . '/inc/assets/css/owl.theme.css' );
//    wp_enqueue_script('owl-carousel-js', get_template_directory_uri() . '/inc/assets/js/owl.carousel.min.js', array() );


    // load Magnific Popup
    wp_enqueue_style( 'magnific-popup-css', get_template_directory_uri() . '/inc/assets/css/magnific-popup.css' );
    wp_enqueue_script('magnific-popup-js', get_template_directory_uri() . '/inc/assets/js/jquery.magnific-popup.min.js', array(), '1.8.1', true );

    // load Jquery Lazy
    wp_enqueue_script('jquery-lazy-js', get_template_directory_uri() . '/inc/assets/js/jquery.lazy.min.js', array(), '1.7.7', true );

    // load Mixitup
    wp_enqueue_script('jquery-mixitup-js', get_template_directory_uri() . '/inc/assets/js/jquery.mixitup.js', array() );

    // load CountTo
    wp_enqueue_script('jquery-countto-js', get_template_directory_uri() . '/inc/assets/js/jquery.countTo.js', array() );

    // load instafeed
    wp_enqueue_script('instafeed-js', get_template_directory_uri() . '/inc/assets/js/instafeed.min.js', array(), '', true );

    // load maplace
    wp_enqueue_script('googlemap-js', 'https://maps.google.com/maps/api/js?key=' . cmb2_get_option('cimahiwall_theme_options', 'google_map_api_key'), array(), '', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// load Bar Rating
    wp_enqueue_style('cimahiwall-barrating-css', get_template_directory_uri() . '/inc/assets/css/fontawesome-stars.css' );
    wp_enqueue_script('cimahiwall-barrating-js', get_template_directory_uri() . '/inc/assets/js/jquery.barrating.js', array(), '', true );

    // Load Main Script
    wp_enqueue_script('theme-js', get_template_directory_uri() . '/inc/assets/js/theme-script.js', array() );

    // Add Localize General
    $cimahiwall_localize = [
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'google_api_key' => cmb2_get_option('cimahiwall_theme_options', 'google_map_api_key')
    ];
    wp_localize_script('theme-js', 'cimahiwall', $cimahiwall_localize );

	// Add Localize Instagram Feed
    $instagram_tag = get_field('instagram_tag', get_the_ID());
    $instagram = [
        'instagram_access_token' => cmb2_get_option('cimahiwall_theme_options', 'instagram_access_token'),
        'instagram_client_id' => cmb2_get_option('cimahiwall_theme_options', 'instagram_client_id'),
        'cimahiwall_instagram_tag' => $instagram_tag
    ];
    wp_localize_script('instafeed-js', 'instagram', $instagram);

}
add_action( 'wp_enqueue_scripts', 'wp_bootstrap_starter_scripts' );


function wp_bootstrap_starter_password_form() {
    global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    $o = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
    <div class="d-block mb-3">' . __( "To view this protected post, enter the password below:", "cimahiwall" ) . '</div>
    <div class="form-group form-inline"><label for="' . $label . '" class="mr-2">' . __( "Password:", "cimahiwall" ) . ' </label><input name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" class="form-control mr-2" /> <input type="submit" name="Submit" value="' . esc_attr__( "Submit", "cimahiwall" ) . '" class="btn btn-primary"/></div>
    </form>';
    return $o;
}
add_filter( 'the_password_form', 'wp_bootstrap_starter_password_form' );


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load plugin compatibility file.
 */
require get_template_directory() . '/inc/plugin-compatibility/plugin-compatibility.php';

/**
 * Load custom WordPress nav walker.
 */
if ( ! class_exists( 'wp_bootstrap_navwalker' )) {
    require_once(get_template_directory() . '/inc/wp_bootstrap_navwalker.php');
}

/**
 * ========================================
 * Customy
 * ========================================
 */

/**
 * Load custom admin file.
 */
require get_template_directory() . '/inc/custom-admin.php';

/**
 * Load request handler file.
 */
require get_template_directory() . '/inc/request-handler.php';

function isJSON($string){
    return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
}

function limit_text($string, $limit) {
    if( strlen($string) >= $limit)
        echo substr($string, 0, $limit) . '...';
    else
        echo $string;
}

/*
 * Api key for ACF
 */
function cimahiwall_google_map_api( $api ){
    $api['key'] = cmb2_get_option('cimahiwall_theme_options', 'google_map_api_key');
    return $api;
}
add_filter('acf/fields/google_map/api', 'cimahiwall_google_map_api');

/*
 * Custom from switch-sticky
 * Show 9 place per page on archive and search
 */
function posts_per_page($query) {
    if ( !is_admin() && $query->is_main_query() ) {
        if( is_home() ) {
            // set the number of posts per page
            $posts_per_page = 9;
            $query->set('posts_per_page', $posts_per_page);
        }

        // set the number of posts per page
        $posts_per_page = 15;
        $query->set('posts_per_page', $posts_per_page);
    }

}
add_action('pre_get_posts','posts_per_page');

function search_and_archive( $query ) {

    if ( !is_admin() && $query->is_main_query() ) {
        // Default view is Popular / Most View on search and archive only | plugin post view counter
        if (is_search() OR is_archive()) {

            // Need min 1 view to get into the result
            if (empty (get_query_var('orderby'))) {
                $query->set('orderby', 'post_views');
                $query->set('order', 'desc');
                $query->pvc_orderby = true;
            }

            // if event archive
            if (is_post_type_archive('event')) {

                $month = $_GET['month'];
                if( empty($month) ) $month = date('m');
                $start_date = strtotime(date('Y'.$month.'01')); // First day of the month
                $end_date = strtotime(date('Y'.$month.'t')); // 't' gets the last day of the month

                $query->set('meta_query', [
                    [
                        'key'       => 'cimahiwall_field_start_datetime',
                        'value'     => array($start_date, $end_date),
                        'compare'   => 'BETWEEN'
                    ]
                ]);

                $query->set('meta_key', 'cimahiwall_field_start_datetime');
                $query->set('orderby', 'meta_value_num');
                $query->set('order', 'desc');
                $query->set('posts_per_page', -1);
                $query->set('ignore_sticky_posts', true);

                $query->pvc_orderby = false;
            }
        }
    }
}
add_action('pre_get_posts','search_and_archive');


/*
 * Pagination
 */
function cimahiwall_pagination($pages = '', $range = 2)
{
    $showitems = ($range * 2) + 1;
    global $paged;
    if(empty($paged)) $paged = 1;
    if($pages == '')
    {
        global $wp_query;
        $pages = $wp_query->max_num_pages;

        if(!$pages)
            $pages = 1;
    }

    if(1 != $pages)
    {
        echo '<nav aria-label="Page navigation" role="navigation">';
        echo '<span class="sr-only">Page navigation</span>';
        echo '<ul class="pagination justify-content-center ft-wpbs">';

        if($paged > 2 && $paged > $range+1 && $showitems < $pages)
            echo '<li class="page-item"><a class="btn std-btn btn-sm btn-common" href="'.get_pagenum_link(1).'" aria-label="First Page"><span class="hidden-sm-down d-none d-md-block">&laquo; First</span></a></li>';

        if($paged > 1 && $showitems < $pages)
            echo '<li class="page-item"><a class="btn std-btn btn-sm btn-common" href="'.get_pagenum_link($paged - 1).'" aria-label="Previous Page"><span class="hidden-sm-down d-none d-md-block">&lsaquo; Previous</span></a></li>';

        for ($i=1; $i <= $pages; $i++)
        {
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
                echo ($paged == $i)? '<li class="page-item active"><span class="btn std-btn btn-sm btn-filled"><span class="sr-only">Current Page </span>'.$i.'</span></li>' : '<li class="page-item"><a class="btn std-btn btn-sm btn-common " href="'.get_pagenum_link($i).'"><span class="sr-only">Page </span>'.$i.'</a></li>';
        }

        if ($paged < $pages && $showitems < $pages)
            echo '<li class="page-item"><a class="btn std-btn btn-sm btn-common" href="'.get_pagenum_link($paged + 1).'" aria-label="Next Page"><span class="hidden-sm-down d-none d-md-block">Next &rsaquo;</span></a></li>';

        if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages)
            echo '<li class="page-item"><a class="btn std-btn btn-sm btn-common" href="'.get_pagenum_link($pages).'" aria-label="Last Page"><span class="hidden-sm-down d-none d-md-block">Last &raquo;</span></a></li>';

        echo '</ul>';
        echo '</nav>';
        //echo '<div class="pagination-info mb-5 text-center">[ <span class="text-muted">Page</span> '.$paged.' <span class="text-muted">of</span> '.$pages.' ]</div>';
    }
}

function place_archive_title() {
    if( is_search() ) echo "Hasil pencarian ";

    $place_category = get_query_var('place_category');
    $city = get_query_var('city');
    $area = get_query_var('area');

    $place_category = get_term_by('slug', $place_category, 'place_category');
    $city = get_term_by('slug', $city, 'city');
    $area = get_term_by('slug', $area, 'area');

    if (!empty($place_category) && !empty($city) && !empty($area))
        echo $place_category->name . " di " . $city->name . " daerah " . $area->name;
    elseif(!empty($place_category) && !empty($city) )
        echo $place_category->name . " di " . $city->name;
    elseif(!empty($place_category) && empty($city) )
        echo $place_category->name;
    elseif(empty($place_category) && !empty($city) )
        echo $city->name;
}
add_action('cimahiwall_place_archive_title', 'place_archive_title');

/**
 * Get Image from term
 *
 * @author Arief Wibowo
 * @param $taxonomy
 * @param $term_id
 * @param string $field
 * @return bool|mixed|string
 */
function get_term_image_url( $taxonomy, $term_id, $field = 'image' ) {

    $image_url = get_field( $field, $taxonomy.'_'.$term_id );

    if( empty($image_url) ) {
        $image_url = get_template_directory_uri() . '/inc/assets/images/' . $taxonomy .'_default.jpg';
    }

    return $image_url;
}

/**
 * Get Image from term
 *
 * @param $taxonomy
 * @param $term_id
 * @param string $field
 */
function the_term_icon( $taxonomy, $term_id, $field = 'icon' ) {

    $icon = get_field( $field, $taxonomy.'_'.$term_id );

    if( empty($icon) ) {
        $icon = 'flag';
    }

    echo "<i class='fa fa-" . $icon. "'></i>";
}

function get_featured_post_image( $post_id, $post_type, $args = '' ) {
    $image_url = get_the_post_thumbnail_url($post_id);
    if( empty($image_url))
        $image_url = get_template_directory_uri() . '/inc/assets/images/' . $post_type . '_default.jpg';

    return $image_url;
}

function terms_id_only( $object ) {
    $array = false;
    if( ! empty($object)) {
        foreach ($object as $item) {
            $array[] = $item->term_id;
        }
    }
    return $array;
}

function get_place_category( $place_id ) {
    $place_category = false;
    $place_categories = wp_get_post_terms($place_id, 'place_category');
    if( ! empty($place_categories[0])) {
        $place_category = $place_categories[0];
    }

    return $place_category;
}

/**
 * Get String event datetime
 *
 * @param bool $event_id
 * @return false|string
 */
function get_event_time( $event_id = false ) {
    if( $event_id == false)
        $event_id = get_the_ID();

    $start_date_time = get_post_meta( $event_id, 'cimahiwall_field_start_datetime', true);
    $end_date_time = get_post_meta( $event_id, 'cimahiwall_field_end_datetime', true);

    if( $start_date_time == $end_date_time)
        $str_date_time = date('l, d F Y', $start_date_time);
    elseif( date('dmy', $start_date_time) == date('dmy', $end_date_time) )
        $str_date_time = date('l, d F Y H:i', $start_date_time) . ' - ' . date('H:i', $end_date_time) ;
    else
        $str_date_time = date('l, d F Y', $start_date_time) . ' - ' . date('l, d F Y', $end_date_time);

    return $str_date_time;
}

function get_event_price( $event_id = false ) {

    if( $event_id == false)
        $price = get_field('price');
    else


    $price = get_field('price');
    if( empty($price) )
        $price = "Free";
    else
        $price = 'IDR ' . number_format_short($price);

    return $price;

}

function number_format_short( $n, $precision = 1 ) {
    if ($n < 900) {
        // 0 - 900
        $n_format = number_format($n, $precision);
        $suffix = '';
    } else if ($n < 900000) {
        // 0.9k-850k
        $n_format = number_format($n / 1000, $precision);
        $suffix = 'K';
    } else if ($n < 900000000) {
        // 0.9m-850m
        $n_format = number_format($n / 1000000, $precision);
        $suffix = 'M';
    } else if ($n < 900000000000) {
        // 0.9b-850b
        $n_format = number_format($n / 1000000000, $precision);
        $suffix = 'B';
    } else {
        // 0.9t+
        $n_format = number_format($n / 1000000000000, $precision);
        $suffix = 'T';
    }
    // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
    // Intentionally does not affect partials, eg "1.50" -> "1.50"
    if ( $precision > 0 ) {
        $dotzero = '.' . str_repeat( '0', $precision );
        $n_format = str_replace( $dotzero, '', $n_format );
    }
    return $n_format . $suffix;
}

function get_nearest_location($place_id = false, $limit = 5) {
    global $wpdb;

    if( $place_id == false )
        $place_id = get_the_ID();

    $place_latitude = get_post_meta( $place_id, 'cimahiwall_latitude', true);
    $place_longitude = get_post_meta( $place_id, 'cimahiwall_longitude', true);

    $result = $wpdb->get_results(
        "
            SELECT DISTINCT 
              p.ID, 
              m1.meta_value as lat, 
              m2.meta_value as lng,
              ( 6371 * acos( cos( radians($place_latitude) ) * cos( radians( m1.meta_value ) ) * cos( radians( m2.meta_value ) - radians($place_longitude) ) + sin( radians($place_latitude) ) * sin(radians(m1.meta_value)) ) ) AS distance
            FROM $wpdb->posts p
			LEFT JOIN $wpdb->postmeta m1
              ON p.ID = m1.post_id AND m1.meta_key = 'cimahiwall_latitude'
            LEFT JOIN mahiwall_postmeta m2
              ON p.ID = m2.post_id AND m2.meta_key = 'cimahiwall_longitude' 
            WHERE p.post_type = 'place' 
            AND p.ID=m1.post_id 
            AND p.ID=m2.post_id
            AND p.ID != '$place_id'
            LIMIT 0, $limit
            "
    );

    // Finale
//    SELECT DISTINCT post_title as place, m1.meta_value as lat, m2.meta_value as lng,
//( 3959 * acos( cos( radians(-6.897605209674478) ) * cos( radians( m1.meta_value ) )
//        * cos( radians( m2.meta_value ) - radians(107.55666577536317) ) + sin( radians(-6.897605209674478) ) * sin(radians(m1.meta_value)) ) ) AS distance
//
//FROM mahiwall_posts p
//			LEFT JOIN mahiwall_postmeta m1
//              ON p.ID = m1.post_id AND m1.meta_key = 'cimahiwall_latitude'
//            LEFT JOIN mahiwall_postmeta m2
//              ON p.ID = m2.post_id AND m2.meta_key = 'cimahiwall_longitude'
//            WHERE p.post_type = 'place' AND p.ID=m1.post_id AND p.ID=m2.post_id

    return $result;
}

/**
 * Widgets
 */
require get_template_directory() . '/inc/widgets.php';
