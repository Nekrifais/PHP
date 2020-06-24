<?php 
	
	if($speciality_title_single_child) {

			$dust->compile($speciality_title_single_child, 'myTemplate_speciality_child_title');

			
			$output = $dust->render('myTemplate_speciality_child_title', $data_district);
			$output = html_entity_decode($output); 
			$array_child_output[$current_speciality_term_id][title] = $output;		
			
		} 
		
		if($speciality_single_description_child) {

			$dust->compile($speciality_single_description_child, 'myTemplate_speciality_child_description');

			
			$output = $dust->render('myTemplate_speciality_child_description', $data_district);
			$output = html_entity_decode($output); 
			$array_child_output[$current_speciality_term_id][description] = $output;		
			
		} 
		
		if($speciality_template_textdescription_child) {

			$dust->compile($speciality_template_textdescription_child, 'myTemplate_speciality_child_textdescription');

			
			$output = $dust->render('myTemplate_speciality_child_textdescription', $data_district);
			$output = html_entity_decode($output); 
			$array_child_output[$current_speciality_term_id][textdescription] = $output;		
			
		} 
		
		if($speciality_template_h1_child) {

			$dust->compile($speciality_template_h1_child, 'myTemplate_speciality_child_h1');

			
			$output = $dust->render('myTemplate_speciality_child_h1', $data_district);
			$output = html_entity_decode($output); 
			$array_child_output[$current_speciality_term_id][h1] = $output;		
			
		} 