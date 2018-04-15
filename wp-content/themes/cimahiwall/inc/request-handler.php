<?php
/**
 * Created by "Unleashed Studios".
 * User: phi314
 * Date: 07/01/18
 * Time: 11:16
 */

/**
 * Get Area by city
 */
function get_area_by_city() {
    if( isset($_GET['cityId']) ) {
        $data = [];
        $cityId = sanitize_text_field($_GET['cityId']);
        $areas = get_terms([
            'taxonomy' => 'area',
            'hide_empty' => false,
        ]);
        foreach ($areas as $area) {
            $area_city = get_field('city', 'area_' . $area->term_id);

            if ($area_city == $cityId) {
                $data[] = [
                    'term_id' => $area->term_id,
                    'name' => $area->name,
                    'slug' => $area->slug
                ];
            }
        }
        echo json_encode( $data );
    }

    wp_die(); // this is required to terminate immediately and return a proper response
}
add_action( 'wp_ajax_get_area_by_city', 'get_area_by_city' );
add_action( 'wp_ajax_nopriv_get_area_by_city', 'get_area_by_city' );

/**
 * Save google post json if post type are place
 * @param $post_id
 */
function save_places( $post_id ) {
    /*
     * In production code, $slug should be set only once in the plugin,
     * preferably as a class property, rather than in each function that needs it.
     */
    $post_type = get_post_type($post_id);

    // If this isn't a 'book' post, don't update it.
    if ( "place" != $post_type ) return;


    /*
     * Insert Latitude and Langitu to custom meta
     */
    $map_fieldId = 'field_5a77df508126c';
    if( ! empty($_POST['fields'][$map_fieldId])) {
        update_post_meta( $post_id, 'cimahiwall_latitude', $_POST['fields'][$map_fieldId]['lat']);
        update_post_meta( $post_id, 'cimahiwall_longitude', $_POST['fields'][$map_fieldId]['lng']);
    }

    /*
     * Insert Google Place
     */
    $google_place_id_fieldId = 'field_5a5c21c1c2457';
    if( ! empty($_POST['fields'][$google_place_id_fieldId])) {
        $json = file_get_contents('https://maps.googleapis.com/maps/api/place/details/json?place_id=' . $_POST['fields'][$google_place_id_fieldId] . '&key=' . cmb2_get_option('cimahiwall_theme_options', 'google_map_api_key') . '&language=id-ID');
        if( isJSON($json) && $json ) {
            $json_decode = json_decode($json);
            if( $json_decode->status == 'OK' )
                update_post_meta( $post_id, 'google_place_json', $json_decode);
        }
    }

    /*
     * Insert Zomato
     */
    $zomato_place_id_fieldId = 'field_5a6eff4b94c44';
    if( ! empty($_POST['fields'][$zomato_place_id_fieldId])) {
        $zomato = new \Zomato\Api\Zomato('c85cc0d90b677bfc3bae5355650daa94');
        $json = $zomato->restaurant(['res_id' => $_POST['fields'][$zomato_place_id_fieldId]]);

        if( isJSON($json) && $json ) {
            $json_decode = json_decode($json);
            update_post_meta( $post_id, 'zomato_place_json', $json_decode);
        }
    }


}
add_action( 'save_post', 'save_places', 10, 3 );