<?php
/**
 * Created by "Unleashed Studios".
 * User: phi314
 * Date: 22/01/18
 * Time: 9:53
 */

global $current_user;

?>
<div class="ui-content container">
    <div class="row justify-content-center">
        <div class="col-sm-8 col-md-8 col-lg-8 col-lg-offset-2 acc-col">
                <h3><?php _e('Profil Diri', 'cimahiwall'); ?></h3>
                <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" class="account-form" role="form">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="inputName" class="control-label"><?php _e('Nama', 'Cimahiwall'); ?>:</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $current_user->first_name; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="inputEmail3" class="control-label"><?php _e('Email', 'Cimahiwall'); ?>:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $current_user->user_email; ?>">
                        </div>
                        <div class="col-sm-6">
                            <label for="inputPassword3" class="control-label"><?php _e('Telepon', 'Cimahiwall'); ?>:</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo get_field('phone', 'user_' . $current_user->ID); ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <label for="inputEmail3" class="control-label"><?php _e('Alamat', 'Cimahiwall'); ?>:</label>
                            <textarea class="form-control" id="address" name="address"><?php echo get_field('address', 'user_' . $current_user->ID); ?></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label for="inputPassword3" class="control-label"><?php _e('Kota', 'Cimahiwall'); ?>:</label>
                            <select class="form-control select2" name="city">
                                <option value="" data-city-id="">- Pilih Kota -</option>
                                <?php
                                $cities = get_terms([
                                    'taxonomy' => 'city',
                                    'hide_empty' => false
                                ]);
                                foreach( $cities as $city ):
                                    $selected_city = $city->term_id == get_field('city', 'user_' . $current_user->ID) ? "selected='selected'" : '';
                                    ?>
                                    <option value="<?php echo $city->slug; ?>" <?php echo $selected_city; ?> data-city-id="<?php echo $city->term_id; ?>"><?php echo $city->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label for="inputPassword3" class="control-label"><?php _e('Area', 'Cimahiwall'); ?>:</label>
                            <?php
                                $area = get_term(get_field('area', 'user_' . $current_user->ID));

                            ?>
                            <select class="form-control select2 input-lg" name="area" data-selected-area="<?php echo $area->slug; ?>">
                                <option value="">- Pilih Area -</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="btn-div">
                                <input type="hidden" name="action" value="cimahiwall_update_user">
                                <button class="btn btn-primary pull-right">Update</button>
                            </div>
                        </div>
                    </div>

                </form>

                <h3><?php _e('Update password', 'cimahiwall'); ?></h3>
                <form class="account-form" role="form">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="inputEmail3" class="control-label">Password:</label>
                            <div class="">
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="inputPassword3" class="control-label">Konfirmasi Password:</label>
                            <div class="">
                                <input type="password" class="form-control" id="password" name="password_confirm">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="btn-div">
                                <a href="https://creativethoughtz.com" class="btn btn-primary pull-right">Update</a>
                            </div>
                        </div>
                    </div>
                </form>
        </div>
        <!-- col-8 -->
    </div>

</div>
