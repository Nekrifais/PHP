<?php 
header('Content-Type: text/html; charset=utf-8', true);
require_once(dirname(__FILE__) . '/../../../wp-load.php');


$clinic_docdoc_array = get_meta_posts_and_values('array', 'clinic');
$id_clinic_array     = get_meta_values_and_posts('Id', 'clinic');
$sign_up_docdoc = get_field('телефон_для_записи_в_docdoc', 'option');

foreach($clinic_docdoc_array as $key => $value) {

	$unserialize_value = unserialize($value);
	$clinic_specialities = $unserialize_value->Specialities;
	
	$Longitude = $unserialize_value->Longitude;
	$Latitude = $unserialize_value->Latitude;
	
	$title 				= $unserialize_value->Name;
	$url 				= get_permalink($key);
	$adress 			= $unserialize_value->Street . ', ' . $unserialize_value->House;
	
	if($sign_up_docdoc) {
		$PhoneAppointment 	= $sign_up_docdoc; 
	} else {
		$PhoneAppointment 	= $unserialize_value->PhoneAppointment; 
	}
	
	
	$options_array[$key][title]				= $title;
	$options_array[$key][url] 				= $url;
	$options_array[$key][adress] 			= $adress;
	$options_array[$key][PhoneAppointment] 	= $PhoneAppointment;
	

	foreach($clinic_specialities as $clinic_speciality){
		$coordinates_array[$clinic_speciality->Id][$key] = $Latitude . ',' . $Longitude;
		
	}


}



foreach($coordinates_array as $key => $value) {
	
	$array['type'] = 'FeatureCollection';

	

	foreach($value as $wp_clinic_id => $coordinate){
		
		$title 				= $options_array[$wp_clinic_id][title];
		$url 				= $options_array[$wp_clinic_id][url];
		$adress 			= $options_array[$wp_clinic_id][adress];
		$PhoneAppointment 	= $options_array[$wp_clinic_id][PhoneAppointment];
		
		$balloonContentHeader 	= '<h4>' . $title . '</h4>';
		$balloonContentBody 	= '<p><i>Адресс: </i>' . $adress . '</p><p><i>Телефон: </i>' . $PhoneAppointment . '<a href="' . $url . '" target="_blank">Подробнее</a></p>';
		
		$features['type'] = 'Feature';
		$features['id'] = $wp_clinic_id;
		
		$features['geometry']['type'] = 'Point';
		
		$implode_coordinate = explode(",", $coordinate);
		
		$coord_x = $implode_coordinate[0];
		$coord_y = $implode_coordinate[1];
		
		
		$features['geometry']['coordinates'] = [(float)$coord_x,(float)$coord_y];
		
		$features['properties']['balloonContentHeader'] = $balloonContentHeader;
		$features['properties']['balloonContentBody'] = $balloonContentBody;
		$features['properties']['balloonContentFooter'] = '';
		$features['properties']['clusterCaption'] = $title;
		$features['properties']['hintContent'] = $title;

		$array['features'][] = $features;

		unset($features);

	}

	$json_array = json_encode($array);
	$filename = 'clinic-speciality-' . $key . '.json';
	file_put_contents(dirname(__FILE__) . '/json/clinic-maps/' . $filename, $json_array, true);
		
	unset($array);


}



$medic_docdoc_array = get_meta_posts_and_values('array', 'medic');


foreach($medic_docdoc_array as $key => $value) {
	
	$unserialize_value = unserialize($value);
	$medic_specialities = $unserialize_value->Specialities;
	
	$medic_docdoc_id = $unserialize_value->Id;
	$clinics_info = $unserialize_value->ClinicsInfo;
	
	foreach($medic_specialities as $medic_speciality){
		
		foreach($clinics_info as $clinic_info){
			$Longitude = $clinic_info->Longitude;
			$Latitude = $clinic_info->Latitude;	
			
			$tmp_array[clinic_docdoc_id] = $clinic_info->ClinicId;	
			$tmp_array[medic_docdoc_id] = $medic_docdoc_id;	
			$tmp_array[medic_wp_id] = $key;	
			$tmp_array[medic_coordinate] = $Latitude . ',' . $Longitude;
			$tmp_array[medic_name] = $unserialize_value->Name;
			

			$medic_coordinates_array[$medic_speciality->Id][] = $tmp_array;
		}
		
		$medic_array[$medic_speciality->Id][$key] = $medic_docdoc_id;
		
		
	}
	
	
}




foreach($medic_coordinates_array as $key => $value) {
	
	$array['type'] = 'FeatureCollection';
	
	foreach($value as $medic_coordinate) {
		
		$wp_medic_id 	= $medic_coordinate[medic_wp_id];
		$wp_clinic_id 	= $id_clinic_array[$medic_coordinate[clinic_docdoc_id]];
		
		
		$medic_title 		= $medic_coordinate[medic_name];
		$clinic_title 		= $options_array[$wp_clinic_id][title];
		$url 				= $options_array[$wp_clinic_id][url];
		$medic_url 			= get_permalink($medic_coordinate[medic_wp_id]);
		$clinic_adress 		= $options_array[$wp_clinic_id][adress];
		$PhoneAppointment 	= $options_array[$wp_clinic_id][PhoneAppointment];
		
		$balloonContentHeader 	= '<h4>' . $medic_title . '</h4>';
		$balloonContentBody 	= '<p><b>Приём в</b> «'  . $clinic_title . '»</p><p><i>Адресс :</i>' . $clinic_adress . '</p> <p><i>Телефон :</i> ' . $PhoneAppointment . '<a href="' . $medic_url . '" target="_blank">Записаться</a></p>';
		
		$features['type'] = 'Feature';
		$features['id'] = $wp_clinic_id . '' . $wp_medic_id;
		
		$features['geometry']['type'] = 'Point';
		
		$coordinate = $medic_coordinate[medic_coordinate];
		$implode_coordinate = explode(",", $coordinate);
		
		$coord_x = $implode_coordinate[0];
		$coord_y = $implode_coordinate[1];
		
		
		$features['geometry']['coordinates'] = [(float)$coord_x,(float)$coord_y];
		
		$features['properties']['balloonContentHeader'] = $balloonContentHeader;
		$features['properties']['balloonContentBody'] = $balloonContentBody;
		$features['properties']['balloonContentFooter'] = '';
		$features['properties']['clusterCaption'] = $medic_title ;
		$features['properties']['hintContent'] = $medic_title ;

		$array['features'][] = $features;
	}
	
	$json_array = json_encode($array);
	$filename = 'medic-speciality-' . $key . '.json';
	file_put_contents(dirname(__FILE__) . '/json/medic-maps/' . $filename, $json_array, true);
		
	unset($array);
	
	
	
}














