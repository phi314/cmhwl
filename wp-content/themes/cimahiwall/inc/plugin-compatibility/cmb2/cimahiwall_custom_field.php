<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'cimahiwall_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( dirname( __FILE__ ) . '/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/init.php';
} 

add_action( 'cmb2_admin_init', 'cimahiwall_register_place_detail_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function cimahiwall_register_place_detail_metabox() {
	$prefix = 'cimahiwall_field_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cimahiwall_field = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Gallery', 'cimahiwall' ),
		'object_types'  => array( 'place' ), // Post type
		// 'show_on_cb' => 'cimahiwall_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
		// 'classes_cb' => 'cimahiwall_add_some_classes', // Add classes through a callback.
	) );

    $cimahiwall_field->add_field( array(
		'name'         => esc_html__( 'Local Gallery', 'cimahiwall' ),
		'desc'         => esc_html__( 'Upload or add multiple images/attachments.', 'cimahiwall' ),
		'id'           => $prefix . 'local_gallery',
		'type'         => 'file_list',
		'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
	) );

	$cimahiwall_field->add_field( array(
		'name' => esc_html__( 'Video', 'cimahiwall' ),
		'desc' => sprintf(
			/* translators: %s: link to codex.wordpress.org/Embeds */
			esc_html__( 'Enter a youtube, twitter, or instagram URL. Supports services listed at %s.', 'cmb2' ),
			'<a href="https://codex.wordpress.org/Embeds">codex.wordpress.org/Embeds</a>'
		),
		'id'   => $prefix . 'video',
		'type' => 'oembed',
	) );

    // Cloud Gallery
    $cloud_photos = $cimahiwall_field->add_field( array(
        'id'          => $prefix . 'cloud_photos',
        'type'        => 'group',
        'description' => esc_html__( 'Cloud Gallery', 'cimahiwall' ),
        'options'     => array(
            'group_title'   => esc_html__( 'Cloud Photo {#}', 'cimahiwall' ), // {#} gets replaced by row number
            'add_button'    => esc_html__( 'Add Another Entry', 'cimahiwall' ),
            'remove_button' => esc_html__( 'Remove Entry', 'cimahiwall' ),
            'sortable'      => true, // beta
            // 'closed'     => true, // true to have the groups closed by default
        ),
    ) );
    $cimahiwall_field->add_group_field( $cloud_photos, array(
        'name'        => esc_html__( 'Cloud Image Url', 'cimahiwall' ),
        'description' => esc_html__( 'Insert image url', 'cimahiwall' ),
        'id'          => 'cloud_image_url',
        'type'        => 'text_url',
    ) );
    $cimahiwall_field->add_group_field( $cloud_photos, array(
        'name'        => esc_html__( 'Image Source', 'cimahiwall' ),
        'description' => esc_html__( 'Insert image source', 'cimahiwall' ),
        'id'          => 'cloud_image_source',
        'type'        => 'text',
    ) );

}

add_action( 'cmb2_admin_init', 'cimahiwall_register_event_detail_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function cimahiwall_register_event_detail_metabox() {
    $prefix = 'cimahiwall_field_';

    /**
     * Sample metabox to demonstrate each field type included
     */
    $cimahiwall_field = new_cmb2_box( array(
        'id'            => $prefix . 'event_time',
        'title'         => esc_html__( 'Event time', 'cimahiwall' ),
        'object_types'  => array( 'event' ), // Post type
    ) );

    $cimahiwall_field->add_field( array(
        'name'         => esc_html__( 'Waktu mulai', 'cimahiwall' ),
        'desc'         => "Tanggal dan jam mulai",
        'id'           => $prefix . 'start_datetime',
        'type'         => 'text_datetime_timestamp',
        'attributes'  => array(
            'required'    => 'required',
        ),
        'default'      => '12:00 am'
    ) );

    $cimahiwall_field->add_field( array(
        'name'         => esc_html__( 'Waktu selesai', 'cimahiwall' ),
        'desc'         => "Tanggal dan jam selesai",
        'id'           => $prefix . 'end_datetime',
        'type'         => 'text_datetime_timestamp',
        'attributes'  => array(
            'required'    => 'required',
        ),
        'default'      => '12:00 am'
    ) );

    $cimahiwall_field->add_field( array(
        'name'         => esc_html__( 'Sepanjang hari', 'cimahiwall' ),
        'desc'         => "Check jika event sepanjang hari, maka jam akan dihiraukan. (Inputkan jam 12:00 AM)",
        'id'           => $prefix . 'all_day',
        'type'         => 'checkbox',
        'default'      => false
    ) );

}

