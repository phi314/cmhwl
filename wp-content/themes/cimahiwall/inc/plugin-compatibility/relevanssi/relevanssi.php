<?php
/**
 * Created by "Unleashed Studios".
 * User: phi314
 * Date: 25/01/18
 * Time: 15:32
 */

/*
 * Continue if 's' is empty
 */
add_filter('relevanssi_search_ok', 'relevanssi_disable_filter');
function relevanssi_disable_filter($ok) {
    global $wp_query;
    if (empty($wp_query->query_vars['s']) || $wp_query->query_vars['s'] == " ") {
        return false;
    }
    else {
        return $ok;
    }
}