<?php
/**
 * Created by "Unleashed Studios".
 * User: phi314
 * Date: 22/01/18
 * Time: 9:53
 */

global $current_user;

?>
<div class="ui-content container mt-3">
    <div class="row justify-content-center">
        <div class="col-sm-8 col-md-8 col-lg-8 col-lg-offset-2 acc-col">
                <h3><?php _e('Edit profile', 'cimahiwall'); ?></h3>
                <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" class="account-form" role="form">
                    <div class="row mb-2">
                        <div class="col-sm-3">
                            <?php echo get_avatar( $current_user->ID, 100, '', $current_user->display_name ); ?>
                        </div>
                        <div class="col-sm-6">
                            <a href="http://gravatar.com" class="btn btn-common btn-block" target="_blank"><?php _e('Update avatar at Gravatar', 'cimahiwall'); ?></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="inputName" class="control-label"><?php _e('Nama', 'Cimahiwall'); ?>:</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $current_user->first_name; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <label for="inputEmail3" class="control-label"><?php _e('Email', 'Cimahiwall'); ?>:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $current_user->user_email; ?>">
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col-sm-12">
                            <div class="btn-div">
                                <input type="hidden" name="action" value="cimahiwall_update_user">
                                <button class="btn btn-common pull-right">Update</button>
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
                                <input type="hidden" name="action" value="cimahiwall_update_user_password">
                                <button class="btn btn-common pull-right">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
        </div>
        <!-- col-8 -->
    </div>

</div>