add_action( 'cmb2_admin_init', 'cimahiwall_register_theme_options_metabox' );
/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function cimahiwall_register_theme_options_metabox() {

	/**
	 * Registers options page menu item and form.
	 */
	$cimahiwall_options = new_cmb2_box( array(
		'id'           => 'cimahiwall_theme_options_page',
		'title'        => esc_html__( 'Theme Options', 'cimahiwall' ),
		'object_types' => array( 'options-page' ),

		/*
		 * The following parameters are specific to the options-page box
		 * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
		 */

		'option_key'      => 'cimahiwall_theme_options', // The option key and admin menu page slug.
		'icon_url'        => 'dashicons-palmtree', // Menu icon. Only applicable if 'parent_slug' is left empty.
		// 'menu_title'      => esc_html__( 'Options', 'cimahiwall' ), // Falls back to 'title' (above).
		// 'parent_slug'     => 'themes.php', // Make options page a submenu item of the themes menu.
		// 'capability'      => 'manage_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Theme Options', 'cimahiwall' ), // The text for the options-page save button. Defaults to 'Save'.
		// 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
		// 'message_cb'      => 'cimahiwall_options_page_message_callback',
	) );

	$cimahiwall_options->add_field( array(
		'name'    => esc_html__( 'Google Map API Key', 'cimahiwall' ),
		'id'      => 'google_map_api_key',
		'type'    => 'text',
	) );

    $cimahiwall_options->add_field( array(
        'name'    => esc_html__( 'Instagram Client ID', 'cimahiwall' ),
        'id'      => 'instagram_client_id',
        'type'    => 'text',
    ) );

    $cimahiwall_options->add_field( array(
        'name'    => esc_html__( 'Instagram Access Token', 'cimahiwall' ),
        'id'      => 'instagram_access_token',
        'type'    => 'text',
    ) );


    // Booking.com
    $cimahiwall_options->add_field( array(
        'name'    => esc_html__( 'booking.com AID', 'cimahiwall' ),
        'id'      => 'booking_dot_com_aid',
        'type'    => 'text',
    ) );

    // Tiket.com
    $cimahiwall_options->add_field( array(
        'name'    => esc_html__( 'tiket.com Business', 'cimahiwall' ),
        'id'      => 'tiket_dot_com_aid',
        'type'    => 'text',
    ) );

}

/**
 * Callback to define the optionss-saved message.
 *
 * @param cimahiwall  $cmb The cimahiwall object.
 * @param array $args {
 *     An array of message arguments
 *
 *     @type bool   $is_options_page Whether current page is this options page.
 *     @type bool   $should_notify   Whether options were saved and we should be notified.
 *     @type bool   $is_updated      Whether options were updated with save (or stayed the same).
 *     @type string $setting         For add_settings_error(), Slug title of the setting to which
 *                                   this error applies.
 *     @type string $code            For add_settings_error(), Slug-name to identify the error.
 *                                   Used as part of 'id' attribute in HTML output.
 *     @type string $message         For add_settings_error(), The formatted message text to display
 *                                   to the user (will be shown inside styled `<div>` and `<p>` tags).
 *                                   Will be 'Settings updated.' if $is_updated is true, else 'Nothing to update.'
 *     @type string $type            For add_settings_error(), Message type, controls HTML class.
 *                                   Accepts 'error', 'updated', '', 'notice-warning', etc.
 *                                   Will be 'updated' if $is_updated is true, else 'notice-warning'.
 * }
 */
function cimahiwall_options_page_message_callback( $cmb, $args ) {
	if ( ! empty( $args['should_notify'] ) ) {

		if ( $args['is_updated'] ) {

			// Modify the updated message.
			$args['message'] = sprintf( esc_html__( '%s &mdash; Updated!', 'cimahiwall' ), $cmb->prop( 'title' ) );
		}

		add_settings_error( $args['setting'], $args['code'], $args['message'], $args['type'] );
	}
}
