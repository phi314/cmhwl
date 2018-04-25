<?php

/**
 * Created by Customy.
 * User: Indosoft
 * Date: 4/17/2018
 * Time: 12:45 PM
 */
class CimahiwallSocialActivity
{
    public $activity_id;
    public $object_type;
    public $object_id;
    public $user_id;
    public $created_date;
    public $post_id;
    public $name;
    public $comment;

    public function __construct( $data = false )
    {
        $this->user_id = get_current_user_id();

        if( $data != false)
            $this->init_data( $data );
    }

    public function init_data($data) {
        $this->activity_id = $data['activity_id'];
        $this->object_id = $data['object_id'];
        $this->object_type = $data['object_type'];
        $this->user_id = $data['user_id'];
        $this->created_date = $data['created_date'];
        $this->post_id = $data['post_id'];
        $this->name = $data['name'];
        $this->comment = $data['comment'];
    }

    public function set_activity_id ($activity_id) {
        $this->activity_id = $activity_id;
    }

    public function set_object_id ($object_id) {
        $this->object_id = $object_id;
    }

    public function set_object_type ($object_type) {
        $this->object_type = $object_type;
    }

    public function set_user_id ( $user_id ) {
        $this->user_id = $user_id;
    }

    public function add_activity( $object_type, $object_id, $user_id ) {
        global $wpdb;

        $wpdb->insert(
            $wpdb->prefix . "social_activity",
            [
                'object_type' => $object_type,
                'object_id' => $object_id,
                'user_id' => $user_id
            ]
        );
    }

    public function activity_date() {
        return "on " . date('m d, Y', strtotime($this->created_date));
    }

    public function activity_text() {
        $text = 'visited';
        switch ($this->object_type) {
            case 'event':
                $text = 'interest';
                break;
            case 'comment':
                $text = 'leave a tip';
                break;
        }
        return __($text, 'cimahiwall');
    }

    public function get_activity_post_type() {
        $post_type = $this->object_type;
        if( $this->object_type == 'comment')
            $post_type = 'place';

        return $post_type;
    }

    /*
     * Check whether user has visited place today
     */
    public function is_user_visited_today() {
        global $wpdb;

        $activities = $wpdb->get_row("
            SELECT count(*) as total_count
            FROM
            ".$wpdb->prefix."social_activity
            WHERE object_id = '$this->object_id'
            AND user_id = '$this->user_id'
            AND object_type = 'place'
            AND date(created_date) = CURDATE()
        ");

        return $activities->total_count > 0 ? true : false;
    }

    public function is_user_had_interest() {
        global $wpdb;

        $activities = $wpdb->get_row("
            SELECT count(*) as total_count
            FROM
            ".$wpdb->prefix."social_activity
            WHERE object_id = '$this->object_id'
            AND user_id = '$this->user_id'
            AND object_type = 'event'
        ");

        return $activities->total_count > 0 ? true : false;
    }

    /*
     * Check user is visited the place
     */
    public function is_user_has_visited() {
        if( $this->count_user_visited_place() > 1)
            return true;
        else
            return false;
    }

    public function count_user_visited_place() {
        global $wpdb;

        $activities = $wpdb->get_row("
            SELECT count(*) as total_count
            FROM
            ".$wpdb->prefix."social_activity
            WHERE object_id = '$this->object_id'
            AND user_id = '$this->user_id'
            AND object_type = 'place'
            LIMIT 1
        ");

        return $activities->total_count;
    }

    /**
     * mode = own | friends | everyone
     *
     * @param bool $last_activity_id
     * @param int $limit
     * @param string $mode
     * @return array|null|object
     */
    public function activity_listing($last_activity_id = false, $limit = 2, $mode = 'own') {
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

        // 2
        if( is_int($last_activity_id) )
            $query .= " WHERE u.activity_id < $last_activity_id";

        // My Activity
        switch ( $mode ) {
            case 'own' :
                $query .= ! (is_int($last_activity_id)) ? ' WHERE' : ' AND';
                $query .= " u.user_id = $this->user_id";
                break;
            case 'friend' :
                $follow = new CimahiwallSocialFollow();
                $friends = $follow->following();
                $friends_temp = [$this->user_id];
                foreach ($friends as $friend)
                    $friends_temp[] = (int) $friend->follow_user_id;

                $friends = join(',', $friends_temp);
                $query .= ! (is_int($last_activity_id)) ? ' WHERE' : ' AND';
                $query .= " u.user_id IN ( $friends )";
                break;
        }

        $query .= " ORDER BY u.activity_id DESC";
        $query .= " LIMIT $limit";

        $activities = $wpdb->get_results( $query );

        return $activities;
    }

    public function activity_left($last_activity_id = false ) {
        global $wpdb;

        $query = "SELECT count(*) as total_activity
                        FROM ".$wpdb->prefix."social_activity";

        // 1
        if( is_int($last_activity_id) )
            $query .= " WHERE activity_id < $last_activity_id";

        // 2
        if( is_int($this->user_id)) {
            $query .= ! (is_int($last_activity_id)) ? ' WHERE' : ' AND';
            $query .= " u.user_id = $this->user_id";
        }

        $activities = $wpdb->get_row( $query );

        return $activities->total_activity;
    }

    public function delete_activity( $activity_id ) {
        global $wpdb;

        $delete = $wpdb->delete($wpdb->prefix.'social_activity', ['activity_id' => $activity_id, 'user_id' => $this->user_id] );

        return $delete;
    }
}