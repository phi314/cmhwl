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

function cimahiwall_load_more_activity() {
    $last_activity_id = sanitize_text_field( $_POST['last_activity_id']);
    $cimahiwall_activity = new CimahiwallActivity();
    $activities = $cimahiwall_activity->activity_listing( (int) $last_activity_id, 2);

    foreach ($activities as $key => $activity) {
        $cimahiwall_activity = new CimahiwallActivity( (array) $activity );
        $user = get_userdata($cimahiwall_activity->user_id);
        $activities[$key]->avatar = get_avatar( $cimahiwall_activity->user_id, 24, '', $user->display_name, ['class'=>'mr-3 w-auto', 'width'=> 64, 'height'=> 64] );
        $activities[$key]->display_name = $user->display_name;
        $activities[$key]->activity_text = $cimahiwall_activity->activity_text();
        $activities[$key]->activity_date = $cimahiwall_activity->activity_date();
        $activities[$key]->featured_image = $featured_image = get_the_post_thumbnail($cimahiwall_activity->post_id);
        $activities[$key]->post_link = get_permalink($cimahiwall_activity->post_id);
        $last_activity_id = $cimahiwall_activity->activity_id;
    }

    $activities_left = $cimahiwall_activity->activity_left( (int) $last_activity_id );

    echo json_encode( [
         'activities_left' => $activities_left->total_activity,
         'result' => $activities
     ] );

    wp_die(); // this is required to terminate immediately and return a proper response

}
add_action( 'wp_ajax_load_more_activity', 'cimahiwall_load_more_activity' );


function cimahiwall_activity_scripts() {
    wp_enqueue_script('cimahiwall-activity-js', get_template_directory_uri() . '/inc/plugin-compatibility/cimahiwall-activity/inc/js/cimahiwall-activity.js', array() );
}
add_action( 'wp_enqueue_scripts', 'cimahiwall_activity_scripts' );

