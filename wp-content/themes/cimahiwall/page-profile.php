<?php
/**
 * Template Name: Profile
 */

global $current_user;
$user = $current_user;
$username = get_query_var('username');
if( ! empty($username) ) {
    $user = get_user_by('slug', $username);
}

get_header();
?>

    <?php if( $user->ID != $current_user->ID ) : ?>
    <!-- Profile Header -->
        <div class="container mt-3">
            <div class="row justify-content-center align-items-center">
                <div class="col-sm-auto">
                    <?php echo get_avatar( $user->ID, 250, '', $user->display_name ); ?>
                </div>
                <div class="col-sm-auto">
                    <h3><?php echo $user->display_name; ?></h3>
                    <form action="<?php echo admin_url('admin-post.php'); ?>" method="post" class="form-follow-user user-id-<?php echo $user->ID; ?>">
                        <?php wp_nonce_field( 'log_follow_user'); ?>
                        <input type="hidden" name="user_id" value="<?php echo $user->ID; ?>">
                        <?php
                            $follow = new CimahiwallSocialFollow( $current_user->ID );
                            $follow->set_to_user_id( $user->ID );
                            $has_follow = $follow->has_follow();
                            if( $has_follow )
                                echo "<input type='hidden' name='unfollow'>";
                        ?>
                        <button class="btn btn-common <?php echo $has_follow ? 'btn-filled' : ''; ?>">
                            <?php
                                $has_follow_text = 'Follow';
                                if( $has_follow )
                                    $has_follow_text = 'Following';

                                _e($has_follow_text, 'cimahiwall');
                             ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    <!-- /. Profile Header -->
    <?php endif; ?>


	<div id="primary" class="container mt-3">
        <div id="default-tab">
            <!-- Nav tabs -->
            <?php
                $follow = new CimahiwallSocialFollow( $user->ID );
            ?>
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item"><a class="nav-link active" href="#tab1" role="tab" data-toggle="tab">Activity</a></li>
                <li class="nav-item"><a class="nav-link" href="#tab2" role="tab" data-toggle="tab"><?php _e('Saved places', 'cimahiwall'); ?></a></li>
                <li class="nav-item"><a class="nav-link" href="#tab3" role="tab" data-toggle="tab"><?php _e('Saved event', 'cimahiwall'); ?></a></li>
                <li class="nav-item"><a class="nav-link" href="#tab4" role="tab" data-toggle="tab"><?php echo $follow->count_following(); ?> <?php _e('Following', 'cimahiwall'); ?></a></li>
                <li class="nav-item"><a class="nav-link" href="#tab5" role="tab" data-toggle="tab"><?php echo $follow->count_followers(); ?> <?php _e('Followers', 'cimahiwall'); ?></a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab1">
                    <?php
                        set_query_var('user_id', $user->ID);
                        set_query_var('activity_mode', 'own');
                        get_template_part('template-parts/content-social', 'activity-list');
                    ?>
                </div>

                <div role="tabpanel" class="tab-pane fade" id="tab2">

                    <?php
                    $place_favorites = get_user_favorites( $user->ID );

                    if ( ! empty($place_favorites) ) : ?>

                        <div class="row">

                            <?php
                            /* Start the Loop */
                            $place_favorites = new WP_Query([
                                'post_type' => 'place',
                                'post__in' => $place_favorites
                            ]);

                            while ( $place_favorites->have_posts() ) : $place_favorites->the_post();

                                /*
                                 * Include the Post-Format-specific template for the content.
                                 * If you want to override this in a child theme, then include a file
                                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                                 */
                                set_query_var( 'place_loop_column', 'col-md-4' );
                                get_template_part( 'template-parts/content', 'place-loop' );

                            endwhile;

                            wp_reset_postdata();

                            ?>
                        </div>
                        <?php

                    else :

                        get_template_part( 'template-parts/content', 'none-favorites' );

                    endif;
                    ?>

                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab3">
                    <?php
                    $event_favorites = get_user_favorites( $user->ID );

                    if ( ! empty($event_favorites) ) : ?>

                        <div class="row">

                        <?php
                        /* Start the Loop */
                        $event_favorites = new WP_Query([
                            'post_type' => 'event',
                            'post__in' => $event_favorites
                        ]);

                        while ( $event_favorites->have_posts() ) : $event_favorites->the_post();

                            /*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            set_query_var( 'place_loop_column', 'col-md-4' );
                            get_template_part( 'template-parts/content', 'event-loop' );

                        endwhile;

                        wp_reset_postdata();
                        ?>
                        </div>
                        <?php

                    else :
                        get_template_part( 'template-parts/content', 'none-favorites' );
                    endif;
                    ?>

                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab4">
                    <?php
                        set_query_var('user_id', $user->ID );
                        set_query_var('follow_type', 'following');
                        get_template_part('template-parts/content-social', 'friend-list');
                    ?>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab5">
                    <?php
                        set_query_var('user_id', $user->ID );
                        set_query_var('follow_type', 'followers');
                        get_template_part('template-parts/content-social', 'friend-list');
                    ?>
                </div>

            </div>
        </div>
    </div>


<?php
get_footer();
