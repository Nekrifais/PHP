				<div class="filter-home filter-shortcode-medic">

<?php $speciality_test = get_term_by('id', $a[id], 'speciality'); ?>
<?php $current_query_speciality = $speciality_test->slug; ?>	
				
<?php $all_speciality = get_terms( 'speciality', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0 ) ); ?>
		<?php $city_terms = get_terms( 'city', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0 ) ); ?> 
		<?php $metro_city_terms = get_terms( 'metro', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) ); ?> 
		<?php $district_city_terms = get_terms( 'district', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) ); ?> 
		<?php $city = get_field('выбор_города', 'option'); ?> 
		<?php $city = array_shift( $city ); ?> 
		
		<?php $filter_title = get_field('заголовок_для_поиска_на_главной', 'option'); ?>
		<?php $filter_text = get_field('текст_для_поиска_на_главной', 'option'); ?>
		<div class="row">
					<div class="col-md-12">
						
						<form class="form-shortcode-medic" action="<?php bloginfo('url'); ?>/advanced-search/" method="get">
							<div class="row">
							
								<div class="col-md-4">

									<div style="margin-bottom: 20px;" class="specialization-title"> 
										<img src="<?php bloginfo('template_url'); ?>/images/search.png" style="height: 24px;">Специальности 
									</div> 
									<select class="speciality-select js-states form-control speciality-select2 select-home-speciality" name="speciality">
									<option></option>
										
<?php $all_options_speciality = get_field('выгрузить_все_специальности', 'option');
	
	if($all_options_speciality) { ?>
		
			<?php foreach ( $all_speciality as $tag ) { ?>
				<option value="<?php echo $tag->slug; ?>" data-icon="fa-apple"><?php echo $tag->name; ?></option>
			<?php } ?>
			
	<?php } else { 

		$all_speciality = get_terms( 'speciality', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0 ) );
		
		$speciality_to_import = get_field('выбор_специальностей', 'option');
		
		foreach($all_speciality as $speciality_one) {
			
				$speciality_one_name 		= $speciality_one->name;
				$speciality_one_term_id 	= $speciality_one->term_id;
				$speciality_one_slug 		= $speciality_one->slug;
				
				$speciality_docdoc_id	 	= get_field('Id', 'speciality_' . $speciality_one_term_id); 
			
			$speciality_array[$speciality_docdoc_id][term_id] = $speciality_one_term_id;
			$speciality_array[$speciality_docdoc_id][slug] = $speciality_one_slug;
			$speciality_array[$speciality_docdoc_id][name] = $speciality_one_name;
			
			
		}
		
		/* print_r($speciality_array); */
		
		foreach($speciality_array as $key => $value) {
			
			foreach ($speciality_to_import as $speciality_id) { 
			
				if($speciality_id == $key) {
					if (in_array($key, $speciality_to_import)) { ?>
						<option <?php if($value[slug] == $current_query_speciality) { echo "selected"; } ?> value="<?php echo $value[slug]; ?>"><?php echo $value[name]; ?></option>
					<?php } 
				}
			

			}
		}
	} ?>
		 
										
									</select>
										
								</div> 
								<div class="col-md-4">

								<div style="margin-bottom: 20px;" class="specialization-title filter-title-place"> 
									<img src="<?php bloginfo('template_url'); ?>/images/pin.png" style="height: 24px;">Месторасположение
								</div> 
									<select class="speciality-select js-states form-control speciality-select2 select-home-place" name="metro">
										<option></option>
										
					<?php foreach($metro_city_terms as $metro_city_term) { ?>
					
						<?php $current_city = get_field('Id', 'city_' . $metro_city_term->term_id); ?>
						
						<?php if($current_city == $city) { ?>
						
	<?php $metro_terms = get_terms( 'metro', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'child_of' => $metro_city_term->term_id ) ); ?>
						
							<?php foreach ( $metro_terms as $metro_term ) { ?>
								<?php $LineColor_metro = get_field('LineColor_metro', 'metro_' . $metro_term->term_id); ?>
									
			<?php $metro_term_slug = $metro_term->slug;  
			
			$metro_slug_explode = explode("_", $metro_term_slug);
			$end = end($metro_slug_explode);
				
			if(is_numeric($end)){
				continue;
			} ?>
								<option style="color: #<?php echo $LineColor_metro; ?>;" value="metroterm-<?php echo $metro_term->slug; ?>" data-color="<?php echo $LineColor_metro; ?>"><?php echo $metro_term->name; ?></option>
							<?php } ?>
						
						<?php } ?>
					<?php } ?>
						
							
						<?php foreach($district_city_terms as $district_city_term) { ?>
							
						<?php $current_city = get_field('Id_city', 'district_' . $district_city_term->term_id); ?>
						
						
						
						<?php if($current_city == $city) { ?>
						
						<?php $district_terms = get_terms( 'district', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'child_of' => $district_city_term->term_id ) ); ?>
							
								
						<?php foreach($district_terms as $district) { ?>
							<option value="districtterm-<?php echo $district->slug; ?>"><?php echo $district->name; ?></option>
						<?php } ?>
						
					
						<?php } ?>
					<?php } ?>
										
									</select>
								
								</div>
								
								<div class="col-md-4">
									<button class="filter-button btn btn-primary"> Поиск </button>
								</div>
							
							</div>
						
						</form>
						
					</div>
					</div>
				</div>