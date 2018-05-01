<?php
/**
 * Created by Customy.
 * User: Arief Wibowo
 * Date: 4/17/2018
 * Time: 10:49 AM
 */

require "CimahiwallSocialActivity.php";
require "CimahiwallSocialFollow.php";

function cimahiwall_activity_scripts() {
    wp_enqueue_script('cimahiwall-activity-js', get_template_directory_uri() . '/inc/plugin-compatibility/cimahiwall-social/inc/js/cimahiwall-social.js', array() );
}
add_action( 'wp_enqueue_scripts', 'cimahiwall_activity_scripts' );

function cimahiwall_friends_rewrite_rule()
{
    add_rewrite_rule('^friends/(.+)/?$','index.php?pagename=friends&s=$matches[1]','top');
}
add_action('init', 'cimahiwall_friends_rewrite_rule', 10, 0);

function cimahiwall_friends_query_vars( $query_vars )
{
    $query_vars[] = 's';
    return $query_vars;
}
add_filter( 'query_vars', 'cimahiwall_friends_query_vars' );


function cimahiwall_insert_log_a_visit(){
    if( ! empty($_POST['place_id']) ) {
        $object_type = 'place';
        $place_id = sanitize_text_field( $_POST['place_id'] );
        $user_id = get_current_user_id();

        $insert = new CimahiwallSocialActivity();
        $insert->add_activity( $object_type, $place_id, $user_id);

        wp_redirect(get_permalink( $place_id ));
    }
}
add_action( 'admin_post_log_a_visit', 'cimahiwall_insert_log_a_visit' );

function cimahiwall_insert_log_an_interest(){
    if( ! empty($_POST['event_id']) ) {
        $object_type = 'event';
        $event_id = sanitize_text_field( $_POST['event_id'] );
        $user_id = get_current_user_id();
        $insert = new CimahiwallSocialActivity();
        $insert->add_activity( $object_type, $event_id, $user_id);
        wp_redirect(get_permalink( $event_id ));
    }
}
add_action( 'admin_post_log_an_interest', 'cimahiwall_insert_log_an_interest' );

function cimahiwall_delete_activity() {

    if( isset( $_POST['activity_id'])) {
        $activity_id = sanitize_text_field( $_POST['activity_id'] );

        if( is_user_logged_in() ) {
            $activity = new CimahiwallSocialActivity();
            $delete = $activity->delete_activity( $activity_id );

            echo json_encode([ 'success' => $delete ]);
        }
    }

    wp_die();
}
add_action( 'wp_ajax_delete_activity', 'cimahiwall_delete_activity' );

function cimahiwall_insert_log_a_tip($comment_id, $comment_object) {
    $object_type = 'comment';
    $user_id = $comment_object->user_id;
    $insert = new CimahiwallSocialActivity();
    $insert->add_activity( $object_type, $comment_id, $user_id);
}
add_action('wp_insert_comment', 'cimahiwall_insert_log_a_tip', 99, 2);

function cimahiwall_insert_log_follow_user(){

    if( isset( $_POST['user_id']) ) {
        $user_id = sanitize_text_field($_POST['user_id']);
        $follow = new CimahiwallSocialFollow();
        $follow->set_to_user_id( $user_id );

        if( ! isset( $_POST['unfollow'] )) {
            $result = $follow->add_follow();
            $status = 'follow';
        }
        else
        {
            $result = $follow->remove_follow();
            $status = 'unfollow';
        }
        echo json_encode([
            'result' => $result,
            'status' => $status
        ]);
    }
    wp_die();

}
add_action( 'wp_ajax_log_follow_user', 'cimahiwall_insert_log_follow_user' );

/**
 * Load more activity handler
 */
function cimahiwall_load_more_activity() {
    $last_activity_id = isset( $_POST['last_activity_id'] ) ? sanitize_text_field( $_POST['last_activity_id'] ) : false;
    $mode = isset( $_POST['mode'] ) ? sanitize_text_field( $_POST['mode'] ) : false;
    $user_id = isset( $_POST['user_id'] ) ? sanitize_text_field( $_POST['user_id'] ) : false;

    $cimahiwall_activity = new CimahiwallSocialActivity();
    if( $user_id != false ) $cimahiwall_activity->set_user_id( (int) $user_id ) ;

    $activities = $cimahiwall_activity->activity_listing( (int) $last_activity_id, 2, $mode);

    foreach ($activities as $key => $activity) {
        $cimahiwall_activity = new CimahiwallSocialActivity( (array) $activity );
        $user = get_userdata($cimahiwall_activity->user_id);
        $activities[$key]->avatar = get_avatar( $cimahiwall_activity->user_id, 24, '', $user->display_name, ['class'=>'mr-3 w-auto', 'width'=> 64, 'height'=> 64] );
        $activities[$key]->display_name = $user->display_name;
        $activities[$key]->user_link = home_url("profile/$user->user_nicename");
        $activities[$key]->activity_text = $cimahiwall_activity->activity_text();
        $activities[$key]->activity_date = $cimahiwall_activity->activity_date();
        $activities[$key]->featured_image = $featured_image = get_the_post_thumbnail($cimahiwall_activity->post_id);
        $activities[$key]->post_link = get_permalink($cimahiwall_activity->post_id);
        $last_activity_id = $cimahiwall_activity->activity_id;
    }

    echo json_encode( [
         'activities_left' => $cimahiwall_activity->activity_left( (int) $last_activity_id ),
         'result' => $activities
     ] );

    wp_die(); // this is required to terminate immediately and return a proper response

}
add_action( 'wp_ajax_load_more_activity', 'cimahiwall_load_more_activity' );

