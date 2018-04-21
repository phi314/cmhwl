<?php
/**
 * Created by Customy.
 * User: Indosoft
 * Date: 4/18/2018
 * Time: 4:06 PM
 */

$all_user = get_query_var('all_user');
$user_id = get_query_var('user_id');

$cimahiwall_activity = new CimahiwallSocialActivity();

// to showing all user activity
if( $all_user === true ) $cimahiwall_activity->set_all_user();

// to showing by user id
if( $user_id != false ) {
    $cimahiwall_activity->set_user_id( $user_id );
}

$activities = $cimahiwall_activity->activity_listing( false, 5 );
$last_activity_id = false;

if( ! empty($activities)) :
    ?>
    <div id="activity-container">
        <?php
        foreach ($activities as $activity) :
            $cimahiwall_activity = new CimahiwallSocialActivity((array) $activity);
            $user = get_userdata($cimahiwall_activity->user_id);
            $last_activity_id = $cimahiwall_activity->activity_id;
            ?>
            <div class="media border-bottom py-2">
                <!-- Avatar -->
                <?php echo get_avatar( $cimahiwall_activity->user_id, 24, '', $user->display_name, ['class'=>'mr-3 w-auto', 'width'=> 64, 'height'=> 64] ); ?>
                <!-- /. Avatar -->
                <div class="media-body">
                    <p class="mt-0">
                        <a href="<?php echo home_url('profile?u=' . $user->user_login); ?>"><?php echo $user->display_name; ?></a>
                        <?php echo $cimahiwall_activity->activity_text(); ?>
                        <small class="d-block">
                            <?php echo $cimahiwall_activity->activity_date(); ?>
                        </small>
                    </p>

                    <div>
                        <a href="<?php echo get_permalink( $cimahiwall_activity->post_id); ?>">
                            <div class="row">
                                <div class="col-4 col-md-3">
                                    <?php $featured_image = get_featured_post_image($cimahiwall_activity->post_id); ?>
                                    <img src="<?php echo $featured_image; ?>">
                                </div>
                                <div class="col-8 col-md-9 my-auto pl-0">
                                    <p class="pl-0">
                                        <?php echo $cimahiwall_activity->name; ?>
                                        <?php if( ! empty($cimahiwall_activity->comment)) echo '<small class="d-block"><em>"' . $cimahiwall_activity->comment . '"</em></small>';?>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <?php
        endforeach;
        ?>
    </div>
    <?php
endif;

if( $cimahiwall_activity->activity_left( $last_activity_id )->total_activity <= 0 ) : ?>

    <?php if( $all_user === true ) : ?>
        <input type="hidden" id="all-user" value="true">
    <?php else : ?>
        <input type="hidden" id="user-id" value="<?php echo $user_id; ?>">
    <?php endif; ?>

    <button id="loadmore" class="btn btn-common btn-block mt-4" value="<?php echo $last_activity_id; ?>"><?php _e('Load more' ,'cimahiwall'); ?></button>
    <script type="html/tpl" id="activityTemplate">
            <div class="media border-bottom py-2">
                <!-- Avatar -->
                {avatar}
                <!-- /. Avatar -->
                <div class="media-body">
                    <p class="mt-0">
                        <a href="{user_link}">{display_name}</a>
                        {activity_text}
                        <small class="d-block">
                            {activity_date}
                        </small>
                    </p>
                    <div>
                        <a href="{post_link}">
                            <div class="row">
                                <div class="col-4 col-md-3">
                                    {featured_image}
                                </div>
                                <div class="col-8 col-md-9 my-auto pl-0">
                                    <p class="pl-0">
                                        {name}
                                        <small class="d-block"><em>{comment}</em></small>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </script>
<?php endif; ?>
