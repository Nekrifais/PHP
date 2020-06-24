<?php

function create_medic( $value = '', $array_Specialities_terms  = '', $wp_city_id = '', $clinic_ids_array = '', $district_ids_array = '', $weak_hosting = 3, $publish = '') {
	
    if( empty( $value ) )
        return;

	$Clinics_all = $value->Clinics;
	
	$Clinics_part = implode(",", $Clinics_all);


	
$Id 				= $value->Id;
$Name				= $value->Name;
$SpecialPrice 		= $value->SpecialPrice;
$Rating 			= $value->Rating;
$ExperienceYear 	= $value->ExperienceYear;
$Price 				= $value->Price;
$Clinics 			= $Clinics_part;
$isActive 			= $value->isActive;
$OpinionCount 		= $value->OpinionCount;
$InternalRating 	= $value->InternalRating;
$Description 		= $value->Description;
$TextAbout 			= $value->TextAbout;
$KidsReception 		= $value->KidsReception;
$Departure 			= $value->Departure;
$Img 				= 'https://cdn.docdoc.ru/doctor/' . $Id . '.162x162.jpg';

$isActive = (int)$isActive;

$args = array("post_type" => "medic", "meta_key" => "Id", "meta_value" =>$Id);
$posts = get_posts($args);
if (empty($posts)){ 

  $my_post = array(
     'post_title' => $value->Name,
     'post_status' => 'publish',
	 'post_content' => $Description,
	 'post_excerpt' => $TextAbout,
	 'post_type' => 'medic',

	 
  );
 
 	if($publish == 3) {
		$my_post['post_status'] = 'pending';
	}
 
/* 	$article_categories = array(); */
/* 	$article_categories[] = $data['cat']; */
	
	// Вставляем запись в базу данных
$post_id = wp_insert_post( $my_post );

} else {
	return false;
	
}

update_post_meta( $post_id, 'SpecialPrice', $SpecialPrice );
update_post_meta( $post_id, 'Rating', $Rating );
update_post_meta( $post_id, 'ExperienceYear', $ExperienceYear );
update_post_meta( $post_id, 'Price', $Price );
update_post_meta( $post_id, 'Clinics', $Clinics );
update_post_meta( $post_id, 'isActive', $isActive );
update_post_meta( $post_id, 'OpinionCount', $OpinionCount );
update_post_meta( $post_id, 'InternalRating', $InternalRating );
update_post_meta( $post_id, 'Id', $Id );



delete_post_meta($post_id, 'wp_clinics_ids');
foreach($Clinics_all as $clinic) {

$wp_clininc_id = $clinic_ids_array[$clinic];
$wp_clinic[] =  $wp_clininc_id;

$wp_district_clinic[] =  (int)$district_ids_array[$wp_clininc_id];



}

add_post_meta( $post_id, 'wp_clinics_ids', $wp_clinic );

update_post_meta( $post_id, 'array', $value );	

$term_taxonomy_ids = wp_set_object_terms( $post_id, $wp_district_clinic, 'district' );

	if($weak_hosting == 2) {
		usleep(400000);
	}


// Add Featured Image to Post
$image_url  = $Img; // Define the image URL here
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
	



  $array_Specialities = array();

	$Specialities = $value->Specialities;
	foreach($Specialities as $Speciality) {

$array_Specialities[] = $array_Specialities_terms[$Speciality->Id];
	
	  }
	$term_taxonomy_ids = wp_set_object_terms( $post_id, $array_Specialities, 'speciality' );
	
	if($weak_hosting == 2) {
		usleep(400000);
	}
	
	
	if($weak_hosting == 2) {
		usleep(400000);
	}
	
	
	if($weak_hosting == 2) {
		usleep(400000);
	}
	
	$term_taxonomy_ids = wp_set_object_terms( $post_id, $wp_city_id, 'city' );	
	
	if($weak_hosting == 2) {
		usleep(400000);
	}
	
	if($KidsReception == 1 and $Departure == 1) {
		$term_taxonomy_ids = wp_set_object_terms( $post_id, array( 'child', 'nadom' ), 'dop' );	
	} elseif($KidsReception == 1) {
		$term_taxonomy_ids = wp_set_object_terms( $post_id, 'child', 'dop' );	
	} elseif($Departure == 1) {
		$term_taxonomy_ids = wp_set_object_terms( $post_id, 'nadom', 'dop' );	
	}
	
	
echo '<br>';	
echo 'Медик <span style="color:green;">добавлен</span> - ' . $Name;
echo '<br>';

}







