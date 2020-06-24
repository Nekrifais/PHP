<?php
header('Content-Type: text/html; charset=utf-8', true);
require_once(dirname(__FILE__) . '/../../../wp-load.php');
require_once(dirname(__FILE__) . '/login-password.php');

$id_medic_docs = get_meta_values_and_posts('Id', 'medic');


$all_speciality = get_terms( 'speciality', array( 'hide_empty' => 0 ) );




$all_nearmetro = get_terms( 'district', array( 'orderby' => 'count', 'hide_empty' => 0, 'parent' => 0 ) );

foreach($all_nearmetro as $nearmetro) {
	$id_nearmetro                      		= get_field('Id_city', 'district_' . $nearmetro->term_id);
	$all_near_metro_city[$id_nearmetro] 	= $nearmetro->term_id;
	
}


$all_city = get_field('выгрузить_все_города', 'option');
if ($all_city == 0) {
	$cityarray = get_field('выбор_города', 'option');
	
} else {
	$cityjson = file_get_contents('https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/city/');
	usleep(400000);
	$citylist = json_decode($cityjson);
	
	foreach ($citylist->CityList as $city) {
		$cityarray[] = $city->Id;
	}
	
}



foreach($cityarray as $city_id) {
	$city_nearmetro_id_array[$city_id] = $all_near_metro_city[$city_id];
}

print_R($city_nearmetro_id_array);

foreach($city_nearmetro_id_array as $city_nearmetro_id) {

$metro_terms   = get_terms(array(
	'taxonomy' => 'district',
	'child_of'	=> $city_nearmetro_id,
	'hide_empty' => 0
));

foreach ($metro_terms as $term) {
	
	$district_docdoc_id = get_field('id', 'district_' . $term->term_id);
	
	
	if($district_docdoc_id  != "") {
		$id_term[$term->term_id]       = $district_docdoc_id;
	}
}

foreach($all_speciality as $speciality) {
	
	$speciality_docdoc_id 	= get_field('Id', 'speciality_' . $speciality->term_id);


foreach($id_term as $key => $value) {
	
echo $value;
$nearjson = file_get_contents('https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/doctor/list/start/0/count/10/city/1/district/' . $value . '/speciality/' . $speciality_docdoc_id . '/near/extra/');

print_r($nearjson);

usleep(400000);

$nearlist = json_decode($nearjson);
 print_r($nearlist); 





foreach($nearlist->DoctorList as $medic) {
	/* echo $medic->Id . "\n"; */
	echo $id_medic_docs[$medic->Id] . "\n";
	$id_medic_docs_wp = $id_medic_docs[$medic->Id];
	
	
	$near_array_file[$speciality->term_id][$key][] = $id_medic_docs_wp;
	
	
	
	
	
}



echo " конец - район -" . $value;
break;


}
break;
}


echo " конец";
break;
}



	$path = dirname(__FILE__);

print_r($near_array_file);

foreach($near_array_file as $key => $value) {
	$serialize_value = serialize($value);
	
	$filename = $key . '.txt';
	file_put_contents($path . '/json/near/district/' . $filename, $serialize_value, true);
	
	
	
}

















