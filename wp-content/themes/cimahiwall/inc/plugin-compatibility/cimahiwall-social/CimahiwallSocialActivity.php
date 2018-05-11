<?php

/**
 * Created by Customy.
 * User: Indosoft
 * Date: 4/17/2018
 * Time: 12:45 PM
 */


class CimahiwallSocialActivity
{
    private $activity_id;
    private $object_type;
    private $object_id;
    protected $user_id;
    private $created_date;
    private $post_id;
    private $name;
    private $comment;

    protected $last_activity_id;
    protected $activity_mode = 'own';
    protected $activity_limit = 10;

    public function __construct( $user_id = false )
    {
        if( empty( $user_id ))
            $user_id = get_current_user_id();

        $this->user_id = $user_id;
    }

    public function set_activity_id ($activity_id) {
        $this->activity_id = $activity_id;
    }

    public function set_object_type ($object_type) {
        $this->object_type = $object_type;
    }

    public function set_object_id ($object_id) {
        $this->object_id = $object_id;
    }

    public function set_user_id ( $user_id ) {
        $this->user_id = $user_id;
    }

    public function set_created_date ( $created_date ) {
        $this->created_date = $created_date;
    }

    public function set_post_id ( $post_id ) {
        $this->post_id = $post_id;
    }

    public function set_name ( $name ) {
        $this->name = $name;
    }

    public function set_comment( $comment ) {
        $this->comment = $comment;
    }

    public function set_activity_mode ( $activity_mode ) {
        $this->activity_mode = $activity_mode;
    }

    public function set_last_activity_id ( $last_activity_id ) {
        $this->last_activity_id = $last_activity_id;
    }

    public function set_activity_limit ( $activity_limit ) {
        $this->activity_limit = $activity_limit;
    }

    public function insert() {
        global $wpdb;

        $wpdb->insert(
            $wpdb->prefix . "social_activity",
            [
                'object_type' => $this->object_type,
                'object_id' => $this->object_id,
                'user_id' => $this->user_id
            ]
        );
    }

    public function get_activity_post_type() {
        $post_type = $this->object_type;
        if( $this->object_type == 'comment')
            $post_type = 'place';

        return $post_type;
    }

    private function count_user_visited_place( $today = false ) {
        global $wpdb;

        $query = "
            SELECT count(*) as total_count
            FROM
            ".$wpdb->prefix."social_activity
            WHERE object_id = '$this->object_id'
            AND user_id = '$this->user_id'
            AND object_type = 'place'
        ";

        if( $today ) $query .= " AND date(created_date) = CURDATE()";

        $activities = $wpdb->get_row( $query );

        return $activities->total_count;
    }

    /*
     * Check whether user has visited place today
     */
    public function is_user_visited_place_today() {
        return $this->count_user_visited_place( true ) > 0 ? true : false;
    }

    /*
     * Check user is visited the place
     */
    public function is_user_has_visited_place() {
        return $this->count_user_visited_place() > 0 ? true : false;
    }

