<?php

//Remove Query Strings
function remove_cssjs_ver( $src ) {
if( strpos( $src, '?ver=' ) )
 $src = remove_query_arg( 'ver', $src );
return $src;
}
add_filter( 'style_loader_src', 'remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'remove_cssjs_ver', 10, 2 );


//Remove RSD Links
remove_action( 'wp_head', 'rsd_link' );


//Disable Emoticons
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );


//Remove Shortlink
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);


//Disable Embeds
function disable_embed(){
    wp_dequeue_script( 'wp-embed' );
}
add_action( 'wp_footer', 'disable_embed' );


//Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');


//Hide WordPress Version
remove_action( 'wp_head', 'wp_generator' );


//Remove WLManifest Link
remove_action( 'wp_head', 'wlwmanifest_link' );


//Remove JQuery Migrate
function deregister_qjuery() { 
  if ( !is_admin() ) {
    wp_deregister_script('jquery');
  }
} 
add_action('wp_enqueue_scripts', 'deregister_qjuery');


//Disable Self Pingback
function disable_pingback( &$links ) {
   foreach ( $links as $l => $link )
     if ( 0 === strpos( $link, get_option( 'home' ) ) )
   unset($links[$l]);
}
add_action( 'pre_ping', 'disable_pingback' );


//Disable or Limit Post Revisions - add in config.php
define('WP_POST_REVISIONS', false);
define('WP_POST_REVISIONS', 2);


//Disable Heartbeat
add_action( 'init', 'stop_heartbeat', 1 );
function stop_heartbeat() {
  wp_deregister_script('heartbeat');
}


//Disable Dashicons on Front-end
function wpdocs_dequeue_dashicon() {
    if (current_user_can( 'update_core' )) {
        return;
    }
    wp_deregister_style('dashicons');
}
add_action( 'wp_enqueue_scripts', 'wpdocs_dequeue_dashicon' );