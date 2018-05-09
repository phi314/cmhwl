<?php
/**
 * Created by Customy.
 * User: Indosoft
 * Date: 4/18/2018
 * Time: 4:06 PM
 */

$activity_mode = get_query_var('activity_mode');
$user_id = get_query_var('user_id');

$cimahiwall_activity = new CimahiwallSocialActivity( (int) $user_id );
$cimahiwall_activity->set_activity_mode( $activity_mode );
$activities = $cimahiwall_activity->activity_listing();
$last_activity_id = "";

if( ! empty($activities)) :
    ?>
    <div id="activity-container">
        <?php
        foreach ($activities as $activity) :
            $user = get_userdata($activity->user_id);
            $last_activity_id = $activity->activity_id;
            ?>
            <div class="media border-bottom py-2" id="activity-<?php echo $activity->activity_id; ?>">
                <!-- Avatar -->
                <?php echo get_avatar( $activity->user_id, 24, '', $user->display_name, ['class'=>'mr-3 w-auto', 'width'=> 64, 'height'=> 64] ); ?>
                <!-- /. Avatar -->
                <div class="media-body">
                    <p class="mt-0">
                        <a href="<?php echo home_url('profile/' . $user->user_nicename); ?>"><?php echo $user->display_name; ?></a>
                        <?php echo activity_text( $activity->object_type ); ?>
                        <small class="d-block">
                            <?php echo activity_date( $activity->created_date ); ?>
                        </small>
                    </p>

                    <div>
                        <a href="<?php echo get_permalink( $activity->post_id); ?>">
                            <div class="row">
                                <div class="col-4 col-md-3">
                                    <?php $featured_image = get_featured_post_image($activity->post_id); ?>
                                    <img src="<?php echo $featured_image; ?>">
                                </div>
                                <div class="col-8 col-md-9 my-auto pl-0">
                                    <p class="pl-0">
                                        <?php echo $activity->name; ?>
                                        <?php if( ! empty($activity->comment)) echo '<small class="d-block"><em>"' . $activity->comment . '"</em></small>';?>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <?php if( get_current_user_id() == $activity->user_id && ! is_page('activity') ) : ?>
                    <a href="#" class="btn-remove btn-remove-activity" data-activity-id="<?php echo $activity->activity_id; ?>"><i class="fa fa-times"></i></a>
                <?php endif; ?>

            </div>

            <?php
        endforeach;
        ?>
    </div>
    <?php
endif;

$cimahiwall_activity_pagination = new CimahiwallSocialActivityPagination();
$cimahiwall_activity_pagination->set_last_activity_id( $last_activity_id );
if( $cimahiwall_activity_pagination->activity_left_count() > 0 ) : ?>

    <input type="hidden" id="mode" value="<?php echo $activity_mode; ?>">
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
                                    <img src="{featured_image}">
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