    private function count_user_insterest_event() {
        global $wpdb;

        $activities = $wpdb->get_row("
            SELECT count(*) as total_count
            FROM
            ".$wpdb->prefix."social_activity
            WHERE object_id = '$this->object_id'
            AND user_id = '$this->user_id'
            AND object_type = 'event'
        ");

        return $activities->total_count;
    }

    public function is_user_had_interest_event() {
        return $this->count_user_insterest_event() > 0 ? true : false;
    }

    /**
     * @return array|null|object
     */
    public function activity_listing() {
        global $wpdb;

        $query = "SELECT *
                    FROM (
                        SELECT a.*, p.ID as post_id, p.post_title as name, NULL as comment FROM ".$wpdb->prefix."social_activity a
                        LEFT JOIN ".$wpdb->prefix."posts p ON p.ID = a.object_ID
                        WHERE a.object_type = p.post_type
                        UNION
                        SELECT a.*, c.comment_post_ID as post_id, p.post_title as name, c.comment_content as comment FROM ".$wpdb->prefix."social_activity a
                        LEFT JOIN ".$wpdb->prefix."comments c ON c.comment_ID = a.object_ID
                        LEFT JOIN ".$wpdb->prefix."posts p ON p.ID = c.comment_post_ID
                        WHERE a.object_type = 'comment'
                    ) as u";

        // My Activity
        switch ( $this->activity_mode ) {
            case 'friend' :
                $follow = new CimahiwallSocialFollow();
                $friends = $follow->following();
                $friends_temp = [$this->user_id];
                foreach ($friends as $friend)
                    $friends_temp[] = (int) $friend->friend_id;

                $friends = join(',', $friends_temp);
                $query .= " WHERE u.user_id IN ( $friends )";
                break;
            case 'everyone' :
                $query .= "";
                break;
            default :
                $query .= " WHERE u.user_id = $this->user_id";
                break;
        }

        $query .= " ORDER BY u.activity_id DESC";
        $query .= " LIMIT $this->activity_limit";

        $activities = $wpdb->get_results( $query );

        return $activities;
    }

    public function delete() {
        global $wpdb;

        $delete = $wpdb->delete($wpdb->prefix.'social_activity', ['activity_id' => $this->activity_id, 'user_id' => $this->user_id] );

        return $delete;
    }
}

class CimahiwallSocialActivityPagination extends CimahiwallSocialActivity {

    public function activity_left_count() {
        global $wpdb;

        $query = "SELECT count(*) as total_activity
                        FROM ".$wpdb->prefix."social_activity
                        WHERE activity_id < $this->last_activity_id";


        switch ( $this->activity_mode ) {
            case 'friend' :
                $follow = new CimahiwallSocialFollow();
                $friends = $follow->following();
                $friends_temp = [$this->user_id];
                foreach ($friends as $friend)
                    $friends_temp[] = (int) $friend->follow_user_id;

                $friends = join(',', $friends_temp);
                $query .= " AND user_id IN ( $friends )";
                break;
            default :
                $query .= " AND user_id = $this->user_id";
                break;
        }

        $activities = $wpdb->get_row( $query );

        return $activities->total_activity;
    }

    public function activity_left_result() {
        global $wpdb;

        $query = "SELECT *
                    FROM (
                        SELECT a.*, p.ID as post_id, p.post_title as name, NULL as comment FROM ".$wpdb->prefix."social_activity a
                        LEFT JOIN ".$wpdb->prefix."posts p ON p.ID = a.object_ID
                        WHERE a.object_type = p.post_type
                        UNION
                        SELECT a.*, c.comment_post_ID as post_id, p.post_title as name, c.comment_content as comment FROM ".$wpdb->prefix."social_activity a
                        LEFT JOIN ".$wpdb->prefix."comments c ON c.comment_ID = a.object_ID
                        LEFT JOIN ".$wpdb->prefix."posts p ON p.ID = c.comment_post_ID
                        WHERE a.object_type = 'comment'
                    ) as u
                     WHERE u.activity_id < $this->last_activity_id";

        // My Activity
        switch ( $this->activity_mode ) {
            case 'friend' :
                $follow = new CimahiwallSocialFollow();
                $friends = $follow->following();
                $friends_temp = [$this->user_id];
                foreach ($friends as $friend)
                    $friends_temp[] = (int) $friend->friend_id;

                $friends = join(',', $friends_temp);
                $query .= " AND u.user_id IN ( $friends )";
                break;
            case 'everyone' :
                $query .= "";
                break;
            default :
                $query .= " AND u.user_id = $this->user_id";
                break;
        }

        $query .= " ORDER BY u.activity_id DESC";
        $query .= " LIMIT $this->activity_limit";

        $activities = $wpdb->get_results( $query );

        return $activities;
    }

}

