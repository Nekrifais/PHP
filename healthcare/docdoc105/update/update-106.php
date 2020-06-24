<?php 
header('Content-Type: text/html; charset=utf-8', true);
require_once(dirname(__FILE__).'/../../../../wp-load.php');

$clinic_ids_array = get_meta_posts_and_values('id', 'clinic');
$medic_clinic_ids_array = get_meta_posts_and_values('wp_clinics_ids', 'medic');



foreach($medic_clinic_ids_array as $key => $value){
	$value = unserialize($value);
/* 	$implode_id_clinic_array = explode(",", $value); */
	
	foreach($value as $implode_id_clinic) {
		if($implode_id_clinic != "") {
			$insert_data[$implode_id_clinic][] = $key;
		}
	}
	
}

/* print_r($clinic_ids_array); */

$inclinic_terms = get_terms('inclinic', 'orderby=count&hide_empty=0');



foreach($inclinic_terms as $inclinic_term) {
	$inclinic_term_slug 		= $inclinic_term->slug;
	$inclinic_term_term_id 		= $inclinic_term->term_id;
	$inclinic_array[$inclinic_term_slug] = $inclinic_term_term_id;
}

/* print_r($inclinic_array); */

foreach($clinic_ids_array as $key => $value) {
	
	if(isset($inclinic_array[$key])) {
		
	} else {
		$current_title = get_the_title($key);
		
		$term = wp_insert_term(
			$current_title, // the term 
			'inclinic', // the taxonomy
			array(
				'description'=> '',
				'slug' => $key,
			)
		);
		
		$term_id = $term[term_id];
		
		if(isset($insert_data[$key])) {
			$medic_ids = $insert_data[$key];
			foreach($medic_ids as $medic_id) {
				
				$term_taxonomy_ids = wp_set_object_terms( $medic_id, $term_id, 'inclinic', true );
				
			}
		}
		
		update_field('id_клиники_в_базе_docdoc', $value, 'inclinic_' . $term_id );
		
	}
	
	
}






echo "Конец.";








