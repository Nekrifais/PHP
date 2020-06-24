<?php
	
$diagnostic_title_single = get_field('title_шаблон_для_диагностики', 'option', false);
$clinic_diagnostic_district_template = get_field('title_шаблон_комбинации_диагностика_район', 'option', false);
$clinic_diagnostic_metro_template = get_field('title_шаблон_комбинации_диагностика_метро', 'option', false);


$diagnostic_single_description = get_field('description_шаблон_для_диагностики', 'option', false);
$clinic_diagnostic_district_template_description = get_field('description_шаблон_комбинации_диагностика_район', 'option', false);
$clinic_diagnostic_metro_template_description = get_field('description_шаблон_комбинации_диагностика_метро', 'option', false);


$diagnostic_template_textdescription = get_field('описание_шаблон_для_диагностики', 'option', false);
$diagnostic_district_template_textdescription = get_field('описание_шаблон_комбинации_диагностик_район', 'option', false);
$diagnostic_metro_template_textdescription = get_field('описание_шаблон_комбинации_диагностик_метро', 'option', false);



$diagnostic_template_h1 = get_field('заголовок_шаблон_для_диагностики', 'option', false);
$diagnostic_district_template_h1 = get_field('заголовок_шаблон_комбинации_диагностик_район', 'option', false);
$diagnostic_metro_template_h1 = get_field('заголовок_шаблон_комбинации_диагностик_метро', 'option', false);


unset($custom_metro_template);
unset($custom_district_template);

foreach($custom_template_array as $key => $value) {
	
	if($value == 4 ) {
		
		$template_text_area			= get_field("template", $key, false);
		$template_type 				= get_field("template_type", $key, true);
		$template_type_extended 	= $type_array[$template_type];
		
		$template_metro 			= get_field("template_metro", $key, true);
		$template_district 			= get_field("template_district", $key, true);
		
		/* print_r($template_district); */
		/* print_r($template_metro); */
		
		
		
		if($template_metro != "") {
			foreach($template_metro as $metro_id) {
				$custom_metro_template[$metro_id][$template_type_extended] 			= $template_text_area;
			}
		}
		
		if($template_district != "") {
			foreach($template_district as $district_id) {
				$custom_district_template[$district_id][$template_type_extended] 	= $template_text_area;
			}
		}
		
	}
	
}













/* $clinic_speciality_district_template $clinic_speciality_metro_template  */

