<?php
	
$speciality_title_single = get_field('title_шаблон_для_специализации_врачей', 'option', false);
$speciality_district_template = get_field('title_шаблон_комбинации_специальность_район', 'option', false);
$speciality_metro_template = get_field('title_шаблон_комбинации_специальность_метро', 'option', false);


$speciality_single_description = get_field('description_шаблон_для_специализации_врачей', 'option', false);
$speciality_district_template_description = get_field('description_шаблон_комбинации_специальность_район', 'option', false);
$speciality_metro_template_description = get_field('description_шаблон_комбинации_специальность_метро', 'option', false);




$speciality_template_textdescription = get_field('описание_шаблон_для_специальности_врачей', 'option', false);
$speciality_district_template_textdescription = get_field('описание_шаблон_комбинации_специальность_район', 'option', false);
$speciality_metro_template_textdescription = get_field('описание_шаблон_комбинации_специальность_метро', 'option', false);


$speciality_template_h1 = get_field('заголовок_шаблон_для_специальности_врачей', 'option', false);
$speciality_district_template_h1 = get_field('заголовок_шаблон_комбинации_специальность_район', 'option', false);
$speciality_metro_template_h1 = get_field('заголовок_шаблон_комбинации_специальность_метро', 'option', false);






// nadom

$speciality_title_single_nadom = get_field('title_шаблон_для_комбинации_специальность_выезд_на_дом', 'option', false);
$speciality_single_description_nadom = get_field('decription_шаблон_для_комбинации_специальность_выезд_на_дом', 'option', false);
$speciality_template_textdescription_nadom = get_field('описание_шаблон_для_комбинации_специальность_выезд_на_дом', 'option', false);
$speciality_template_h1_nadom = get_field('заголовок_шаблон_для_комбинации_специальность_выезд_на_дом', 'option', false);


// child

$speciality_title_single_child = get_field('title_шаблон_для_комбинации_специальность_детский_врач', 'option', false);
$speciality_single_description_child = get_field('decription_шаблон_для_комбинации_специальность_детский_врач', 'option', false);
$speciality_template_textdescription_child = get_field('описание_шаблон_для_комбинации_специальность_детский_врач', 'option', false);
$speciality_template_h1_child = get_field('заголовок_шаблон_для_комбинации_специальность_детский_врач', 'option', false);



// Rating

$speciality_title_single_rating = get_field('title_шаблон_для_комбинации_специальность_рейтинг', 'option', false);
$speciality_single_description_rating = get_field('decription_шаблон_для_комбинации_специальность_рейтинг', 'option', false);
$speciality_template_textdescription_rating = get_field('описание_шаблон_для_комбинации_специальность_рейтинг', 'option', false);
$speciality_template_h1_rating = get_field('заголовок_шаблон_для_комбинации_специальность_рейтинг', 'option', false);



// ExpirienceYear

$speciality_title_single_expirience = get_field('title_шаблон_для_комбинации_специальность_стаж', 'option', false);
$speciality_single_description_expirience = get_field('decription_шаблон_для_комбинации_специальность_стаж', 'option', false);
$speciality_template_textdescription_expirience = get_field('описание_шаблон_для_комбинации_специальность_стаж', 'option', false);
$speciality_template_h1_expirience = get_field('заголовок_шаблон_для_комбинации_специальность_стаж', 'option', false);



// Price

$speciality_title_single_price = get_field('title_шаблон_для_комбинации_специальность_стоимость', 'option', false);
$speciality_single_description_price = get_field('decription_шаблон_для_комбинации_специальность_стоимость', 'option', false);
$speciality_template_textdescription_price = get_field('описание_шаблон_для_комбинации_специальность_стоимость', 'option', false);
$speciality_template_h1_price = get_field('заголовок_шаблон_для_комбинации_специальность_стоимость', 'option', false);



// Reviews

