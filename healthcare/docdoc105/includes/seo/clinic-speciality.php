<?php

$clinic_speciality_title_single = get_field('title_шаблон_для_специализации_клиник', 'option', false);
$clinic_speciality_district_template = get_field('title_шаблон_комбинации_специализация_клиники_район', 'option', false);
$clinic_speciality_metro_template = get_field('title_шаблон_комбинации_специализация_клиники_метро', 'option', false);


$clinic_speciality_single_description = get_field('description_шаблон_для_специализации_клиник', 'option', false);
$clinic_speciality_district_template_description = get_field('description_шаблон_комбинации_специализация_клиники_район', 'option', false);

$clinic_speciality_metro_template_description = get_field('description_шаблон_комбинации_специализация_клиники_метро', 'option', false);


$clinic_speciality_template_textdescription = get_field('описание_шаблон_для_специализации_клиник', 'option', false);
$clinic_speciality_district_template_textdescription = get_field('описание_шаблон_комбинации_специализации_клиник_район', 'option', false);
$clinic_speciality_metro_template_textdescription = get_field('описание_шаблон_комбинации_специализации_клиник_метро', 'option', false);



$clinic_speciality_template_h1 = get_field('заголовок_шаблон_для_специализации_клиник', 'option', false);
$clinic_speciality_district_template_h1 = get_field('заголовок_шаблон_комбинации_специализации_клиник_район', 'option', false);
$clinic_speciality_metro_template_h1 = get_field('заголовок_шаблон_комбинации_специализации_клиник_метро', 'option', false);


$default_template_array = array();

$default_template_array['title'] 						= $clinic_speciality_title_single;
$default_template_array['title_district'] 				= $clinic_speciality_district_template;
$default_template_array['title_metro']					= $clinic_speciality_metro_template;
$default_template_array['description'] 					= $clinic_speciality_single_description;
$default_template_array['description_district'] 		= $clinic_speciality_district_template_description;
$default_template_array['description_metro'] 			= $clinic_speciality_metro_template_description;
$default_template_array['textdescription'] 				= $clinic_speciality_template_textdescription;
$default_template_array['textdescription_district'] 	= $clinic_speciality_district_template_textdescription;
$default_template_array['textdescription_metro'] 		= $clinic_speciality_metro_template_textdescription;
$default_template_array['h1'] 							= $clinic_speciality_template_h1;
$default_template_array['h1_district'] 					= $clinic_speciality_district_template_h1;
$default_template_array['h1_metro'] 					= $clinic_speciality_metro_template_h1;



unset($custom_metro_template);
unset($custom_district_template);

