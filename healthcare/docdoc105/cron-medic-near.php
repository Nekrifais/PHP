<?php
header( 'Content-Type: text/html; charset=utf-8', true );
require_once( dirname( __FILE__ ) . '/../../../wp-load.php' );
$login                   = get_field( 'логин', 'option' );
$password                = get_field( 'пароль', 'option' );


$path                    = dirname( __FILE__ );


$id_medic_docs           = get_meta_values_and_posts( 'Id', 'medic' );
$all_speciality          = get_terms( 'speciality', array(
     'hide_empty' => 0 
) );
$all_speciality_option   = get_field( 'выгрузить_все_специальности', 'option' );
$chose_speciality_option = get_field( 'выбор_специальностей', 'option' );


foreach ( $all_speciality as $speciality ) {
    $speciality_docdoc_id = get_field( 'Id', 'speciality_' . $speciality->term_id );
    if ( in_array( $speciality_docdoc_id, $chose_speciality_option ) or $all_speciality_option == 1 ) {
        $id_speciality_array[ $speciality->term_id ] = $speciality_docdoc_id;
    }
}


$all_nearmetro = get_terms( 'metro', array(
     'orderby' => 'count',
    'hide_empty' => 0,
    'parent' => 0 
) );
foreach ( $all_nearmetro as $nearmetro ) {
    $id_nearmetro                         = get_field( 'Id', 'metro_' . $nearmetro->term_id );
    $all_near_metro_city[ $id_nearmetro ] = $nearmetro->term_id;
}


$all_neardistrict = get_terms( 'district', array(
     'orderby' => 'count',
    'hide_empty' => 0,
    'parent' => 0 
) );
foreach ( $all_neardistrict as $neardistrict ) {
    $id_neardistrict                            = get_field( 'Id_city', 'district_' . $neardistrict->term_id );
    $all_near_district_city[ $id_neardistrict ] = $neardistrict->term_id;
}


$all_city = get_field( 'выгрузить_все_города', 'option' );
if ( $all_city == 0 ) {
    $cityarray = get_field( 'выбор_города', 'option' );
} else {
    $cityjson = file_get_contents( 'https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/city/' );
	
    usleep( 450000 );
    $citylist = json_decode( $cityjson );
	
    foreach ( $citylist->CityList as $city ) {
        $cityarray[ ] = $city->Id;
    }
	
	
}



foreach ( $cityarray as $city_id ) {
    $city_nearmetro_id_array[ $city_id ]    = $all_near_metro_city[ $city_id ];
    $city_neardistrict_id_array[ $city_id ] = $all_near_district_city[ $city_id ];
}




foreach ( $city_neardistrict_id_array as $city_neardictrict_docdoc_id => $city_neardictrict_docdoc_wp ) {
    $district_terms = get_terms( array(
         'taxonomy' => 'district',
        'parent' => $city_neardictrict_docdoc_wp,
        'hide_empty' => 0 
    ) );
	
    if ( $city_neardictrict_docdoc_id == 1 ) {
        foreach ( $district_terms as $district_term ) {
            $msk_district_terms = get_terms( array(
                 'taxonomy' => 'district',
                'parent' => $district_term->term_id,
                'hide_empty' => 0 
            ) );
           
            foreach ( $msk_district_terms as $msk_district_term ) {
                $docdoc_district_id                              = get_field( 'id', 'district_' . $msk_district_term->term_id );
                $id_district_term[ $msk_district_term->term_id ] = $docdoc_district_id;
            }
        }
    } else {
        foreach ( $district_terms as $district_term ) {
            $docdoc_district_id                          = get_field( 'id', 'district_' . $district_term->term_id );
            $id_district_term[ $district_term->term_id ] = $docdoc_district_id;
        }
    }
	
	

  
}


foreach ( $id_speciality_array as $speciality_wp_id => $speciality_docdoc_id ) {
        foreach ( $id_district_term as $key => $value ) {
            $url      = 'https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/doctor/list/start/0/count/10/city/' . $city_neardictrict_docdoc_id . '/district/' . $value . '/speciality/' . $speciality_docdoc_id . '/near/extra/';
            $nearjson = file_get_contents( $url );
            usleep( 450000 );
            $nearlist = json_decode( $nearjson );
            foreach ( $nearlist->DoctorList as $medic ) {
                $id_medic_docs_wp                                         = $id_medic_docs[ $medic->Id ];
                $near_district_array_file[ $speciality_wp_id ][ $key ][ ] = $id_medic_docs_wp;
            }
            $get_district_by = get_term_by( 'id', $key, 'district' );
            echo "Конец - район - " . $get_district_by->name . "\n";
        }
        $get_speciality_by = get_term_by( 'id', $speciality_wp_id, 'speciality' );
        echo "Конец - специальность - " . $get_speciality_by->name . "\n";
    }

foreach ( $near_district_array_file as $key => $value ) {
    $serialize_value = serialize( $value );
    $filename        = $key . '.txt';
    file_put_contents( $path . '/json/near/district/' . $filename, $serialize_value, true );
}







foreach ( $city_nearmetro_id_array as $city_nearmetro_docdoc_id => $city_nearmetro_docdoc_wp ) {
    $metro_terms = get_terms( array(
         'taxonomy' => 'metro',
        'parent' => $city_nearmetro_docdoc_wp,
        'hide_empty' => 0 
    ) );
    foreach ( $metro_terms as $term ) {
        $docdoc_metro_id           = get_field( 'Id_metro', 'metro_' . $term->term_id );
        $id_term[ $term->term_id ] = $docdoc_metro_id;
    }

}

    foreach ( $id_speciality_array as $speciality_wp_id => $speciality_docdoc_id ) {
        foreach ( $id_term as $key => $value ) {
            $url      = 'https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/doctor/list/start/0/count/10/city/' . $city_nearmetro_docdoc_id . '/stations/' . $value . '/speciality/' . $speciality_docdoc_id . '/near/extra/';
            $nearjson = file_get_contents( $url );
            usleep( 450000 );
            $nearlist = json_decode( $nearjson );
            foreach ( $nearlist->DoctorList as $medic ) {
                /* echo $medic->Id . "\n"; */
                /* echo $id_medic_docs[$medic->Id] . "\n"; */
                $id_medic_docs_wp                                = $id_medic_docs[ $medic->Id ];
                $near_array_file[ $speciality_wp_id ][ $key ][ ] = $id_medic_docs_wp;
            }
            $get_metro_by = get_term_by( 'id', $key, 'metro' );
            echo "Конец - метро - " . $get_metro_by->name . "\n";
        }
    }

/* print_r($near_array_file); */
foreach ( $near_array_file as $key => $value ) {
    $serialize_value = serialize( $value );
    $filename        = $key . '.txt';
    file_put_contents( $path . '/json/near/metro/' . $filename, $serialize_value, true );
}
echo "Конец.";





