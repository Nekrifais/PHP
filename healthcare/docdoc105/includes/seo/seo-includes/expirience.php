<?php 

		if($speciality_title_single_expirience) {
			
			$dust->compile($speciality_title_single_expirience, 'myTemplate_speciality_expirience_title');
			
			
			$output = $dust->render('myTemplate_speciality_expirience_title', $data_district);
			$output = html_entity_decode($output); 
			$array_expirience_output[$current_speciality_term_id][title] = $output;		
			
		} 
		
		if($speciality_single_description_expirience) {
			
			$dust->compile($speciality_single_description_expirience, 'myTemplate_speciality_expirience_description');
			
			
			$output = $dust->render('myTemplate_speciality_expirience_description', $data_district);
			$output = html_entity_decode($output); 
			$array_expirience_output[$current_speciality_term_id][description] = $output;		
			
		} 
		
		if($speciality_template_textdescription_expirience) {
			
			$dust->compile($speciality_template_textdescription_expirience, 'myTemplate_speciality_expirience_textdescription');
			
			
			$output = $dust->render('myTemplate_speciality_expirience_textdescription', $data_district);
			$output = html_entity_decode($output); 
			$array_expirience_output[$current_speciality_term_id][textdescription] = $output;		
			
		} 
		
		if($speciality_template_h1_expirience) {
			
			$dust->compile($speciality_template_h1_expirience, 'myTemplate_speciality_expirience_h1');
			
			
			$output = $dust->render('myTemplate_speciality_expirience_h1', $data_district);
			$output = html_entity_decode($output); 
			$array_expirience_output[$current_speciality_term_id][h1] = $output;		
			
		} 