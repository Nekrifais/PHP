<?php 

		if($speciality_title_single_review) {
			
			$dust->compile($speciality_title_single_review, 'myTemplate_speciality_review_title');
			
			
			$output = $dust->render('myTemplate_speciality_review_title', $data_district);
			$output = html_entity_decode($output); 
			$array_review_output[$current_speciality_term_id][title] = $output;		
			
		} 
		
		if($speciality_single_description_review) {
			
			$dust->compile($speciality_single_description_review, 'myTemplate_speciality_review_description');
			
			
			$output = $dust->render('myTemplate_speciality_review_description', $data_district);
			$output = html_entity_decode($output); 
			$array_review_output[$current_speciality_term_id][description] = $output;		
			
		} 
		
		if($speciality_template_textdescription_review) {
			
			$dust->compile($speciality_template_textdescription_review, 'myTemplate_speciality_review_textdescription');
			
			
			$output = $dust->render('myTemplate_speciality_review_textdescription', $data_district);
			$output = html_entity_decode($output); 
			$array_review_output[$current_speciality_term_id][textdescription] = $output;		
			
		} 
		
		if($speciality_template_h1_review) {
			
			$dust->compile($speciality_template_h1_review, 'myTemplate_speciality_review_h1');
			
			
			$output = $dust->render('myTemplate_speciality_review_h1', $data_district);
			$output = html_entity_decode($output); 
			$array_review_output[$current_speciality_term_id][h1] = $output;		
			
		} 