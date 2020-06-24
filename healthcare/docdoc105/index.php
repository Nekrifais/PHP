<?php
/**
 * Doc doc
 *
 * @package     PluginPackage
 * @author      Orbital
 * @copyright   2016 Your Name or Company Name
 *
 * @wordpress-plugin
 * Plugin Name: Doc doc
 * Plugin URI:  https://example.com/plugin-name
 * Description: Плагин для созания партнёрского сайта на базе DocDoc
 * Version:     1.0.62
 * Author:      Orbital
 * Author URI:  https://example.com
 * Text Domain: doc-doc
 */


 
require_once dirname(__FILE__). "/includes/post-type-register.php";
require_once dirname(__FILE__). "/includes/taxonomy-register.php";
require_once dirname(__FILE__). "/includes/admin-columns/orders-list.php";











// 1. customize ACF path
add_filter('acf/settings/path', 'my_acf_settings_path');
 
function my_acf_settings_path( $path ) {
 
    // update path
    $path = dirname(__FILE__) . '/acf/';
    
    // return
    return $path;
    
}
 

// 2. customize ACF dir
add_filter('acf/settings/dir', 'my_acf_settings_dir');
 
function my_acf_settings_dir( $dir ) {
 
    // update path
    $dir = get_bloginfo('url') . '/wp-content/plugins/docdoc105/acf/';
    
    // return
    return $dir;
    
}
 

// 3. Hide ACF field group menu item
add_filter('acf/settings/show_admin', '__return_false');


// 4. Include ACF
include_once( dirname(__FILE__) . '/acf/acf.php' );

require_once dirname(__FILE__). "/includes/acf.php"; 





















