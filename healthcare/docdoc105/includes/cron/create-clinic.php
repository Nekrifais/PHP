<?php
function create_clinic( $value = '', $array_diagnostic_terms  = '', $array_specialities_terms  = '', $metro_terms_array  = '', $district_terms_array = '', $array_uslugi_terms = "", $weak_hosting = 3) {


    if( empty( $value ) )
		return;
	
	
$Id 				= $value->Id;
$Name 				= $value->Name;
$ShortName 			= $value->ShortName;
$RewriteName 		= $value->RewriteName;
$URL 				= $value->URL;
$Longitude 			= $value->Longitude;
$Latitude 			= $value->Latitude;
$City 				= $value->City;
$Street 			= $value->Street;
$StreetId 			= $value->StreetId;
$House 				= $value->House;
$Description 		= $value->Description;
$ShortDescription 	= $value->ShortDescription;
$IsDiagnostic 		= $value->IsDiagnostic;
$isClinic 			= $value->isClinic;
$IsDoctor 			= $value->IsDoctor;
$Phone 				= $value->Phone;
$PhoneAppointment 	= $value->PhoneAppointment;
$logoPath 			= $value->logoPath;
$ScheduleState 		= $value->ScheduleState;
$DistrictId 		= $value->DistrictId;
$Email 				= $value->Email;
$ReplacementPhone 	= $value->ReplacementPhone;
$MinPrice 			= $value->MinPrice;
$MaxPrice 			= $value->MaxPrice;
$Logo				= $value->Logo;

if (isset($clinic_ids_array[$value->Id])) {
   
}
$args = array("post_type" => "clinic", "meta_key" => "Id", "meta_value" =>$Id);
$posts = get_posts($args);
if (empty($posts)){ 
    //add new post

	// Создаём объект записи
	
  $my_post = array(
     'post_title' => $value->Name,
     'post_status' => 'publish',
	 'post_content' => $Description,
	 'post_excerpt' => $ShortDescription,
	 'post_type' => 'clinic',

	 
  );
 
	$article_categories = array();
/* 	$article_categories[] = $data['cat']; */
	
	// Вставляем запись в базу данных
$post_id = wp_insert_post( $my_post );

} else {
	return false;
}

/* wp_set_post_terms( $the_post_id, $article_categories, 'qa-category' ); */




update_post_meta( $post_id, 'Id', $Id );
update_post_meta( $post_id, 'Name', $Name );
update_post_meta( $post_id, 'ShortName', $ShortName );
update_post_meta( $post_id, 'RewriteName', $RewriteName );
update_post_meta( $post_id, 'URL', $URL );
update_post_meta( $post_id, 'Longitude', $Longitude );
update_post_meta( $post_id, 'Latitude', $Latitude );
update_post_meta( $post_id, 'City', $City );
update_post_meta( $post_id, 'Street', $Street );
update_post_meta( $post_id, 'StreetId', $StreetId );
update_post_meta( $post_id, 'House', $House );
update_post_meta( $post_id, 'Description', $Description );
update_post_meta( $post_id, 'ShortDescription', $ShortDescription );
update_post_meta( $post_id, 'IsDiagnostic', $IsDiagnostic );
update_post_meta( $post_id, 'isClinic', $isClinic );
update_post_meta( $post_id, 'IsDoctor', $IsDoctor );
update_post_meta( $post_id, 'Phone', $Phone );
update_post_meta( $post_id, 'PhoneAppointment', $PhoneAppointment );
update_post_meta( $post_id, 'logoPath', $logoPath );
update_post_meta( $post_id, 'ScheduleState', $ScheduleState );
update_post_meta( $post_id, 'DistrictId', $DistrictId );
update_post_meta( $post_id, 'Email', $Email );
update_post_meta( $post_id, 'ReplacementPhone', $ReplacementPhone );
update_post_meta( $post_id, 'MinPrice', $MinPrice );
update_post_meta( $post_id, 'MaxPrice', $MaxPrice );
update_post_meta( $post_id, 'Logo', $Logo );


	
	
update_post_meta( $post_id, 'array', $value );
	
	
	
	
	
	
	
	
 
$Logo = strtok($Logo, '?');
$image_url  = $Logo;  // Define the image URL here
$upload_dir = wp_upload_dir(); // Set upload folder
$image_data = file_get_contents($image_url); // Get image data
usleep(400000);
$filename   = basename($image_url); // Create image file name

// Check folder permission and define file location
if( wp_mkdir_p( $upload_dir['path'] ) ) {
    $file = $upload_dir['path'] . '/' . $filename;
} else {
    $file = $upload_dir['basedir'] . '/' . $filename;
}

// Create the image  file on the server
file_put_contents( $file, $image_data );

// Check image file type
$wp_filetype = wp_check_filetype( $filename, null );

// Set attachment data
$attachment = array(
    'post_mime_type' => $wp_filetype['type'],
    'post_title'     => sanitize_file_name( $filename ),
    'post_content'   => '',
    'post_status'    => 'inherit'
);

// Create the attachment
$attach_id = wp_insert_attachment( $attachment, $file, $post_id );

// Include image.php
require_once(ABSPATH . 'wp-admin/includes/image.php');

// Define attachment metadata
$attach_data = wp_generate_attachment_metadata( $attach_id, $file );

// Assign metadata to attachment
wp_update_attachment_metadata( $attach_id, $attach_data );

// And finally assign featured image to post
set_post_thumbnail( $post_id, $attach_id );
	

	
	
	
	
$array_diagnostics = array();

	$Diagnostics = $value->Diagnostics;
	foreach( (array) $Diagnostics as $Diagnostic) {
		$array_diagnostics[] = $array_diagnostic_terms[$Diagnostic->Id];
	}
	
	
	
	$term_taxonomy_ids = wp_set_object_terms( $post_id, $array_diagnostics, 'diagnostic' );
	usleep(800000);
		
	
	
$array_uslugi = array();

	$Uslugi = $value->Services->ServiceList;
	foreach( (array) $Uslugi as $Usluga) {
		$array_uslugi[] = $array_uslugi_terms[$Usluga->ServiceId];
	}
	
	
	$term_uslugi_ids = wp_set_object_terms( $post_id, $array_uslugi, 'uslugi' );
	
	usleep(800000);
	
	

$array_specialities = array();

	$Specialities = $value->Specialities;
	
	foreach($Specialities as $Speciality) {
		$array_specialities[] = $array_specialities_terms[$Speciality->Id];
	}

	$term_specialities_ids = wp_set_object_terms( $post_id, $array_specialities, 'clinic-speciality' );
	
	if($weak_hosting == 2) {
		usleep(400000);
	}
	
	
	
	$Stations = $value->Stations;


	
	$term_taxonomy_ids = array();
	
	foreach($Stations as $Station) {
		$array_stations_id[] = $metro_terms_array[$Station->Id];
	
	}
	
	$term_taxonomy_ids = wp_set_object_terms( $post_id, $array_stations_id, 'metro' );
	unset($array_stations_id);
	
	if($weak_hosting == 2) {
		usleep(400000);
	}
	
	$City 				= $value->City;
	$term_taxonomy_ids = wp_set_object_terms( $post_id, $City, 'city' );
	
	if($weak_hosting == 2) {
		usleep(400000);
	}
	
	$District = $value->DistrictId;
    $wp_District = $district_terms_array[$District];
	
update_post_meta( $post_id, '_district', $wp_District );

	$term_taxonomy_ids = wp_set_object_terms( $post_id, $wp_District, 'district' );
	
	if($weak_hosting == 2) {
		usleep(400000);
	}
	
echo "Клиника добавлена - " . $Name;
echo '<br>';

	
	
	

}