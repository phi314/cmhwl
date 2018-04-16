<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WP_Bootstrap_Starter
 */

    get_header();


    if ( have_posts() ) : the_post();

        global $post;

        $post_id = $post->ID;
        $content = $post->post_content;

        /*
         * Initialize
         */
        $locations = get_field('location');
        $website = get_field('cimahiwall_place_website');
        $phone = get_field('cimahiwall_place_phone_number');
        $address = get_field('cimahiwall_place_address');
        $event_tags = wp_get_post_terms($post_id, 'event_tag');
        $event_categories = wp_get_post_terms($post_id, 'event_categories');

//        echo "<pre>";
//        var_dump($google_place);
//        echo "</pre>"



        ?>

<div class="container-place">

    <div class="mb-3"></div>

    <!-- Main Content -->
    <div class="bg-gray">
        <div class="container">
            <div class="row">
                <div id="main" class="col-md-8" role="main">
                    <div class="row">
                        <div class="col-sm-10">
                            <?php
                            $event_categories = wp_get_post_terms($post_id, 'event_category');
                            if( ! empty($event_categories[0])) {
                                ?>
                                <a href="<?php echo get_term_link($event_categories[0]->term_id); ?>">
                                    <?php the_term_icon('event_category', $event_categories[0]->term_id); ?> <?php echo $event_categories[0]->name; ?>
                                </a>
                                <?php
                            }
                            ?>

                            <small><?php echo get_event_time(); ?></small>
                            <h3><?php the_title(); ?></h3>
                        </div>
                    </div>

                    <div class="row pt-3">
                        <div class="col-12 text-center">
                            <button type="button" class="btn std-btn btn-sm btn-common btn-block">
                                <i class="fas fa-calendar-check"></i> <?php _e('Log an attend', 'cimahiwall'); ?>
                            </button>
                        </div>
                        <div class="col-6 text-center">
                            <?php the_favorites_button(); ?>
                        </div>
                        <div class="col-6 text-center">
                            <button type="button" class="btn std-btn btn-sm btn-common btn-block">
                                <i class="fa fa-share"></i> Share
                            </button>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <?php
                    if( $featured_image_url = get_the_post_thumbnail_url() ) :
                        ?>
                        <a href="<?php echo $featured_image_url; ?>" class="card"><img title="Featured Image" class="card-img" src="<?php echo $featured_image_url; ?>"></a>
                        <?php
                    endif;
                    ?>

                    <?php if( ! empty( get_the_content() )) : ?>

                        <article id="place-<?php echo $post_id; ?>" <?php post_class(); ?>>

                            <div class="entry-content p-4 card">
                                <?php
                                    the_content();
                                ?>
                            </div><!-- .entry-content -->

                        </article><!-- #post-## -->

                    <?php endif; ?>

                    <div class="card-columns">
                        <?php
                        // Image from Cloud / Google
                        $cloud_gallery = get_post_meta($post_id, 'cimahiwall_field_cloud_photos', 1);
                        if( ! empty($cloud_gallery) ) :
                            foreach ($cloud_gallery as $cloud_photo) :
                                ?>
                                <a href="<?php echo $cloud_photo['cloud_image_url']; ?>" class="card"><img title="<?php echo $cloud_photo['cloud_image_source']; ?>"  class="card-img lazy" data-src="<?php echo $cloud_photo['cloud_image_url']; ?>"></a>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </div>

                    <footer class="entry-footer">
                        <?php wp_bootstrap_starter_entry_footer(); ?>
                    </footer><!-- .entry-footer -->


                </div><!-- #main -->

                <!-- Sidebar -->
                <div class="col-md-4">

                    <section>
                        <small>
                            <?php $comment_count = get_comment_count($post_id); ?>
                            <?php echo $comment_count['approved'] ; ?> Review(s)
                            <i class="fa fa-eye"></i> <?php echo pvc_get_post_views(); ?>
                        </small>
                    </section>

                    <div class="mb-3"></div>

                    <section>
                        <?php if (! empty($locations)) : ?>
                            <!-- Event Location -->
                            <div>
                                <h3>Lokasi</h3>
                                <ul class="list-style arrow-list arrow-list-four pl-0">
                                    <?php
                                    foreach ($locations as $location) :
                                        ?>
                                        <li>
                                            <i class="fa fa-chevron-right" aria-hidden="true"></i><a href="<?php echo get_permalink($location->ID); ?>"><?php echo $location->post_title; ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <!-- /. Event Location -->

                    </section>

                    <section>
                        <div class="">

                            <ul class="list-style social-list pl-0">
                                <?php if( ! empty($phone)) : ?>
                                    <li>
                                        <a href="tel: <?php echo $phone; ?>">
                                            <i class="fa fa-phone"></i> <?php echo $phone; ?>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if( ! empty($website) ) : ?>
                                    <li>
                                        <a href="<?php echo $website; ?>"><i class="fa fa-link"></i> <?php limit_text($website, 70); ?></a>
                                    </li>
                                <?php endif; ?>

                            </ul>

                        </div>
                    </section>

                    <div class="mb-4"></div>

                    <section>
                        <h4><?php _e('Related event', 'cimahiwall'); ?></h4>
                        <?php
                        $event_categories_id_only = terms_id_only( $event_categories );
                        $event_tags_id_only = terms_id_only( $event_tags );
                        ?>
                        <div class="blog-posts-small">
                            <?php
                            $start_date_time = get_post_meta( $post->ID, 'cimahiwall_field_start_datetime', true);
                            $month = date('m', $start_date_time);
                            $start_date = strtotime(date('Y'.$month.'01')); // First day of the month
                            $end_date = strtotime(date('Y'.$month.'t')); // 't' gets the last day of the month
                            $related_events_by_tag = new WP_Query([
                                'post_type' => 'event',
                                'posts_per_page' => 5,
                                'post__not_in' => [$post->ID],
                                'tax_query' => [
                                    'relation' => 'OR',
                                    [
                                        'taxonomy' => 'event_category',
                                        'field' => 'term_id',
                                        'terms' => $event_categories_id_only
                                    ],
                                    [
                                        'taxonomy' => 'event_tag',
                                        'field' => 'term_id',
                                        'terms' => $event_tags_id_only
                                    ]
                                ],
                                'meta_query' => [
                                    [
                                        'key'       => 'cimahiwall_field_start_datetime',
                                        'value'     => array($start_date, $end_date),
                                        'compare'   => 'BETWEEN'
                                    ]
                                ]
                            ]);

                            while ($related_events_by_tag->have_posts() ) : $related_events_by_tag->the_post();
                                $related_events_by_tag_post_id = get_the_ID();
                                ?>
                                <div class="blog-post-small">
                                    <div class="blog-post-small-image" style="background: url('<?php echo get_featured_post_image($related_events_by_tag_post_id, 'place'); ?>')"></div>
                                    <a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a>
                                    <br>
                                    <p>
                                        <?php
                                        $event_categories = wp_get_post_terms($related_events_by_tag_post_id, 'event_category');
                                        if( ! empty($event_categories[0])) {
                                            echo  $event_categories[0]->name;
                                        }
                                        ?>
                                    </p>
                                </div>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </div>

                    </section>

                    <section>
                        <h4><?php _e('This month', 'cimahiwall'); ?></h4>
                        <div class="blog-posts-small">
                            <?php
                            $start_date_time = get_post_meta( $post->ID, 'cimahiwall_field_start_datetime', true);
                            $month = date('m');
                            $start_date = strtotime(date('Y'.$month.'01')); // First day of the month
                            $end_date = strtotime(date('Y'.$month.'t')); // 't' gets the last day of the month
                            $related_events_by_tag = new WP_Query([
                                'post_type' => 'event',
                                'posts_per_page' => 5,
                                'post__not_in' => [$post->ID],
                                'meta_query' => [
                                    [
                                        'key'       => 'cimahiwall_field_start_datetime',
                                        'value'     => array($start_date, $end_date),
                                        'compare'   => 'BETWEEN'
                                    ]
                                ]
                            ]);

                            while ($related_events_by_tag->have_posts() ) : $related_events_by_tag->the_post();
                                $related_events_by_tag_post_id = get_the_ID();
                                ?>
                                <div class="blog-post-small">
                                    <div class="blog-post-small-image" style="background: url('<?php echo get_featured_post_image($related_events_by_tag_post_id, 'place'); ?>')"></div>
                                    <a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a>
                                    <br>
                                    <p>
                                        <?php
                                        $event_categories = wp_get_post_terms($related_events_by_tag_post_id, 'event_category');
                                        if( ! empty($event_categories[0])) {
                                            echo  $event_categories[0]->name;
                                        }
                                        ?>
                                    </p>
                                </div>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </div>

                    </section>


                </div>
            </div>
        </div>

    </div>
    <!-- ./ Main Content -->

    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <?php

                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;

                ?>

            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>

</div>
<?php

    endif; // End of the loop.

get_footer();
?>