function get_meta_values( $key = '', $type = 'post', $status = 'publish' ) {

    global $wpdb;

    if( empty( $key ) )
        return;

    $r = $wpdb->get_col( $wpdb->prepare( "
        SELECT pm.meta_value FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
        WHERE pm.meta_key = '%s' 
        AND p.post_status = '%s' 
        AND p.post_type = '%s'
    ", $key, $status, $type ) );

    return $r;
}

function get_meta_values_posts( $key = '', $type = 'post', $status = 'publish' ) {

    global $wpdb;

    if( empty( $key ) )
        return;

    $r = $wpdb->get_col( $wpdb->prepare( "
        SELECT pm.post_id FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
        WHERE pm.meta_key = '%s' 
        AND p.post_status = '%s' 
        AND p.post_type = '%s'
    ", $key, $status, $type ) );

    return $r;
}
function get_meta_values_and_posts( $key = '', $type = 'post', $status = 'publish' ) {
	
		global $wpdb;

	if( empty( $key ) )
        return;
						
	    $r = $wpdb->get_results( $wpdb->prepare( "
        SELECT pm.post_id, pm.meta_value FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
        WHERE pm.meta_key = '%s' 
        AND p.post_status = '%s' 
        AND p.post_type = '%s'
    ", $key, $status, $type ) );

		foreach($r as $value) {
		$medic_array[$value->meta_value] = $value->post_id;

	}
	
	return $medic_array;
	
}

function get_meta_posts_and_values( $key = '', $type = 'post', $status = 'publish' ) {
	
		global $wpdb;

	if( empty( $key ) )
        return;
						
	    $r = $wpdb->get_results( $wpdb->prepare( "
        SELECT pm.post_id, pm.meta_value FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
        WHERE pm.meta_key = '%s' 
        AND p.post_status = '%s' 
        AND p.post_type = '%s'
    ", $key, $status, $type ) );

		foreach($r as $value) {
		$medic_array[$value->post_id] = $value->meta_value;

	}
	
	return $medic_array;
	
}

function acf_load_speciality_field_choices( $field ) {
    $login = get_field('логин', 'option');
$password = get_field('пароль', 'option');

	

    // reset choices
    $field['choices'] = array();
    
    
    // get the textarea value from options page without any formatting
    $choices = get_field('my_select_values', 'option', false);

    
    // explode the value so that each line is a new array piece
    $choices = explode("\n", $choices);

    
    // remove any unwanted white space
    $choices = array_map('trim', $choices);

    
    // loop through array and add to field 'choices'
	
$json = file_get_contents('https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/speciality/onlySimple/0');
$obj = json_decode($json);

foreach($obj->SpecList as $value){
            
    $field['choices'][ $value->Id ] = $value->Name; 
	
}

    // return the field
    return $field;
    
}

add_filter('acf/load_field/name=выбор_специальностей', 'acf_load_speciality_field_choices');






function acf_load_city_field_choices( $field ) {
    
	$login = get_field('логин', 'option');
$password = get_field('пароль', 'option');

	
    // reset choices
    $field['choices'] = array();
    
    
    // get the textarea value from options page without any formatting
    $choices = get_field('my_select_values', 'option', false);

    
    // explode the value so that each line is a new array piece
    $choices = explode("\n", $choices);

    
    // remove any unwanted white space
    $choices = array_map('trim', $choices);

    
    // loop through array and add to field 'choices'
	
$json = file_get_contents('https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/city/');
$obj = json_decode($json);

foreach($obj->CityList as $value){
            
    $field['choices'][ $value->Id ] = $value->Name; 
	
}

    // return the field
    return $field;

}

add_filter('acf/load_field/name=выбор_города', 'acf_load_city_field_choices');







if( function_exists('acf_add_options_page') ) {
 	
 	// add parent
	$parent = acf_add_options_page(array(
		'page_title' 	=> 'Опции плагина',
		'menu_title' 	=> 'Опции плагина',
		'menu_slug' => 'theme-general-settings',
		'redirect' 		=> false
	));
	
	
	// add sub page
	acf_add_options_sub_page(array(
		'page_title' 	=> 'SEO',
		'menu_title' 	=> 'SEO',
		'menu_slug' => 'seo',
		'parent_slug' 	=> $parent['menu_slug'],
	));
	
	// add sub page
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Описания',
		'menu_title' 	=> 'Описания',
		'menu_slug' => 'descriptions',
		'parent_slug' 	=> $parent['menu_slug'],
	));	
	
	// add sub page
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Заголовки',
		'menu_title' 	=> 'Заголовки',
		'menu_slug' => 'titles',
		'parent_slug' 	=> $parent['menu_slug'],
	));	
	
	// add sub page
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Хлебные крошки',
		'menu_title' 	=> 'Хлебные крошки',
		'menu_slug' => 'breadcrumbss',
		'parent_slug' 	=> $parent['menu_slug'],
	));
	
	acf_add_options_page('Theme options');
	
}








add_action( 'wp', 'wpse47305_check_home' );
function wpse47305_check_home() {
	
	
	global $wp_query;
	
	$query_speciality_term				= $wp_query->query['speciality'];
	$query_clinic_speciality_term 		= $wp_query->query['clinic-speciality'];
	$query_diagnostic_term				= $wp_query->query['diagnostic'];
	$query_inclinic_term				= $wp_query->query['inclinic'];
	$query_orderby						= $wp_query->query['orderby'];
	$query_order						= $wp_query->query['order'];
	$query_dop							= $wp_query->query['dop'];
	$dop_meta = 2;
	
	
	
	if($query_orderby != "") {
		if($query_orderby == "Rating" and $query_order == "") {
			$dop_meta = 3;
		}
		
		if($query_orderby == "ExperienceYear" and $query_order == "") {
			$dop_meta = 3;
		}
		
		if($query_orderby == "Price" and $query_order == "ASC") {
			$dop_meta = 3;
		}
		
		if($query_orderby == "OpinionCount" and $query_order == "") {
			$dop_meta = 3;
		}

	}
	
	$district = $wp_query->query['district'];
	$metro = $wp_query->query['metro'];
	
	global $seo_data_array;
	
	
	if( $query_speciality_term != "") {
		
		$current_speciality_term = get_term_by('slug', $query_speciality_term, 'speciality');
		$current_speciality_term_id = $current_speciality_term->term_id;
		
		
		if( $metro != "" ) {
			
			$filename = dirname(__FILE__).'/json/seo/speciality-' . $current_speciality_term_id . '-metro.txt';
			
			$seo_data_array = file_get_contents($filename);
			$seo_data_array = unserialize($seo_data_array);
			
			$current_metro_term = get_term_by('slug', $metro, 'metro');
			$current_metro_term_id = $current_metro_term->term_id;
			
			
			
			$title = (string) $seo_data_array[$current_metro_term_id][title];
			$description = (string) $seo_data_array[$current_metro_term_id][description];
			

		} elseif($district != "") {
			
			$filename = dirname(__FILE__).'/json/seo/speciality-' . $current_speciality_term_id . '-district.txt';
			
			$seo_data_array = file_get_contents($filename);			
			$seo_data_array = unserialize($seo_data_array);
			
			$current_district_term = get_term_by('slug', $district, 'district');
			$current_district_term_id = $current_district_term->term_id;
			
			
			$title = (string) $seo_data_array[$current_district_term_id][title];
			$description = (string) $seo_data_array[$current_district_term_id][description];
			
		} else {
			
			if ($query_dop != "") {
				
				$filename = dirname(__FILE__).'/json/seo/speciality-' . $query_dop . '.txt';

				$seo_data_array = file_get_contents($filename);
				$seo_data_array = unserialize($seo_data_array);
						
				$title = (string) $seo_data_array[$current_speciality_term_id][title];
				$description = (string) $seo_data_array[$current_speciality_term_id][description];

			} elseif($query_orderby != "" and $dop_meta == 3) {
				
				$filename = dirname(__FILE__).'/json/seo/speciality-' . $query_orderby . '.txt';
				
				$seo_data_array = file_get_contents($filename);
				$seo_data_array = unserialize($seo_data_array);
				
				$title = (string) $seo_data_array[$current_speciality_term_id][title];
				$description = (string) $seo_data_array[$current_speciality_term_id][description];
				
				
			} else {
			
			if($query_inclinic_term != ""){
					
					
					$nameplural_spec_inclinic = get_field('nameplural', 'speciality_' . $current_speciality_term_id);
					$clinic_name_wp = get_the_title($query_inclinic_term);
					
					
	$title = $nameplural_spec_inclinic . ' в клинике ' . $clinic_name_wp . ', ' . get_bloginfo('description');
				$description = "описание";
				
				
				} else {
					$field = 'single_title_for_speciality-' . $current_speciality_term_id;
					$field_description = 'single_description_for_speciality-' . $current_speciality_term_id;
					
					$title = (string) get_option( $field );
					$description = (string) get_option( $field_description );
				}
			}	
		}
		
		
		
	}
	
	if( $query_clinic_speciality_term != "") {
		
		$current_clinic_speciality_term = get_term_by('slug', $query_clinic_speciality_term, 'clinic-speciality');
		$current_clinic_speciality_term_id = $current_clinic_speciality_term->term_id;
		
		if( $metro != "") {
		
		$filename = dirname(__FILE__).'/json/seo/clinic-speciality-' . $current_clinic_speciality_term_id . '-metro.txt';
			
			$seo_data_array = file_get_contents($filename);
			$seo_data_array = unserialize($seo_data_array);
			
			$current_metro_term = get_term_by('slug', $metro, 'metro');
			$current_metro_term_id = $current_metro_term->term_id;
			
			$title = (string) $seo_data_array[$current_metro_term_id][title];
			$description = (string) $seo_data_array[$current_metro_term_id][description];
			
		} elseif($district != "") {
			
			$filename = dirname(__FILE__).'/json/seo/clinic-speciality-' . $current_clinic_speciality_term_id . '-district.txt';
			$seo_data_array = file_get_contents($filename);
			
			$seo_data_array = file_get_contents($filename);
			$seo_data_array = unserialize($seo_data_array);
			
			$current_district_term = get_term_by('slug', $district, 'district');
			$current_district_term_id = $current_district_term->term_id;
			
			
			$title = (string) $seo_data_array[$current_district_term_id][title];
			$description = (string) $seo_data_array[$current_district_term_id][description];
			
		} else {
			
			$field = 'single_title_for_clinic_speciality-' . $current_clinic_speciality_term_id;
			$field_description = 'single_description_for_clinic_speciality-' . $current_clinic_speciality_term_id;
			
			$title = (string) get_option( $field );
			$description = (string) get_option( $field_description );
			
		}
	}
	
	if( $query_diagnostic_term != "") {
		
		$current_diagnostic_term = get_term_by('slug', $query_diagnostic_term, 'diagnostic');
		$current_diagnostic_term_id = $current_diagnostic_term->term_id;
		
		
		if( $metro != "") {
			
			$filename = dirname(__FILE__).'/json/seo/diagnostic-' . $current_diagnostic_term_id . '-metro.txt';
			
			$seo_data_array = file_get_contents($filename);
			$seo_data_array = unserialize($seo_data_array);
			
			$current_metro_term = get_term_by('slug', $metro, 'metro');
			$current_metro_term_id = $current_metro_term->term_id;
			
			$title = (string) $seo_data_array[$current_metro_term_id][title];
			$description = (string) $seo_data_array[$current_metro_term_id][description];
			
			
		} elseif($district != "") {
			
			$filename = dirname(__FILE__).'/json/seo/diagnostic-' . $current_diagnostic_term_id . '-district.txt';
			$seo_data_array = file_get_contents($filename);
			
			$seo_data_array = file_get_contents($filename);
			$seo_data_array = unserialize($seo_data_array);
			
			$current_district_term = get_term_by('slug', $district, 'district');
			$current_district_term_id = $current_district_term->term_id;
			
			
			$title = (string) $seo_data_array[$current_district_term_id][title];
			$description = (string) $seo_data_array[$current_district_term_id][description];
			
		} else {
			
			$field = 'single_title_for_diagnostic-' . $current_diagnostic_term_id;
			$field_description = 'single_description_for_diagnostic-' . $current_diagnostic_term_id;
			
			$title = (string) get_option( $field );
			$description = (string) get_option( $field_description );
			
		}
		
	}
	
	

	
	
	


	
	
	
	
	
	
	
	
	
	
	
if ( defined('WPSEO_VERSION') ) {

if($title != "") {
	global $custom;
	$custom = $title;
	
	add_filter('wpseo_title', 'custom_wpseo_title', 10, 1);
	
	function custom_wpseo_title($title) {
		global $custom;
		
        $xz = "" . $custom;

		return $xz;
	}

}

if($description != "") {
	global $custom_description;
	$custom_description = $description;
	
	add_filter('wpseo_metadesc', 'custom_wpseo_description', 10, 1);
	
	function custom_wpseo_description($description) {
		global $custom_description;
		
        $xz = "" . $custom_description;

		return $xz;
	}

}

add_filter( 'wpseo_canonical', '__return_false' );

add_filter( 'wpseo_next_rel_link', '__return_false' );


}


if ( defined('AIOSEOP_VERSION') ) {
/* add_filter('aioseop_canonical_url','change_canonical_url', 10, 1); */
	if($title != "") {
	global $custom;
	$custom = $title;
	function my_title($title) {  
		
	
		global $custom;		
        $xz = "" . $custom;
		return $xz;
	}  
	add_filter('aioseop_title', 'my_title', 1);  
	}
	
	
if($description != "") {
	global $custom_description;
	$custom_description = $description;	
function my_description($description)   
{  


		global $custom_description;
		
        $xz = "" . $custom_description;

		return $xz;

}  
add_filter('aioseop_description', 'my_description', 1);  
	
}

}



}


    function removeHeadLinks() {   
        remove_action( 'wp_head', 'feed_links', 2 );
        remove_action( 'wp_head', 'feed_links_extra', 3);
        remove_action( 'wp_head', 'rsd_link');
        remove_action( 'wp_head', 'wlwmanifest_link');
        remove_action( 'wp_head', 'wp_generator');  
        remove_action( 'wp_head', 'rel_canonical');
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    }
    add_action('init', 'removeHeadLinks');
    remove_action('wp_head', 'wp_generator');


	




function acf_load_change_template_metro_field_choices( $field ) {
unset($field['choices']);
$metro_city_terms = get_terms( 'metro', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) );

$city = get_field('выбор_города', 'option');
				 foreach($metro_city_terms as $metro_city_term) { 
				
					 $current_city = get_field('Id', 'city_' . $metro_city_term->term_id); 
					
					 if($current_city == $city[0]) { 
					
 $metro_terms = get_terms( 'metro', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'child_of' => $metro_city_term->term_id ) ); 
					
						 foreach ( $metro_terms as $metro_term ) { 
							$field['choices'][ $metro_term->term_id ] = $metro_term->name;
						 } 
					
					 } 
				 } 

    // return the field
    return $field;
	
    
}

