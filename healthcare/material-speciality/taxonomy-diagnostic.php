<?php get_header(); ?>
	
	<?php $curTerm 			= get_queried_object(); ?>
	<?php $curTerm_id 		= $curTerm->term_id; ?>
	<?php $term_parent 		= $curTerm->parent; ?>
	<?php $term_count 		= $curTerm->count; ?>
				
				
	<?php $category_description = get_field('описание_категории', 'diagnostic_' . $curTerm->term_id); ?>
		
		
				
		
		
			<section id="content_outer_wrapper">
				<div id="content_wrapper">
<?php require_once(dirname(__FILE__).'/includes/top-menu.php'); ?>
					
					<div class="custom-breadcrumb">
						<div class="container">
							<div class="row">
								<div class="col-xs-12">
									<div class="breadcrumb-list">
										<ul class="list-unstyled breadcrumb breadcrumb-custom">
											<li class="first">
												<a href="<?php bloginfo('url'); ?> "> <i class="zmdi zmdi-home"></i> Главная</a>
											</li>
											
			<?php
        $term = get_term_by("slug", get_query_var("term"), get_query_var("taxonomy") );
	
        $tmpTerm = $term;
        $tmpCrumbs = array();
        while ($tmpTerm->parent > 0){
            $tmpTerm = get_term($tmpTerm->parent, get_query_var("taxonomy"));
            $crumb = '<li> <a href="' . get_term_link($tmpTerm, get_query_var('taxonomy')) . '">' . $tmpTerm->name . '</a> </li>';
            array_push($tmpCrumbs, $crumb);
        }
        echo implode('', array_reverse($tmpCrumbs));
	/* echo '<li><a href="' . get_term_link($tmpTerm, get_query_var('taxonomy')) . '">' . $term->name . '</a></li>'; */
    ?>	
											
											<li class="last">
												<span><?php single_cat_title(); ?></span>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					
<?php
	
	$current_query_metro = $wp_query->query['metro']; 
	$current_query_district = $wp_query->query['district']; 
	
	$category_description = get_field('описание_категории', 'diagnostic_' . $curTerm_id); 
	
	if($current_query_metro) {
		
		$current_metro_term = get_term_by('slug', $current_query_metro, 'metro');
		$current_metro_term_id = $current_metro_term->term_id;
		
		$field = 'textdescription_for_diagnostic-' . $curTerm_id . '_x_metro-'  . $current_metro_term_id; 
		$textdescription = get_option($field);
		
	} elseif($current_query_district){
		
		$current_district_term = get_term_by('slug', $current_query_district, 'district');
		$current_district_term_id = $current_district_term->term_id;
		
		$field = 'textdescription_for_diagnostic-' . $curTerm_id . '_x_district-'  . $current_district_term_id; 
		$textdescription = get_option($field);
		
	} else {
		
		$field = 'single_textdescription_for_diagnostic-' . $curTerm_id; 
		$textdescription = get_option($field);
		
	}

global $seo_data_array;

	if($current_query_metro) {
		
		$current_metro_term = get_term_by('slug', $current_query_metro, 'metro');
		$current_metro_term_id = $current_metro_term->term_id;
		
		$h1 = (string) $seo_data_array[$current_metro_term_id][h1];
		$textdescription = (string) $seo_data_array[$current_metro_term_id][textdescription];
		
	} elseif($current_query_district) {
		
		$current_district_term = get_term_by('slug', $current_query_district, 'district');
		$current_district_term_id = $current_district_term->term_id;
			
		$h1 = (string) $seo_data_array[$current_district_term_id][h1];
		$textdescription = (string) $seo_data_array[$current_district_term_id][textdescription];
		
	} else {
		$field_h1 = 'single_h1_for_diagnostic-' . $curTerm_id; 
		$field_textdescription = 'single_textdescription_for_diagnostic-' . $curTerm_id; 
		$h1 = get_option($field_h1);
		$textdescription = get_option($field_textdescription);
	} ?>
					
					
		<div class="container">
			<div class="row">
				
					<div class="col-md-12">
						
						<div class="themeum-title yes taxonomy">
							
							<h3 class="style-title">
								<?php if($h1) {
									echo $h1;
								} else { 
									single_cat_title(); 
								} ?> 
							</h3>
							
							<?php if($category_description or $textdescription) { ?>
								<div class="taxonomy-description"> 
								<?php if($current_query_metro != "" or $current_query_district != ""){
									echo $textdescription; 
								 } else { 
									echo $category_description; 
								} ?>
								</div>
							
							<?php } ?>
							
							
						</div>
						
					</div>
				
				<div style="clear: both;"> </div>
				
				<?php require_once(dirname(__FILE__).'/includes/filters/filter-diagnostic.php'); ?>
				
