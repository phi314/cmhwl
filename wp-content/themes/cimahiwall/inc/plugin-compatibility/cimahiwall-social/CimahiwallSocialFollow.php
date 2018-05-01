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

    public function __construct( $current_user_id = false )
    {
        if( $current_user_id )
            $this->current_user_id = $current_user_id;
        else
            $this->current_user_id = get_current_user_id();
    }

    public function set_to_user_id( $to_user_id ) {
        $this->to_user_id = $to_user_id;
    }

    public function add_follow() {
        global $wpdb;

        $insert = false;
        if( $this->has_follow( $this->current_user_id, $this->to_user_id) == 0) {
            $wpdb->insert(
                $wpdb->prefix . "social_follow",
                [
                    'user_id' => $this->current_user_id,
                    'follow_user_id' => $this->to_user_id
                ]
            );

            $insert = true;
        }

        return $insert;
    }

    public function has_follow() {
        global $wpdb;

        $check = $wpdb->get_row("SELECT count(*) as total_count
                                FROM " . $wpdb->prefix . "social_follow 
                                WHERE user_id=$this->current_user_id AND follow_user_id=$this->to_user_id LIMIT 1");

        $has_follow = false;
        if($check->total_count > 0)
            $has_follow = true;

        return $has_follow;
    }

    public function remove_follow() {
        global $wpdb;

        $wpdb->delete(
            $wpdb->prefix . "social_follow",
            [
                'user_id' => $this->current_user_id,
                'follow_user_id' => $this->to_user_id
            ]
        );

        return true;
    }

    public function following() {
        global $wpdb;

        $result = $wpdb->get_results("
            SELECT f.follow_id, f.user_id, f.follow_user_id, u.display_name, u.user_nicename, u.user_email
            FROM " . $wpdb->prefix . "social_follow f
            JOIN " . $wpdb->prefix . "users u
            ON f.follow_user_id = u.ID
            WHERE f.user_id = $this->current_user_id
            ORDER BY f.follow_id DESC
        ");

        return $result;
    }

    public function followers() {
        global $wpdb;

        $result = $wpdb->get_results("
            SELECT f.follow_id, f.user_id as follow_user_id, f.follow_user_id as user_id, u.display_name, u.user_nicename, u.user_email
            FROM " . $wpdb->prefix . "social_follow f
            JOIN " . $wpdb->prefix . "users u
            ON f.user_id = u.ID
            WHERE f.follow_user_id = $this->current_user_id
            ORDER BY f.follow_id DESC
        ");

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
            SELECT ID as follow_user_id, display_name, user_nicename, user_email
            FROM " . $wpdb->prefix . "users
            WHERE ID != $this->current_user_id
        ";

        if( ! empty( $this->search) ) {
            $query .= " AND display_name LIKE '%$this->search%'";
        }

        $query .= " ORDER BY ID DESC";

        $result = $wpdb->get_results( $query );

        return $result;
    }

    public function search( $search ) {
        $this->search = $search;
    }
}