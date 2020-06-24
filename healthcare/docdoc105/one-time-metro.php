<?php
header('Content-Type: text/html; charset=utf-8', true);
require_once(dirname(__FILE__).'/../../../wp-load.php');
require_once(dirname(__FILE__).'/login-password.php');

$cityjson = file_get_contents('https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/city/');
usleep(400000);
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
usleep(400000);
$citylist = json_decode($cityjson);




	$terms = get_terms( array( 
		'taxonomy' => 'metro',
		'parent'   => 0,
		'hide_empty' => 0
	) );

	

	foreach($terms as $term ) {
		$termsarray[$term->slug] = $term->term_id;
	}



foreach((array)$cityarray as $city ) {

	

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
		'metro', // the taxonomy
		array(
			'description'=> '',
			'slug' => $slug_city,
	  )
	);
	
	$term_id = $term[term_id];
	
	$city_term = wp_insert_term(
		$name_city, // the term 
		'city', // the taxonomy
		array(
			'description'=> '',
			'slug' => $slug_city,
	  )
	);
	$city_term_id = $city_term[term_id];
	
		update_field('тип_таксономии', 2, 'metro_' . $term_id );	
		update_field('Id', $Id_city, 'metro_' . $term_id );	
		update_field('Name', $name_city, 'metro_' . $term_id );	
		update_field('Alias', $slug_city, 'metro_' . $term_id );	
		update_field('Latitude', $Latitude_city, 'metro_' . $term_id );	
		update_field('Longitude', $Longitude_city, 'metro_' . $term_id );	
		update_field('SearchType', $SearchType_city, 'metro_' . $term_id );	
	
	
		update_field('Id', $Id_city, 'metro_' . $city_term_id );	
		update_field('Name', $name_city, 'metro_' . $city_term_id );	
		update_field('Alias', $slug_city, 'metro_' . $city_term_id );	
		update_field('Latitude', $Latitude_city, 'metro_' . $city_term_id );	
		update_field('Longitude', $Longitude_city, 'metro_' . $city_term_id );	
		update_field('SearchType', $SearchType_city, 'metro_' . $city_term_id );		
		
	$termsarray[$slug_city]	= $term_id;
		
}



	$metro_terms = get_terms( array( 
		'taxonomy' => 'metro',
		'parent'   => $termsarray[$allias],
		'hide_empty' => 0
	) );



	foreach($metro_terms as $term ) {

		
		
		$id_term = get_field('Id_metro', 'metro_' . $term->term_id);
		
		
		$metro_terms_array[$id_term] = $term->term_id;
		$metro_slug_array[$term->slug] = $term->term_id;
		
	}
	
	


$metrojson = file_get_contents('https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/metro/city/' . $city);
usleep(400000);

	$metrolist = json_decode($metrojson);
echo "<br>";	
echo $city;
echo "<br>";	
	
	
	
	
	
	/* print_r($metrolist);	 */
	$metrolist = $metrolist->MetroList;

	
	
	foreach($metrolist as $metro){
 
if(!isset($metro_terms_array[$metro->Id])){
		
		$Id_metro = $metro->Id;
		$name_metro = $metro->Name;
		$slug_metro = $metro->Alias;
		
		if(isset($metro_slug_array[$slug_metro])){
			$flipped_metro_slug_array = array_flip($metro_slug_array);
			
			
			$counts = array_count_values($flipped_metro_slug_array);
	
			$count = $counts[$slug_metro];
			
			$slug_metro = $slug_metro . '_' . $metro->Id;

		}
		
	
		$LineName_metro = $metro->LineName;
		$LineColor_metro = $metro->LineColor;
		$CityId_metro = $metro->CityId;
		
		$DistrictIds_metro = $metro->DistrictIds;
		$DistrictId_metro = implode(", ", $DistrictIds_metro);
		
/* 		$DistrictIds_metro = $metro->DistrictIds; */
		
		$term = wp_insert_term(
			$name_metro, // the term 
			'metro', // the taxonomy
			array(
				'description'=> '',
				'slug' => $slug_metro,
				'parent'=> $termsarray[$allias]

		  )
		);
		
		$term_id = $term[term_id];
		
			update_field('тип_таксономии', 3, 'metro_' . $term_id ); 
			update_field('Id_metro', $Id_metro, 'metro_' . $term_id ); 
			update_field('Alias_metro', $slug_metro, 'metro_' . $term_id ); 
			update_field('Name_metro', $name_metro, 'metro_' . $term_id ); 
			update_field('LineName_metro', $LineName_metro, 'metro_' . $term_id ); 
			update_field('LineColor_metro', $LineColor_metro, 'metro_' . $term_id ); 
			update_field('CityId_metro', $CityId_metro, 'metro_' . $term_id ); 
			update_field('DistrictIds_metro', $DistrictId_metro, 'metro_' . $term_id ); 


$metro_slug_array[$slug_metro] = $term_id;

		}
	}
	
	
	
	
	
	

echo "конец";


}
















$city_terms = get_terms( 'metro', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) );

foreach($city_terms as $city_term) {
		$city_term_id 	= $city_term->term_id;
		$city_name 		= $city_term->name;
		$city_slug 		= $city_term->slug;
		
		$metro_terms = get_terms( 'metro', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'child_of' => $city_term_id) );
		
	$count=0;
	
	foreach($metro_terms as $metro_term){
		$metro_term_id = $metro_term->term_id;
		$metro_name = $metro_term->name;
		$metro_slug = $metro_term->slug;
		
			$taxonomy_type 			= get_field('тип_таксономии', 'metro_' . $metro_term_id);
			
			if($taxonomy_type == 2) {
				$Id_metro_docdoc 		= get_field('Id', 'metro_' . $metro_term_id);
				$Alias_metro 			= get_field('Alias', 'metro_' . $metro_term_id);
				$coordinate 			= get_field('координаты', 'metro_' . $metro_term_id);
			}
			
			if($taxonomy_type == 3) {
				$Id_metro_docdoc 		= get_field('Id_metro', 'metro_' . $metro_term_id);
				$LineName_metro 		= get_field('LineName_metro', 'metro_' . $metro_term_id);
				$LineColor_metro 		= get_field('LineColor_metro', 'metro_' . $metro_term_id);
				$CityId_metro 			= get_field('CityId_metro', 'metro_' . $metro_term_id);
				$Alias_metro 			= get_field('Alias_metro', 'metro_' . $metro_term_id);
				$coordinate 			= get_field('координаты', 'metro_' . $metro_term_id);
			}
			
			
		$array_metro_file[$city_slug][$count][Id_metro_docdoc] 		= $Id_metro_docdoc;
		$array_metro_file[$city_slug][$count][Alias_metro]			= $Alias_metro;
		$array_metro_file[$city_slug][$count][metro_name] 			= $metro_name;
		$array_metro_file[$city_slug][$count][metro_slug] 			= $metro_slug;
		$array_metro_file[$city_slug][$count][metro_term_id]		= $metro_term_id;
		$array_metro_file[$city_slug][$count][LineName_metro]		= $LineName_metro;
		$array_metro_file[$city_slug][$count][LineColor_metro]		= $LineColor_metro;
		$array_metro_file[$city_slug][$count][CityId_metro]			= $CityId_metro;
		$array_metro_file[$city_slug][$count][coordinate]			= $coordinate;

$count++;

	}
	
}




	update_option( 'metro-filter-option', $array_metro_file, true ); 


















/* echo "конец"; */