<?php if($term_parent == 0 and $term_count > 0 or $term_parent != 0 and $term_count > 0) { ?>
					
			<div style="clear:both;"></div>
					<div class="col-md-12">
					
			<div class="table-responsive">
				<table class="price table-striped container-mix taxonomy-diagnostic-table table table-responsive" data-ref="mixitup-container">
   <tbody>
	<?php $diagnostic_table_name_three = get_field('текст_колонки_даиностики', 'option'); ?>
		<tr>
			<th class="th-table-title"> <h2 class="category-tax-title"> Клиника </h2> </th>
			<th class="tab-res th-table-title text-center"> <h2 class="category-tax-title"> Адрес Клиники </h2> </th>
			<th class="tab-res th-table-title text-center"> <h2 class="category-tax-title"> 
			<?php if($diagnostic_table_name_three) {
				echo $diagnostic_table_name_three;
			} else {
				echo "Ближайшее метро";
			} ?>
			
			</h2> </th>
			<th  class="th-table-title th-table-price"> <h2 class="category-tax-title"> Цена </h2> </th>
		</tr>
	  
	  
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
				
		<?php $clinic_array 	= get_post_meta($post->ID, "array", true); ?> 
		
		<?php $clinic_id 		= $clinic_array->Id; ?>
		<?php $clinic_street 	= $clinic_array->Street; ?>
		<?php $clinic_house		= $clinic_array->House; ?>
		<?php $clinic_stations 	= $clinic_array->Stations; ?>
		<?php $Diagnostics 		= $clinic_array->Diagnostics; ?>
		<?php $docdoc_DistrictIds 		= $clinic_array->DistrictId; ?>
		
			<?php foreach($Diagnostics as $Diagnostic) { ?>
				<?php $diagnostic_id = $Diagnostic->Id;?>
				<?php $current_diagnostic_id = get_field('Id', 'diagnostic_' . $curTerm_id); ?>
				
			<?php if($diagnostic_id == $current_diagnostic_id) { ?>
				
				<?php $diagnostic_price = $Diagnostic->Price; ?>
				
			<?php } ?>
		<?php } ?>	
		
			<tr data-price="<?php echo $diagnostic_price; ?>" class="item green mix">
	  		
				<td class="td-block-diagnostic table-clinic-name table-clinic-name-<?php echo $clinic_id; ?>" > <a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a> </td>
				<td class="tab-res td-block-diagnostic table-clinic-adress-<?php echo $clinic_id; ?>"> <?php echo $clinic_street; ?>, <?php echo $clinic_house; ?> </td>
				<td class="tab-res th-table-td-metro td-block-diagnostic table-clinic-metro-<?php echo $clinic_id; ?>"> 
		<?php $all_metro = get_terms('metro', array( 'orderby' => 'name' )); ?>
		<?php $all_district = get_terms('district', array( 'orderby' => 'name' )); ?>
		
					<?php if(count($all_metro) >= 1) { ?>
						<?php foreach($clinic_stations as $clinic_station) { ?>
							<?php $clinic_station_name 		= $clinic_station->Name; ?>
							<?php $clinic_station_LineColor = $clinic_station->LineColor; ?>
							<span class="th-table-metro-block-one">
							<i style=" color:#<?php echo $clinic_station_LineColor; ?>;" class="zmdi zmdi-circle"></i> <span class="th-table-metro-name"><?php echo $clinic_station_name; ?> </span>
						</span>
						<?php } ?>
					<?php } else { ?>
						<?php $wp_DistrictIds = wp_get_post_terms( $post->ID, 'district'); ?>
						<?php foreach($wp_DistrictIds as $wp_DistrictId){ ?>
							<span class="th-table-metro-block-one">
								<span class="th-table-metro-name"><?php echo $wp_DistrictId->name; ?> </span>
							</span>
						<?php } ?>
					<?php } ?>
				</td>
				<td class="th-table-price-number td-block-diagnostic-price">
				

				
					<span class="price one-raids-price"> <?php echo $diagnostic_price; ?>&nbsp;<span class="currency">Руб.</span> </span>
					<span class="table-diagnostic-order" data-id="<?php echo $clinic_id; ?>" data-price="<?php echo $diagnostic_price; ?>" data-diagnosticid="<?php echo $current_diagnostic_id; ?>" data-toggle="modal" data-target="#myModal"> Записаться </span>
				
					
				
				</td>
			 
			</tr>
		<?php endwhile; ?> 
	<?php endif; ?>
	
   </tbody>
</table>
					
					</div>
					</div>
					
		
		<?php $diagnostics_parent_top = get_terms( 'diagnostic', array( 'parent' => 0, 'hide_empty' => 0 ) ); ?>
			   
					<div class="col-md-12">	
						<h2 style="padding: 30px 0px;"> 
							Вас так же может заинтересовать:
						</h2> 
					</div>
					<div class="speciality-home-list">
					

		<?php foreach($diagnostics_parent_top as $diagnostic_top) { 
			$diagnostic_term_id = $diagnostic_top->term_id;
			$diagnostic_name = $diagnostic_top->name;
			
			$diagnostic_link = get_term_link($diagnostic_term_id, 'diagnostic'); 
			
			$children_term = get_term_children( $diagnostic_term_id, 'diagnostic');
			
			if(empty($children_term)) {
				$diagnostic_count = $diagnostic_top->count;
			} else { 
				$diagnostic_count = count (get_term_children( $diagnostic_term_id, 'diagnostic'));
			} ?>
			
				<div class="col-md-6 pad-b-15 speciality-home-one">
					<span class="speciality-number-home-wrap" style="position: absolute; right: 15px; bottom: 5px;"> 
						<span class="speciality-number-home"> <?php echo $diagnostic_count; ?> </span> 
					</span>
					<div class="dotted" style=" padding-right: 45px;">
						<a class="broker-down-link speciality-name-home" href="<?php echo $diagnostic_link; ?>">
							<i class="fa fa-minus home-minus" aria-hidden="true"></i> <?php echo $diagnostic_name; ?>
						</a> 
					</div>
				</div>
		<?php } ?>
					
			<div class="clear-both"> </div>
			<div class="col-md-12">
			
				<?php include(dirname(__FILE__).'/includes/call-support.php');  ?>	
			</div>
					
					<?php } else { ?>
					

					
	<?php $diagnostics_terms = get_terms( 'diagnostic', array( 'order' => 'ASC', 'parent' => $curTerm->term_id ) ); ?>
					
					<?php if($diagnostics_terms) { ?>
						<div class="speciality-home-list speciality-home-list-last" >
						
							<?php foreach ( $diagnostics_terms as $diagnostic_term ) { ?>
								<div class="col-md-6 pad-b-15 speciality-home-one">
										<span class="speciality-number-home-wrap changes-diagnostic-settings"> 
											<span class="speciality-number-home"> <?php echo $diagnostic_term->count; ?> </span> 
										</span>
									<div class="dotted" style=" padding-right: 45px;">
										<a class="broker-down-link speciality-name-home" href="<?php echo get_term_link($diagnostic_term->term_id);; ?>"> <?php echo $diagnostic_term->name; ?> </a> 
									</div>
								</div>
							<?php $a++; ?> <?php } ?>
						</div>
					<?php } else { ?>
							<div class="col-md-12">
								<span class="diagnostic-not-found"> К сожалению, по вашему запросу ничего не найдено. </span>
							</div>
					<?php } ?>
					
					<?php } ?>

					
				

				
				
			</div>
		</div>
				
				
				
	</div>
			
			
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog diagnostic-modal">
			  <div class="modal-content">
				
				<div class="modal-header">
				
					<div class="modal-diagnostic-name-single"> <?php single_cat_title(); ?> </div>
				 
				<div class="dotted m-t-5 one-block-raids dotted-one-clinic">
						<span class="broker-down-link one-raids-link">Цена</span>
						<span class="one-raids-price-wrap">
							<span class="price one-raids-price modal-diagnostic-price-taxonomy"></span>
						</span>
					</div>
					
					<div class="clear-both"> </div>
					
			<div class="adress-clinic">
				
				<div class="adress-clinic-one">
				
					<a class="adress-clinic-one-link" href="#"> </a>
					<div class="street"></div>	
						<div class="clear-both"> </div>

						<span class="metro-all"> </span>

				</div>
		
				<div class="clear-both"> </div>
			
			</div>
			
				</div>
				<div class="clear-both"> </div>
					
				<div class="modal-footer">
					<div class="appointments">Заказать диагностику</div>
					<?php echo do_shortcode( '[contact-form-7 id="1376" title="Диагностика"]' ); ?>
					<center class="agreement-text">
Нажимая на "Отправить", вы даете <a href="<?php bloginfo('url'); ?>/agreement/"><b>согласие</b></a> на обработку своих персональных данных.
</center>  
				</div>
				
			  </div>
			</div>
		  </div>
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
<?php get_footer(); ?>