<?php

$post_type = 'place';

if( locate_template( 'archive-' . $post_type . '.php' ) ) {

    // if so, load that template
    get_template_part('archive', $post_type);

    // and then exit out
    exit;
}
else {
    wp_redirect(404);
}
?>