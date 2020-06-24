<?php 
header('Content-Type: text/html; charset=utf-8', true);
require_once(dirname(__FILE__).'/../../../wp-load.php');
require_once(dirname(__FILE__) . '/login-password.php');
$loader = require(__DIR__ . '/includes/vendor/autoload.php');


$path = dirname(__FILE__);

$option_all_city = get_field('выгрузить_все_города', 'option');
$count=0;

if ($option_all_city == 0) {
	$cityarray = get_field('выбор_города', 'option');
	
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




$all_nearmetro = get_terms( 'metro', array( 'orderby' => 'count', 'hide_empty' => 0, 'parent' => 0 ) );

foreach($all_nearmetro as $nearmetro) {
	$id_nearmetro                      		= get_field('Id', 'metro_' . $nearmetro->term_id);
	$all_near_metro_city[$id_nearmetro] 	= $nearmetro->term_id;
	
}

$all_neardistrict = get_terms( 'district', array( 'orderby' => 'count', 'hide_empty' => 0, 'parent' => 0 ) );
foreach($all_neardistrict as $neardistrict) {
	$id_neardistrict                      		= get_field('Id_city', 'district_' . $neardistrict->term_id);
	$all_near_district_city[$id_neardistrict] 	= $neardistrict->term_id;
	
}


foreach($cityarray as $city_id) {
	$city_nearmetro_id_array[$city_id] = $all_near_metro_city[$city_id];
	$city_neardistrict_id_array[$city_id] = $all_near_district_city[$city_id];
	
}


foreach($city_neardistrict_id_array as $city_neardictrict_docdoc_id => $city_neardictrict_docdoc_wp) {

$city_tmp_slug = get_term_by('term_id', $city_neardictrict_docdoc_wp, 'district');
$district_terms   = get_terms(array(
	'taxonomy' => 'district',
	'parent'	=> $city_neardictrict_docdoc_wp,
	'hide_empty' => 0
));


if($city_neardictrict_docdoc_id == 1) {


foreach ($district_terms as $district_term) {
$msk_district_terms   = get_terms(array(
	'taxonomy' => 'district',
	'parent'	=> $district_term->term_id,
	'hide_empty' => 0
));



foreach ($msk_district_terms as $msk_district_term) {
	$docdoc_district_id 						= get_field('id', 'district_' . $msk_district_term->term_id);
	$id_district_term[$msk_district_term->term_id]	= $docdoc_district_id;
	$city_tmp_array[$msk_district_term->term_id] = $city_tmp_slug->slug;
	
}


}

} else {

foreach ($district_terms as $district_term) {
	$docdoc_district_id 						= get_field('id', 'district_' . $district_term->term_id);
	$id_district_term[$district_term->term_id]	= $docdoc_district_id;
	$city_tmp_array[$district_term->term_id] = $city_tmp_slug->slug;
	
}

}

}


foreach($city_nearmetro_id_array as $city_nearmetro_docdoc_id => $city_nearmetro_docdoc_wp) {
$city_tmp_slug = get_term_by('term_id', $city_nearmetro_docdoc_wp, 'metro');

$metro_terms   = get_terms(array(
	'taxonomy' => 'metro',
	'parent'	=> $city_nearmetro_docdoc_wp,
	'hide_empty' => 0
));



foreach ($metro_terms as $term) {
	$docdoc_metro_id = get_field('Id_metro', 'metro_' . $term->term_id);
	$id_term[$term->term_id]       = $docdoc_metro_id;
	$city_tmp_array[$term->term_id] = $city_tmp_slug->slug;

}
}



$all_speciality 	= get_terms( 'speciality', array( 'hide_empty' => 0 ) );
$all_city 			= get_terms( 'city', array( 'hide_empty' => 0 ) );
$all_diagnostic		= get_terms( 'diagnostic', array( 'hide_empty' => 0 ) );


foreach($all_city as $diagnostic_city) {
	$diagnostic_city_wp_id 		= $diagnostic_city->term_id;
	$diagnostic_city_slug 		= $diagnostic_city->slug;
	
	
	foreach($all_diagnostic as $diagnostic) {
		$diagnostic_wp_id = $diagnostic->term_id;
		
		$args = array(
			'posts_per_page' => '1',
			'post_type' => 'clinic',
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'diagnostic',
					'field'    => 'term_id',
					'terms'    => array( $diagnostic_wp_id ),
				),
				array(
					'taxonomy' => 'city',
					'field'    => 'term_id',
					'terms'    => array( $diagnostic_city_wp_id ),
				)
			)
		);
		
		$recent = new WP_Query( $args );
		$number_diagnostic = $recent->found_posts;
		
		$diagnostic_city_number_array[$diagnostic_city_slug][$diagnostic_wp_id] = $number_diagnostic;
	}
	
	
}




	
		$diagnostic_city_number_array_serialize = serialize($diagnostic_city_number_array);
		$filename = 'diagnostic-count.txt';
		file_put_contents($path . '/json/seo/data/' . $filename, $diagnostic_city_number_array_serialize, true);