foreach($all_diagnostic_terms as $clinic_diagnostic_term){
	
	
	$current_diagnostic_term_id = $clinic_diagnostic_term->term_id;
	$current_clinic_diagnostic_term_name = $clinic_diagnostic_term->name;
	
unset($data_district);
unset($data_metro);

$rows = get_field('пользовательские_переменные', 'diagnostic_' . $current_diagnostic_term_id);

$data_district[diagnostic_title] 	= $current_clinic_diagnostic_term_name;

		if($rows) { 
		
			foreach($rows as $row) { 
				$key = $row['ключ']; 
				$value = $row['переменная']; 
				$data_district[$key] = $value;
			} 
		} 
		
$data_metro[diagnostic_title] 		= $current_clinic_diagnostic_term_name;


		if($rows) { 
		
			foreach($rows as $row) { 
				$key = $row['ключ']; 
				$value = $row['переменная']; 
				$data_metro[$key] = $value;
			} 
		} 


	$field_textdescription_single_category = 'single_textdescription_for_diagnostic-' . $current_diagnostic_term_id;
	$field_single_diagnostic = 'single_title_for_diagnostic-' . $current_diagnostic_term_id;
	$field_single_description_diagnostic = 'single_description_for_diagnostic-' . $current_diagnostic_term_id;
	$field_single_h1_diagnostic = 'single_h1_for_diagnostic-' . $current_diagnostic_term_id;
			
	
		if(isset($custom_metro_template[$current_metro_term_id]['title'])){
			$diagnostic_title_single = $custom_metro_template[$current_metro_term_id]['title'];
		}
		
	if(isset($custom_metro_template[$current_metro_term_id]['description'])){
$diagnostic_single_description = $custom_metro_template[$current_metro_term_id]['description'];
	}
		
	if(isset($custom_metro_template[$current_metro_term_id]['описание'])){
		$diagnostic_template_textdescription = $custom_metro_template[$current_metro_term_id]['описание'];
	}
		
		if(isset($custom_metro_template[$current_metro_term_id]['заголовок'])){
			$diagnostic_template_h1 = $custom_metro_template[$current_metro_term_id]['заголовок'];
		}
	
	
	
		if($diagnostic_template_textdescription) {
			
			$dust->compile($diagnostic_template_textdescription, 'myTemplate_diagnostic_single_textdescription');
			//render the template for that name
			$output = $dust->render('myTemplate_diagnostic_single_textdescription', $data_district);
			$output = html_entity_decode($output);
			update_option( $field_textdescription_single_category, $output, false );		
		} else { 
			delete_option( $field_textdescription_single_category );
		}
		
		
		if($diagnostic_title_single) {
			$dust->compile($diagnostic_title_single, 'myTemplate_diagnostic_single');
			$output = $dust->render('myTemplate_diagnostic_single', $data_district);
			update_option( $field_single_diagnostic, $output, false ); 
		} else { 
			delete_option( $field_single_diagnostic );
		}
		
		if($diagnostic_single_description) {
			$dust->compile($diagnostic_single_description, 'myTemplate_diagnostic_single_description');
			$output = $dust->render('myTemplate_diagnostic_single_description', $data_district);
			update_option( $field_single_description_diagnostic, $output, false ); 
		} else { 
			delete_option( $field_single_description_diagnostic );
		}
		
		if($diagnostic_template_h1) {
			$dust->compile($diagnostic_template_h1, 'myTemplate_diagnostic_single_h1');
			$output = $dust->render('myTemplate_diagnostic_single_h1', $data_district);
			update_option( $field_single_h1_diagnostic, $output, false ); 
		} else { 
			delete_option( $field_single_h1_diagnostic );
		}
		
		
		
		
		$array_metro_output = array();
		$array_district_output = array();
	
	
	foreach($all_district_terms as $district_term){
		
		$current_district_term_id = $district_term->term_id;
		$name	 				= get_field('name', 'district_' . $current_district_term_id);
		$data_district[district_name] 	= $name;
		
		$field = 'title_for_diagnostic-' . $current_diagnostic_term_id . '_x_district-'  . $current_district_term_id;
		$field_description = 'description_for_diagnostic-' . $current_diagnostic_term_id . '_x_district-'  . $current_district_term_id;
		$field_textdescription = 'textdescription_for_diagnostic-' . $current_diagnostic_term_id . '_x_district-'  . $current_district_term_id;
		
		
		$rows = get_field('пользовательские_переменные', 'district_' . $current_district_term_id); 
		
		if($rows) { 
		
			foreach($rows as $row) { 
				$key = $row['ключ']; 
				$value = $row['переменная']; 
				$data_district[$key] = $value;
			} 
		} 
		


		
		unset($current_template);
		if($clinic_diagnostic_district_template) {
			if(isset($custom_district_template[$current_district_term_id]['title'])){
				$current_template = $custom_district_template[$current_district_term_id]['title'];
				$dust->compile($current_template, 'myTemplate_diagnostic_district');
			} else {
				$dust->compile($clinic_diagnostic_district_template, 'myTemplate_diagnostic_district');
			}
			
			$output = $dust->render('myTemplate_diagnostic_district', $data_district);
			$array_district_output[$current_district_term_id][title] = $output;
			
		} 
		
		unset($current_template);
		if($clinic_diagnostic_district_template_description) {
			if(isset($custom_district_template[$current_district_term_id]['description'])){
				$current_template = $custom_district_template[$current_district_term_id]['description'];
				$dust->compile($current_template, 'myTemplate_diagnostic_district_description');
			} else { 
				$dust->compile($clinic_diagnostic_district_template_description, 'myTemplate_diagnostic_district_description');
			}
			
			$output = $dust->render('myTemplate_diagnostic_district_description', $data_district);
			$array_district_output[$current_district_term_id][description] = $output;
			
		} 
		
		unset($current_template);
		if($diagnostic_district_template_textdescription) {
			if(isset($custom_district_template[$current_district_term_id]['описание'])){
				$current_template = $custom_district_template[$current_district_term_id]['описание'];
				$dust->compile($current_template, 'myTemplate_diagnostic_district_textdescription');
			} else {
				$dust->compile($diagnostic_district_template_textdescription, 'myTemplate_diagnostic_district_textdescription');
			}
			
			$output = $dust->render('myTemplate_diagnostic_district_textdescription', $data_district);
			$output = html_entity_decode($output);
			$array_district_output[$current_district_term_id][textdescription] = $output; 
			
		} 
		
		unset($current_template);
		if($diagnostic_district_template_h1) {
			if(isset($custom_district_template[$current_district_term_id]['заголовок'])){
				$current_template = $custom_district_template[$current_district_term_id]['заголовок'];
				$dust->compile($current_template, 'myTemplate_diagnostic_district_h1');
			} else {
				$dust->compile($diagnostic_district_template_h1, 'myTemplate_diagnostic_district_h1');
			}
			
			$output = $dust->render('myTemplate_diagnostic_district_h1', $data_district);
			$array_district_output[$current_district_term_id][h1] = $output; 
			
		}
		
		
		if($rows) { 
			
			foreach($rows as $row) { 
				$key = $row['ключ']; 
				$value = $row['переменная']; 
				unset($data_district[$key]);
			}
			
		}
		
        unset($rows);
	
	}
	
	$district_serialize = serialize($array_district_output);
	unset($array_district_output);
	$filename = 'diagnostic-' . $current_diagnostic_term_id . '-district.txt';
	file_put_contents($path . '/json/seo/' . $filename, $district_serialize, true);
	
	
	
	
	foreach($all_metro_terms as $metro_term) {
		
		
		
		$current_metro_term_id = $metro_term->term_id;
		

		$Id_metro	 			= get_field('Id_metro', 'metro_' . $current_metro_term_id);
		$Name_metro 			= get_field('Name_metro', 'metro_' . $current_metro_term_id);
		$LineName_metro 		= get_field('LineName_metro', 'metro_' . $current_metro_term_id);
		$LineColor_metro		= get_field('LineColor_metro', 'metro_' . $current_metro_term_id);
		$CityId_metro			= get_field('CityId_metro', 'metro_' . $current_metro_term_id);
		$Alias_metro			= get_field('Alias_metro', 'metro_' . $current_metro_term_id);
		$DistrictIds_metro		= get_field('DistrictIds_metro', 'metro_' . $current_metro_term_id);

		
		
		$data_metro[Id_metro] 				= $Id_metro;
		$data_metro[Name_metro] 			= $Name_metro;
		$data_metro[LineName_metro] 		= $LineName_metro;
		$data_metro[LineColor_metro] 		= $LineColor_metro;
		$data_metro[CityId_metro] 			= $CityId_metro;
		$data_metro[Alias_metro] 			= $Alias_metro;
		$data_metro[DistrictIds_metro] 		= $DistrictIds_metro;
		
		$field = 'title_for_diagnostic-' . $current_diagnostic_term_id . '_x_metro-'  . $current_metro_term_id;
		$field_description = 'description_for_diagnostic-' . $current_diagnostic_term_id . '_x_metro-'  . $current_metro_term_id;
		$field_textdescription = 'textdescription_for_diagnostic-' . $current_diagnostic_term_id . '_x_metro-'  . $current_metro_term_id;
		
		
		$rows = get_field('пользовательские_переменные', 'metro_' . $current_metro_term_id); 

		if($rows) { 
		
			foreach($rows as $row) { 
				$key = $row['ключ']; 
				$value = $row['переменная']; 
				$data_metro[$key] = $value;
			} 
		} 
		

		
		unset($current_template);
		if($clinic_diagnostic_metro_template) {
			if(isset($custom_metro_template[$current_metro_term_id]['title'])){
				$current_template = $custom_metro_template[$current_metro_term_id]['title'];
				$dust->compile($current_template, 'myTemplate_diagnostic_metro');
			} else {
				$dust->compile($clinic_diagnostic_metro_template, 'myTemplate_diagnostic_metro');
			}

			$output = $dust->render('myTemplate_diagnostic_metro', $data_metro);
			$array_metro_output[$current_metro_term_id][title] = $output;
			
		} 
		
		unset($current_template);
		if($clinic_diagnostic_metro_template_description) {
			if(isset($custom_metro_template[$current_metro_term_id]['description'])){
				$current_template = $custom_metro_template[$current_metro_term_id]['description'];
				$dust->compile($current_template, 'myTemplate_diagnostic_metro_diagnostic');
			} else { 
				$dust->compile($clinic_diagnostic_metro_template_description, 'myTemplate_diagnostic_metro_diagnostic');
			}
			
			$output = $dust->render('myTemplate_diagnostic_metro_diagnostic', $data_metro);
			$array_metro_output[$current_metro_term_id][description] = $output;
			
		} 
		
		unset($current_template);
		if($diagnostic_metro_template_textdescription) {
			if(isset($custom_metro_template[$current_metro_term_id]['описание'])){
				$current_template = $custom_metro_template[$current_metro_term_id]['описание'];
				$dust->compile($current_template, 'myTemplate_diagnostic_textdescription');
			} else {
				$dust->compile($diagnostic_metro_template_textdescription, 'myTemplate_diagnostic_textdescription');
			}
			
			$output = $dust->render('myTemplate_diagnostic_textdescription', $data_metro);
			$array_metro_output[$current_metro_term_id][textdescription] = $output;
			
		} 
		
		unset($current_template);
		if($diagnostic_metro_template_h1) {
			if(isset($custom_metro_template[$current_metro_term_id]['заголовок'])){
				$current_template = $custom_metro_template[$current_metro_term_id]['заголовок'];
				$dust->compile($current_template, 'myTemplate_diagnostic_metro_h1');
			} else {
				$dust->compile($diagnostic_metro_template_h1, 'myTemplate_diagnostic_metro_h1');
			}
			
			$output = $dust->render('myTemplate_diagnostic_metro_h1', $data_metro);
			$array_metro_output[$current_metro_term_id][h1] = $output; 
			
		} 
		
		
		
		if($rows) { 
		
			foreach($rows as $row) { 
				$key = $row['ключ']; 
				$value = $row['переменная']; 
				unset($data_metro[$key]);
			} 
		}
		
        unset($rows);
		
		
		
		
	}
	
	$metro_serialize = serialize($array_metro_output);
	unset($array_metro_output);
	$filename = 'diagnostic-' . $current_diagnostic_term_id . '-metro.txt';
	file_put_contents($path . '/json/seo/' . $filename, $metro_serialize, true);
	

}

echo "Ok отработаны диагностики для клииник. \n";
