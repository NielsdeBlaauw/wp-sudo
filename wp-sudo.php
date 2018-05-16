<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


add_action('admin_notices', function(){
    wp_die();
    $class = 'notice notice-error';
    $title = __("Users with admin roles are public");
	$message = __( 'There are users that have a administration permission that have published public posts. This means their user information is publicly available.', 'sample-text-domain' );

	printf( '<div class="%1$s"><h2>%2$s</2><p>%3$s</p></div>', esc_attr( $class ), esc_html($title), esc_html( $message ) ); 
});