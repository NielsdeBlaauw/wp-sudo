<?php

namespace WPSudo;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


add_action('admin_notices', function(){
    check_admin_default_username();
    check_admin_users_public();
});

function check_admin_users_public(){
    $admin_user_ids = get_users(array(
        'role'=>'administrator',
        'fields'=>'ids'
    )); 
    $public_post_type_slugs = array_merge(
        get_post_types(array(
            'public'=>true,
            '_builtin'=>true
        )),
        get_post_types(array(
            'public'=>true,
            '_builtin'=>false
        ))
    );
    if(get_posts(array(
      'post_type' => $public_post_type_slugs,
      'author__in' => $admin_user_ids,
      'post_status' => 'publish'
    ))){
        warn_admin_users_public();
    }
}

function warn_admin_users_public(){
    $class = 'notice notice-error';
    $title = __('Security: Admin user information is publicly available', 'wp-sudo');
	$message = __( 'There seem to be admin users that have published public posts. Information about users that have public posts is freely available on your website. This information appears in sitemaps, the WordPress API and other places. Hackers and bots can use this information to attack your website.', 'wp-sudo' );

	printf( '<div class="%1$s"><h1>%2$s</h1><p>%3$s</p></div>', esc_attr( $class ), esc_html($title), esc_html( $message ) ); 
}

function check_admin_default_username(){
    if(get_user_by('slug', 'admin')){
        warn_admin_default_username();
    }
}

function warn_admin_default_username(){
    $class = 'notice notice-error';
    $title = __('Security: Using default admin username', 'wp-sudo');
	$message = __( 'This webste has a user with the default \'admin\' username. This username is often tested by automated tools in an attempt to hack your website.', 'wp-sudo' );

	printf( '<div class="%1$s"><h1>%2$s</h1><p>%3$s</p></div>', esc_attr( $class ), esc_html($title), esc_html( $message ) ); 
}