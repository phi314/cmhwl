<?php
/**
 * Created by "Unleashed Studios".
 * User: phi314
 * Date: 08/01/18
 * Time: 0:16
 */

$s = get_query_var('s');
$q_placeCategorySlug = get_query_var('place_category');
$q_placeTagSlug = get_query_var('place_tag');
$q_citySlug = get_query_var('city');
$q_areaSlug = get_query_var('area');
$orderby = get_query_var('orderby');

?>

<form action="<?php echo home_url('place'); ?>" class="row advanced-search">
    <div class="col-md-9">
        <input type="text" class="form-control input-lg" name="s" placeholder="Cari . . . " value="<?php echo $s; ?>" />
    </div>
    <div class="col-md-3">
        <select class="form-control select2 input-lg" name="place_category">
            <option value="">- Pilih Kategori -</option>
            <?php
            $place_categories = get_terms([
                'taxonomy' => 'place_category',
                'hide_empty' => false
            ]);
            foreach ($place_categories as $place_category) :
                $selected_place_category = $place_category->slug == $q_placeCategorySlug ? "selected='selected'" : '';
                ?>
                <option value="<?php echo $place_category->slug; ?>" <?php echo $selected_place_category; ?>><?php echo $place_category->name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3">
        <select class="form-control select2 input-lg" name="city">
            <option value="" data-city-id="">- Pilih Kota -</option>
            <?php
            $cities = get_terms([
                'taxonomy' => 'city',
                'hide_empty' => false
            ]);
            foreach( $cities as $city ):
                $selected_city = $city->slug == $q_citySlug ? "selected='selected'" : '';
                ?>
                <option value="<?php echo $city->slug; ?>" <?php echo $selected_city; ?> data-city-id="<?php echo $city->term_id; ?>"><?php echo $city->name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3">
        <select class="form-control select2 input-lg" name="area" data-selected-area="<?php echo $q_areaSlug; ?>">
            <option value="">- Pilih Area -</option>
        </select>
    </div>
    <div class="col-md-3">
        <select class="form-control select2 input-lg" name="orderby">
            <option value="post_views">Popular</option>
            <option value="date" <?php echo $orderby == 'date' ? 'selected="selected"' : ''; ?>>Latest</option>
        </select>
    </div>
    <div class="col-md-3 text-center">
        <button class="btn std-btn btn-filled btn-block"><i class="fa fa-search"></i> Cari Lokasi</button>
    </div>
    <input type="hidden" name="mahiwal_type" value="place">
</form>
