<?php
header('Content-Type: text/html; charset=utf-8', true);
require_once(dirname(__FILE__).'/../../../wp-load.php');
require_once(dirname(__FILE__).'/includes/cron/create-clinic.php');
require_once(dirname(__FILE__).'/login-password.php');


$clinic_ids_array = get_meta_values('id', 'clinic');
$clinic_post_ids_array = get_meta_values_posts('id', 'clinic');

$clinic_ids_array_flip = array_flip($clinic_ids_array);

for($i = 0;
$i < count($clinic_ids_array);
++$i)
{
    $clinic_ids_and_post_ids_array[$clinic_ids_array[$i]] = $clinic_post_ids_array[$i];
}

$imgready_array = get_meta_values_posts('imgready', 'clinic');
$imgready_array = array_flip($imgready_array);

foreach($clinic_ids_array as $value_id) {

$post_id = $clinic_ids_and_post_ids_array[$value_id];
if (isset($imgready_array[$post_id])) {
  
} else {



$json = file_get_contents('https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/clinic/gallery/' .  $value_id . '/');
usleep(400000);

$obj = json_decode($json);




$imagelist = $obj->ImageList;

echo $post_id;
foreach ($imagelist as $value){


// Add Featured Image to Post
$image_url  = $value->url; // Define the image URL here
$upload_dir = wp_upload_dir(); // Set upload folder
$image_data = file_get_contents($image_url); // Get image data
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


update_post_meta( $post_id, 'imgready', "1" );


}
}
}
?> 
<!DOCTYPE html>
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	  
	  </head>
	  <body>
	
<?php 






