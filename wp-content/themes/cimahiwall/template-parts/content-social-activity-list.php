<?php
/**
 * Created by Customy.
 * User: Indosoft
 * Date: 4/18/2018
 * Time: 4:06 PM
 */

$mode = get_query_var('mode');
$user_id = get_query_var('user_id');
$cimahiwall_activity = new CimahiwallSocialActivity();

// to showing by user id
if( $user_id != false ) {
    $cimahiwall_activity->set_user_id( $user_id );
}

$activities = $cimahiwall_activity->activity_listing( false, 5, $mode );
$last_activity_id = false;

if( ! empty($activities)) :
    ?>
    <div id="activity-container">
        <?php
        foreach ($activities as $activity) :
            $cimahiwall_activity_detail = new CimahiwallSocialActivity((array) $activity);
            $user = get_userdata($cimahiwall_activity_detail->user_id);
            $last_activity_id = $cimahiwall_activity_detail->activity_id;
            ?>
            <div class="media border-bottom py-2" id="activity-<?php echo $cimahiwall_activity_detail->activity_id; ?>">
                <!-- Avatar -->
                <?php echo get_avatar( $cimahiwall_activity_detail->user_id, 24, '', $user->display_name, ['class'=>'mr-3 w-auto', 'width'=> 64, 'height'=> 64] ); ?>
                <!-- /. Avatar -->
                <div class="media-body">
                    <p class="mt-0">
                        <a href="<?php echo home_url('profile/' . $user->user_nicename); ?>"><?php echo $user->display_name; ?></a>
                        <?php echo $cimahiwall_activity_detail->activity_text(); ?>
                        <small class="d-block">
                            <?php echo $cimahiwall_activity_detail->activity_date(); ?>
                        </small>
                    </p>

                    <div>
                        <a href="<?php echo get_permalink( $cimahiwall_activity_detail->post_id); ?>">
                            <div class="row">
                                <div class="col-4 col-md-3">
                                    <?php $featured_image = get_featured_post_image($cimahiwall_activity_detail->post_id); ?>
                                    <img src="<?php echo $featured_image; ?>">
                                </div>
                                <div class="col-8 col-md-9 my-auto pl-0">
                                    <p class="pl-0">
                                        <?php echo $cimahiwall_activity_detail->name; ?>
                                        <?php if( ! empty($cimahiwall_activity_detail->comment)) echo '<small class="d-block"><em>"' . $cimahiwall_activity_detail->comment . '"</em></small>';?>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <?php if( get_current_user_id() == $cimahiwall_activity_detail->user_id && ! is_page('activity') ) : ?>
                    <a href="#" class="btn-remove btn-remove-activity" data-activity-id="<?php echo $cimahiwall_activity_detail->activity_id; ?>"><i class="fa fa-times"></i></a>
                <?php endif; ?>

            </div>

            <?php
        endforeach;
        ?>
    </div>
    <?php
endif;

if( $cimahiwall_activity->activity_left( $last_activity_id )->total_activity <= 0 ) : ?>

    <input type="hidden" id="mode" value="<?php echo $mode; ?>">
    <input type="hidden" id="user-id" value="<?php echo $user_id; ?>">

    <button id="loadmore" class="btn btn-common btn-block mt-4" value="<?php echo $last_activity_id; ?>"><?php _e('Load more' ,'cimahiwall'); ?></button>
    <script type="html/tpl" id="activityTemplate">
            <div id="activity-{activity_id}" class="media border-bottom py-2">
                {avatar}
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
                <?php if( !is_page('activity')) : ?>
                    <a href="#" class="btn-remove btn-remove-activity" data-activity-id="{activity_id}"><i class="fa fa-times"></i></a>
                <?php endif; ?>
            </div>
        </script>
<?php endif; ?>
