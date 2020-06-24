		
		
		
		<?php $metro_city_terms = get_terms( 'metro', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) ); ?> 
		<?php $district_city_terms = get_terms( 'district', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) ); ?> 
		<?php $city = get_field('выбор_города', 'option'); ?> 
		<?php $city = array_shift( $city ); ?> 
		<?php $tags = get_terms( 'diagnostic', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0) ); ?>
		
		
		
		<?php $current_query_diagnostic = $wp_query->query['diagnostic']; ?>
		<?php $current_query_metro = $wp_query->query['metro']; ?>
		<?php $current_query_district = $wp_query->query['district']; ?>
		
				<div class="filter-diagnostic">
					<div class="col-md-12">
					
						<form action="<?php bloginfo('url'); ?>/advanced-diagnostic-search/" method="get">
							<div class="row">
								<div class="col-md-4">

									<div class="specialization-title"> 
										<img src="<?php bloginfo('template_url'); ?>/images/search.png" style="height: 24px;">Диагностика 
									</div> 
									
									<select class="speciality-select js-states form-control speciality-select2 select-diagnostic-speciality" name="diagnostic">
										<option></option>
									<?php foreach ( $tags as $tag ) { ?> 
		<?php $term_children = get_term_children( $tag->term_id, 'diagnostic' ); ?>					
							<?php $count = $tag->count; ?>							
							<?php if(!empty($term_children)) { ?>							
							<optgroup label="<?php echo $tag->name; ?>">
							<?php $diagnostics_terms = get_terms( 'diagnostic', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'child_of' => $tag->term_id ) ); ?>						
								<?php foreach($diagnostics_terms as $diagnostic_term){ ?>
									<option <?php if($diagnostic_term->slug == $current_query_diagnostic) { echo "selected"; } ?> value="<?php echo $diagnostic_term->slug; ?>" data-icon="fa-apple"><?php echo $diagnostic_term->name; ?></option>
								<?php } ?>							
							</optgroup>						
								<?php } else {  ?>					
									<option <?php if($tag->slug == $current_query_diagnostic) { echo "selected"; } ?> value="<?php echo $tag->slug; ?>"> <?php echo $tag->name; ?></option>							
								<?php } ?>							
								<?php } ?>
									</select>
										
								</div> 
								
								<div class="col-md-4">

								<div class="specialization-title specialization-title-place"> 
									<img src="<?php bloginfo('template_url'); ?>/images/pin.png" style="height: 24px;">Месторасположение
								</div> 
								
									<select class="speciality-select js-states form-control speciality-select2 select-diagnostic-place" name="metro">
										<option></option>
										<optgroup label="Специализации врачей">
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
										</optgroup>
									</select>
								
								</div>
								
					<?php $curTerm_diagnostic 	= get_queried_object(); ?>
					<?php $term_parent 			= $curTerm_diagnostic->parent; ?>
					<?php $term_count 			= $curTerm_diagnostic->count; ?>		
					
			<?php if($term_parent == 0 and $term_count > 0 or $term_parent != 0 and $term_count > 0) { ?> 
				
				<div class="col-md-4">
					<div class="title-mixiitup-diagnostic tax-diagnostic-title-mixiitup-diagnostic">
						<img src="<?php bloginfo('template_url'); ?>/images/exchange.png">Сортировка
					</div>
					<div class="controls filter-diagnostic-block-button">
						<button type="button" class="control first-mixiitup" data-mixitup-control data-sort="price:asc">Сначала дешевые</button>
						<button type="button" class="control" data-mixitup-control data-sort="price:desc">Сначала дорогие</button>
					</div>
				</div>
				
			<?php } ?>
								<div class="col-md-8">
									<button class="filter-button btn btn-primary"> Найти </button>
								</div>
								
							</div>
						
						</form>
						
					</div>
				</div>
				
				
				