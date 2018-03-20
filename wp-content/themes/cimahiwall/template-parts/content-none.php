<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>

<section class="no-results not-found text-center">
    <header class="page-header">
        <h1 class="page-title"><?php esc_html_e( 'Tidak ada hasil', 'cimahiwall' ); ?></h1>
    </header><!-- .page-header -->

    <div class="page-content">

        <p>Silahkan request ke <a href="mailto:info@cimahiwall.com">info@cimahiwall.com</a> kalau anda tidak dapat menemukannya.</p>

        <form class="animated fadeInUp" action="<?php echo home_url(); ?>">
            <div class="input-group">
                <input type="text" class="form-control input-sm" name="s" placeholder="Coba cari disini ..." />
                <div class="input-group-append">
                    <button class="btn btn-filled btn-sm">Cari <i class="fa fa-search"></i> </button>
                </div>
            </div>
        </form>

    </div><!-- .page-content -->
</section><!-- .no-results -->
