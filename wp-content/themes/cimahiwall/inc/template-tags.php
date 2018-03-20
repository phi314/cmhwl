<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WP_Bootstrap_Starter
 */

if ( ! function_exists( 'wp_bootstrap_starter_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function wp_bootstrap_starter_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'cimahiwall' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'cimahiwall' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span> | <span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

    if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
        echo ' | <span class="comments-link"><i class="fa fa-comments" aria-hidden="true"></i> ';
        /* translators: %s: post title */
        comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'cimahiwall' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
        echo '</span>';
    }

}
endif;

if ( ! function_exists( 'wp_bootstrap_starter_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function wp_bootstrap_starter_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'cimahiwall' ) );
		if ( $categories_list && wp_bootstrap_starter_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'cimahiwall' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'cimahiwall' ) );
		if ( $tags_list ) {
			printf( ' | <span class="tags-links">' . esc_html__( 'Tagged %1$s', 'cimahiwall' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}


	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'cimahiwall' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		' | <span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function wp_bootstrap_starter_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'wp_bootstrap_starter_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'wp_bootstrap_starter_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so wp_bootstrap_starter_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so wp_bootstrap_starter_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in wp_bootstrap_starter_categorized_blog.
 */
function wp_bootstrap_starter_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'wp_bootstrap_starter_categories' );
}
add_action( 'edit_category', 'wp_bootstrap_starter_category_transient_flusher' );
add_action( 'save_post',     'wp_bootstrap_starter_category_transient_flusher' );


if ( ! function_exists( 'wp_bootstrap_starter_comment' ) ) :
    /**
     * Template for comments and pingbacks.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     */
    function wp_bootstrap_starter_comment( $comment, $args, $depth ) {
       // $GLOBALS['comment'] = $comment;

        if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

            <li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'media' ); ?>>
            <div class="comment-body">
                <?php _e( 'Pingback:', 'cimahiwall' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'cimahiwall' ), '<span class="edit-link">', '</span>' ); ?>
            </div>

        <?php else : ?>

        <li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body media mb-4">
                <a class="pull-left" href="#">
                    <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
                </a>

                <div class="media-body">
                    <div class="media-body-wrap card">

                        <div class="card-header">
                            <div class="mt-0">
                                <?php echo get_comment_author_link(); ?>
                                <?php if(get_the_author() == $comment->comment_author) : ?>
                                        <span class="badge badge-info">Pengelola</span>
                                <?php endif; ?>,
                                <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                                    <small datetime="<?php comment_time( 'c' ); ?>">
                                        <?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'cimahiwall' ), get_comment_date(), get_comment_time() ); ?>
                                    </small>
                                </a>
                                <?php edit_comment_link( __( '<span style="margin-left: 5px;" class="glyphicon glyphicon-edit"></span> Edit', 'cimahiwall' ), '<span class="edit-link">', '</span>' ); ?>
                            </div>

                        </div>

                        <?php if ( '0' == $comment->comment_approved ) : ?>
                            <p class="comment-awaiting-moderation alert alert-warning"><?php _e( 'Your comment is awaiting moderation.', 'cimahiwall' ); ?></p>
                        <?php endif; ?>

                        <div class="comment-content card-block">
                            <?php
                            if( empty($comment->comment_parent)) :
                                $rating = get_comment_meta( $comment->comment_ID, 'cimahiwall_rating', true );
                                $is_selected = "selected='selected'";
                            ?>
                                <select class="cimahiwall_rating_only">
                                    <option <?php echo $rating == '' ? $is_selected : ''; ?> value=""></option>
                                    <option <?php echo $rating == 1 ? $is_selected : ''; ?> value="1">1</option>
                                    <option <?php echo $rating == 2 ? $is_selected : ''; ?> value="2">2</option>
                                    <option <?php echo $rating == 3 ? $is_selected : ''; ?> value="3">3</option>
                                    <option <?php echo $rating == 4 ? $is_selected : ''; ?> value="4">4</option>
                                    <option <?php echo $rating == 5 ? $is_selected : ''; ?> value="5">5</option>
                                </select>

                            <?php endif; ?>
                            <?php comment_text(); ?>
                        </div><!-- .comment-content -->

                        <?php comment_reply_link(
                            array_merge(
                                $args, array(
                                    'add_below' => 'div-comment',
                                    'depth' 	=> $depth,
                                    'max_depth' => $args['max_depth'],
                                    'before' 	=> '<footer class="reply comment-reply card-footer">',
                                    'after' 	=> '</footer><!-- .reply -->'
                                )
                            )
                        ); ?>

                    </div>
                </div><!-- .media-body -->

            </article><!-- .comment-body -->

            <?php
        endif;
    }
endif; // ends check for wp_bootstrap_starter_comment()
