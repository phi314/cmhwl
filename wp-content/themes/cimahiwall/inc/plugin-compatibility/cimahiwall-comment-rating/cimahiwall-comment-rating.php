<?php
/**
 * Created by "Unleashed Studios".
 * User: phi314
 * Date: 16/01/18
 * Time: 20:59
 */

/**
 * Add our field to the comment form
 */
add_action( 'comment_form_logged_in_after', 'cimahiwall_rating_field' );
add_action( 'comment_form_after_fields', 'cimahiwall_rating_field' );
function cimahiwall_rating_field()
{
    ?>
    <div id="cimahiwall-rating-container">
        <label for="cimahiwall-rate"><?php _e( 'Rating:' ); ?></label>
        <select id="cimahiwall-rate" name="cimahiwall_rating" required>
            <option value=""></option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
    </div>
    <?php
}

/**
 * Add the title to our admin area, for editing, etc
 */
add_action( 'add_meta_boxes_comment', 'cimahiwall_comment_add_meta_box_rating' );
function cimahiwall_comment_add_meta_box_rating()
{
    add_meta_box( 'cimahiwall-comment-rating', __( 'Rating' ), 'cimahiwall_comment_meta_box_rating', 'comment', 'normal', 'high' );
}
function cimahiwall_comment_meta_box_rating( $comment )
{
    if( empty($comment->comment_parent) ) {
        $rating = get_comment_meta($comment->comment_ID, 'cimahiwall_rating', true);
        $is_selected = "selected='selected'";
        wp_nonce_field('cimahiwall_comment_update', 'cimahiwall_comment_update', false);
        ?>
        <select id="cimahiwall-rate" name="cimahiwall_rating" required>
            <option <?php echo $rating == 1 ? $is_selected : ''; ?> value="1">1</option>
            <option <?php echo $rating == 2 ? $is_selected : ''; ?> value="2">2</option>
            <option <?php echo $rating == 3 ? $is_selected : ''; ?> value="3">3</option>
            <option <?php echo $rating == 4 ? $is_selected : ''; ?> value="4">4</option>
            <option <?php echo $rating == 5 ? $is_selected : ''; ?> value="5">5</option>
        </select>
        <?php
    }
}

/**
 * Validate Rating is Required
 *
 * @param $commentdata
 * @return mixed
 */
function preprocess_comment_validate_rating( $commentdata ) {
    // If not reply comment
    if( empty($_POST['comment_parent']) ) {
        if (empty($_POST['cimahiwall_rating'])) {
            wp_die('<p>Jangan lupa kasih rating ya . . .</p><p><a href="javascript:history.back()">« Back</a></p>');
        }
    }

    return $commentdata;
}
add_filter( 'preprocess_comment' , 'preprocess_comment_validate_rating' );

/**
 * Save rating (from the admin area)
 */
add_action( 'edit_comment', 'cimahiwall_comment_edit_comment' );
function cimahiwall_comment_edit_comment( $comment_id )
{
    if( ! isset( $_POST['cimahiwall_comment_update'] ) || ! wp_verify_nonce( $_POST['cimahiwall_comment_update'], 'cimahiwall_comment_update' ) ) return;
    if( isset( $_POST['cimahiwall_rating'] ) ) {
        update_comment_meta( $comment_id, 'cimahiwall_rating', esc_attr( $_POST['cimahiwall_rating'] ) );
        // If not reply comment
        if( empty($_POST['comment_parent']) ) {
            cimahiwall_update_post_rating( $_POST['comment_post_ID'] );
        }
    }
}

/**
 * Save rating (from the front end)
 */
add_action( 'comment_post', 'cimahiwall_insert_comment_rating', 10, 1 );
function cimahiwall_insert_comment_rating( $comment_id )
{
    if( isset( $_POST['cimahiwall_rating'] ) ) {
        update_comment_meta($comment_id, 'cimahiwall_rating', esc_attr($_POST['cimahiwall_rating']));
        // If not reply comment
        if( empty($_POST['comment_parent']) ) {
            cimahiwall_update_post_rating( $_POST['comment_post_ID'] );
        }
    }

}

/**
 * Get Total Rating
 * can be from all or meta post
 *
 *
 * @param $post_id
 * @return int
 */
function cimahiwall_get_total_rating( $post_id ) {

    $args['post_id'] = $post_id;
    $args['status'] = 'approve';
    $total_rating = 0;

    $comments = get_comments($args);
    foreach ($comments as $comment) {
        $rating = get_comment_meta( $comment->comment_ID, 'cimahiwall_rating', true );
        $total_rating = $total_rating + $rating;
    }

    return $total_rating;
}

/**
 *
 * Get Average Rating
 *
 * @param $post_id
 * @param string $source
 * @return float|int|mixed
 */
function cimahiwall_get_average_rating( $post_id, $source = 'post' ) {

    $args['post_id'] = $post_id;
    $args['status'] = 'approve';
    $avg_rating = 0;

    if( $source == 'post' ) {
        $post_avg_rating = (float) get_post_meta($post_id, 'cimahiwall_avg_rating', true);
        if( ! empty($post_avg_rating) && is_float($post_avg_rating) ){
            $avg_rating = $post_avg_rating;
        }
    }
    elseif( $source == 'all') {
        $total_rating = cimahiwall_get_total_rating($post_id);
        $total_review = get_comment_count($post_id);
        if( $total_review['approved'] > 0) {
            $avg_rating = ($total_rating / $total_review['approved']);
            $avg_rating = round($avg_rating, 1);
        }
    }

    if($avg_rating == 0)
    {
        $google_place = get_post_meta($post_id, 'google_place_json', true);
        $avg_rating = $google_place->result->rating;
    }

    return (float) $avg_rating;
}

function cimahiwall_update_post_rating ( $post_id ) {
    $avg_rating = cimahiwall_get_average_rating( $post_id, 'all' );
    update_post_meta( $post_id, 'cimahiwall_avg_rating', $avg_rating);
}

/*
 * Add Column on Admin
 */
add_filter("manage_edit-comments_columns", 'cimahiwall_add_columns_to_comment');
function cimahiwall_add_columns_to_comment($cols)
{
    $cols['rating'] = __('Rating', 'Cimahiwall');
    return $cols;
}
add_action('manage_comments_custom_column', 'cimahiwall_column_comment', 10, 2);
function cimahiwall_column_comment($col, $comment_id)
{
    // you could expand the switch to take care of other custom columns
    switch($col)
    {
        case 'rating':
            if($t = get_comment_meta($comment_id, 'cimahiwall_rating', true))
            {
                echo esc_html($t);
            }
            else
            {
                esc_html_e('No Rating', 'cimahiwall');
            }
            break;
    }
}