$speciality_title_single_review = get_field('title_шаблон_для_комбинации_специальность_отзывы', 'option', false);
$speciality_single_description_review = get_field('decription_шаблон_для_комбинации_специальность_отзывы', 'option', false);
$speciality_template_textdescription_review = get_field('описание_шаблон_для_комбинации_специальность_отзывы', 'option', false);
$speciality_template_h1_review = get_field('заголовок_шаблон_для_комбинации_специальность_отзывы', 'option', false);



	$file_path_spec_count = $path . '/json/seo/data/speciality-count.txt';
	$speciality_spec_count = file_get_contents($file_path_spec_count);
	$speciality_spec_count = unserialize($speciality_spec_count);
	
	/* print_r($speciality_spec_count); */

	$file_path_exp_count = $path . '/json/seo/data/speciality-expirience-count.txt';
	$speciality_expirience_count = file_get_contents($file_path_exp_count);
	$speciality_expirience_count = unserialize($speciality_expirience_count);
	
	/* print_r($speciality_expirience_count); */

	$file_path_rating_count = $path . '/json/seo/data/speciality-rating-count.txt';
	$speciality_rating_count = file_get_contents($file_path_rating_count);
	$speciality_rating_count = unserialize($speciality_rating_count);
	
	/* print_r($speciality_rating_count); */
	
	$file_path_reviews_count = $path . '/json/seo/data/speciality-reviews-count.txt';
	$speciality_reviews_count = file_get_contents($file_path_reviews_count);
	$speciality_reviews_count = unserialize($speciality_reviews_count);
	
	
	
	
	
	
	$file_path_district_count = $path . '/json/seo/data/speciality-district-count.txt';
	$speciality_district_count = file_get_contents($file_path_district_count);
	$speciality_district_count = unserialize($speciality_district_count);
	
	/* print_r($speciality_district_count); */
	
	
	$file_path_metro_count = $path . '/json/seo/data/speciality-metro-count.txt';
	$speciality_metro_count = file_get_contents($file_path_metro_count);
	$speciality_metro_count = unserialize($speciality_metro_count);
	
/* 	  print_r($speciality_metro_count);  
	
	die;  */
	
	/* print_r($speciality_reviews_count); */
	
	$file_path_nadom_count = $path . '/json/seo/data/speciality-nadom-count.txt';
	$speciality_nadom_count = file_get_contents($file_path_nadom_count);	
	$speciality_nadom_count = unserialize($speciality_nadom_count);
	

	
	$file_path_child_count = $path . '/json/seo/data/speciality-child-count.txt';
	$speciality_child_count = file_get_contents($file_path_child_count);
	$speciality_child_count = unserialize($speciality_child_count);
	
	
	

	






unset($custom_metro_template);
unset($custom_district_template);

