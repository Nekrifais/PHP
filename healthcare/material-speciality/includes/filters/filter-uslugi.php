		<?php $all_speciality = get_terms( 'speciality', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0 ) ); ?>
		<?php $city_terms = get_terms( 'city', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0 ) ); ?> 
		<?php $metro_city_terms = get_terms( 'metro', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) ); ?> 
		<?php $district_city_terms = get_terms( 'district', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) ); ?> 
		<?php $city = get_field('выбор_города', 'option'); ?> 
		<?php $city = array_shift( $city ); ?> 
		
		
		
				<div class="filter-uslugi">
					<div class="col-md-12">
					
					
						<div class="row">
							<!-- <div class="col-md-4">

								<div style="margin-bottom: 20px;" class="specialization-title"> 
									<img src="<?php bloginfo('template_url'); ?>/images/search.png" style="height: 24px;">Специальности 
								</div> 
								<select class="speciality-select js-states form-control speciality-select2 select-uslugi-speciality" name="speciality">
									<option></option>
									<optgroup label="Специализации врачей">
										
							<?php foreach ( $all_speciality as $tag ) { ?>
								<option value="<?php echo $tag->slug; ?>" data-icon="fa-apple"><?php echo $tag->name; ?></option>
							<?php } ?>
									</optgroup>
								</select>
									
							</div> 
							<div class="col-md-4">

							<div style="margin-bottom: 20px;" class="specialization-title"> 
								<img src="<?php bloginfo('template_url'); ?>/images/pin.png" style="height: 24px;">Месторасположение
							</div> 
								<select class="speciality-select js-states form-control speciality-select2 select-uslugi-place" name="speciality">
									<option></option>
									<optgroup label="Специализации врачей">
				<?php foreach($metro_city_terms as $metro_city_term) { ?>
				
					<?php $current_city = get_field('Id', 'city_' . $metro_city_term->term_id); ?>
					
					<?php if($current_city == $city) { ?>
					
<?php $metro_terms = get_terms( 'metro', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'child_of' => $metro_city_term->term_id ) ); ?>
					
						<?php foreach ( $metro_terms as $metro_term ) { ?>
							<?php $LineColor_metro = get_field('LineColor_metro', 'metro_' . $metro_term->term_id); ?>
							
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
									</optgroup>
								</select>
							
							</div> 
							
							
							
							<div class="col-md-8">
								<button class="filter-button btn btn-primary"> Найти </button>
							</div>-->
							
		<div class="col-md-4">
			<div class="title-mixiitup-diagnostic">
				<img src="<?php bloginfo('template_url'); ?>/images/exchange.png">Сортировка
			</div>
			<div class="controls filter-diagnostic-block-button">
				<button type="button" class="control first-mixiitup" data-mixitup-control data-sort="price:asc">Сначала дешевые</button>
				<button type="button" class="control" data-mixitup-control data-sort="price:desc">Сначала дорогие</button>
			</div>
		</div>
							
						</div>
					</div>
				</div>