foreach($all_city as $city) {
	$city_term_id 		= $city->term_id;
	$city_docdoc_id 	= get_field('Id', 'city_' . $city_term_id );
	$city_slug 			= $city->slug;
echo $city_slug;
echo "\n";
/* 		if ($option_all_city == 0) {
			if(in_array($city_docdoc_id, $cityarray)) {
			
			} else {
				continue;
			}
		}  */
	
	foreach($all_speciality as $speciality) {
	$speciality_term_id = $speciality->term_id;
    echo $city_slug;	
	echo "\n";

		
		
		
		
		
		
		include(dirname( __FILE__ ) . '/includes/seo/get-seo-data/specialities-count.php');
		
		$speciality_medic_number_array[$city_slug][$speciality_term_id] = $number;
		
		
		$speciality_medic_number_array_serialize = serialize($speciality_medic_number_array);
		$filename = 'speciality-count.txt';
		file_put_contents($path . '/json/seo/data/' . $filename, $speciality_medic_number_array_serialize, true);
		
	/* die;	 */
		include(dirname( __FILE__ ) . '/includes/seo/get-seo-data/specialities-rating.php');
		
			$speciality_medic_rating_array_serialize = serialize($speciality_medic_rating_array);
			$filename = 'speciality-rating-count.txt';
			file_put_contents($path . '/json/seo/data/' . $filename, $speciality_medic_rating_array_serialize, true);
		
		include(dirname( __FILE__ ) . '/includes/seo/get-seo-data/specialities-expirience.php');
				
			$speciality_medic_ExperienceYear_array_serialize = serialize($speciality_medic_ExperienceYear_array);
			$filename = 'speciality-expirience-count.txt';
			file_put_contents($path . '/json/seo/data/' . $filename, $speciality_medic_ExperienceYear_array_serialize, true);
		
		include(dirname( __FILE__ ) . '/includes/seo/get-seo-data/specialities-reviews.php');
		
			$speciality_medic_OpinionCount_array_serialize = serialize($speciality_medic_OpinionCount_array);
			$filename = 'speciality-reviews-count.txt';
			file_put_contents($path . '/json/seo/data/' . $filename, $speciality_medic_OpinionCount_array_serialize, true);
		
		
		
		
		include(dirname( __FILE__ ) . '/includes/seo/get-seo-data/speciality-nadom-count.php');
		
			$speciality_medic_nadom_number_array[$city_slug][$speciality_term_id] = $number_nadom;
		
			$speciality_medic_nadom_number_array_serialize = serialize($speciality_medic_nadom_number_array);
			$filename = 'speciality-nadom-count.txt';
			file_put_contents($path . '/json/seo/data/' . $filename, $speciality_medic_nadom_number_array_serialize, true);
		
		include(dirname( __FILE__ ) . '/includes/seo/get-seo-data/speciality-child-count.php');
		
			$speciality_medic_child_number_array[$city_slug][$speciality_term_id] = $number_child;
		
			$speciality_medic_child_number_array_serialize = serialize($speciality_medic_child_number_array);
			$filename = 'speciality-child-count.txt';
			file_put_contents($path . '/json/seo/data/' . $filename, $speciality_medic_child_number_array_serialize, true);
		
		
		
	}
}

	foreach($all_speciality as $speciality) {
	$speciality_term_id = $speciality->term_id;
    echo $city_slug;	
		echo "\n";
 		include(dirname(__FILE__) . '/includes/seo/get-seo-data/speciality-district-count.php');
		
		
		
		$speciality_district_medic_number_array_serialize = serialize($speciality_district_medic_number_array);
		$filename = 'speciality-district-count.txt';
		file_put_contents($path . '/json/seo/data/' . $filename, $speciality_district_medic_number_array_serialize, true);		
		
		

		include(dirname(__FILE__) . '/includes/seo/get-seo-data/speciality-metro-count.php');
		
		
		
		$speciality_metro_medic_number_array_serialize = serialize($speciality_metro_medic_number_array);
		$filename = 'speciality-metro-count.txt';
		file_put_contents($path . '/json/seo/data/' . $filename, $speciality_metro_medic_number_array_serialize, true);
		
	}
echo $city_slug;
echo "\n";
echo "Конец.";

	/* print_r($speciality_medic_number_array); */
	/* print_r($speciality_medic_rating_array); */















































