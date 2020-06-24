<?php
header('Content-Type: text/html; charset=utf-8', true);
require_once(dirname(__FILE__) . '/../../../wp-load.php');
require_once(dirname(__FILE__) . '/login-password.php');
$count=0;
$id_medic_docs = get_meta_values_and_posts('id', 'medic');
$a = 0;
foreach ($id_medic_docs as $key => $value) {
	$json = file_get_contents('https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/review/doctor/' . $key);
	usleep(400000);
	$obj  = json_decode($json);
	echo count($obj->ReviewList);
	echo "\n";
	echo $value;
	echo "<br>";
	if (json_last_error() === JSON_ERROR_NONE) {
	} else {
	}
	update_post_meta($value, 'reviews_array', $obj);
	$a++;
	$count++;
}


echo 'Ok' . $count;
$reviews_count = $count * 6;
update_option( 'reviews_count', $reviews_count );

