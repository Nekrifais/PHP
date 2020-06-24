<?php
header('Content-Type: text/html; charset=utf-8', true);
require_once(dirname(__FILE__) . '/../../../wp-load.php');
require_once(dirname(__FILE__) . '/includes/cron/create-medic.php');
require_once(dirname(__FILE__) . '/includes/cron/update-medic.php');
require_once(dirname(__FILE__) . '/login-password.php');

$weak_hosting = get_field('слабый_хостинг', 'option');

	wp_defer_term_counting( true );
	wp_defer_comment_counting( true );

$count=0;
$medic_ids_array  = get_meta_values('id', 'medic');
$medic_ids_array  = array_flip($medic_ids_array);
$clinic_ids_array = get_meta_values_and_posts('Id', 'clinic');
$district_ids_array = get_meta_posts_and_values('_district', 'clinic');

$publish = get_field('publish_medic_clinic_immediately', 'option');
$terms            = get_terms('speciality', 'orderby=count&hide_empty=0');

$terms            = get_terms('speciality', 'orderby=count&hide_empty=0');

if (!empty($terms) && !is_wp_error($terms)) {
	foreach ($terms as $term) {
		$docdoc_id                            	= get_field('Id', 'speciality_' . $term->term_id);
		$array_Specialities_terms[$docdoc_id] 	= $term->term_id;
		$wp_Specialities_name 					= $term->name;
		$array_option_speciality[$docdoc_id] 	= $wp_Specialities_name;
	}
}

update_option( 'specialities_docdocid_wpname', $array_option_speciality );

$city_terms = get_terms(array(
	'taxonomy' => 'city',
	'hide_empty' => 0
));
foreach ($city_terms as $term) {
	$doc_doc_id_term                    = get_field('Id', 'city_' . $term->term_id);
	$city_terms_array[$doc_doc_id_term] = $term->term_id;
	$city_slug_array[$term->slug]       = $term->term_id;
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
$medic_array = get_meta_values_and_posts('id', 'medic');
foreach ($cityarray as $city) {
	$all_speciality = get_field('выгрузить_все_специальности', 'option');
	$wp_city_id     = $city_terms_array[$city];
	if ($all_speciality == 0) {
		$speciality_to_import = get_field('выбор_специальностей', 'option');
		foreach ($speciality_to_import as $speciality_id) {
			$json  = file_get_contents('https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/doctor/list/start/0/count/1/city/' . $city . '/speciality/' . $speciality_id . '/');
			usleep(450000);
			$obj   = json_decode($json);
			$total = $obj->Total;
			for ($i = 0; $i <= $total; $i += 50) {
				$url = 'https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/doctor/list/start/' . $i . '/count/50/city/' . $city . '/speciality/' . $speciality_id . '/';
				/* echo $url . "\n"; */
				$json = file_get_contents($url);
				usleep(450000);
				$obj  = json_decode($json);
				foreach ($obj->DoctorList as $value) {
					
					$a++;
					$array_Specialities = array();
					$Specialities       = $value->Specialities;
					foreach ($Specialities as $Speciality) {
						$array_Specialities[] = $array_Specialities_terms[$Speciality->Id];
					}
					$array_Specialities = array_filter($array_Specialities);
					if (isset($medic_array[$value->Id])) {
						$wp_id = $medic_array[$value->Id];
						update_medic($value, $array_Specialities_terms, $wp_id, $wp_city_id, $clinic_ids_array, $district_ids_array);
					} else {
						create_medic($value, $array_Specialities_terms, $wp_city_id, $clinic_ids_array, $district_ids_array, $weak_hosting, $publish);
					}
				}
				$count++;
			}
		}
	} else {
		$json  = file_get_contents('https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/doctor/list/start/1/count/1/city/' . $city . '/');
		usleep(450000);
		$obj   = json_decode($json);
		$total = $obj->Total;
		for ($i = 1; $i <= $total; $i += 50) {
			$url = 'https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/doctor/list/start/' . $i . '/count/50/city/' . $city . '/';
			/* echo $url . "\n"; */
			$json = file_get_contents($url);
			usleep(450000);
			$obj  = json_decode($json);
			foreach ($obj->DoctorList as $value) {
				$array_Specialities = array();
				$Specialities       = $value->Specialities;
				foreach ($Specialities as $Speciality) {
					$array_Specialities[] = $array_Specialities_terms[$Speciality->Id];
				}
				$array_Specialities = array_filter($array_Specialities);
				if (isset($medic_array[$value->Id])) {
					$wp_id = $medic_array[$value->Id];
					update_medic($value, $array_Specialities_terms, $wp_id, $wp_city_id, $clinic_ids_array, $district_ids_array);
				} else {
					create_medic($value, $array_Specialities_terms, $wp_city_id, $clinic_ids_array, $district_ids_array, $weak_hosting, $publish);
				}
				$count++;
			
			}
		}
	}
}

	wp_defer_term_counting( false );
	wp_defer_comment_counting( false );

echo 'Ok - ' . $count;





