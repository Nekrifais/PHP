<?php

/**
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://kwork.ru/user/orbital
 * @since             1.0.0
 * @package           Seo Changer
 *
 * @wordpress-plugin
 * Plugin Name:       Seo Changer
 * Plugin URI:        https://kwork.ru/user/orbital
 * Description:       Seo Changer
 * Version:           1.0.0
 * Author:            O. Vysotskyi
 * Author URI:        https://kwork.ru/user/orbital
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       seo-changer
 */
 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 
 */
define( 'POSTS_DATE_CHANGER_VERSION', '1.0.0' );


/**
 * The code that runs during plugin activation.
 */
function activate_posts_date_changer() {
	wp_clear_scheduled_hook( 'pdc_action_hook' );
	wp_schedule_event( time(), 'daily', 'pdc_action_hook');
}


/**
 * The code that runs during plugin activation.
 */
function deactivate_posts_date_changer() {
	wp_clear_scheduled_hook( 'pdc_action_hook' );
	delete_option('posts_date_changer');
}


register_activation_hook( __FILE__, 'activate_posts_date_changer' );
register_deactivation_hook( __FILE__, 'deactivate_posts_date_changer' );



/**
 * ACF
 * Customize ACF path
*/
add_filter('acf/settings/path', 'my_acf_settings_path');
 
function my_acf_settings_path( $path ) {
 
    // update path
    $path = dirname(__FILE__) . '/acf/';
    
    // return
    return $path;
    
}

 
/**
 * ACF
 * Customize ACF dir
*/
add_filter('acf/settings/dir', 'my_acf_settings_dir');
 
function my_acf_settings_dir( $dir ) {
 
    // update path
    $dir =  plugin_dir_url( __FILE__ ) . '/acf/';
    
    // return
    return $dir;
    
}

 
/**
 * ACF
 * Hide ACF field group menu item
*/
add_filter('acf/settings/show_admin', '__return_false');


/**
 * ACF
 * Include ACF
*/
include_once( dirname(__FILE__) . '/acf/acf.php' );
require_once dirname(__FILE__). "/includes/acf_data.php";  


/**
 * ACF
 * Add option page
*/
if( function_exists('acf_add_options_page') ) {	
	acf_add_options_page(array(
		'page_title' 	=> 'Posts date changer',
		'menu_title'	=> 'Posts date changer',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}


/**
 * Main plugin Hook
*/
add_action( 'pdc_action_hook', 'posts_date_update' );
 
function posts_date_update() {
global $wpdb;
$tasks = get_field( 'tasks', 'option' );
if ( $tasks )
 {
  $frequency_data = get_option( 'posts_date_changer' );
  $current_time   = current_time( 'timestamp', true );
  $changed_time   = $current_time - 12 * 60 * 60;

  foreach ( $tasks as $task )
   {
    $category        = $task[ 'category' ];
    $frequency       = $task[ 'frequency' ];
    $increment_days  = $task[ 'days' ];
    $increment_hours = $task[ 'hours' ];	
	 
	if ( $category == "" )
    continue;
	
	// Сheck, how much time has passed since the last execution of this category
    $next_time       = $frequency_data[ $category ] + $frequency * 60 * 60;
    if ( $current_time < $next_time )
      continue;
    $days = '-' . $increment_days . ' days';
	$date = date("Y-m-d H:i:s", strtotime($days));
	
    $frequency_data[ $category ] = $current_time;
    $select                      = $wpdb->prepare( "SELECT *
                            FROM $wpdb->posts
                            LEFT JOIN  $wpdb->term_relationships  as t
                            ON ID = t.object_id
                            WHERE post_type = 'post' AND post_date < '$date' AND post_status = 'publish' AND t.term_taxonomy_id = %d", $category );
    $post_ids_array              = $wpdb->get_col( $select );

    foreach ( $post_ids_array as $post_id )
     {
	  // Сheck for posts with multiple categories to avoid double updates.
	  if(isset($executed_array[$post_id])) continue;
	  
	  // Verification, date should not be in the future
      if ( $current_time < $changed_time )
        continue;
	
      $mysql_time_format = "Y-m-d H:i:s";
      $post_modified     = gmdate( $mysql_time_format, $changed_time );
      $post_modified_gmt = gmdate( $mysql_time_format, ( $changed_time + get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) );
      wp_update_post( array(
         'ID' => $post_id, // ID of the post to update
        'post_date' => $post_modified,
        'post_date_gmt' => get_gmt_from_date( $post_modified ) 
      ) );
	  
	  $executed_array[$post_id] = $post_modified;
     } //$post_ids_array as $post_id
   } //$tasks as $task
  update_option( 'posts_date_changer', $frequency_data );
 } //$tasks


}













