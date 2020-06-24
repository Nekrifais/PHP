<?php 
header('Content-Type: text/html; charset=utf-8', true);
require_once(dirname(__FILE__) . '/../../../../wp-load.php');



$metro_array_serialize = file_get_contents( 'coordinates-metro.txt');
$metro_array_unserialize = unserialize($metro_array_serialize);


$all_metro = get_terms(array('taxonomy' => 'metro', 'hide_empty' => 0 ));

if (!empty($all_metro) && !is_wp_error($all_metro)) {

	foreach ($all_metro as $metro) {
		$metro_docdoc_id = get_field('Id_metro', 'metro_' . $metro->term_id);
		
		if($metro_docdoc_id){
			
			$coordinate = $metro_array_unserialize[$metro_docdoc_id];
			update_field('координаты', $coordinate, 'metro_' . $metro->term_id); 
			
		}
	} 
} 





$district_array_serialize = file_get_contents( 'coordinates-district.txt');
$district_array_unserialize = unserialize($district_array_serialize);


$all_district = get_terms(array('taxonomy' => 'district', 'hide_empty' => 0 ));
if (!empty($all_district) && !is_wp_error($all_district)) {

	foreach ($all_district as $district) {
		$district_docdoc_id	= get_field('id', 'district_' . $district->term_id);
		
		if($district_docdoc_id){
			
			$coordinate = $district_array_unserialize[$district_docdoc_id];
			update_field('координаты', $coordinate, 'district_' . $district->term_id);
			
			
		}
	} 
} 




