<?php
if (!defined('ABSPATH')) {
    die();
}

// -----------------------------------------------------------------------------
// actions
// -----------------------------------------------------------------------------

/** https://developer.wordpress.org/reference/hooks/after_setup_theme/ */
function nordcom_action_setup() {
    // TODO.
}

/** Use parent theme stylesheet */
function nordcom_action_enqueue_styles() {
    // Add our parent theme's stylesheet
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

    // Add our own stylesheet
    wp_enqueue_style('child-style', get_stylesheet_uri());
}

/** https://developer.wordpress.org/reference/hooks/customize_register/ */
function nordcom_action_customize_register($wp_customize) {
    // TODO.
}

add_action('after_setup_theme', 'nordcom_action_setup');
add_action('wp_enqueue_scripts', 'nordcom_action_enqueue_styles');
add_action('customize_register', 'nordcom_action_customize_register');

// -----------------------------------------------------------------------------
// filters
// -----------------------------------------------------------------------------

/** Disable unauthenticated access to the REST API */
function nordcom_filter_no_unauthenticated_rest_api_access($result) {
    if ($result === true || is_wp_error($result)) {
        return $result;
    }

    if (!is_user_logged_in()) {
        return new WP_Error('rest_unauthenticated', __('This endpoint requires authentication.'), array('status' => rest_authorization_required_code()));
    }

    return $result;
}

/** Modify kriesi's cheeky back-link */
function nordcom_filter_modify_back_link() {
    return ". <a href=\"https://nordcom.io/?utm_campaign=footer&utm_source=" . urlencode(get_bloginfo('name')) . "\">In Collaboration with Nordcom AB</a>.";
}

add_filter('rest_authentication_errors', 'nordcom_filter_no_unauthenticated_rest_api_access');
add_filter('kriesi_backlink', 'nordcom_filter_modify_back_link', -1);
add_filter('xmlrpc_enabled', '__return_false');
add_filter( 'show_admin_bar', '__return_false' );

// -----------------------------------------------------------------------------
// shortcodes
// -----------------------------------------------------------------------------

/** Override layerslider shortcode */
function nordcom_shortcode_layerslider($attributes) {
    return '';
}

add_shortcode('layerslider', 'nordcom_shortcode_layerslider');
