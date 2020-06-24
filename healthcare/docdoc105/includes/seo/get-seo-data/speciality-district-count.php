<?php 

		foreach($id_district_term as $key => $value) {
		$args = array(
			'posts_per_page' => '1',
			'post_type' => 'medic',
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'speciality',
					'field'    => 'term_id',
					'terms'    => array( $speciality_term_id ),
				),
				array(
					'taxonomy' => 'district',
					'field'    => 'term_id',
					'terms'    => array( $key ),
				),
			),
			'meta_query' => array(
				array(
					'key'     => 'isActive',
					'value'   => array( 1 ),
				),
			),
		);
		
		$recent = new WP_Query( $args );
		
		
		$number = $recent->found_posts;
		$tmp_slug = $city_tmp_array[$key];
		$speciality_district_medic_number_array[$tmp_slug][$speciality_term_id][$key] = $number;
		
		
		}
		
		