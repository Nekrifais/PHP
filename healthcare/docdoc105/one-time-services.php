<?php 
header('Content-Type: text/html; charset=utf-8', true);
require_once(dirname(__FILE__).'/../../../wp-load.php');
require_once(dirname(__FILE__).'/login-password.php');




$gm = file_get_contents('uslugi.txt');

$gm = unserialize($gm);

$uslugi = get_terms( 'uslugi', array( 'hide_empty' => 0 ) );
global $array_parent;
foreach ($uslugi as $usluga) {
	
	$usluga_term_id = $usluga->term_id;
	$usluga_docdoc_id = get_field('Id', 'uslugi_' . $usluga_term_id);
	if($usluga_docdoc_id){
		$array_parent[$usluga_docdoc_id] = $usluga_term_id;
	} else {
		wp_delete_term( $usluga_term_id, 'uslugi' );  
	}
}
/* print_r($array_parent);  */






function trace($arr) {
	global $a;
	global $array_parent;
	
if($a > 120) {
	return;
}


/* echo "----- $a \n"; */

	$docdoc_name 	= (string)$arr['Name'];
	/* echo "$docdoc_name \n"; */
	
	$docdoc_id		= (int)$arr['Id'];
	/* echo "$docdoc_id \n"; */
	
	$docdoc_parent 	= (int)$arr['parent'];
	$wp_parent 	= (int) $array_parent[$arr['parent']];
	
/* 	echo "Докдок $docdoc_parent \n";
	echo "Вп $wp_parent \n";
	echo $array_parent[$docdoc_id]; */

if($docdoc_id != "" and $array_parent[$docdoc_id] == "") {
	
	
	if($wp_parent) {
		
		$args = array(
			'description' => '',
			'parent'      => $wp_parent,
			'slug'      => $docdoc_id,
		);
		/* print_r($args); */
		$term =	wp_insert_term(	$arr['Name'], 'uslugi', $args);
		$a++;
		
	} else {
		
		$args = array(
			'description' => '',
			'parent'      => 0,
			'slug'      => $docdoc_id,
		);
		/* print_r($args); */
		$term =	wp_insert_term(	$arr['Name'], 'uslugi', $args);
		$a++;	
		
	}
/* 	print_r($term);
	print_r($array_parent); */
	$term_id = $term[term_id];
	update_field('Id', $docdoc_id, 'uslugi_' . $term_id );
	$array_parent[$docdoc_id] = $term_id;
	
}
  foreach ($arr as $el) {
    if (is_array($el)){
		trace($el);
	} 

  } 
}

trace($gm);



echo "Ok";