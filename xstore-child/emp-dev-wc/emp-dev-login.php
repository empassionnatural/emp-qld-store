<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/07/2018
 * Time: 9:11 AM
 */

function my_account_login( $atts ) {
    $html  = '<div id="login-section">';

    $html .= '<div class="wpb_column vc_column_container vc_col-sm-6 vc_col-has-fill">';
    $html .= '<img class="bgPicLogin" src="http://staging.wa.empassion.com.au/wp-content/uploads/2018/07/Capture.png" alt="bg-pic-login">';
    $html .= '</div>';

    $html .= '<div id="login" class="wpb_column vc_column_container vc_col-sm-6 vc_col-has-fill">';
    $html .= '<div class="u-column1 col-1">';
    $html .= '<div class="container">';

    $html .= '<h2>Login</h2>';

    $html .= '<form method="post" class="woocommerce-form woocommerce-form-login login">';

    $html .= '<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">';
    $html .= '<label for="username">Username or email address&nbsp;<span class="required">*</span></label>';
    $html .= '<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="">';
    $html .= '</p>';

    $html .= '<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">';
    $html .= '<label for="password">Password&nbsp;<span class="required">*</span></label>';
    $html .= '<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password">';
    $html .= '</p>';

    $html .= '<div class="clear"></div>';

    $html .= '<p class="form-row">';
    $html .= '<input type="hidden" id="woocommerce-login-nonce" name="woocommerce-login-nonce" value="08d4b01eaa"><input type="hidden" name="_wp_http_referer" value="/my-account/">	';
    $html .= '<button id="btn-login" type="submit" class="woocommerce-Button button" name="login" value="Log in">Log in</button>';
    $html .= '<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">';
    $html .= '<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever"> <span>Remember me</span>';
    $html .= '</label>';
    $html .= '</p>';

    $html .= '<p class="woocommerce-LostPassword lost_password">';
    $html .= '<a href="https://staging.wa.empassion.com.au/my-account/lost-password/">Lost your password?</a>';
    $html .= '</p>';


    $html .= '<div class="clear"></div>';
    $html .= '</form>';

    $html .= '<div class="et-facebook-login-wrapper"><a href="https://staging.wa.empassion.com.au/my-account/?facebook=login" class="et-facebook-login-button"><i class="fa fa-facebook"></i> Login with Facebook</a></div>';

    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';

    $html .= '</div>';

    return $html;
}
add_shortcode( 'my_account_login', 'my_account_login' );
do_shortcode('[lsphe-header]' );

function my_account_register( $atts ) {
    $html  = '<div id="login-section">';

    $html .= '<div class="wpb_column vc_column_container vc_col-sm-6 vc_col-has-fill">';
    $html .= '<img class="bgPicLogin" src="http://staging.wa.empassion.com.au/wp-content/uploads/2018/07/adult-beautiful-girl-blue-875862-1.jpg" alt="bg-pic-login">';
    $html .= '</div>';

    $html .= '<div id="login" class="wpb_column vc_column_container vc_col-sm-6 vc_col-has-fill">';
    $html .= '<div class="u-column1 col-1">';
    $html .= '<div class="container">';

    $html .= '<h2>Register</h2>';

    $html .= '<form method="post" class="woocommerce-form woocommerce-form-login login">';

    $html .= '<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">';
    $html .= '<label for="username">Username or email address&nbsp;<span class="required">*</span></label>';
    $html .= '<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="">';
    $html .= '</p>';

    $html .= '<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">';
    $html .= '<label for="password">Password&nbsp;<span class="required">*</span></label>';
    $html .= '<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password">';
    $html .= '</p>';

    $html .= '<div class="clear"></div>';

    $html .= '<p class="form-row">';
    $html .= '<input type="hidden" id="woocommerce-login-nonce" name="woocommerce-login-nonce" value="08d4b01eaa"><input type="hidden" name="_wp_http_referer" value="/my-account/">	';
    $html .= '<button id="btn-login" type="submit" class="woocommerce-Button button" name="login" value="Log in">Log in</button>';
    $html .= '<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">';
    $html .= '<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever"> <span>Remember me</span>';
    $html .= '</label>';
    $html .= '</p>';

    $html .= '<p class="woocommerce-LostPassword lost_password">';
    $html .= '<a href="https://staging.wa.empassion.com.au/my-account/lost-password/">Lost your password?</a>';
    $html .= '</p>';


    $html .= '<div class="clear"></div>';
    $html .= '</form>';

    $html .= '<div class="et-facebook-login-wrapper"><a href="https://staging.wa.empassion.com.au/my-account/?facebook=login" class="et-facebook-login-button"><i class="fa fa-facebook"></i> Register with Facebook</a></div>';

    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';

    $html .= '</div>';

    return $html;
}
add_shortcode( 'my_account_register', 'my_account_register' );

