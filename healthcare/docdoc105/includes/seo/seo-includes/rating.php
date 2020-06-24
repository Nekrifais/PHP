<?php 
		
		if($speciality_title_single_rating) {
			
			$dust->compile($speciality_title_single_rating, 'myTemplate_speciality_rating_title');
			
			
			$output = $dust->render('myTemplate_speciality_rating_title', $data_district);
			$output = html_entity_decode($output); 
			$array_rating_output[$current_speciality_term_id][title] = $output;		
			
		} 
		
		if($speciality_single_description_rating) {
			
			$dust->compile($speciality_single_description_rating, 'myTemplate_speciality_rating_description');
			
			
			$output = $dust->render('myTemplate_speciality_rating_description', $data_district);
			$output = html_entity_decode($output); 
			$array_rating_output[$current_speciality_term_id][description] = $output;		
			
		} 
		
		if($speciality_template_textdescription_rating) {
			
			$dust->compile($speciality_template_textdescription_rating, 'myTemplate_speciality_rating_textdescription');
			
			
			$output = $dust->render('myTemplate_speciality_rating_textdescription', $data_district);
			$output = html_entity_decode($output); 
			$array_rating_output[$current_speciality_term_id][textdescription] = $output;		
			
		} 
		
		if($speciality_template_h1_rating) {
			
			$dust->compile($speciality_template_h1_rating, 'myTemplate_speciality_rating_h1');
			
			
			$output = $dust->render('myTemplate_speciality_rating_h1', $data_district);
			$output = html_entity_decode($output); 
			$array_rating_output[$current_speciality_term_id][h1] = $output;		
			
		} 