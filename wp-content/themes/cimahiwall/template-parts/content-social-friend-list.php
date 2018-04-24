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
$follow = new CimahiwallSocialFollow();
$follow->set_from_user_id( $user_id );

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

    <?php if( !empty( $follow_type )) : ?>
        <a class="btn btn-sm btn-common btn-block" href="<?php echo home_url('friends'); ?>"><?php _e('Find friends', 'cimahiwall'); ?></a>
    <?php endif; ?>

    <?php
    foreach ($friends as $friend) :
    ?>
    <div class="row friend my-3">
        <div class="col-2 col-md-1 pr-0 pr-md-3">
            <?php echo get_avatar( $friend->follow_user_id ); ?>
        </div>
        <div class="col-6 col-md-7 pr-0 pr-md-3 my-auto">
            <a href="<?php echo home_url('profile/' . $friend->user_nicename); ?>"><?php echo $friend->display_name; ?></a>
        </div>
        <div class="col-4 my-auto">
            <?php if( $current_user->ID != $friend->follow_user_id) : ?>
                <form action="<?php echo admin_url('admin-post.php'); ?>" method="post" class="form-follow-user user-id-<?php echo $friend->follow_user_id; ?> text-right">
                    <?php wp_nonce_field( 'log_follow_user'); ?>
                    <input type="hidden" name="user_id" value="<?php echo $friend->follow_user_id; ?>">
                    <?php
                    $follow->set_from_user_id( $current_user->ID );
                    $follow->set_to_user_id( $friend->follow_user_id );
                    $has_follow = $follow->has_follow();
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
    <?php endforeach; ?>
