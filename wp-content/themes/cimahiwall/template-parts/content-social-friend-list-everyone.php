<?php
/**
 * Created by Customy.
 * User: Indosoft
 * Date: 4/24/2018
 * Time: 2:11 PM
 */
global $current_user;

$user_id = get_query_var( 'user_id' );
$follow_type = get_query_var( 'follow_type' );
$follow = new CimahiwallSocialFollow( $user_id );
$follow->set_limit( 2 );
$search = get_query_var('search');
$last_user_id = "";
$last_follow_id = "";

if( ! empty( $search )) {
    $follow->search( $search );
}

switch ( $follow_type ) {
    case 'following':
        $friends = $follow->following();
        break;
    case 'followers':
        $friends = $follow->followers();
        break;
    default:
        $friends = $follow->everyone();
        break;
}
?>

    <?php if( ! is_page( 'friends' ) && $user_id == get_current_user_id() ) : ?>
        <a class="btn btn-sm btn-common btn-block" href="<?php echo home_url('friends'); ?>"><?php _e('Find friends', 'cimahiwall'); ?></a>
    <?php endif; ?>

    <div id="friends-container-<?php echo $follow_type; ?>">
        <?php
        if( ! empty( $friends )) :
        foreach ($friends as $friend) :
            ?>
            <div id="friend-<?php echo $friend->ID; ?>" class="row friend my-3">
                <div class="col-2 col-md-1 pr-0 pr-md-3">
                    <?php echo get_avatar( $friend->ID ); ?>
                </div>
                <div class="col-6 col-md-7 pr-0 pr-md-3 my-auto">
                    <a href="<?php echo home_url('profile/' . $friend->user_nicename); ?>"><?php echo $friend->display_name; ?></a>
                </div>
                <div class="col-4 my-auto">
                    <?php if( $current_user->ID != $friend->ID) : ?>
                        <form action="<?php echo admin_url('admin-post.php'); ?>" method="post" class="form-follow-user user-id-<?php echo $friend->ID; ?> text-right">
                            <?php wp_nonce_field( 'log_follow_user'); ?>
                            <input type="hidden" name="user_id" value="<?php echo $friend->ID; ?>">
                            <?php
                            $has_follow = $follow->has_follow( $friend->ID );
                            if( $has_follow )
                                echo "<input type='hidden' name='unfollow'>";
                            ?>
                            <button class="btn btn-follow btn-common <?php echo $has_follow ? 'btn-filled' : ''; ?>">
                                <?php
                                $has_follow_text = 'Follow';
                                if( $has_follow )
                                    $has_follow_text = 'Following';

                                _e($has_follow_text, 'cimahiwall');
                                ?>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            <?php
            $last_user_id = $friend->ID;
            if( $follow_type != 'everyone' ) $last_follow_id = $friend->follow_id;

        endforeach;
        ?>
    </div>

    <?php
        $friends_pagination = new CimahiwallSocialFollowPagination( $user_id );
        $friends_pagination->set_last_user_id( $last_user_id );
        $friends_pagination->set_last_follow_id( $last_follow_id );
        $friends_pagination->set_follow_type( $follow_type );

        if( $friends_pagination->left_count() > 0 ) :
    ?>
        <input type="hidden" id="follow_type" value="<?php echo $follow_type; ?>">
        <input type="hidden" id="user-id" value="<?php echo $user_id; ?>">

        <button class="btn btn-common btn-block mt-4 loadmore-friends" value="<?php echo $last_user_id; ?>" data-last-follow-id="<?php echo $last_follow_id; ?>"><?php _e('Load more friends' ,'cimahiwall'); ?></button>
        <script type="html/tpl" id="friendTemplate">
            <div id="friend-{friend_id}" class="row friend my-3">
                <div class="col-2 col-md-1 pr-0 pr-md-3">
                    {avatar}
                </div>
                <div class="col-6 col-md-7 pr-0 pr-md-3 my-auto">
                    <a href="{user_link}">{display_name}</a>
                </div>
                <div class="col-4 my-auto">
                    <form action="<?php echo admin_url('admin-post.php'); ?>" method="post" class="form-follow-user user-id-{friend_id} text-right">
                        <?php wp_nonce_field( 'log_follow_user'); ?>
                        <input type="hidden" name="user_id" value="{friend_id}">
                        {unfollow_input}
                        <button class="btn btn-follow btn-common {has_follow_class}">
                            {has_follow_text}
                        </button>
                    </form>
                </div>
            </div>
        </script>
    <?php endif; ?>

    <?php
    else :
    ?>
        <div class="col-12 my-3 text-center">
            <div class="text-muted">
                <?php _e('Friends not found', 'cimahiwall'); ?>
            </div>
        </div>
    <?php endif; ?>
