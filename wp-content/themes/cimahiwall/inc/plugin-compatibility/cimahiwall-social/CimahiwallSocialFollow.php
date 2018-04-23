<?php

/**
 * Created by Customy.
 * User: Indosoft
 * Date: 4/23/2018
 * Time: 4:22 PM
 */
class CimahiwallSocialFollow
{
    public function add_follow( $from_user_id, $to_user_id ) {
        global $wpdb;

        $wpdb->insert(
            $wpdb->prefix . "social_follow",
            [
                'user_id' => $from_user_id,
                'follow_user_id' => $to_user_id
            ]
        );
    }
}