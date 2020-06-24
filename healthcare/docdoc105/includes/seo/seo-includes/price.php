<?php 

		if($speciality_title_single_price) {
			
			$dust->compile($speciality_title_single_price, 'myTemplate_speciality_price_title');
			
			
			$output = $dust->render('myTemplate_speciality_price_title', $data_district);
			$output = html_entity_decode($output); 
			$array_price_output[$current_speciality_term_id][title] = $output;		
			
		} 
		
		if($speciality_single_description_price) {
			
			$dust->compile($speciality_single_description_price, 'myTemplate_speciality_price_description');
			
			
			$output = $dust->render('myTemplate_speciality_price_description', $data_district);
			$output = html_entity_decode($output); 
			$array_price_output[$current_speciality_term_id][description] = $output;		
			
		} 
		
		if($speciality_template_textdescription_price) {
			
			$dust->compile($speciality_template_textdescription_price, 'myTemplate_speciality_price_textdescription');
			
			
			$output = $dust->render('myTemplate_speciality_price_textdescription', $data_district);
			$output = html_entity_decode($output); 
			$array_price_output[$current_speciality_term_id][textdescription] = $output;		
			
		} 
		
		if($speciality_template_h1_price) {
			
			$dust->compile($speciality_template_h1_price, 'myTemplate_speciality_price_h1');
			
			
			$output = $dust->render('myTemplate_speciality_price_h1', $data_district);
			$output = html_entity_decode($output); 
			$array_price_output[$current_speciality_term_id][h1] = $output;		
			
		} 