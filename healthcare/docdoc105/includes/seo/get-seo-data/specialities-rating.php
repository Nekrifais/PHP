<?php 
		$args = array(
			'posts_per_page' => '10',
			'post_type' => 'medic',
			'orderby' => 'Rating',
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
		
		while($recent->have_posts()) : $recent->the_post(); 
			
			$medic_wp_id 	= $post->ID;
			$medic_link 	= get_permalink($medic_wp_id);
			$medic_title 	= get_the_title($medic_wp_id);
			$medic_rating 	= get_field("Rating", $medic_wp_id, true);
			
			$medic_rating_array[title] 	= $medic_title;
			$medic_rating_array[link] 	= $medic_link;
			$medic_rating_array[value] 	= $medic_rating;
			$speciality_medic_rating_array[$city_slug][$speciality_term_id][] = $medic_rating_array;
			
		endwhile;
		
		