foreach($custom_template_array as $key => $value) {
	
	if($value == 3 ) {
		
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



print_r($custom_district_template);















foreach($all_clinic_speciality_terms as $clinic_speciality_term){
	
	$current_clinic_speciality_term_id = $clinic_speciality_term->term_id;
	
unset($data_district);
unset($data_metro);

$rows = get_field('пользовательские_переменные', 'clinic-speciality_' . $current_clinic_speciality_term_id); 

$Id	 					= get_field('Id', 'clinic-speciality_' . $current_clinic_speciality_term_id);
$Alias 					= get_field('alias', 'clinic-speciality_' . $current_clinic_speciality_term_id);
$Namegenitive 			= get_field('namegenitive', 'clinic-speciality_' . $current_clinic_speciality_term_id);
$Nameplural				= get_field('nameplural', 'clinic-speciality_' . $current_clinic_speciality_term_id);
$Namepluralgenitive		= get_field('namepluralgenitive', 'clinic-speciality_' . $current_clinic_speciality_term_id);
$Issimple				= get_field('issimple', 'clinic-speciality_' . $current_clinic_speciality_term_id);
$Branchname				= get_field('branchname', 'clinic-speciality_' . $current_clinic_speciality_term_id);
$Branchalias			= get_field('branchalias', 'clinic-speciality_' . $current_clinic_speciality_term_id);

$data_district[clinic_speciality_Id] 					= $Id;
$data_district[clinic_speciality_alias] 				= $Alias;
$data_district[clinic_speciality_namegenitive] 			= $Namegenitive;
$data_district[clinic_speciality_nameplural] 			= $Nameplural;
$data_district[clinic_speciality_namepluralgenitive] 	= $Namepluralgenitive;
$data_district[clinic_speciality_branchname] 			= $Branchname;
$data_district[clinic_speciality_branchalias] 			= $Branchalias;

		if($rows) { 
		
			foreach($rows as $row) { 
				$key = $row['ключ']; 
				$value = $row['переменная']; 
				$data_district[$key] = $value;
			} 
		} 

$data_metro[clinic_speciality_Id] 					= $Id;
$data_metro[clinic_speciality_alias] 				= $Alias;
$data_metro[clinic_speciality_namegenitive] 		= $Namegenitive;
$data_metro[clinic_speciality_nameplural] 			= $Nameplural;
$data_metro[clinic_speciality_namepluralgenitive] 	= $Namepluralgenitive;
$data_metro[clinic_speciality_branchname] 			= $Branchname;
$data_metro[clinic_speciality_branchalias] 			= $Branchalias;

		if($rows) { 
		
			foreach($rows as $row) { 
				$key = $row['ключ']; 
				$value = $row['переменная']; 
				$data_metro[$key] = $value;
			} 
		} 

	$field_textdescription_single_category = 'single_textdescription_for_clinic_speciality-' . $current_clinic_speciality_term_id;
$field_single_title_category = 'single_title_for_clinic_speciality-' . $current_clinic_speciality_term_id;
$field_single_description_category = 'single_description_for_clinic_speciality-' . $current_clinic_speciality_term_id;
$field_single_h1_category = 'single_h1_for_clinic_speciality-' . $current_clinic_speciality_term_id;
	
	
		if($clinic_speciality_template_textdescription) {
			
			$dust->compile($clinic_speciality_template_textdescription, 'myTemplate_clinic_speciality_single_textdescription');
			//render the template for that name
			$output = $dust->render('myTemplate_clinic_speciality_single_textdescription', $data_district);
			$output = html_entity_decode($output);
			update_option( $field_textdescription_single_category, $output, false );		
		} else { 
			delete_option( $field_textdescription_single_category );
		}
		
		
		
		//
		
		
		if($clinic_speciality_title_single) {
			$dust->compile($clinic_speciality_title_single, 'myTemplate_clinic_speciality_single');
			$output = $dust->render('myTemplate_clinic_speciality_single', $data_district);
			update_option( $field_single_title_category, $output, false ); 
		} else { 
			delete_option( $field_single_title_category );
		}
		
		if($clinic_speciality_single_description) {
			$dust->compile($clinic_speciality_single_description, 'myTemplate_clinic_speciality_single_description');
			$output = $dust->render('myTemplate_clinic_speciality_single_description', $data_district);
			update_option( $field_single_description_category, $output, false ); 
		} else { 
			delete_option( $field_single_description_category );
		}
		
		if($clinic_speciality_template_h1) {
			$dust->compile($clinic_speciality_template_h1, 'myTemplate_clinic_speciality_single_h1');
			$output = $dust->render('myTemplate_clinic_speciality_single_h1', $data_district);
			update_option( $field_single_h1_category, $output, false ); 
		} else { 
			delete_option( $field_single_h1_category );
		}
		
		//
		
		
		
		
		
		
		
		
	$array_metro_output = array();
	$array_district_output = array();


	foreach($all_district_terms as $district_term){
		
		$current_district_term_id = $district_term->term_id;
		$name	 				= get_field('name', 'district_' . $current_district_term_id);
		$data_district[district_name] 	= $name;
		
		$field = 'title_for_clinic_speciality-' . $current_clinic_speciality_term_id . '_x_district-'  . $current_district_term_id;

		$field_description = 'description_for_clinic_speciality-' . $current_clinic_speciality_term_id . '_x_district-'  . $current_district_term_id;
		$field_textdescription = 'textdescription_for_clinic_speciality-' . $current_clinic_speciality_term_id . '_x_district-'  . $current_district_term_id;
		
		
		$rows = get_field('пользовательские_переменные', 'district_' . $current_district_term_id); 
		
		if($rows) { 
		
			foreach($rows as $row) { 
				$key = $row['ключ']; 
				$value = $row['переменная']; 
				$data_district[$key] = $value;
			} 
		} 
		
		
		

		
		
		
		
		
		unset($current_template);
		// title
		if($clinic_speciality_district_template) {
			if(isset($custom_district_template[$current_district_term_id]['title'])){
				$current_template = $custom_district_template[$current_district_term_id]['title'];
				$dust->compile($current_template, 'myTemplate_clinic_speciality_district');
			} else {
				$dust->compile($clinic_speciality_district_template, 'myTemplate_clinic_speciality_district');
			}
			
			$output = $dust->render('myTemplate_clinic_speciality_district', $data_district);
			$array_district_output[$current_district_term_id][title] = $output;
			
		} 
		
		unset($current_template);
		// description
		if($clinic_speciality_district_template_description) {
			if(isset($custom_district_template[$current_district_term_id]['description'])){
				$current_template = $custom_district_template[$current_district_term_id]['description'];
				$dust->compile($current_template, 'myTemplate_clinic_speciality_district_description');
			} else {
				$dust->compile($clinic_speciality_district_template_description, 'myTemplate_clinic_speciality_district_description');
			}
			
			$output = $dust->render('myTemplate_clinic_speciality_district_description', $data_district);
			$array_district_output[$current_district_term_id][description] = $output;
			
		} 
		
		unset($current_template);
		// описание
		if($clinic_speciality_district_template_textdescription) {
			if(isset($custom_district_template[$current_district_term_id]['описание'])){
				$current_template = $custom_district_template[$current_district_term_id]['описание'];
				$dust->compile($current_template, 'myTemplate_clinic_speciality_district_textdescription');
			} else {
				$dust->compile($clinic_speciality_district_template_textdescription, 'myTemplate_clinic_speciality_district_textdescription');
			}
			
			$output = $dust->render('myTemplate_clinic_speciality_district_textdescription', $data_district);
			$output = html_entity_decode($output);
			$array_district_output[$current_district_term_id][textdescription] = $output; 
			
		} 
		
		unset($current_template);
		//заголовок
		if($clinic_speciality_district_template_h1) {
			if(isset($custom_district_template[$current_district_term_id]['заголовок'])){
				$current_template = $custom_district_template[$current_district_term_id]['заголовок'];
				$dust->compile($current_template, 'myTemplate_clinic_speciality_district_h1');
			} else {
				$dust->compile($clinic_speciality_district_template_h1, 'myTemplate_clinic_speciality_district_h1');
			}
			
			$output = $dust->render('myTemplate_clinic_speciality_district_h1', $data_district);
			$array_district_output[$current_district_term_id][h1] = $output; 
			
		}
		print_r($clinic_speciality_district_template_h1);
			echo " \n \n Район - " . $name . ', ' . $current_district_term_id . "\n";
			
			echo "Шаблон - " . $clinic_speciality_district_template_h1 . "\n" . $current_template . "\n";
			
			echo "Результат - " . $output . "\n \n"; 
		
		unset($current_template);
	
		
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
	$filename = 'clinic-speciality-' . $current_clinic_speciality_term_id . '-district.txt';
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
		
		
		$field = 'title_for_clinic_speciality-' . $current_clinic_speciality_term_id . '_x_metro-'  . $current_metro_term_id;
		
		$field_description = 'description_for_clinic_speciality-' . $current_clinic_speciality_term_id . '_x_metro-'  . $current_metro_term_id;
		
		$field_textdescription = 'textdescription_for_clinic_speciality-' . $current_clinic_speciality_term_id . '_x_metro-'  . $current_metro_term_id;
		
		$rows = get_field('пользовательские_переменные', 'metro_' . $current_metro_term_id); 

		if($rows) { 
		
			foreach($rows as $row) { 
				$key = $row['ключ']; 
				$value = $row['переменная']; 
				$data_metro[$key] = $value;
			} 
		} 
		
		
		
		unset($current_template);
		if($clinic_speciality_metro_template) {
			if(isset($custom_metro_template[$current_metro_term_id]['title'])){
				$current_template = $custom_metro_template[$current_metro_term_id]['title'];
				$dust->compile($current_template, 'myTemplate_clinic_speciality_metro');
			} else {
				$dust->compile($clinic_speciality_metro_template, 'myTemplate_clinic_speciality_metro');
			}
			
			$output = $dust->render('myTemplate_clinic_speciality_metro', $data_metro);
			$array_metro_output[$current_metro_term_id][title] = $output;
			
		} 
		
		unset($current_template);
		if($clinic_speciality_metro_template_description) {
			if(isset($custom_metro_template[$current_metro_term_id]['description'])){
				$current_template = $custom_metro_template[$current_metro_term_id]['description'];
				$dust->compile($current_template, 'myTemplate_clinic_speciality_metro_description');
			} else {
		$dust->compile($clinic_speciality_metro_template_description, 'myTemplate_clinic_speciality_metro_description');
			}
			
			$output = $dust->render('myTemplate_clinic_speciality_metro_description', $data_metro);
			$array_metro_output[$current_metro_term_id][description] = $output;
			
		} 
		
		unset($current_template);
		if($clinic_speciality_metro_template_textdescription) {
			if(isset($custom_metro_template[$current_metro_term_id]['описание'])){
				$current_template = $custom_metro_template[$current_metro_term_id]['описание'];
				$dust->compile($current_template, 'myTemplate_clinic_speciality_metro_textdescription');
			} else {
				$dust->compile($clinic_speciality_metro_template_textdescription, 'myTemplate_clinic_speciality_metro_textdescription');
			}
			
			$output = $dust->render('myTemplate_clinic_speciality_metro_textdescription', $data_metro);
			$output = html_entity_decode($output);
			$array_metro_output[$current_metro_term_id][textdescription] = $output;
			
		} 
		
	/* 	
			echo " \n \n Метро - " . $Name_metro . ', ' . $current_metro_term_id . "\n";
			
			echo "Шаблон - " . $clinic_speciality_metro_template_textdescription . "\n" . $current_template . "\n";
			
			echo "Результат - " . $output . "\n \n";  */
		
		
		
		unset($current_template);
		if($clinic_speciality_metro_template_h1) {
			if(isset($custom_metro_template[$current_metro_term_id]['заголовок'])){
				$current_template = $custom_metro_template[$current_metro_term_id]['заголовок'];
				$dust->compile($current_template, 'myTemplate_clinic_speciality_metro_h1');
			} else {
				$dust->compile($clinic_speciality_metro_template_h1, 'myTemplate_clinic_speciality_metro_h1');
			}
			
			$output = $dust->render('myTemplate_clinic_speciality_metro_h1', $data_metro);
			$array_metro_output[$current_metro_term_id][h1] = $output; 
			
		} 
		
			echo " \n \n Метро - " . $Name_metro . ', ' . $current_metro_term_id . "\n";
			
			echo "Шаблон - " . $clinic_speciality_metro_template_h1 . "\n" . $current_template . "\n";
			
			echo "Результат - " . $output . "\n \n"; 
		
		
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
	$filename = 'clinic-speciality-' . $current_clinic_speciality_term_id . '-metro.txt';
	file_put_contents($path . '/json/seo/' . $filename, $metro_serialize, true);
	
	
	$a++; 
	
}

echo "Ok отработана специализации для клииник. \n";
