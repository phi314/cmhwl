<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

    <?php
    // You can start editing here -- including this comment!
    if ( have_comments() ) : ?>

        <h4><?php _e('Tips', 'cimahiwall'); ?></h4>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
            <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
                <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'cimahiwall' ); ?></h2>
                <div class="nav-links">

                    <div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'cimahiwall' ) ); ?></div>
                    <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'cimahiwall' ) ); ?></div>

                </div><!-- .nav-links -->
            </nav><!-- #comment-nav-above -->
        <?php endif; // Check for comment navigation. ?>

        <ul class="comment-list">
            <?php
            wp_list_comments( array( 'callback' => 'wp_bootstrap_starter_comment', 'avatar_size' => 50 ));
            ?>
        </ul><!-- .comment-list -->

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
            <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
                <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'cimahiwall' ); ?></h2>
                <div class="nav-links">

                    <div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'cimahiwall' ) ); ?></div>
                    <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'cimahiwall' ) ); ?></div>

                </div><!-- .nav-links -->
            </nav><!-- #comment-nav-below -->
            <?php
        endif; // Check for comment navigation.

    endif; // Check for have_comments().


    // If comments are closed and there are comments, let's leave a little note, shall we?
    if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

        <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'cimahiwall' ); ?></p>
        <?php
    endif; ?>

    <?php comment_form( $args = array(
        'id_form'           => 'commentform',  // that's the wordpress default value! delete it or edit it ;)
        'id_submit'         => 'commentsubmit',
        'title_reply_before' => '<h4 id="reply-title" class="comment-reply-title">',
        'title_reply_after'  => '</h4>',
        'title_reply'       => __( '', 'cimahiwall' ),  // that's the wordpress default value! delete it or edit it ;)
        'title_reply_to'    => __( 'Leave a Reply to %s', 'cimahiwall' ),  // that's the wordpress default value! delete it or edit it ;)
        'cancel_reply_link' => __( 'Cancel Reply', 'cimahiwall' ),  // that's the wordpress default value! delete it or edit it ;)
        'label_submit'      => __( 'Post Comment', 'cimahiwall' ),  // that's the wordpress default value! delete it or edit it ;)

        'comment_field' =>  '<p><textarea placeholder="'. __('Leave your own tip (favorite things to do, food, etc..)', 'cimahiwall') .'" id="comment" class="form-control" name="comment" cols="45" rows="8" maxlength="500" aria-required="true"></textarea></p>',

        'fields' => apply_filters( 'comment_form_default_fields', array(
            'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Nama' ) . '</label> ' . ( $req ? '<span>*</span>' : '' ) .
                '<input id="author" name="author" class="form-control" type="text" placeholder="' . __( 'Nama' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',

            'email'  => '<p class="comment-form-email">' .
                '<label for="email">' . __( 'Email' ) . '</label> ' .
                ( $req ? '<span>*</span>' : '' ) .
                '<input id="email" name="email" class="form-control" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />'.'</p>',
            ) ),


        // So, that was the needed stuff to have bootstrap basic styles for the form elements and buttons

        // Basically you can edit everything here!
        // Checkout the docs for more: http://codex.wordpress.org/Function_Reference/comment_form
        // Another note: some classes are added in the bootstrap-wp.js - ckeck from line 1

    ));

	?>

</div><!-- #comments -->
