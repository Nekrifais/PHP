<?php
header('Content-Type: text/html; charset=utf-8', true);
require_once(dirname(__FILE__).'/../../../wp-load.php');
require_once(dirname(__FILE__).'/login-password.php');

$json = file_get_contents('https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/diagnostic/');

$obj = json_decode($json);



$diagnostic_terms = get_terms( 'diagnostic', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0 ) );;

	$diagnostic_terms = get_terms( array( 
		'taxonomy' => 'diagnostic',
		'order'   => 'ASC',
		'orderby'   => 'name',
		'hide_empty' => 0
	) );
	foreach($diagnostic_terms as $diagnostic_term ) {
		$termsarray[$diagnostic_term->slug] = $diagnostic_term->term_id;
	}
	
	
foreach($obj->DiagnosticList as $value){

	if(!isset($termsarray[$value->Alias])){	
	
		$term = wp_insert_term(
			$value->Name, // the term 
			'diagnostic', // the taxonomy
				array(
					'description'=> '',
					'slug' => $value->Alias
				)
		);
		
		
		
		if ( is_wp_error( $term ) ) {
		
		} else {
			$term_id = $term[term_id];
			update_field('Id', $value->Id, 'diagnostic_' . $term_id ); 
		}
		 


		$sub = $value->SubDiagnosticList;
			if($sub != "") {
			
			foreach ($sub as $SubDiagnostic) {
		$array = array(91, 19, 21, 34, 1, 88);
		if (in_array($value->Id, $array)) {
			$title = $value->Name . ' ' . $SubDiagnostic->Name;
		} else {
			$title = $SubDiagnostic->Name;		
		}
				$term = wp_insert_term(
					$title, // the term 
					'diagnostic', // the taxonomy
					array(
						'description'=> '',
						'slug' => $SubDiagnostic->Alias,
						'parent'=> $term_id
					 )
				); 

				$term_sub_id = $term[term_id];

				update_field('Id', $SubDiagnostic->Id, 'diagnostic_' . $term_sub_id );
			
			} 
				
			
		}
	}

}