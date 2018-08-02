<?php
/**
 * Created by "Unleashed Studios".
 * User: phi314
 * Date: 07/01/18
 * Time: 10:36
 */

function add_area_columns($columns){
    $columns['city'] = 'City';
    return $columns;
}
add_filter('manage_edit-area_columns', 'add_area_columns');

function add_area_column_content($content, $column_name, $term_id){

    switch ($column_name) {
        case 'city':
            $content = "";
            $city_id = get_field('city', 'area_' . $term_id);
            $city = get_term( $city_id );
            if( ! empty($city ))
                $content = $city->name;
            break;
        default:
            break;
    }
    return $content;
}
add_filter('manage_area_custom_column', 'add_area_column_content', 10, 3);

function add_place_category_columns($columns){
    $columns['icon'] = 'Icon';
    return $columns;
}
add_filter('manage_edit-place_category_columns', 'add_place_category_columns');

/**
 * Admin | Place category icon column
 * @param $content
 * @param $column_name
 * @param $term_id
 * @return string
 */
function add_book_place_column_content($content,$column_name,$term_id){
    $term = get_term($term_id, 'place_category');
    $icon = get_category_icon( $term_id, 'place_category');
    switch ($column_name) {
        case 'icon':
            //do your stuff here with $term or $term_id
            $content = "<i class='{$icon}'></i>";
            break;
        default:
            break;
    }
    return $content;
}
add_filter('manage_place_category_custom_column', 'add_book_place_column_content',10,3);