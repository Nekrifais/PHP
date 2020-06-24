<?php

function create_review( $value = '' ) {
print_r($value);
    if( empty( $value ) )
        return;


$Id 				= $value->Id;
$Client 			= $value->Client;
$RatingQlf 			= $value->RatingQlf;
$RatingAtt 			= $value->RatingAtt;
$RatingRoom 		= $value->RatingRoom;
$Text 				= $value->Text;
$Date 				= $value->Date;
$DoctorId 			= $value->DoctorId;
$ClinicId 			= $value->ClinicId;
$Answer 			= $value->Answer;
$WaitingTime 		= $value->WaitingTime;
$RatingDoctor 		= $value->RatingDoctor;
$RatingClinic 		= $value->RatingClinic;
$TagClinicLocation 	= $value->TagClinicLocation;
$TagClinicService 	= $value->TagClinicService;
$TagClinicCost 		= $value->TagClinicCost;
$TagClinicRecommend = $value->TagClinicRecommend;
$TagDoctorAttention = $value->TagDoctorAttention;
$TagDoctorExplain 	= $value->TagDoctorExplain;
$TagDoctorQuality 	= $value->TagDoctorQuality;
$TagDoctorRecommend = $value->TagDoctorRecommend;



  $my_post = array(
     'post_title' => $value->Client,
     'post_status' => 'publish',
	 'post_content' => $Text,
	 'post_type' => 'reviews',

  );
	
	// Вставляем запись в базу данных
$post_id = wp_insert_post( $my_post );



update_post_meta( $post_id, 'Id', $Id );
update_post_meta( $post_id, 'Client', $Client );
update_post_meta( $post_id, 'RatingQlf', $RatingQlf );
update_post_meta( $post_id, 'RatingAtt', $RatingAtt );
update_post_meta( $post_id, 'RatingRoom', $RatingRoom );
update_post_meta( $post_id, 'Text', $Text );
update_post_meta( $post_id, 'Date', $Date );
update_post_meta( $post_id, 'DoctorId', $DoctorId );
update_post_meta( $post_id, 'ClinicId', $ClinicId );
update_post_meta( $post_id, 'Answer', $Answer );
update_post_meta( $post_id, 'WaitingTime', $WaitingTime );
update_post_meta( $post_id, 'RatingDoctor', $RatingDoctor );
update_post_meta( $post_id, 'RatingClinic', $RatingClinic );
update_post_meta( $post_id, 'TagClinicLocation', $TagClinicLocation );
update_post_meta( $post_id, 'TagClinicService', $TagClinicService );
update_post_meta( $post_id, 'TagClinicCost', $TagClinicCost );
update_post_meta( $post_id, 'TagClinicRecommend', $TagClinicRecommend );
update_post_meta( $post_id, 'TagDoctorAttention', $TagDoctorAttention );
update_post_meta( $post_id, 'TagDoctorExplain', $TagDoctorExplain );
update_post_meta( $post_id, 'TagDoctorQuality', $TagDoctorQuality );
update_post_meta( $post_id, 'TagDoctorRecommend', $TagDoctorRecommend );

}

