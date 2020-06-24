<?php
	header('Content-Type: text/html; charset=utf-8', true);
	require_once(dirname(__FILE__).'/../../../../wp-load.php');
	
	$all_speciality_terms = get_terms('speciality', array( 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => 0 ) );
	
	$all_clinic_speciality_terms = get_terms('clinic-speciality', array( 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => 0 ) );
	
	$all_diagnostic_terms = get_terms('diagnostic', array( 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => 0 ));
	
	
	$metro_city_terms = get_terms('metro', array( 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => 0 ) );

	$district_city_terms = get_terms( 'district', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0 ) );

foreach($all_speciality_terms as $speciality_term) {
	$current_speciality_term_id = $speciality_term->term_id;
	foreach($metro_city_terms as $metro_term) {
		$current_metro_term = $metro_term->term_id;
		
 		$field_name_title = 'title_for_speciality-' . $current_speciality_term_id . '_x_metro-'  . $current_metro_term;	
		delete_option( $field_name_title );
		
		$array_fields[] = $field_name_title;
		
 		$field_name_description = 'description_for_speciality-' . $current_speciality_term_id . '_x_metro-'  . $current_metro_term;	
		delete_option( $field_name_description );
		
		$field_name_textdescription = 'textdescription_for_speciality-' . $current_speciality_term_id . '_x_metro-'  . $current_metro_term;	
		delete_option( $field_name_textdescription );
		
	}

	foreach($district_city_terms as $district_term) {
		$current_district_term_id = $district_term->term_id;

		$field_name_title = 'title_for_speciality-' . $current_speciality_term_id . '_x_district-'  . $current_district_term_id;	
		delete_option( $field_name_title ); 
			
		$array_fields[] = $field_name_title;
			
 		$field_name_description = 'description_for_speciality-' . $current_speciality_term_id . '_x_district-'  . $current_district_term_id;	
		delete_option( $field_name_description );
			
		 $field_name_textdescription = 'textdescription_for_speciality-' . $current_speciality_term_id . '_x_district-'  . $current_district_term_id;	
		delete_option( $field_name_textdescription ); 
			
	}
	
}

foreach($all_clinic_speciality_terms as $clinic_speciality_term) {
	$clinic_speciality_term_id = $clinic_speciality_term->term_id;
	foreach($metro_city_terms as $metro_term) {
		$current_metro_term = $metro_term->term_id;
		
		$field_name_title = 'title_for_clinic_speciality-' . $clinic_speciality_term_id . '_x_metro-'  . $current_metro_term;	
		delete_option( $field_name_title ); 
		
		$array_fields[] = $field_name_title;
		
 		$field_name_description = 'description_for_clinic_speciality-' . $clinic_speciality_term_id . '_x_metro-'  . $current_metro_term;	
		delete_option( $field_name_description );
		
		$field_name_textdescription = 'textdescription_for_clinic_speciality-' . $clinic_speciality_term_id . '_x_metro-'  . $current_metro_term;	
		delete_option( $field_name_textdescription );
		
	}
	
	foreach($district_city_terms as $district_term) {
		$current_district_term_id = $district_term->term_id;

		$field_name_title = 'title_for_clinic_speciality-' . $clinic_speciality_term_id . '_x_district-'  . $current_district_term_id;	
		delete_option( $field_name_title ); 
		
		$array_fields[] = $field_name_title;
			
 		$field_name_description = 'description_for_clinic_speciality-' . $clinic_speciality_term_id . '_x_district-'  . $current_district_term_id;	
		delete_option( $field_name_description );
			
		 $field_name_textdescription = 'textdescription_for_clinic_speciality-' . $clinic_speciality_term_id . '_x_district-'  . $current_district_term_id;	
		delete_option( $field_name_textdescription ); 
			
	}
	
}


foreach($all_diagnostic_terms as $diagnostic_term) {
	$diagnostic_term_id = $diagnostic_term->term_id;
	foreach($metro_city_terms as $metro_term) {
		$current_metro_term = $metro_term->term_id;
		
		$field_name_title = 'title_for_diagnostic-' . $diagnostic_term_id . '_x_metro-'  . $current_metro_term;	
		delete_option( $field_name_title );

			$array_fields[] = $field_name_title;
		
 		$field_name_description = 'description_for_diagnostic-' . $diagnostic_term_id . '_x_metro-'  . $current_metro_term;	
		delete_option( $field_name_description );
		
		$field_name_textdescription = 'textdescription_for_diagnostic-' . $diagnostic_term_id . '_x_metro-'  . $current_metro_term;	
		delete_option( $field_name_textdescription );
		
	}
	
	foreach($district_city_terms as $district_term) {
		$current_district_term_id = $district_term->term_id;

		$field_name_title = 'title_for_diagnostic-' . $diagnostic_term_id . '_x_district-'  . $current_district_term_id;	
		delete_option( $field_name_title ); 
		
		$array_fields[] = $field_name_title;
			
 		$field_name_description = 'description_for_diagnostic-' . $diagnostic_term_id . '_x_district-'  . $current_district_term_id;	
		delete_option( $field_name_description );
			
		 $field_name_textdescription = 'textdescription_for_diagnostic-' . $diagnostic_term_id . '_x_district-'  . $current_district_term_id;	
		delete_option( $field_name_textdescription ); 
			
	}
	
	
} 