foreach($custom_template_array as $key => $value) {
	
	if($value == 2 ) {
		
		$template_text_area			= get_field("template", $key, false);
		$template_type 				= get_field("template_type", $key, true);
		/* print_r($template_type); */
		
		$template_type_extended 	= $type_array[$template_type];
		/* print_r($template_type_extended); */
		
		$template_metro 			= get_field("template_metro", $key, true);
		$template_district 			= get_field("template_district", $key, true);
		
		
		
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


 /* print_r($custom_metro_template);  */




foreach($all_speciality_terms as $speciality_term){
	
	$current_speciality_term_id = $speciality_term->term_id;
	
unset($data_district);
unset($data_metro);

$rows = get_field('пользовательские_переменные', 'speciality_' . $current_speciality_term_id); 

$Id	 					= get_field('Id', 'speciality_' . $current_speciality_term_id);
$Alias 					= get_field('alias', 'speciality_' . $current_speciality_term_id);
$Namegenitive 			= get_field('namegenitive', 'speciality_' . $current_speciality_term_id);
$Nameplural				= get_field('nameplural', 'speciality_' . $current_speciality_term_id);
$Namepluralgenitive		= get_field('namepluralgenitive', 'speciality_' . $current_speciality_term_id);
$Issimple				= get_field('issimple', 'speciality_' . $current_speciality_term_id);
$Branchname				= get_field('branchname', 'speciality_' . $current_speciality_term_id);
$Branchalias			= get_field('branchalias', 'speciality_' . $current_speciality_term_id);

$data_district[speciality_Id] 					= $Id;
$data_district[speciality_alias] 				= $Alias;
$data_district[speciality_namegenitive] 		= $Namegenitive;
$data_district[speciality_nameplural] 			= $Nameplural;
$data_district[speciality_namepluralgenitive] 	= $Namepluralgenitive;
$data_district[speciality_branchname] 			= $Branchname;
$data_district[speciality_branchalias] 			= $Branchalias;

		
		if($rows) { 
		
			foreach($rows as $row) { 
				$key = $row['ключ']; 
				$value = $row['переменная']; 
				$data_district[$key] = $value;
			} 
		} 
		
$data_district[count] = $speciality_spec_count[$current_city_slug][$current_speciality_term_id];

		
		
		
		
		
		
$data_metro[speciality_Id] 					= $Id;
$data_metro[speciality_alias] 				= $Alias;
$data_metro[speciality_namegenitive] 		= $Namegenitive;
$data_metro[speciality_nameplural] 			= $Nameplural;
$data_metro[speciality_namepluralgenitive] 	= $Namepluralgenitive;
$data_metro[speciality_branchname] 			= $Branchname;
$data_metro[speciality_branchalias] 		= $Branchalias;

		if($rows) { 
		
			foreach($rows as $row) { 
				$key = $row['ключ']; 
				$value = $row['переменная']; 
				$data_metro[$key] = $value;
			} 
		} 
		

	$field_textdescription_single_category = 'single_textdescription_for_speciality-' . $current_speciality_term_id;
	$field_single_category = 'single_title_for_speciality-' . $current_speciality_term_id;
	$field_single_description_category = 'single_description_for_speciality-' . $current_speciality_term_id;
	$field_single_h1_category = 'single_h1_for_speciality-' . $current_speciality_term_id;

		if($speciality_template_textdescription) {
			
			$dust->compile($speciality_template_textdescription, 'myTemplate_speciality_single_textdescription');
			//render the template for that name
			$output = $dust->render('myTemplate_speciality_single_textdescription', $data_district);
			$output = html_entity_decode($output);
			update_option( $field_textdescription_single_category, $output, false ); 
		} else { 
			delete_option( $field_textdescription_single_category );
		}
		
		if($speciality_title_single) {
			$dust->compile($speciality_title_single, 'myTemplate_speciality_single');
			$output = $dust->render('myTemplate_speciality_single', $data_district);
			update_option( $field_single_category, $output, false ); 
		} else { 
			delete_option( $field_single_category );
		}
		
		if($speciality_single_description) {
			$dust->compile($speciality_single_description, 'myTemplate_speciality_single_description');
			$output = $dust->render('myTemplate_speciality_single_description', $data_district);
			update_option( $field_single_description_category, $output, false ); 
		} else { 
			delete_option( $field_single_description_category );
		}
		
		if($speciality_template_h1) {
			$dust->compile($speciality_template_h1, 'myTemplate_speciality_single_h1');
			$output = $dust->render('myTemplate_speciality_single_h1', $data_district);
			update_option( $field_single_h1_category, $output, false ); 
		} else { 
			delete_option( $field_single_h1_category );
		}
		
		

		
		
		
		

		
		// rating
		
			include(dirname(__FILE__) . '/seo-includes/rating.php');
		
		// ExpirienceYear

			include(dirname(__FILE__) . '/seo-includes/expirience.php');
		
		// Price
			
			include(dirname(__FILE__) . '/seo-includes/price.php');
		
		// Reviews
		
			include(dirname(__FILE__) . '/seo-includes/reviews.php');
		
		// nadom
		$data_district[count] = $speciality_nadom_count[$current_city_slug][$current_speciality_term_id];
			include(dirname(__FILE__) . '/seo-includes/nadom.php');
		
		// child
		$data_district[count] = $speciality_child_count[$current_city_slug][$current_speciality_term_id];
			include(dirname(__FILE__) . '/seo-includes/child.php');	

	$array_metro_output = array();
	$array_district_output = array();

	foreach($all_district_terms as $district_term) {
		
		
		$current_district_term_id = $district_term->term_id;
		$name	 				= get_field('name', 'district_' . $current_district_term_id);
		$data_district[district_name] 	= $name;
		
		$data_district[count] = $speciality_district_count[$current_city_slug][$current_speciality_term_id][$current_district_term_id];
		
		$field = 'title_for_speciality-' . $current_speciality_term_id . '_x_district-'  . $current_district_term_id;
		$field_description = 'description_for_speciality-' . $current_speciality_term_id . '_x_district-'  . $current_district_term_id;
		$field_textdescription = 'textdescription_for_speciality-' . $current_speciality_term_id . '_x_district-'  . $current_district_term_id;
		
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
		if($speciality_district_template) {
			if(isset($custom_district_template[$current_district_term_id]['title'])){
				$current_template = $custom_district_template[$current_district_term_id]['title'];
				$dust->compile($current_template, 'myTemplate_speciality_district');
			} else {
				$dust->compile($speciality_district_template, 'myTemplate_speciality_district');
			}
			
			$output = $dust->render('myTemplate_speciality_district', $data_district);			
			$array_district_output[$current_district_term_id][title] = $output;
			
  		} 
		
		unset($current_template);
		// description
		if($speciality_district_template_description) {
			if(isset($custom_district_template[$current_district_term_id]['description'])){
				$current_template = $custom_district_template[$current_district_term_id]['description'];
				$dust->compile($current_template, 'myTemplate_speciality_district_description');
			} else { 
				$dust->compile($speciality_district_template_description, 'myTemplate_speciality_district_description');
			}
			
			$output = $dust->render('myTemplate_speciality_district_description', $data_district);
			$array_district_output[$current_district_term_id][description] = $output;	

		} 
		
		unset($current_template);
		// описание
		if($speciality_district_template_textdescription) {
			if(isset($custom_district_template[$current_district_term_id]['описание'])){
				$current_template = $custom_district_template[$current_district_term_id]['описание'];
				$dust->compile($current_template, 'myTemplate_speciality_district_textdescription');
			} else { 
				$dust->compile($speciality_district_template_textdescription, 'myTemplate_speciality_district_textdescription');
			}
			
			$output = $dust->render('myTemplate_speciality_district_textdescription', $data_district);
			$output = html_entity_decode($output);
			$array_district_output[$current_district_term_id][textdescription] = $output;	
			
		}
		
		
		unset($current_template);
		//заголовок
		if($speciality_district_template_h1) {
			if(isset($custom_district_template[$current_district_term_id]['заголовок'])){
				$current_template = $custom_district_template[$current_district_term_id]['заголовок'];
				$dust->compile($current_template, 'myTemplate_speciality_district_h1');
			} else {
				$dust->compile($speciality_district_template_h1, 'myTemplate_speciality_district_h1');
			}
			
			$output = $dust->render('myTemplate_speciality_district_h1', $data_district);
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
        unset($data_district[count]);
	
	}
	
	$district_serialize = serialize($array_district_output);
	unset($array_district_output);
	$filename = 'speciality-' . $current_speciality_term_id . '-district.txt';
	file_put_contents($path . '/json/seo/' . $filename, $district_serialize, true);
	
	
	foreach($all_metro_terms as $metro_term){
		
	
	
		
		$current_metro_term_id = $metro_term->term_id;
	
		$Id_metro	 			= get_field('Id_metro', 'metro_' . $current_metro_term_id);
		$Name_metro 			= get_field('Name_metro', 'metro_' . $current_metro_term_id);
		$LineName_metro 		= get_field('LineName_metro', 'metro_' . $current_metro_term_id);
		$LineColor_metro		= get_field('LineColor_metro', 'metro_' . $current_metro_term_id);
		$CityId_metro			= get_field('CityId_metro', 'metro_' . $current_metro_term_id);
		$Alias_metro			= get_field('Alias_metro', 'metro_' . $current_metro_term_id);
		$DistrictIds_metro		= get_field('DistrictIds_metro', 'metro_' . $current_metro_term_id);

		
		$data_metro[count] = $speciality_metro_count[$current_city_slug][$current_speciality_term_id][$current_metro_term_id];
	
	
	
	
		$data_metro[Id_metro] 				= $Id_metro;
		$data_metro[Name_metro] 			= $Name_metro;
		$data_metro[LineName_metro] 		= $LineName_metro;
		$data_metro[LineColor_metro] 		= $LineColor_metro;
		$data_metro[CityId_metro] 			= $CityId_metro;
		$data_metro[Alias_metro] 			= $Alias_metro;
		$data_metro[DistrictIds_metro] 		= $DistrictIds_metro;
		
		$rows = get_field('пользовательские_переменные', 'metro_' . $current_metro_term_id); 
	
	
	
	 /* print_r($rows);  */
	
		if($rows) { 
		
			foreach($rows as $row) { 
				$key = $row['ключ']; 
				$value = $row['переменная']; 
				$data_metro[$key] = $value;
			} 
		} 
	
		$field = 'title_for_speciality-' . $current_speciality_term_id . '_x_metro-'  . $current_metro_term_id;
		$field_description = 'description_for_speciality-' . $current_speciality_term_id . '_x_metro-'  . $current_metro_term_id;
		$field_textdescription = 'textdescription_for_speciality-' . $current_speciality_term_id . '_x_metro-'  . $current_metro_term_id;
		
		
		
		
		unset($current_template);
		if($speciality_metro_template) {
			if(isset($custom_metro_template[$current_metro_term_id]['title'])){
				
				$current_template = $custom_metro_template[$current_metro_term_id]['title'];
				$dust->compile($current_template, 'myTemplate_speciality_metro');
				
			} else {
				$dust->compile($speciality_metro_template, 'myTemplate_speciality_metro');
			}
			
			$output = $dust->render('myTemplate_speciality_metro', $data_metro);
			$array_metro_output[$current_metro_term_id][title] = $output;
			
		}
		
/*  		echo " \n \n Метро - " . $Name_metro . ', ' . $current_metro_term_id . "\n";
			
			echo "Шаблон - " . $speciality_metro_template . "\n" . $current_template . "\n";
			
			echo "Результат - " . $output . "\n \n";  */
			
		unset($current_template);
		if($speciality_metro_template_description) {
			if(isset($custom_metro_template[$current_metro_term_id]['description'])){
				$current_template = $custom_metro_template[$current_metro_term_id]['description'];
				$dust->compile($current_template, 'myTemplate_speciality_metro_description');
			} else {
				$dust->compile($speciality_metro_template_description, 'myTemplate_speciality_metro_description');
			}
			
			$output = $dust->render('myTemplate_speciality_metro_description', $data_metro);
			$array_metro_output[$current_metro_term_id][description] = $output;
			
		} 
		
		if($speciality_metro_template_textdescription) {
			if(isset($custom_metro_template[$current_metro_term_id]['описание'])){
				$current_template = $custom_metro_template[$current_metro_term_id]['описание'];
				$dust->compile($current_template, 'myTemplate_speciality_metro_textdescription');
			} else {
			$dust->compile($speciality_metro_template_textdescription, 'myTemplate_speciality_metro_textdescription');
			}
			
			$output = $dust->render('myTemplate_speciality_metro_textdescription', $data_metro);
			$output = html_entity_decode($output); 
			$array_metro_output[$current_metro_term_id][textdescription] = $output;		
			
		} 
		
/* 			echo " \n \n Метро - " . $Name_metro . ', ' . $current_metro_term_id . "\n";
			
			echo "Шаблон - " . $speciality_metro_template_textdescription . "\n" . $current_template . "\n";
			
			echo "Результат - " . $output . "\n \n";  */
		
		if($speciality_metro_template_h1) {
			if(isset($custom_metro_template[$current_metro_term_id]['заголовок'])){
				$current_template = $custom_metro_template[$current_metro_term_id]['заголовок'];
				$dust->compile($current_template, 'myTemplate_speciality_metro_h1');
			} else {
				$dust->compile($speciality_metro_template_h1, 'myTemplate_speciality_metro_h1');
			}
			
			$output = $dust->render('myTemplate_speciality_metro_h1', $data_metro);
			$array_metro_output[$current_metro_term_id][h1] = $output; 
			
		}
		
		/* print_r($data_metro); */
		if($rows) { 
		
			foreach($rows as $row) { 
				$key = $row['ключ']; 
				$value = $row['переменная']; 
				unset($data_metro[$key]);
			} 
		}
        unset($rows);
        unset($data_metro[count]);
		
		
	}
	
	$metro_serialize = serialize($array_metro_output);
	unset($array_metro_output);
	$filename = 'speciality-' . $current_speciality_term_id . '-metro.txt';
	file_put_contents($path . '/json/seo/' . $filename, $metro_serialize, true);
	
	
	
	$a++; 
}

	$nadom_serialize = serialize($array_nadom_output);
	unset($array_nadom_output);
	$filename = 'speciality-nadom.txt';
	file_put_contents($path . '/json/seo/' . $filename, $nadom_serialize, true);
	
	
	$child_serialize = serialize($array_child_output);
	unset($array_child_output);
	$filename = 'speciality-child.txt';
	file_put_contents($path . '/json/seo/' . $filename, $child_serialize, true);
		
	$rating_serialize = serialize($array_rating_output);
	unset($array_rating_output);
	$filename = 'speciality-Rating.txt';
	file_put_contents($path . '/json/seo/' . $filename, $rating_serialize, true);
		
	$expirience_serialize = serialize($array_expirience_output);
	unset($array_expirience_output);
	$filename = 'speciality-ExperienceYear.txt';
	file_put_contents($path . '/json/seo/' . $filename, $expirience_serialize, true);
		
	$price_serialize = serialize($array_price_output);
	unset($array_price_output);
	$filename = 'speciality-Price.txt';
	file_put_contents($path . '/json/seo/' . $filename, $price_serialize, true);
			
	$review_serialize = serialize($array_review_output);
	unset($array_review_output);
	$filename = 'speciality-OpinionCount.txt';
	file_put_contents($path . '/json/seo/' . $filename, $review_serialize, true);
	
	

echo "Конец специальности. \n";
