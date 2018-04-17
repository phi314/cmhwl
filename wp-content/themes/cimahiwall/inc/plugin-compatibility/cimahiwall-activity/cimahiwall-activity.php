<?php
/**
 * Created by Customy.
 * User: Arief Wibowo
 * Date: 4/17/2018
 * Time: 10:49 AM
 */

require "CimahiwallActivity.php";

function cimahiwall_insert_log_a_visit(){
    global $wpdb;

    if( ! empty($_POST['place_id']) ) {
        $object_type = 'place';
        $place_id = sanitize_text_field( $_POST['place_id'] );
        $user_id = get_current_user_id();

        $wpdb->insert(
            $wpdb->prefix . "activity",
            [
                'object_type' => $object_type,
                'object_id' => $place_id,
                'user_id' => $user_id
            ]
        );
        wp_redirect(get_permalink( $place_id ));
    }
}
add_action( 'admin_post_log_a_visit', 'cimahiwall_insert_log_a_visit' );

function cimahiwall_insert_log_an_attend(){
    global $wpdb;

    if( ! empty($_POST['event_id']) ) {
        $object_type = 'event';
        $event_id = sanitize_text_field( $_POST['event_id'] );
        $user_id = get_current_user_id();

        $wpdb->insert(
            $wpdb->prefix . "activity",
            [
                'object_type' => $object_type,
                'object_id' => $event_id,
                'user_id' => $user_id
            ]
        );
        wp_redirect(get_permalink( $event_id ));
    }
}
add_action( 'admin_post_log_an_attend', 'cimahiwall_insert_log_an_attend' );

function cimahiwall_insert_log_a_tip($comment_id, $comment_object) {
    global $wpdb;

    $object_type = 'comment';
    $user_id = $comment_object->user_id;

    $wpdb->insert(
        $wpdb->prefix . "activity",
        [
            'object_type' => $object_type,
            'object_id' => $comment_id,
            'user_id' => $user_id
        ]
    );

}
add_action('wp_insert_comment', 'cimahiwall_insert_log_a_tip', 99, 2);
