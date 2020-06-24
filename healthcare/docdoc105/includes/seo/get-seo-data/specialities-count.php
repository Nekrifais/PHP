<?php 


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
					'taxonomy' => 'city',
					'field'    => 'term_id',
					'terms'    => array( $city_term_id ),
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
		
	