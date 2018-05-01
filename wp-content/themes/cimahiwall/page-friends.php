<?php
/**
 * Template Name: Friends Page
 * The template for displaying My Account
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

get_header();

$search = '';
if( isset( $_GET['search']) ) {
    $search = $_GET['search'];
    set_query_var('search', $search);
}

?>

<div class="container mt-3">
    <form action="<?php echo home_url('friends'); ?>" class="row advanced-search">
        <div class="col-md-9">
            <input type="text" class="form-control input-lg" name="search" placeholder="<?php _e('Search for friends', 'cimahiwall'); ?>" value="<?php echo $search; ?>" />
        </div>
        <div class="col-md-3 text-center">
            <button class="btn std-btn btn-filled btn-block"><i class="fa fa-search"></i> <?php _e('Find', 'cimahiwall'); ?></button>
        </div>
    </form>
    <?php
        set_query_var('all_user', true);
        set_query_var('user_id', get_current_user_id());
        get_template_part('template-parts/content-social', 'friend-list');
    ?>
</div>

<?php
get_footer();
?>

