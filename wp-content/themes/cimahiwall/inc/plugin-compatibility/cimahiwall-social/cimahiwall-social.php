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

        $activity = new CimahiwallSocialActivity( (int) $user_id );
        $activity->set_object_type( $object_type );
        $activity->set_object_id( $place_id );
        $activity->insert();

        wp_redirect(get_permalink( $place_id ));
    }
}
add_action( 'admin_post_log_a_visit', 'cimahiwall_insert_log_a_visit' );

function cimahiwall_insert_log_an_interest(){
    if( ! empty($_POST['event_id']) ) {
        $object_type = 'event';
        $event_id = sanitize_text_field( $_POST['event_id'] );
        $user_id = get_current_user_id();
        $activity = new CimahiwallSocialActivity( (int) $user_id );
        $activity->set_object_type( $object_type );
        $activity->set_object_id( $event_id );
        $activity->insert();
        wp_redirect(get_permalink( $event_id ));
    }
}
add_action( 'admin_post_log_an_interest', 'cimahiwall_insert_log_an_interest' );

function cimahiwall_delete_activity() {

    if( isset( $_POST['activity_id'])) {
        $activity_id = sanitize_text_field( $_POST['activity_id'] );

        if( is_user_logged_in() ) {
            $activity = new CimahiwallSocialActivity( get_current_user_id() );
            $activity->set_activity_id( $activity_id );
            $delete = $activity->delete();

            echo json_encode([ 'success' => $delete ]);
        }
    }

    wp_die();
}
add_action( 'wp_ajax_delete_activity', 'cimahiwall_delete_activity' );

function cimahiwall_insert_log_a_tip($comment_id, $comment_object) {
    $object_type = 'comment';
    $user_id = $comment_object->user_id;
    $activity = new CimahiwallSocialActivity( (int) $user_id );
    $activity->set_object_type( $object_type );
    $activity->set_object_id( $comment_id );
    $activity->insert();
}
add_action('wp_insert_comment', 'cimahiwall_insert_log_a_tip', 99, 2);

function cimahiwall_insert_log_follow_user(){

    if( isset( $_POST['user_id']) ) {
        $user_id = sanitize_text_field($_POST['user_id']);
        $follow = new CimahiwallSocialFollow();

        if( ! isset( $_POST['unfollow'] )) {
            $result = $follow->add_follow( $user_id );
            $status = 'follow';
        }
        else
        {
            $result = $follow->remove_follow( $user_id );
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
    $activity_mode = isset( $_POST['mode'] ) ? sanitize_text_field( $_POST['mode'] ) : 'own';
    $user_id = isset( $_POST['user_id'] ) ? sanitize_text_field( $_POST['user_id'] ) : false;

    $cimahiwall_activity = new CimahiwallSocialActivityPagination( (int) $user_id  );
    $cimahiwall_activity->set_last_activity_id( $last_activity_id );
    $cimahiwall_activity->set_activity_mode( $activity_mode );
    $cimahiwall_activity->set_activity_limit( 2 );
    $activities = $cimahiwall_activity->activity_left_result();

    foreach ($activities as $key => $activity) {
        $user = get_userdata($activity->user_id);
        $activities[$key]->avatar = get_avatar( $activity->user_id, 24, '', $user->display_name, ['class'=>'mr-3 w-auto', 'width'=> 64, 'height'=> 64] );
        $activities[$key]->display_name = $user->display_name;
        $activities[$key]->user_link = home_url("profile/$user->user_nicename");
        $activities[$key]->activity_text = activity_text( $activity->object_type );
        $activities[$key]->activity_date = activity_date( $activity->created_date );
        $activities[$key]->featured_image = get_featured_post_image($activity->post_id);
        $activities[$key]->post_link = get_permalink($activity->post_id);

    }

    echo json_encode( [
         'activities_left' => $cimahiwall_activity->activity_left_count()   ,
         'result' => $activities
     ] );

    wp_die(); // this is required to terminate immediately and return a proper response

}
add_action( 'wp_ajax_load_more_activity', 'cimahiwall_load_more_activity' );

/**
 * Load more friends handler
 */
function cimahiwall_load_more_friends() {
    $last_user_id = isset( $_POST['last_user_id'] ) ? sanitize_text_field( $_POST['last_user_id'] ) : false;
    $last_follow_id = isset( $_POST['last_follow_id'] ) ? sanitize_text_field( $_POST['last_follow_id'] ) : false;
    $follow_type = isset( $_POST['follow_type'] ) ? sanitize_text_field( $_POST['follow_type'] ) : 'everyone';
    $user_id = isset( $_POST['user_id'] ) ? sanitize_text_field( $_POST['user_id'] ) : false;

    $cimahiwall_friends = new CimahiwallSocialFollowPagination( $user_id );
    $cimahiwall_friends->set_limit( 20 );
    $cimahiwall_friends->set_follow_type( $follow_type );
    $cimahiwall_friends->set_last_user_id( $last_user_id );
    $cimahiwall_friends->set_last_follow_id( $last_follow_id );

    $friends = $cimahiwall_friends->left_result();
    foreach ($friends as $key => $friend) {
        $user = get_userdata($friend->friend_id);
        $friends[$key]->follow_id = $friend->follow_id;
        $friends[$key]->friend_id = $user->ID;
        $friends[$key]->avatar = get_avatar( $user->ID );
        $friends[$key]->display_name = $user->display_name;
        $friends[$key]->user_link = home_url("profile/$user->user_nicename");
        $friends[$key]->has_follow = $cimahiwall_friends->has_follow( $friend->friend_id );
    }

    echo json_encode( [
        'friends_left' => $cimahiwall_friends->left_count(),
        'follow_type' => $follow_type,
        'result' => $friends
    ] );

    wp_die(); // this is required to terminate immediately and return a proper response

}
add_action( 'wp_ajax_load_more_friends', 'cimahiwall_load_more_friends' );


function activity_text( $object_type ) {
    $text = 'visited';
    switch ($object_type) {
        case 'event':
            $text = 'interest';
            break;
        case 'comment':
            $text = 'leave a tip';
            break;
    }
    return __($text, 'cimahiwall');
}

function activity_date( $date ) {
    return "on " . date('M d, Y', strtotime($date));
}

