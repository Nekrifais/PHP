<?php
header('Content-Type: text/html; charset=utf-8', true);
require_once(dirname(__FILE__) . '/../../../wp-load.php');
require_once(dirname(__FILE__) . '/includes/cron/create-clinic.php');
require_once(dirname(__FILE__) . '/login-password.php');

$weak_hosting = get_field('слабый_хостинг', 'option');


	wp_defer_term_counting( true );
	wp_defer_comment_counting( true );


$all_city = get_field('выгрузить_все_города', 'option');

$count=0;
if ($all_city == 0) {
	$cityarray = get_field('выбор_города', 'option');
} else {
	$cityjson = file_get_contents('https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/city/');
	$citylist = json_decode($cityjson);
	foreach ($citylist->CityList as $city) {
		$cityarray[] = $city->Id;
	}
}
$terms = get_terms('clinic-speciality', 'orderby=count&hide_empty=0');
if (!empty($terms) && !is_wp_error($terms)) {
	foreach ($terms as $term) {
		$docdoc_id                            = get_field('Id', 'clinic-speciality_' . $term->term_id);
		$array_specialities_terms[$docdoc_id] = $term->term_id;
	}
}
$clinic_ids_array = get_meta_values('id', 'clinic');

$clinic_ids_array = array_flip($clinic_ids_array);


$terms            = get_terms('diagnostic', 'orderby=count&hide_empty=0');
if (!empty($terms) && !is_wp_error($terms)) {
	foreach ($terms as $term) {
		$docdoc_id                          = get_field('Id', 'diagnostic_' . $term->term_id);
		$array_diagnostic_terms[$docdoc_id] = $term->term_id;
	}
}


$metro_terms = get_terms(array(
	'taxonomy' => 'metro',
	'hide_empty' => 0
));
foreach ($metro_terms as $term) {
	$id_term                       = get_field('Id_metro', 'metro_' . $term->term_id);
	$metro_terms_array[$id_term]   = $term->term_id;
	$metro_slug_array[$term->slug] = $term->term_id;
}

$district_terms = get_terms(array(
	'taxonomy' => 'district',
	'hide_empty' => 0
));

foreach ($district_terms as $term) {
	$district_id_term             				 = get_field('id', 'district_' . $term->term_id);
	if($district_id_term){
		$district_terms_array[$district_id_term]   	 = $term->term_id;
		$district_slug_array[$term->slug] 			 = $term->term_id;
	}
}


// services start

$uslugi_terms = get_terms(array('taxonomy' => 'uslugi', 'hide_empty' => 0 ));

if (!empty($uslugi_terms) && !is_wp_error($uslugi_terms)) {

	foreach ($uslugi_terms as $term) {
		$uslugi_id_term             				= get_field('Id', 'uslugi_' . $term->term_id);
		if($uslugi_id_term){
			$array_uslugi_terms[$uslugi_id_term] 	= $term->term_id;
		}
	} 
} 

// services end

foreach ($cityarray as $city) {
	$json  = file_get_contents('https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/clinic/list/start/0/count/5/city/' . $city . '/');
	usleep(800000);
	$obj   = json_decode($json);
	$total = $obj->Total;

	$all_speciality = get_field('выгрузить_все_специальности', 'option');
	if ($all_speciality == 0) {
		$speciality_to_import = get_field('выбор_специальностей', 'option');
		foreach ($speciality_to_import as $speciality) {
			for ($i = 0; $i <= $total; $i += 50) {
				$url = 'https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/clinic/list/start/' . $i . '/count/50/city/' . $city . '/speciality/' . $speciality . '/';
				/* echo $url . "\n"; */
				$json = file_get_contents($url);
				
				if (strlen($json)<180) {
					$i = $total;
				}
				
				usleep(800000);
				$obj  = json_decode($json);
				
				
				
				foreach ($obj->ClinicList as $value) {
					if (isset($clinic_ids_array[$value->Id])) {
					} else {
						
						$inclinics_create[$value->Id] = $value->Name;
						
						create_clinic($value, $array_diagnostic_terms, $array_specialities_terms, $metro_terms_array, $district_terms_array, $array_uslugi_terms, $weak_hosting);
					}
					$count++;
				}
			}
		}
	} else {
		for ($i = 0; $i <= $total; $i += 50) {
			$url = 'https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/clinic/list/start/' . $i . '/count/50/city/' . $city . '/';
			/* echo $url . "\n"; */
			$json = file_get_contents($url);
			
			usleep(800000);
			$obj  = json_decode($json);
			foreach ($obj->ClinicList as $value) {
				if (isset($clinic_ids_array[$value->Id])) {
				} else {
					
					$inclinics_create[$value->Id] = $value->Name;
					
					create_clinic($value, $array_diagnostic_terms, $array_specialities_terms, $metro_terms_array, $district_terms_array, $array_uslugi_terms, $weak_hosting);
				}
				$count++;
			}
		}
	}
echo 'Конец города';
}


	wp_defer_term_counting( false );
	wp_defer_comment_counting( false );


	
	
	

echo 'Ok ' . $count;
	
foreach($inclinics_create as $key => $value) {

	
	$args = array("post_type" => "clinic", "meta_key" => "Id", "meta_value" => $key, "post_status" => "any");
	$posts = get_posts($args);
	
	$clinic_post_id = $posts->ID;
	
	$term = wp_insert_term (
		$value, // the term 
		'inclinic', // the taxonomy
			array(
				'description'=> '',
				'slug' => $posts[0]->ID
			)
	);

	

	if (! is_wp_error( $term )){
		$term_id = $term[term_id];
		update_field('id_клиники_в_базе_docdoc', $key, 'inclinic_' . $term_id ); 
	}
	
}
