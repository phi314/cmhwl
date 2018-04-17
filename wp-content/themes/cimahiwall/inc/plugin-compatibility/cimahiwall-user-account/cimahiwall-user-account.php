<?php
/**
 * Created by "Unleashed Studios".
 * User: phi314
 * Date: 18/01/18
 * Time: 16:08
 */

function cimahiwall_login() {
    echo "<link rel='stylesheet' type='text/css' href='" . get_template_directory_uri() . "/inc/plugin-compatibility/cimahiwall-user-account/cimahiwall-login.css' />";
}
add_action('login_head', 'cimahiwall_login');

function cimahiwall_register_form() {

    $first_name = ( ! empty( $_POST['first_name'] ) ) ? trim( $_POST['first_name'] ) : '';
    $last_name = ( ! empty( $_POST['last_name'] ) ) ? trim( $_POST['last_name'] ) : '';

    ?>
    <p>
        <label for="first_name"><?php _e( 'Nama Lengkap', 'cimahiwall' ) ?><br />
            <input type="text" name="first_name" id="first_name" class="input" value="<?php echo esc_attr( wp_unslash( $first_name ) ); ?>" size="25" /></label>
    </p>
    <?php
}
add_action( 'register_form', 'cimahiwall_register_form' );

function cimahiwall_register_validation( $errors, $sanitized_user_login, $user_email ) {

    if(isset($errors->errors['email_exists'])){
        unset($errors->errors['email_exists']);
        $errors->add( 'email_error', __( '<strong>ERROR</strong>: Email sudah terdaftar.', 'cimahiwall' ) );
    }

    if(isset($errors->errors['empty_email'])){
        unset($errors->errors['empty_email']);
        $errors->add( 'email_error', __( '<strong>ERROR</strong>: Silahkan isi email anda.', 'cimahiwall' ) );
    }

    if(isset($errors->errors['invalid_email'])){
        unset($errors->errors['invalid_email']);
        $errors->add( 'invalid_email', __( '<strong>ERROR</strong>: Email anda salah.', 'cimahiwall' ) );
    }

    if ( empty($_POST['first_name'] ) ) {
        $errors->add( 'first_name_error', __( '<strong>ERROR</strong>: Silahkan isi nama anda.', 'cimahiwall' ) );
    }

    if(isset($errors->errors['empty_username'])){
        unset($errors->errors['empty_username']);
    }

    if(isset($errors->errors['username_exists'])){
        unset($errors->errors['username_exists']);
    }

    return $errors;
}
add_filter( 'registration_errors', 'cimahiwall_register_validation', 10, 3 );

add_action('login_form_register', function(){
    if(isset($_POST['user_login']) && isset($_POST['user_email']) && !empty($_POST['user_email'])){
        $_POST['user_login'] = $_POST['user_email'];
    }
});

add_action( 'user_register', 'cimahiwall_user_register' );
function cimahiwall_user_register( $user_id ) {
    if ( ! empty( $_POST['first_name'] ) ) {
        $userdata = [
            'ID' => $user_id,
            'first_name' => trim( $_POST['first_name'] ),
            'display_name' => trim( $_POST['first_name'] )
        ];
        wp_update_user($userdata);
    }
}

add_filter( 'login_headerurl', 'cimahiwall_loginlogo_url' );
function cimahiwall_loginlogo_url($url) {
    return home_url();
}

/**
 * Redirect user after successful login.
 *
 * @param string $redirect_to URL to redirect to.
 * @param string $request URL the user is coming from.
 * @param object $user Logged user's data.
 * @return string
 */

function cimahiwall_login_redirect( $redirect_to, $request, $user ) {
    //is there a user to check?
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        //check for admins
        if ( in_array( 'subscriber', $user->roles ) ) {
            // redirect them to the default place
            return home_url();
        } else {
            return $redirect_to;
        }
    } else {
        return $redirect_to;
    }
}

add_filter( 'login_redirect', 'cimahiwall_login_redirect', 10, 3 );

/*
 * Hide Admin Bar For Subscriber
 */
function remove_admin_bar() {
    if ( current_user_can('subscriber') ) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'remove_admin_bar');

function add_specific_menu_location_atts( $atts, $item, $args ) {
    // check if the item is in the primary menu
    if( $args->theme_location == 'primary' ) {
        // add the desired attributes:
        if( $atts['title'] == 'Account' ) {
            global $current_user;
            $atts['title'] = $current_user->display_name;
            $item->title = get_avatar( $current_user->ID, 20 ) . "&nbsp;&nbsp;&nbsp;&nbsp;" . $current_user->display_name;
        }
    }

    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'add_specific_menu_location_atts', 10, 3 );

function cimahiwall_update_user() {
    global $current_user;

    $errors = new WP_Error();

    if( empty($_POST['name']) ) {
        $errors->add('empty_name', __('Nama tidak boleh kosong', 'cimahiwall'));
    }

    if( empty($_POST['email']) ) {
        $errors->add('empty_email', __('Email tidak boleh kosong', 'cimahiwall'));
    }

    if( isset( $_POST['name'], $_POST['email']) ) {
        $first_name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);

        $userdata = [
            'ID' => $current_user->ID,
            'first_name' => trim( $first_name ),
            'display_name' => trim( $first_name ),
            'user_email' => $email
        ];
        wp_update_user($userdata);

        wp_redirect(home_url() . '/my-account');
    }

    if( ! empty($errors->errors) ) {
        wp_die($errors);
    }
}
add_action('admin_post_cimahiwall_update_user', 'cimahiwall_update_user');

function cimahiwall_loginout_menu_link( $items, $args ) {
    if ($args->theme_location == 'primary') {
        if (is_user_logged_in()) {
            $items .= '<li class="nav-item menu-item"><a href="'. wp_logout_url( home_url() ) .'" class="nav-link">'. __("Sign out") .'</a></li>';
        }
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'cimahiwall_loginout_menu_link', 10, 2 );
