<?php 


		if($speciality_title_single_nadom) {

			$dust->compile($speciality_title_single_nadom, 'myTemplate_speciality_nadom_title');

			
			$output = $dust->render('myTemplate_speciality_nadom_title', $data_district);
			$output = html_entity_decode($output); 
			$array_nadom_output[$current_speciality_term_id][title] = $output;		
			
		} 
		
		if($speciality_single_description_nadom) {

			$dust->compile($speciality_single_description_nadom, 'myTemplate_speciality_nadom_description');

			
			$output = $dust->render('myTemplate_speciality_nadom_description', $data_district);
			$output = html_entity_decode($output); 
			$array_nadom_output[$current_speciality_term_id][description] = $output;		
			
		} 
		
		if($speciality_template_textdescription_nadom) {

			$dust->compile($speciality_template_textdescription_nadom, 'myTemplate_speciality_nadom_textdescription');

			
			$output = $dust->render('myTemplate_speciality_nadom_textdescription', $data_district);
			$output = html_entity_decode($output); 
			$array_nadom_output[$current_speciality_term_id][textdescription] = $output;		
			
		} 
		
		if($speciality_template_h1_nadom) {

			$dust->compile($speciality_template_h1_nadom, 'myTemplate_speciality_nadom_h1');

			
			$output = $dust->render('myTemplate_speciality_nadom_h1', $data_district);
			$output = html_entity_decode($output); 
			$array_nadom_output[$current_speciality_term_id][h1] = $output;		
			
		} 
		