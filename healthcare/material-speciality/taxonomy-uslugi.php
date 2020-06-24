<?php get_header(); ?>
	
	<?php $curTerm 			= get_queried_object(); ?>
	<?php $curTerm_id 		= $curTerm->term_id; ?>
	<?php $term_parent 		= $curTerm->parent; ?>
	<?php $term_count 		= $curTerm->count; ?>
	
	<?php $docdoc_service_id = get_field('Id', 'uslugi_' . $curTerm_id); ?>	
	
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
		$breadcrumbs_count = 1;
        while ($tmpTerm->parent > 0){
			$tmpTerm = get_term($tmpTerm->parent, get_query_var("taxonomy"));
			$crumb = '<li><a href="' . get_term_link($tmpTerm, get_query_var('taxonomy')) . '">' . $tmpTerm->name . '</a> </li>';
			array_push($tmpCrumbs, $crumb);
        }
		/* print_r($tmpCrumbs); */
		/* $breadcrumbs = implode('', array_reverse($tmpCrumbs)); */
		$breadcrumbs_count = 1;
		/* print_r($breadcrumbs_count); */
		foreach(array_reverse($tmpCrumbs) as $breadcrumb) {
			if($breadcrumbs_count <= 2) {
				echo $breadcrumb;
			}
			$breadcrumbs_count++;
		}
		
       
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
					
					
					
				<?php $category_description = get_field('описание_категории', 'uslugi_' . $curTerm_id); ?>	
					
		<div class="container">
			<div class="row">
				
					<div class="col-md-12">
						
						<div class="themeum-title yes taxonomy tax-usugi-top">
							
							<h3 class="style-title"> <?php single_cat_title(); ?> </h3>
							<?php if($category_description or $textdescription) { ?>
								<div class="taxonomy-description"> 							
									<?php if($category_description){
										echo $category_description; 
									 } else { 
										echo $textdescription; 
									} ?> 
								</div>
							<?php } ?>
						</div>
						
					</div>
				<?php $term_children = get_term_children($curTerm_id, 'uslugi'); ?>
				
				
				
			<?php $b =2; ?>
			
	<?php $uslugi_terms = get_terms( 'uslugi', array( 'order' => 'ASC', 'parent' => $curTerm->term_id ) ); ?>
					
					<?php if(!empty($term_children)) { ?>
					<div class="clearfix"> </div>
						<div class="speciality-home-list speciality-home-list-last uslugi-tax-list">
						
							<?php foreach ( $uslugi_terms as $uslugi_term ) { ?>
								<div class="col-md-6 pad-b-15 speciality-home-one">
										<span class="speciality-number-home-wrap" style="position: absolute; right: 15px; bottom: 5px;"> 
											<span class="speciality-number-home"> <?php echo $uslugi_term->count; ?> </span> 
										</span>
									<div class="dotted" style=" padding-right: 45px;">
										<a class="broker-down-link speciality-name-home" href="<?php echo get_term_link($uslugi_term->term_id);; ?>"> <?php echo $uslugi_term->name; ?> </a> 
									</div>
								</div>
							<?php $a++; ?> 
							
					<?php $b = 3; ?>
							<?php } ?>
						</div>
						
					<?php } ?>
				
				<div class="clearfix"> </div>
				
				
				<?php if($b == 2) { ?>	
				
				<?php require_once(dirname(__FILE__).'/includes/filters/filter-uslugi.php'); ?>
					
			<div style="clear:both;"></div>
					<div class="col-md-12">
					
					
			<div class="table-responsive">
				<table class="price table-striped container-mix taxonomy-diagnostic-table table table-responsive" data-ref="mixitup-container">
   <tbody>
	<?php $diagnostic_table_name_three = get_field('текст_колонки_даиностики', 'option'); ?>
		<tr>
			<th class="th-table-title"> <h2 class="category-tax-title service-title" data-service="<?php echo $docdoc_service_id; ?>"> Клиника </h2> </th>
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
		
		<?php $clinic_id 			= $clinic_array->Id; ?>
		<?php $clinic_street 		= $clinic_array->Street; ?>
		<?php $clinic_house			= $clinic_array->House; ?>
		<?php $clinic_stations 		= $clinic_array->Stations; ?>
		<?php $Diagnostics 			= $clinic_array->Services->ServiceList; ?>
		<?php $docdoc_DistrictIds 	= $clinic_array->DistrictId; ?>
		
			<?php foreach($Diagnostics as $Diagnostic) { ?>
				<?php $diagnostic_id = $Diagnostic->ServiceId;?>
				<?php $current_diagnostic_id = get_field('Id', 'uslugi_' . $curTerm_id); ?>
				
			<?php if($diagnostic_id == $current_diagnostic_id) { ?>
				
				<?php $diagnostic_price = $Diagnostic->Price; ?>
				
			<?php } ?>
		<?php } ?>	
				<?php
						if($diagnostic_price) {
							$row_data_price_mixi_tab = $diagnostic_price;
						} else {
							$row_data_price_mixi_tab = "1000000";
						}
				?>
				
			
				<tr data-price="<?php echo $row_data_price_mixi_tab; ?>" class="item green mix">
				
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
					<td class="th-table-price-number td-block-diagnostic-price" >
					
					<?php if($diagnostic_price) { ?>
						<span class="price one-raids-price"> <?php echo $diagnostic_price; ?>&nbsp;<span class="currency">Руб.</span> </span>
						
					<?php } else { ?>	
						<span class="price one-raids-price"> Требуется уточнение </span>
					<?php } ?>
					
						<span class="table-diagnostic-order" data-id="<?php echo $clinic_id; ?>" data-price="<?php echo $diagnostic_price; ?>" data-diagnosticid="<?php echo $current_diagnostic_id; ?>" data-toggle="modal" data-target="#myModal"> Записаться </span>
					
					</td>
				 
				</tr>
			
			
			
		<?php endwhile; ?> 
	<?php endif; ?>
	
   </tbody>
</table>
					
					</div>
					</div>
					
					<?php } ?>

		<?php if($c == 3 and $b == 2) { ?>
			<div class="col-md-12">
				<span style="font-size: 22px; font-weight: bold;"> К сожалению, по вашему запросу ничего не найдено. </span>
			</div>
		<?php } ?>
				
				
				
				
				

				
				
			</div>
		</div>
				
				
				
	</div>
			
			
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog uslugi-modal">
			  <div class="modal-content">
				
				<div class="modal-header">
				
					<div class="modal-diagnostic-name-single"> <?php single_cat_title(); ?> </div>
				 
				<div class="dotted m-t-5 one-block-raids dotted-one-clinic">
						<span class="broker-down-link one-raids-link">Цена</span>
						<span class="one-raids-price-wrap">
							<span class="price one-raids-price modal-diagnostic-price-taxonomy">123</span>
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
					<div class="appointments">Заказать услугу</div>
					<?php echo do_shortcode( '[contact-form-7 id="30588" title="Заявка на услугу"]' ); ?>
					<center class="agreement-text">
Нажимая на "Отправить", вы даете <a href="<?php bloginfo('url'); ?>/agreement/"><b>согласие</b></a> на обработку своих персональных данных.
</center>  
				</div>
				
			  </div>
			</div>
		  </div>
			
			
			
<?php get_footer(); ?>