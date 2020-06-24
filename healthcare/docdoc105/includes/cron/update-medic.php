<?php 
function update_medic( $value = '', $array_Specialities_terms  = '', $wp_id  = '', $wp_city_id = '', $clinic_ids_array = '', $district_ids_array = '' ) {
	
	/* print_r($value); */
	    if( empty( $value ) )
        return;
	
		$wp_array = get_post_meta($wp_id, "array", true);
		
		
		
		$docdoc_array = $value;
		$Name = $value->Name;
		
		if($wp_array == $docdoc_array){
			echo '<br>';
			echo 'Медик - ' . $Name . ' обновлений не найденно <span style="color:#999999">пропускаем</span>';
			echo '<br>';
		} else {
			
			
	$Clinics_all = $value->Clinics;
	$Clinics_part = implode(",", $Clinics_all);
	
$SpecialPrice 		= $value->SpecialPrice;
$Rating 			= $value->Rating;
$ExperienceYear 	= $value->ExperienceYear;
$Price 				= $value->Price;
$Clinics 			= $Clinics_part;
$isActive 			= $value->isActive;
$OpinionCount 		= $value->OpinionCount;
$InternalRating 	= $value->InternalRating;


update_post_meta( $wp_id, 'SpecialPrice', $SpecialPrice );
update_post_meta( $wp_id, 'Rating', $Rating );
update_post_meta( $wp_id, 'ExperienceYear', $ExperienceYear );
update_post_meta( $wp_id, 'Price', $Price );
update_post_meta( $wp_id, 'Clinics', $Clinics );
update_post_meta( $wp_id, 'isActive', $isActive );
update_post_meta( $wp_id, 'OpinionCount', $OpinionCount );
update_post_meta( $wp_id, 'InternalRating', $InternalRating );


delete_post_meta($wp_id, 'wp_clinics_ids');
foreach($Clinics_all as $clinic) {


$wp_clinic[]			= $clinic_ids_array[$clinic];



}
add_post_meta( $wp_id, 'wp_clinics_ids', $wp_clinic );

update_post_meta( $wp_id, 'array', $value );	


update_post_meta( $wp_id, 'array', $value );
			
			  $array_Specialities = array();

	$Specialities = $value->Specialities;
	foreach($Specialities as $Speciality) {

$array_Specialities[] = $array_Specialities_terms[$Speciality->Id];
	
	  }
	$term_taxonomy_ids = wp_set_object_terms( $wp_id, $array_Specialities, 'speciality' );
	$term_taxonomy_ids = wp_set_object_terms( $wp_id, $wp_city_id, 'city' );	
		echo '<br>';	
		echo 'Медика - ' . $Name . 'обновления найденны, <span style="color:#00cc44">обновляем</span>';
		echo '<br>';
	}

}
	