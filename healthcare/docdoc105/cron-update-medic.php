<?php 

header('Content-Type: text/html; charset=utf-8', true);
require_once(dirname(__FILE__) . '/../../../wp-load.php');
require_once(dirname(__FILE__) . '/login-password.php');
$id_medic_docs = get_meta_values_and_posts('Id', 'medic');

$a=0;
foreach ($id_medic_docs as $key => $value) {
	$json     = file_get_contents('https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.5/json/doctor/' . $key);
	usleep(400000);
	$obj      = json_decode($json);

	
	$isActive_boolen = $obj->Doctor[0]->isActive;
	
	echo $isActive_boolen . " boolen \n";
if($isActive_boolen == 1){
	$isActive = 1;
} else {
	$isActive = 0;
}
echo $isActive . " isActive \n";
echo get_the_permalink($value) . " \n \n";

update_post_meta( $value, 'isActive', $isActive );

unset($isActive);
	
$a++;
}