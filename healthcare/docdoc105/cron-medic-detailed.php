<?php
header('Content-Type: text/html; charset=utf-8', true);
require_once(dirname(__FILE__) . '/../../../wp-load.php');
require_once(dirname(__FILE__) . '/login-password.php');
$count         = 0;
$id_medic_docs = get_meta_values_and_posts('Id', 'medic');
$metro_terms   = get_terms(array(
	'taxonomy' => 'metro',
	'hide_empty' => 0
));
foreach ($metro_terms as $term) {
	$id_term                       = get_field('Id_metro', 'metro_' . $term->term_id);
	$metro_terms_array[$id_term]   = $term->term_id;
	$metro_slug_array[$term->slug] = $term->term_id;
}
$all_inclinics            = get_terms('inclinic', 'hide_empty=0');

foreach($all_inclinics as $inclinic) {
	$inclinic_wp_id = $inclinic->term_id;
	$inclinic_id_docdoc  = get_field('id_клиники_в_базе_docdoc', 'inclinic_' . $inclinic_wp_id);
	$array_inclinics_docdoc_wp[$inclinic_id_docdoc] = $inclinic_wp_id;
}



/* $metro_terms   = get_terms(array(
	'taxonomy' => 'metro',
	'hide_empty' => 0
));
foreach ($metro_terms as $term) {
	$id_term                       = get_field('Id_metro', 'metro_' . $term->term_id);
	$metro_terms_array[$id_term]   = $term->term_id;
	$metro_slug_array[$term->slug] = $term->term_id;
} */
$a = 0;
foreach ($id_medic_docs as $key => $value) {
	$json     = file_get_contents('https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.5/json/doctor/' . $key);
	usleep(400000);
	$obj      = json_decode($json);
	
	$wp_array = get_post_meta($value, "arraydetailed", true);
	if ($wp_array == $obj) {
		echo 'Врач - ' . $obj->Doctor[0]->Name . ',  <span style="color:grey;">обновлений не найденно.</span> <br> <br>';
		
	} else {
		echo 'Врач - ' . $obj->Doctor[0]->Name . ', есть обновления. <span style="color:green;"> Обновляем. </span> <br>';
		$first_doctor = $obj->Doctor[0];
		$Stations     = $first_doctor->Stations;
		
				$medic_inclinics = $first_doctor->Clinics;
		foreach($medic_inclinics as $medic_inclinic){
			$insert_inclinic[] = $array_inclinics_docdoc_wp[$medic_inclinic];
		}
		
	
		$term_taxonomy_inclinic = wp_set_object_terms($value, $insert_inclinic, 'inclinic');
		unset($insert_inclinic);
		
		foreach ($Stations as $Station) {
			$array_stations_id[] = $metro_terms_array[$Station->Id];
		}
		$term_taxonomy_ids = wp_set_object_terms($value, $array_stations_id, 'metro');
		unset($array_stations_id);
		usleep(400000);
		update_post_meta($value, 'Stations', $Stations);
		update_post_meta($value, 'arraydetailed', $obj);
	}
	$count++;
	
	
}

echo 'Ok' . $count;