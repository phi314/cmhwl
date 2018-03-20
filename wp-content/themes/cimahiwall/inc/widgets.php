<?php
/**
 * Created by "Unleashed Studios".
 * User: phi314
 * Date: 08/01/18
 * Time: 21:35
 */

// Register and load the widget
function cimahiwall_load_widget() {
    register_widget( 'cimahiwall_author_widget' );
    register_widget( 'cimahiwall_popular_post_widget' );
    register_widget( 'cimahiwall_recent_post_widget' );
    register_widget( 'cimahiwall_related_post_widget' );
}
add_action( 'widgets_init', 'cimahiwall_load_widget' );

/**
 * Class cimahiwall_author_widget
 */
class cimahiwall_author_widget extends WP_Widget {

    function __construct() {
        parent::__construct(

            // Base ID of your widget
            'cimahiwall_author_widget',

            // Widget name will appear in UI
            __('Cimahiwall Post Author', 'cimahiwall'),

            // Widget description
            array( 'description' => __( 'Showing Author of Post', 'cimahiwall' ), )
        );
    }

    // Creating widget front-end
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        ?>

        <div class="blog-block about-sidebar-widget">
            <img src="https://randomuser.me/api/portraits/men/32.jpg">
            <h4>About Author</h4>
            <p>Aenean vestibulum purus a nulla sollicitudin molestie. Maecenas bibendum erat in erat maximus, vel imperdiet leo mattis.</p>
        </div>

        <?php
        echo $args['after_widget'];
    }

    // Widget Backend
    public function form( $instance ) {}

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {}

}

/**
 * Class cimahiwall_recent_post_widget
 */
class cimahiwall_recent_post_widget extends WP_Widget {

    function __construct() {
        parent::__construct(

            // Base ID of your widget
            'cimahiwall_recent_post_widget',

            // Widget name will appear in UI
            __('Cimahiwall Recent Posts', 'cimahiwall'),

            // Widget description
            array( 'description' => __( 'Cimahiwall Recent Posts', 'cimahiwall' ), )
        );
    }

    // Creating widget front-end
    public function widget( $args, $instance ) {

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        ?>

        <div class="blog-block blog-posts-widget">
            <div class="widget-title">
                <h4>Latest News</h4>
            </div>
            <div class="blog-posts-small">
            <?php
            $latest_posts = get_posts([
                'post_type' => 'post',
                'numberposts' => 5
            ]);

            foreach ($latest_posts as $latest_post) :
                ?>
                <div class="blog-post-small">
                    <div class="blog-post-small-image" style="background: url('<?php echo get_featured_post_image($latest_post->ID, 'place'); ?>')"></div>
                    <a href="<?php echo get_permalink($latest_post->ID); ?>">
                        <?php limit_text($latest_post->post_title, 37); ?>
                    </a>
                    <p>
                        <?php
                        $latest_post_categories = get_the_category($latest_post->ID);

                        if( ! empty($latest_post_categories[0]))
                            echo $latest_post_categories[0]->name;
                        ?>
                    </p>
                    <p class="text-right">~ <?php echo get_the_date('F Y', $latest_post->ID); ?>
                    </p>
                </div>

            <?php endforeach; ?>
        </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    // Widget Backend
    public function form( $instance ) {}

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {}

}

/**
 * Class cimahiwall_related_post_widget
 */
class cimahiwall_related_post_widget extends WP_Widget {

    function __construct() {
        parent::__construct(

        // Base ID of your widget
            'cimahiwall_related_post_widget',

            // Widget name will appear in UI
            __('Cimahiwall Related Posts', 'cimahiwall'),

            // Widget description
            array( 'description' => __( 'Cimahiwall Related Posts', 'cimahiwall' ), )
        );
    }

    // Creating widget front-end
    public function widget( $args, $instance ) {

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        ?>

        <div class="blog-block blog-posts-widget">
            <div class="widget-title">
                <h4>Related Posts</h4>
            </div>
            <div class="blog-posts-small">
            <?php
            $latest_posts = get_posts([
                'post_type' => 'post',
                'numberposts' => 5
            ]);

            foreach ($latest_posts as $latest_post) :
                ?>
                <div class="blog-post-small">
                    <div class="blog-post-small-image" style="background: url('<?php echo get_featured_post_image($latest_post->ID, 'place'); ?>')"></div>
                    <a href="<?php echo get_permalink($latest_post->ID); ?>">
                        <?php limit_text($latest_post->post_title, 37); ?>
                    </a>
                    <p>
                        <?php
                        $latest_post_categories = get_the_category($latest_post->ID);

                        if( ! empty($latest_post_categories[0]))
                            echo $latest_post_categories[0]->name;
                        ?>
                    </p>
                    <p class="text-right">~ <?php echo get_the_date('F Y', $latest_post->ID); ?>
                    </p>
                </div>

            <?php endforeach; ?>
        </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    // Widget Backend
    public function form( $instance ) {}

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {}

}

/**
 * Class cimahiwall_popular_post_widget
 */
class cimahiwall_popular_post_widget extends WP_Widget {

    function __construct() {
        parent::__construct(

        // Base ID of your widget
            'cimahiwall_popular_post_widget',

            // Widget name will appear in UI
            __('Cimahiwall Popular Posts', 'cimahiwall'),

            // Widget description
            array( 'description' => __( 'Cimahiwall Popular Posts', 'cimahiwall' ), )
        );
    }

    // Creating widget front-end
    public function widget( $args, $instance ) {

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        ?>

        <div class="blog-block blog-posts-widget">
            <div class="widget-title">
                <h4>Popular</h4>
            </div>
            <div class="blog-posts-small">
                <?php
                $latest_posts = get_posts([
                    'post_type' => 'post',
                    'numberposts' => 5
                ]);

                foreach ($latest_posts as $latest_post) :
                    ?>
                    <div class="blog-post-small">
                        <div class="blog-post-small-image" style="background: url('<?php echo get_featured_post_image($latest_post->ID, 'place'); ?>')"></div>
                        <a href="<?php echo get_permalink($latest_post->ID); ?>">
                            <?php limit_text($latest_post->post_title, 37); ?>
                        </a>
                        <p>
                            <?php
                            $latest_post_categories = get_the_category($latest_post->ID);

                            if( ! empty($latest_post_categories[0]))
                                echo $latest_post_categories[0]->name;
                            ?>
                        </p>
                        <p class="text-right">~ <?php echo get_the_date('F Y', $latest_post->ID); ?>
                        </p>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>

        <?php
        echo $args['after_widget'];
    }

    // Widget Backend
    public function form( $instance ) {}

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {}

}