add_filter('acf/load_field/name=template_metro', 'acf_load_change_template_metro_field_choices');



function acf_load_change_template_district_field_choices( $field ) {
unset($field['choices']);
$district_city_terms = get_terms( 'district', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) );
			$city = get_field('выбор_города', 'option');
					foreach($district_city_terms as $district_city_term) {
						
					$current_city = get_field('Id_city', 'district_' . $district_city_term->term_id); 
					
						if($current_city == $city[0]) {
					
		$district_terms = get_terms( 'district', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'child_of' => $district_city_term->term_id ) ); 
						
							foreach($district_terms as $district) { 
								$field['choices'][ $district->term_id ] = $district->name;
							} 
						} 
					} 

    // return the field
    return $field;
    
}

add_filter('acf/load_field/name=template_district', 'acf_load_change_template_district_field_choices');



function acf_load_change_template_theme_uslugi_choices( $field ) {
	unset($field['choices']);

	$parents_uslugi = get_terms( 'uslugi', array( 'hide_empty' => 0, 'parent' => 0 ) ); 
			
		foreach($parents_uslugi as $parent_child) { 
				
			$parent_child_term_id = $parent_child->term_id;
			$parents_uslugi = get_terms( 'uslugi', array( 'hide_empty' => 0, 'orderby' => 'name', 'parent' => $parent_child_term_id ) );
			
			foreach($parents_uslugi as $parent_usluga_child) { 
				$array_uslugi[$parent_usluga_child->term_id] = $parent_usluga_child->name;
			} 
			
		} 
			
	foreach($array_uslugi as $key => $value ) {
		if (strpos($value, 'NEW') !== false) {
			unset($array_uslugi[$key]);
		}
	} 
	
	foreach($array_uslugi as $key => $value) { 
		
		$childrens_uslugi = get_terms( 'uslugi', array( 'hide_empty' => 0, 'orderby' => 'name', 'parent' => $key ) );
		
		foreach($childrens_uslugi as $usluga) { 
		
			$usluga_name 		= $usluga->name;
			$usluga_term_id 	= $usluga->term_id;
			$usluga_count 		= $usluga->count;
			
			$usluga_link 		= get_term_link($usluga_term_id, 'uslugi');
			
			$field['choices'][ $usluga_term_id ] = $usluga_name; 
			
		}
		
	} 
	
    // return the field
    return $field;
    
}

add_filter('acf/load_field/name=выбор_услуг', 'acf_load_change_template_theme_uslugi_choices');