function login_form($atts) {
    return require_once( get_stylesheet_directory() . '/emp-dev-wc/form-login.php' );
}
add_shortcode('login_form', 'login_form');

function product_form($atts) {
    $html = '<div id="da-thumbs" class="da-thumbs">';

    $html .= '<div class="box">';
    $html .= '<a href="product-category/ranges/signature-range/">';
    $html .= '<img src="/wp-content/uploads/2018/09/thumb_signature.jpg" />';
    $html .= '<div class="overlay"><span></span></div>';
    $html .= '<div class="bg-color-txt-pic">
                <img src="/wp-content/uploads/2018/09/icon_section_signature.png">
                <p>Signature Range</p>
              </div>';
    $html .= '</a>';
    $html .= '</div>';

    $html .= '<div class="box">';
    $html .= '<a href="product-category/ranges/lavender-range/">';
    $html .= '<img src="/wp-content/uploads/2018/09/thumb_lavender.jpg" />';
    $html .= '<div class="overlay"><span></span></div>';
    $html .= '<div class="bg-color-txt-pic">
                <img src="/wp-content/uploads/2018/09/icon_section_lavender.png">
                <p>Lavender</p>
              </div>';
    $html .= '</a>';
    $html .= '</div>';

    $html .= '<div class="box">';
    $html .= '<a href="product-category/aromatherapy/">';
    $html .= '<img src="/wp-content/uploads/2018/09/thumb_aromatherapy.jpg" />';
    $html .= '<div class="overlay"><span></span></div>';
    $html .= '<div class="bg-color-txt-pic">
                <img src="/wp-content/uploads/2018/09/icon_section_aroma.png">
                <p>Aromatherapy</p>
              </div>';
    $html .= '</a>';
    $html .= '</div>';

    $html .= '<div class="box">';
    $html .= '<a href="product-category/men/">';
    $html .= '<img src="/wp-content/uploads/2018/09/thumb_men.jpg" />';
    $html .= "<div class='overlay'><span></span></div>";
    $html .= "<div class='bg-color-txt-pic'>
                <img src='/wp-content/uploads/2018/09/icon_section_men.png'>
                <p>Men's Range</p>
              </div>";
    $html .= '</a>';
    $html .= '</div>';

    $html .= '<div class="box">';
    $html .= '<a href="product-category/age-ranges/teen-range/teen-boys/">';
    $html .= '<img src="/wp-content/uploads/2018/09/thumb_teen_boys.jpg" />';
    $html .= '<div class="overlay"><span></span></div>';
    $html .= '<div class="bg-color-txt-pic">
                <img src="/wp-content/uploads/2018/09/icon_section_teenboys.png">
                <p>Teen Boys</p>
              </div>';
    $html .= '</a>';
    $html .= '</div>';

    $html .= '<div class="box">';
    $html .= '<a href="product-category/age-ranges/teen-range/teen-girls/">';
    $html .= '<img src="/wp-content/uploads/2018/09/thumb_teen_girls.jpg" />';
    $html .= '<div class="overlay"><span></span></div>';
    $html .= '<div class="bg-color-txt-pic">
                <img src="/wp-content/uploads/2018/09/icon_section_teengirls.png">
                <p>Teen Girls</p>
              </div>';
    $html .= '</a>';
    $html .= '</div>';

    $html .= '<div class="box">';
    $html .= '<a href="product-category/age-ranges/kids/">';
    $html .= '<img src="/wp-content/uploads/2018/09/thumb_kids.jpg" />';
    $html .= '<div class="overlay"><span></span></div>';
    $html .= '<div class="bg-color-txt-pic">
                <img src="/wp-content/uploads/2018/09/icon_section_kids.png">
                <p>Kids</p>
              </div>';
    $html .= '</a>';
    $html .= '</div>';

    $html .= '<div class="box">';
    $html .= '<a href="product-category/age-ranges/baby/">';
    $html .= '<img src="/wp-content/uploads/2018/09/thumb_baby.jpg" />';
    $html .= '<div class="overlay"><span></span></div>';
    $html .= '<div class="bg-color-txt-pic">
                <img src="/wp-content/uploads/2018/09/icon_section_baby.png">
                <p>Baby</p>
              </div>';
    $html .= '</a>';
    $html .= '</div>';

    $html .= '</div>';

    return $html;

}
add_shortcode('product_form', 'product_form');

function redirect($url) {
    ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}

function if_login() {
    if( !is_user_logged_in() ){
        echo do_shortcode( '[woocommerce_my_account]');
    }
    else {
        return redirect('https://staging.wa.empassion.com.au/');
    }
}
add_shortcode( 'if_login', 'if_login' );

remove_action('woocommerce_myaccount_coupons', 'coupons');