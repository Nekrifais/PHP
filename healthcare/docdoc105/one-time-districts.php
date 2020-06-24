<?php
header('Content-Type: text/html; charset=utf-8', true);
require_once(dirname(__FILE__).'/../../../wp-load.php');
require_once(dirname(__FILE__).'/login-password.php');



$cityjson = file_get_contents('https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/city/');

$citylist = json_decode($cityjson);


	foreach($citylist->CityList as $city ) {
		$bigcityarray[$city->Id] = $city;
	}



$all_city = get_field('выгрузить_все_города', 'option');

if( $all_city == 0){
	
	$cityarray = get_field('выбор_города', 'option');
	
} else {

	foreach($citylist->CityList as $city ) {
		$cityarray[] = $city->Id;
	}
	
}

$cityjson = file_get_contents('https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/city/');
usleep(300000);
$citylist = json_decode($cityjson);



	$terms = get_terms( array( 
		'taxonomy' => 'district',
		'parent'   => 0,
		'hide_empty' => 0
	) );
	
	
	
	foreach($terms as $term ) {
		$termsarray[$term->slug] = $term->term_id;
		
		$docdoc_id_city = get_field('Id_city', 'district_' . $term->term_id);
		
		$city_for_district[$docdoc_id_city] = $term->term_id;
	}



foreach($cityarray as $city ) {
	

	$allias = $bigcityarray[$city]->Alias;
	
	if(!isset($termsarray[$allias])){
		
	$Id_city = $bigcityarray[$city]->Id;
	$name_city = $bigcityarray[$city]->Name;
	$slug_city = $bigcityarray[$city]->Alias;
	$Latitude_city = $bigcityarray[$city]->Latitude;
	$Longitude_city = $bigcityarray[$city]->Longitude;
	$SearchType_city = $bigcityarray[$city]->SearchType;
	
 	$term = wp_insert_term(
		$name_city, // the term 
		'district', // the taxonomy
		array(
			'description'=> '',
			'slug' => $slug_city,
	  )
	);
	
	$term_id = $term[term_id];
	
	
		update_field('тип_таксономии', 'city', 'district_' . $term_id );	
		update_field('Id_city', $Id_city, 'district_' . $term_id );	
		update_field('Name_city', $name_city, 'district_' . $term_id );	
		update_field('Alias_city', $slug_city, 'district_' . $term_id );	
		update_field('Latitude_city', $Latitude_city, 'district_' . $term_id );	
		update_field('Longitude_city', $Longitude_city, 'district_' . $term_id );	
		update_field('SearchType_city', $SearchType_city, 'district_' . $term_id );	
	
	
	
		
	$termsarray[$slug_city]	= $term_id;
	$city_for_district[$Id_city] = $term_id;
}
}



	$area_terms = get_terms( array( 
		'taxonomy' => 'district',
		'hide_empty' => 0,
		'parent' => $termsarray['msk']
	) );

	

	foreach($area_terms as $term ) {
		$area_termsarray[$term->slug] = $term->term_id;
	}




$areajson = file_get_contents('https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/area');
usleep(400000);

$arealist = json_decode($areajson);

$arealist = $arealist->AreaList;



	foreach($arealist as $area ) {
		
	$alias_area = $area->Alias;
		
	if(!isset($area_termsarray[$alias_area])){		
	$Id_area = $area->Id;
	$name_area = $area->Name;
	$FullName_area = $area->FullName;

		
 	$term = wp_insert_term(
		$name_area, // the term 
		'district', // the taxonomy
		array(
			'description'=> '',
			'slug' => $alias_area,
			'parent'=> $termsarray['msk']
	  )
	);
	
	$term_id = $term[term_id];
	
	
		update_field('тип_таксономии', 'area', 'district_' . $term_id );	
		update_field('id_area', $Id_area, 'district_' . $term_id );	
		update_field('alias_area', $alias_area, 'district_' . $term_id );	
		update_field('name_area', $name_area, 'district_' . $term_id );	
		update_field('fullname_area', $FullName_area, 'district_' . $term_id );	
	
$area_termsarray[$alias_area]	= $term_id;
	}
	}
	
	$district_terms = get_terms( array( 
		'taxonomy' => 'district',
		'hide_empty' => 0
	) );
	
	
	foreach($district_terms as $term ) {
		$district_termsarray[$term->slug] = $term->term_id;
		$docdoc_district_id = get_field('id', 'district_' . $term->term_id);
		$docdoc_district_id_array[$docdoc_district_id] = $term->term_id;
	}	
	
	$a=0;
	foreach($cityarray as $city ) {
	
$districtjson = file_get_contents('https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/district/city/' . $city);
usleep(400000);


$districtlist = json_decode($districtjson);
$districtlist = $districtlist->DistrictList;



foreach($districtlist as $district ) {
		$a++;
	$Id = $district->Id;
	$alias = $district->Alias;

	if(!isset($docdoc_district_id_array[$Id])){	

	$name = $district->Name;
	

	$current_district = $district->Area->Alias;
	
	
if($city == 1){
 	$term = wp_insert_term(
		$name, // the term 
		'district', // the taxonomy
		array(
			'description'=> '',
			'slug' => $alias,
			'parent' => $area_termsarray[$current_district]
		
	  )
	);
} else {	
 	$term = wp_insert_term(
		$name, // the term 
		'district', // the taxonomy
		array(
			'description'=> '',
			'slug' => $alias,
		    'parent' => $city_for_district[$city]
	  )
	);	
	
}
	
	
	$term_id = $term[term_id];
	
		update_field('тип_таксономии', 'district', 'district_' . $term_id );	
		update_field('id', $Id, 'district_' . $term_id );	
		update_field('alias', $alias, 'district_' . $term_id );	
		update_field('name', $name, 'district_' . $term_id );
$docdoc_district_id_array[$Id] = $term_id;
}
}

	}
	
echo $a;





$city_terms = get_terms( 'district', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) );

foreach($city_terms as $city_term) {
		$city_term_id = $city_term->term_id;
		$city_name = $city_term->name;
		$city_slug = $city_term->slug;
		
		$district_terms = get_terms( 'district', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'child_of' => $city_term_id) );
		
	$count=0;
	
	foreach($district_terms as $district_term){
		$district_term_id 		= $district_term->term_id;
		$district_name 		= $district_term->name;
		$district_slug 		= $district_term->slug;
		
			$taxonomy_type 			= get_field('тип_таксономии', 'district_' . $metro_term_id);
			
			if($taxonomy_type == "district") {
				$Id_docdoc 			= get_field('id', 'district_' . $metro_term_id);
				$Alias_district 	= get_field('alias', 'district_' . $metro_term_id);
				$coordinate 		= get_field('координаты', 'district_' . $metro_term_id);
			}
			
		$array_district_file[$city_slug][$count][Id_docdoc] 			= $Id_docdoc;
		$array_district_file[$city_slug][$count][district_name]			= $district_name;
		$array_district_file[$city_slug][$count][district_term_id]		= $district_term_id;
		$array_district_file[$city_slug][$count][Alias_district]		= $Alias_district;
		$array_district_file[$city_slug][$count][coordinate]			= $coordinate;
		$array_district_file[$city_slug][$count][district_slug]			= $district_slug;
		
		$count++;
		
	}
	
}



	update_option( 'district-filter-option', $array_district_file, false ); 





