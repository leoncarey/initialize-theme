<?php

// Remove admin bar
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}
show_admin_bar(false);

// registering wp3+ menus
register_nav_menus(
    array(
        'main-nav' => __( 'The Main Menu', 'initialize-theme' )
    )
);

remove_action( 'wp_head', 'wp_generator' ) ;
remove_action( 'wp_head', 'wlwmanifest_link' ) ;
remove_action( 'wp_head', 'rsd_link' ) ;

function rss_post_thumbnail($content) {
    global $post;
    if(has_post_thumbnail($post->ID)) {
        $content = '<p>' . get_the_post_thumbnail($post->ID) .
            '</p>' . get_the_content();
    }
    return $content;
}
add_filter('the_excerpt_rss', 'rss_post_thumbnail');
add_filter('the_content_feed', 'rss_post_thumbnail');


function page_type_support() {
    $post = get_post($_GET['post']);

    remove_post_type_support('page', 'editor');
    remove_post_type_support('page', 'page-attributes');
    remove_post_type_support('page', 'thumbnail');

    remove_post_type_support('post', 'editor');
    remove_post_type_support('post', 'page-attributes');
    remove_post_type_support('post', 'thumbnail');
    remove_post_type_support('post', 'post-formats');
}
add_action( 'admin_menu' , 'page_type_support' );


/*
 * Login errors validation
 * */
function my_front_end_login_fail( $username ) {

    $referrer = $_SERVER['HTTP_REFERER'];
    $referrer = parse_url($referrer);
    $referrer = $referrer['scheme'] .'://'. $referrer['host'] . $referrer['path'];

    if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
        wp_redirect( $referrer . '?login=failed&username='. $username );
        exit;
    }
}
add_action( 'wp_login_failed', 'my_front_end_login_fail' );  // hook failed login

function _catch_empty_user( $username, $pwd ) {

    if($_POST && !strpos($_SERVER['HTTP_REFERER'], 'wp-login')) {
        $referrer = $_SERVER['HTTP_REFERER'];
        $referrer = parse_url($referrer);
        $referrer = $referrer['scheme'] .'://'. $referrer['host'] . $referrer['path'];
        if ( is_null($username) || empty( $username ) || is_null($pwd) || empty($pwd) ) {
            wp_safe_redirect( $referrer .'?login=empty' );
            exit();
        }
    }
}
add_action( 'wp_authenticate', '_catch_empty_user', 1, 2 );

function weekday($weekday_number) {
    $weekdays = [
        0 => 'Domingo',
        1 => 'Segunda-feira',
        2 => 'Terça-feira',
        3 => 'Quarta-feira',
        4 => 'Quinta-feira',
        5 => 'Sexta-feira',
        6 => 'Sábado'
    ];

    return $weekdays[$weekday_number];
}

add_action( 'init', 'blockusers_init' );
function blockusers_init() {
    if ( is_user_logged_in() && is_admin() && !current_user_can( 'administrator' ) &&
        !( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
        wp_redirect( home_url() );
        exit;
    }
}