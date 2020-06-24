<?php 
header('Content-Type: text/html; charset=utf-8', true);
require_once(dirname(__FILE__) . '/../../../../wp-load.php');

$uslugi_terms = get_terms(array('taxonomy' => 'uslugi', 'hide_empty' => 0 ));

if (!empty($uslugi_terms) && !is_wp_error($uslugi_terms)) {

	foreach ($uslugi_terms as $term) {
		$uslugi_id_term             				= get_field('Id', 'uslugi_' . $term->term_id);
		if($uslugi_id_term){
			$array_uslugi_terms[$uslugi_id_term] 	= $term->term_id;
		}
	} 
} 



$clinic_docdoc_array = get_meta_posts_and_values('array', 'clinic');


foreach($clinic_docdoc_array as $key => $value) {
	$value = unserialize($value);
	
	$array_uslugi = array();
	$Uslugi = $value->Services->ServiceList;
	
	foreach( (array) $Uslugi as $Usluga) {
		$array_uslugi[] = $array_uslugi_terms[$Usluga->ServiceId];
	}
	
	
	$term_uslugi_ids = wp_set_object_terms( $key, $array_uslugi, 'uslugi' );
	usleep(400000);
}


