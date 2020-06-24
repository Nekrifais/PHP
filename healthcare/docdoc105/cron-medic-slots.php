<?php
header('Content-Type: text/html; charset=utf-8', true);
require_once(dirname(__FILE__) . '/../../../wp-load.php');
require_once(dirname(__FILE__) . '/login-password.php');
$count_slot              = 0;
$count_medic 			 = 0; 
$id_medic_docs      = get_meta_values_and_posts('Id', 'medic');
$clinics_medic_docs = get_meta_values_and_posts('Clinics', 'medic');
$clinics_medic_docs = array_flip($clinics_medic_docs);
foreach ($id_medic_docs as $key => $value) {
	$clinics = get_post_meta($value, "Clinics", true);
	if ($clinics != "") {
		$clinics = explode(",", $clinics);
		if (is_array($clinics)) {
			foreach ($clinics as $clinic) {
				$json = file_get_contents('https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/slot/list/doctor/' . $key . '/clinic/' . $clinic . '/from/' . date('Y-m-d') . '/to/' . date('Y-m-d', strtotime('+2 week')));
				usleep(400000);
				$obj  = json_decode($json);
				update_post_meta($value, 'slot_clinic_' . $clinic, $obj);
				$count_slot++;
			}
		} else {
			$json = file_get_contents('https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/slot/list/doctor/' . $key . '/clinic/' . $clinics . '/from/' . date('Y-m-d') . '/to/' . date('Y-m-d', strtotime('+2 week')));
			usleep(400000);
			$obj  = json_decode($json);
			update_post_meta($value, 'slot_clinic_' . $clinics, $obj);
			$count_slot++;
		}
	}
	$count_medic++;
}


echo 'Ok ' . $count_slot . ' ' . $count_medic;