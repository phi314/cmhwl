<?php
/**
 * Template Name: Profile
 */

global $current_user;
$logged_user_id = $current_user->ID;

get_header();

$username = get_query_var('username');
if( ! empty($username) ) {
    $user = get_user_by('slug', $username);
    $current_user = $user;
}

$user_id = $current_user->ID;
?>

    <?php if( $user_id != $logged_user_id ) : ?>
    <!-- Profile Header -->
        <div class="container mt-3">
            <div class="row justify-content-center align-items-center">
                <div class="col-sm-auto">
                    <?php echo get_avatar( $current_user->ID, 250, '', $current_user->display_name ); ?>
                </div>
                <div class="col-sm-auto">
                    <h3><?php echo $current_user->display_name; ?></h3>
                    <form action="<?php echo admin_url('admin-post.php'); ?>" method="post">
                        <?php wp_nonce_field( 'log_follow_user'); ?>
                        <input type="hidden" name="action" value="log_follow_user">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <button class="btn btn-common"><?php _e('Follow', 'cimahiwall'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    <!-- /. Profile Header -->
    <?php endif; ?>


	<div id="primary" class="container mt-3">
        <div id="default-tab">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item"><a class="nav-link active" href="#tab1" role="tab" data-toggle="tab">Activity</a></li>
                <li class="nav-item"><a class="nav-link" href="#tab2" role="tab" data-toggle="tab"><?php _e('Saved places', 'cimahiwall'); ?></a></li>
                <li class="nav-item"><a class="nav-link" href="#tab3" role="tab" data-toggle="tab"><?php _e('Saved event', 'cimahiwall'); ?></a></li>
                <li class="nav-item"><a class="nav-link" href="#tab4" role="tab" data-toggle="tab">0 <?php _e('Following', 'cimahiwall'); ?></a></li>
                <li class="nav-item"><a class="nav-link" href="#tab5" role="tab" data-toggle="tab">0 <?php _e('Followers', 'cimahiwall'); ?></a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab1">
                    <?php
                        set_query_var('user_id', $user_id);
                        get_template_part('template-parts/content-social', 'activity');
                    ?>
                </div>

                <div role="tabpanel" class="tab-pane fade" id="tab2">

                    <?php
                    $place_favorites = get_user_favorites( $current_user->ID );

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

                    <?php cimahiwall_pagination(); ?>

                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab3">
                    <?php
                    $event_favorites = get_user_favorites();

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
            </div>
        </div>
    </div>


<?php
get_footer();
