				<div class="filter-tax-speciality">
					<div class="col-md-12">
					
<?php $tags = get_terms( 'speciality', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0 ) ); ?>		
<?php $city_terms = get_terms( 'city', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0 ) ); ?>		
<?php $metro_city_terms = get_terms( 'metro', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) ); ?>

<?php $district_city_terms = get_terms( 'district', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) ); ?>

<?php $current_query_speciality = $wp_query->query['speciality']; ?>
<?php $current_query_metro = $wp_query->query['metro']; ?>
<?php $current_query_district = $wp_query->query['district']; ?>

						<form action="<?php bloginfo('url'); ?>/advanced-search/" method="get">
							<div class="row">
								<div class="col-md-4">

									<div class="specialization-title"> 
										<img src="<?php bloginfo('template_url'); ?>/images/search.png" style="height: 24px;">Специальности 
									</div> 
									<select class="speciality-select js-states form-control speciality-select2 select-taxonomy-spec-speciality" name="speciality">
										<option>  </option>
										<optgroup label="Специализации врачей">

<?php $all_speciality = get_field('выгрузить_все_специальности', 'option');
	
	if($all_speciality) { ?>
					<?php foreach ( $tags as $tag ) { ?>
						<option <?php if($tag->slug == $current_query_speciality) { echo "selected"; } ?> value="<?php echo $tag->slug; ?>" data-icon="fa-apple"><?php echo $tag->name; ?></option> 
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
						<option <?php if($value[slug] == $current_query_speciality) { echo "selected"; } ?>  value="<?php echo $value[slug]; ?>"><?php echo $value[name]; ?></option>
					<?php } 
				}
			

			}
		}
	} ?>

								
										</optgroup>
									</select>
										
								</div> 
								<div class="col-md-4">
							
								<div class="specialization-title specialization-title-place"> 
									<img src="<?php bloginfo('template_url'); ?>/images/pin.png" style="height: 24px;">Месторасположение
								</div> 
									<select class="speciality-select js-states form-control speciality-select2 select-taxonomy-spec-place" name="metro">
										<option>  </option>

	<?php 
	
		$logic_download = get_field('выгрузить_все_города', 'option');
		$select_city = get_field('выбор_города', 'option');  
		
				 	
$city_terms = get_terms( 'city', array( 'order' => 'ASC', 'orderby' => 'count', 'hide_empty' => 0 ) );
		
			
	foreach($city_terms as $city_term) {
		$city_terms_term_id 	= $city_term->term_id;
		$Id_city_docdoc 		= get_field('Id', 'city_' . $city_terms_term_id);
		
		if($Id_city_docdoc == $select_city[0]) {
			$slug_select = $city_term->slug;
		}
		
	}

	
	$city_filter_option_metro = get_option('metro-filter-option'); 
	$city_filter_select_metro = $city_filter_option_metro[$slug_select]; 
	
	
	
	 foreach ( $city_filter_select_metro as $metro_term_city ) { 
		 $LineColor_metro = get_field('LineColor_metro', 'metro_' . $metro_term_city[metro_term_id]); 
			$metro_term_slug = $metro_term_city[metro_slug];  
			
			$metro_slug_explode = explode("_", $metro_term_slug);
			$end = end($metro_slug_explode);
				
			if(is_numeric($end)){
				continue;
			} ?>
		
		<option <?php if($metro_term_city[metro_slug] == $current_query_metro) { echo "selected"; } ?> style="color: #<?php echo $LineColor_metro; ?>;" value="metroterm-<?php echo $metro_term_city[metro_slug]; ?>" data-color="<?php echo $LineColor_metro; ?>"><?php echo $metro_term_city[metro_name]; ?></option>
		
		
	<?php } ?> 
		
	<?php 
	
	$city_filter_option_district = get_option('district-filter-option'); 
	$city_filter_select_district = $city_filter_option_district[$slug_select]; ?>
		
			<?php foreach($city_filter_select_district as $district) { ?>
				<option <?php if($district[district_slug] == $current_query_district) { echo "selected"; } ?> value="districtterm-<?php echo $district[district_slug]; ?>"><?php echo $district[district_name]; ?></option>
			<?php } ?>
									</select>
								
								</div>
								
								<div class="col-md-4">
									<button class="filter-button btn btn-primary"> Найти </button>
								</div>
								
		<div class="col-md-12 flipCheckbox" style="position: relative;">
		
	<?php 
		
		$wp_query_child_dom = $wp_query->query['dop'];
		if($wp_query_child_dom == "nadom"){
			$checked_dom = " checked";
		}
		if($wp_query_child_dom == "child"){
			$checked_child = " checked";
		}
		
	?>
		
			<div class="row">
			
				<div class="col-md-4">
				
					<img src="<?php bloginfo('template_url'); ?>/images/ambulance.png" style=" position: absolute; margin-left: 2px; top: 3px; pointer-events: none;">
					<input id="nadom-checkbox" style="display: none; margin-bottom: 15px;" class="addon addon-checkbox" name="dop[]"  value="nadom" type="checkbox"<?php echo $checked_dom; ?>>
					<label for="nadom-checkbox" style="left: 36px;"> 
						<span class="text-input-ckeckbox"> 
							Выезд на дом 
						</span> 
					</label>
				
				</div>
				
				<div class="col-md-4">
				
					<img src="<?php bloginfo('template_url'); ?>/images/nipple.png" style=" position: absolute; margin-left: 2px; top: 3px;">
					<input id="child-checkbox" style="display: none; margin-bottom: 15px;" class="addon addon-checkbox" name="dop[]" value="child" type="checkbox"<?php echo $checked_child; ?>>
					<label for="child-checkbox" style="left: 36px;"> 
						<span class="text-input-ckeckbox">  Детский врач </span> 
					</label>
				
				</div>
				
			</div>
			
		</div>
		

								
							</div>
						</form>
					</div>
				</div>