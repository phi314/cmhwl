<?php
/**
 * Template Name: Front Page
 */

get_header('front'); ?>

    <!-- All Category -->
    <?php get_template_part('template-parts/content', 'category-grid'); ?>
    <!-- /. All Category -->

    <div class="mb-30"></div>

<?php
get_footer();
