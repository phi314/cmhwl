<?php
/**
 * Template Name: My Account
 * The template for displaying My Account
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

get_header();
?>

<div class="container mt-5">
    <h4>
        Activity
    </h4>

    <?php

    $cimahiwall_activity = new CimahiwallActivity();
    $activities = $cimahiwall_activity->activity_listing();
    echo "<pre>";
    var_dump($activities);
    echo "</pre>";
if( ! empty($activities)) :
    foreach ($activities as $activity) :
        $cimahiwall_activity = new CimahiwallActivity((array) $activity);
        $user = get_userdata($cimahiwall_activity->user_id);
?>
    <div class="media border-bottom py-2">
        <?php echo get_avatar( $cimahiwall_activity->user_id, 24, '', $user->display_name, ['class'=>'mr-3 w-auto', 'width'=> 64, 'height'=> 64] ); ?>
        <div class="media-body">
            <p class="mt-0">
                <a href="<?php echo get_permalink($cimahiwall_activity->user_id); ?>"><?php echo $user->display_name; ?></a>
                <?php echo $cimahiwall_activity->activity_text(); ?>
                <small class="d-block">
                    <?php echo $cimahiwall_activity->activity_date(); ?>
                </small>
            </p>

            <div>
                <a href="<?php echo get_permalink( $cimahiwall_activity->post_id); ?>">
                    <div class="row">
                        <div class="col-4 col-md-3">
                            <?php
                            $featured_image = get_the_post_thumbnail($cimahiwall_activity->post_id);
                            echo $featured_image;
                            ?>
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
endif;
?>

</div>
<?php
get_footer();
?>

