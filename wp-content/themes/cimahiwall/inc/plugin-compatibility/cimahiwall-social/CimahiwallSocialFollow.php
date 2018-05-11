<?php

/**
 * Created by Customy.
 * User: Indosoft
 * Date: 4/23/2018
 * Time: 4:22 PM
 */
class CimahiwallSocialFollow
{
    public $current_user_id;
    public $to_user_id;
    private $search;
    protected $limit = false;
    protected $follow_type;

    public function __construct( $current_user_id = false )
    {
        if( $current_user_id )
            $this->current_user_id = $current_user_id;
        else
            $this->current_user_id = get_current_user_id();
    }

    public function set_limit ( $limit ) {
        $this->limit = $limit;
    }

    public function set_follow_type ( $follow_type ) {
        $this->follow_type = $follow_type;
    }

    public function add_follow( $friend_id ) {
        global $wpdb;

        $insert = false;
        if( $this->has_follow( $friend_id ) == 0) {
            $wpdb->insert(
                $wpdb->prefix . "social_follow",
                [
                    'user_id' => $this->current_user_id,
                    'follow_user_id' => $friend_id
                ]
            );

            $insert = true;
        }

        return $insert;
    }

    public function has_follow( $friend_id ) {
        global $wpdb;

        $check = $wpdb->get_row("SELECT count(*) as total_count
                                FROM " . $wpdb->prefix . "social_follow 
                                WHERE user_id=$this->current_user_id AND follow_user_id=$friend_id LIMIT 1");

        $has_follow = false;
        if($check->total_count > 0)
            $has_follow = true;

        return $has_follow;
    }

    public function remove_follow( $friend_id ) {
        global $wpdb;

        $wpdb->delete(
            $wpdb->prefix . "social_follow",
            [
                'user_id' => $this->current_user_id,
                'follow_user_id' => $friend_id
            ]
        );

        return true;
    }

    public function following() {
        global $wpdb;

        $query = "
            SELECT f.follow_id, f.follow_user_id as friend_id, u.display_name, u.user_nicename, u.user_email
            FROM " . $wpdb->prefix . "social_follow f
            JOIN " . $wpdb->prefix . "users u
            ON f.follow_user_id = u.ID
            WHERE f.user_id = $this->current_user_id
            ORDER BY f.follow_id DESC";

        // limit
        if( is_int($this->limit) ) $query .= " LIMIT " . $this->limit;

        $result = $wpdb->get_results($query);

        return $result;
    }

    public function followers() {
        global $wpdb;
        $query = "
            SELECT f.follow_id, f.user_id as friend_id, u.display_name, u.user_nicename, u.user_email
            FROM " . $wpdb->prefix . "social_follow f
            JOIN " . $wpdb->prefix . "users u
            ON f.user_id = u.ID
            WHERE f.follow_user_id = $this->current_user_id
            ORDER BY f.follow_id DESC
        ";

        // limit
        if( is_int($this->limit) ) $query .= " LIMIT " . $this->limit;

        $result = $wpdb->get_results($query);

        return $result;
    }

    public function count_following() {
        global $wpdb;

        $result = $wpdb->get_row("
            SELECT count(*) as total_count
            FROM " . $wpdb->prefix . "social_follow f
            JOIN " . $wpdb->prefix . "users u
            ON f.follow_user_id = u.ID
            WHERE f.user_id = $this->current_user_id
        ");

        return $result->total_count;
    }

    public function count_followers() {
        global $wpdb;

        $result = $wpdb->get_row("
            SELECT count(*) as total_count
            FROM " . $wpdb->prefix . "social_follow f
            JOIN " . $wpdb->prefix . "users u
            ON f.user_id = u.ID
            WHERE f.follow_user_id = $this->current_user_id
        ");

        return $result->total_count;
    }

    public function everyone() {
        global $wpdb;

        $query = "
            SELECT ID as friend_id, display_name, user_nicename, user_email
            FROM " . $wpdb->prefix . "users
            WHERE ID != $this->current_user_id
        ";

        if( ! empty( $this->search) ) {
            $query .= " AND display_name LIKE '%$this->search%'";
        }

        $query .= " ORDER BY ID DESC";

        // limit
        if( is_int($this->limit) ) $query .= " LIMIT " . $this->limit;

        $result = $wpdb->get_results( $query );

        return $result;
    }

    public function search( $search ) {
        $this->search = $search;
    }
}

class CimahiwallSocialFollowPagination extends CimahiwallSocialFollow {

    private $last_follow_id;
    private $last_user_id;

    public function set_last_follow_id( $follow_id ) {
        $this->last_follow_id = $follow_id;
    }

    public function set_last_user_id( $user_id ) {
        $this->last_user_id = $user_id;
    }

    public function left_count() {
        switch ( $this->follow_type ) {
            case "followers":
                return $this->followers_left_count();
                break;
            case "following":
                return $this->following_left_count();
                break;
            default:
                return $this->everyone_left_count();
                break;
        }
    }

    public function left_result() {
        switch ( $this->follow_type ) {
            case "followers":
                return $this->followers_left_result();
                break;
            case "following":
                return $this->following_left_result();
                break;
            default:
                return $this->everyone_left_result();
                break;
        }
    }

    public function followers_left_count(){
        global $wpdb;

        $result = $wpdb->get_row("
            SELECT count(*) as total_count
            FROM " . $wpdb->prefix . "social_follow f
            JOIN " . $wpdb->prefix . "users u
            ON f.user_id = u.ID
            WHERE f.follow_user_id = $this->current_user_id
            AND f.follow_id < $this->last_follow_id
        ");

        return $result->total_count;
    }
    public function followers_left_result(){
        global $wpdb;
        $query = "
            SELECT f.follow_id, f.user_id as friend_id, u.display_name, u.user_nicename, u.user_email
            FROM " . $wpdb->prefix . "social_follow f
            JOIN " . $wpdb->prefix . "users u
            ON f.user_id = u.ID
            WHERE f.follow_user_id = $this->current_user_id
            AND f.follow_id < $this->last_follow_id
            ORDER BY f.follow_id DESC
        ";

        // limit
        if( is_int($this->limit) ) $query .= " LIMIT " . $this->limit;

        $result = $wpdb->get_results($query);

        return $result;
    }
    public function following_left_count(){
        global $wpdb;

        $query = "
            SELECT count(*) as total_count
            FROM " . $wpdb->prefix . "social_follow f
            JOIN " . $wpdb->prefix . "users u
            ON f.follow_user_id = u.ID
            WHERE f.user_id = $this->current_user_id
            AND f.follow_id < $this->last_follow_id
        ";

        $result = $wpdb->get_row( $query );

        return $result->total_count;
    }
    public function following_left_result(){
        global $wpdb;

        $query = "
            SELECT f.follow_id, f.follow_user_id as friend_id, u.display_name, u.user_nicename, u.user_email
            FROM " . $wpdb->prefix . "social_follow f
            JOIN " . $wpdb->prefix . "users u
            ON f.follow_user_id = u.ID
            WHERE f.user_id = $this->current_user_id
            AND f.follow_id < $this->last_follow_id
            ORDER BY f.follow_id DESC
        ";
        if( is_int($this->limit) ) $query .= " LIMIT " . $this->limit;

        $result = $wpdb->get_results( $query );

        return $result;
    }

    public function everyone_left_count() {
        global $wpdb;

        $query = "SELECT count(*) as total_users
                        FROM ".$wpdb->prefix."users
                        WHERE ID < $this->last_user_id
                        AND ID <> $this->current_user_id";

        $activities = $wpdb->get_row( $query );
        return $activities->total_users;
    }

    public function everyone_left_result() {
        global $wpdb;

        $query = "
            SELECT ID as friend_id, display_name, user_nicename, user_email
            FROM " . $wpdb->prefix . "users
            WHERE ID <> $this->current_user_id
            AND ID < $this->last_user_id
        ";
        $query .= " ORDER BY ID DESC";

        if( is_int($this->limit) ) $query .= " LIMIT " . $this->limit;

        $result = $wpdb->get_results( $query );

        return $result;
    }

}