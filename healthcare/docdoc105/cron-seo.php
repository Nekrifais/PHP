<?php 
header('Content-Type: text/html; charset=utf-8', true);
require_once(dirname(__FILE__).'/../../../wp-load.php');
$loader = require(__DIR__ . '/includes/vendor/autoload.php');


$dust = new \Dust\Dust();
	$city = get_field('выбор_города', 'option');
	$city = array_shift( $city );
	
	
	$all_speciality_terms = get_terms('speciality', array( 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => 0 ) );
	
	$all_clinic_speciality_terms = get_terms('clinic-speciality', array( 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => 0 ) );
	
	$all_diagnostic_terms = get_terms('diagnostic', array( 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => 0 ));
	
	
	$metro_city_terms = get_terms('metro', array( 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => 0, 'parent' => 0 ) );

	$district_city_terms = get_terms( 'district', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) );

	 foreach($district_city_terms as $district_city_term) { 

		$current_city = get_field('Id_city', 'district_' . $district_city_term->term_id);
					
		 if($current_city == $city) {
					
			$all_district_terms = get_terms( 'district', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'child_of' => $district_city_term->term_id ) );
			
		} 
	}
	
	
	foreach($metro_city_terms as $metro_city_term) { 
			
		$current_city = get_field('Id', 'metro_' . $metro_city_term->term_id);
		if($current_city == $city) {
			$current_city_slug = $metro_city_term->slug;
		
			$all_metro_terms = get_terms( 'metro', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'child_of' => $metro_city_term->term_id ) ); 
 
		}
	}
		
	$custom_template_array = get_meta_posts_and_values('taxonomy', 'templates');
	
	/* print_r($custom_template_array); */
	
	$type_array = array(
		"2" => "title",
		"3" => "description",
		"4" => "заголовок",
		"5" => "описание",
	);

	
	$path = dirname(__FILE__);
	
		include(dirname(__FILE__) . '/includes/seo/speciality.php'); 
		
 		include(dirname(__FILE__) . '/includes/seo/clinic-speciality.php'); 
		
		include(dirname(__FILE__) . '/includes/seo/diagnostic.php');  
	









echo "Конец.";














