<?php function table_medic_shortcode( $atts, $content = null){
	
	$a = shortcode_atts(
		array(
			'id'	=> '',
			'number'	=> 7,
		), $atts
	);
	
ob_start(); ?>
			<div class="table-responsive">
			
				<?php require_once(dirname(__FILE__).'/filters/filter-shortcode-medic.php'); ?>
			
			<table class="price table-striped container-mix taxonomy-diagnostic-table shortcode-table-medic" data-ref="mixitup-container" style="width: 100%;">
		
		<?php $shortcode_term = get_term_by('id', $a[id], 'speciality'); ?>
		<?php $shortcode_term_link = get_term_link( $shortcode_term->term_id ); ?>
		
		
		
   <tbody>
	<?php $diagnostic_table_name_three = get_field('текст_колонки_даиностики', 'option'); ?>
		<tr>
			<th class="th-table-title"> <h2 class="category-tax-title"> Врач </h2> </th>
			<th class="tab-res th-table-title text-center"> <h2 class="category-tax-title"> Рейтинг </h2> </th>
			<th class="tab-res th-table-title text-center"> <h2 class="category-tax-title"> 
			<?php if($diagnostic_table_name_three) {
				echo $diagnostic_table_name_three;
			} else {
				echo "Ближайшее метро";
			} ?>
			
			</h2> </th>
			<th  class="th-table-title th-table-price"> <h2 class="category-tax-title"> Подробнее </h2> </th>
		</tr>
		
	<?php 
	
			/* 'orderby' => 'rand', */
			
			$args = array(
				'posts_per_page' => $a[number],
				'post_type' => 'medic',
				'orderby' => 'meta_value_num',
				'meta_key' => 'Rating',
				'tax_query' => array(
					array(
						'taxonomy' => 'speciality',
						'field'    => 'term_id',
						'terms'    => $a[id],
					),
				),
			);
			
			$recent = new WP_Query( $args );
			while($recent->have_posts()) : $recent->the_post(); 
			
				$currentshortcode_medic_id = get_the_id();
			
				$post_thumbnail_id = get_post_thumbnail_id( $currentshortcode_medic_id ); 
				if($post_thumbnail_id) { 
					$post_thumbnail_url = lazy_image_size($post_thumbnail_id, 64, 64, 1); 
					$current_image = $post_thumbnail_url[0]; 
				} else { 
					$current_image = "http://placehold.it/64x64";
				}
			
				$current_title 		= get_the_title($currentshortcode_medic_id); 
				$pieces_title 		= explode(" ", $current_title); 
			
				$wp_MetroIds 		= wp_get_post_terms( $currentshortcode_medic_id, 'metro'); 
				$wp_clinics_ids 	= get_post_meta($currentshortcode_medic_id, "wp_clinics_ids", true);
				
				
				
				$medic_array 		= get_post_meta($currentshortcode_medic_id, "array", true);
				
					$Rating 			= $medic_array->Rating; 
					$rating_percent 	= ($Rating / 5) * 100; 
					$Price 				= $medic_array->Price;
					$SpecialPrice 		= $medic_array->SpecialPrice;
					
					
			?>
			
			
			
				<tr data-price="<?php echo $diagnostic_price; ?>" class="item green mix string-medic-shortcode">
					
					<td class="td-block-diagnostic table-clinic-name shortcode-medic-first"> 
						
						<img src="<?php echo $current_image; ?>"> 
						
						<a class="shortcode-medic-title" href="<?php the_permalink(); ?>"> 
							<div> <?php echo $pieces_title[0]; ?> </div> 
								<?php $a=1; foreach($pieces_title as $piece_title) {
										if($a != 1) {
											echo $piece_title . ' ';
										} $a++; } ?>  
						</a> 
						
					</td>
					
					
					
		<td class="tab-res td-block-diagnostic medic-shortcode-rating"> 
			
			<div class=" pull-left rating-block-title-clinic-speciality"> <span class="number-reviews-all"><?php echo round($Rating, 2); ?></span></div>
			<div class="star-ratings-css star-ratings-css-clinic"> 
				<div class="star-ratings-css-top" style="width: <?php echo $rating_percent; ?>%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
				<div class="star-ratings-css-bottom"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
			</div> 
			
		</td>
			<td class="tab-res th-table-td-metro td-block-diagnostic table-clinic-metro"> 
	<?php foreach ($wp_MetroIds as $wp_MetroId ) { 
			$LineColor_metro = get_field('LineColor_metro', 'metro_' . $wp_MetroId->term_id);
			$clinic_station_name 		= $wp_MetroId->name; ?>
		<div class="metro-one">
	<i style="color:#<?php echo $LineColor_metro; ?>;" class="zmdi zmdi-circle"></i> <?php echo $clinic_station_name; ?> 
		</div>
		
	<?php } ?>
			</td>
			
			<td class="th-table-price-number td-block-diagnostic-price shortcode-medic-link-info">
				
				<a class="shortcode-medic-link" href="<?php the_permalink(); ?>"> Записаться </a> 
				
			</td>
				
				</tr>
			<?php endwhile; ?>
			   </tbody>
</table>



	
	
</div> 
	
	<div class="shortcode-medic-view-all pull-right"> 
		<a href="<?php echo $shortcode_term_link; ?>"> 
			Смотреть всех врачей по специальности <span>«<?php echo $shortcode_term->name; ?>» </span> (<?php echo $shortcode_term->count; ?>) <i class="zmdi zmdi-long-arrow-right"></i>
		</a> 
	</div>
	
<?php 

	$page = ob_get_contents();
	ob_end_clean();
	return $page; 
}

add_shortcode( 'table_medic', 'table_medic_shortcode' ); 
/* 
function diagnostic_shortcode( $atts, $content = null){
ob_start(); ?>

 <?php $diagnostics_terms = get_terms( 'diagnostic', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0 ) ); ?>
<?php $diagnostics_terms_array = array('mrt', 'uzi', 'komputernaya-tomografiya', 'dupleksnoe-skanirovanie', 'rentgen'); ?>

				<div class="row speciality-home-list speciality-home-list-last" >
<?php foreach ( $diagnostics_terms as $diagnostic_term ) { ?>
			<?php $diagnostic_term_name = $diagnostic_term->name; ?>
			
			<?php $diagnostic_term_name_parts = explode(" ", $diagnostic_term_name); ?>
			
					
					<?php $diagnostic_term_slug = $diagnostic_term->slug; ?>
					
					<?php if( in_array($diagnostic_term_slug, $diagnostics_terms_array) ){ ?>
						<?php $current_parent_term_id = $diagnostic_term->term_id; 
						$parent_diagnostic_name = $diagnostic_term_name; ?>

						
					<div class="col-md-12">	
						<h2 style='padding: 30px 0px; font-family: "Open Sans", sans-serif;'> 
					
							<a class="title-diagnostic-parts" href="<?php echo get_term_link($diagnostic_term); ?>"><?php echo $diagnostic_term_name; ?></a>
						
						</h2> 
					</div>
					
					
					<?php } else { ?>
						<?php $current_parent = $diagnostic_term->parent; ?>
							<?php if($current_parent == $current_parent_term_id and $current_parent_term_id != "") {
$diagnostic_name = $diagnostic_term->name;
$string = 'УЗИ менять';
$pattern = '/' . preg_quote($parent_diagnostic_name, '/') . '/';
$replacement = '';

$diagnostic_name =  preg_replace($pattern, $replacement, $diagnostic_name);
$diagnostic_name = trim($diagnostic_name);
$diagnostic_name = upFirstLetter($diagnostic_name);


							?>
						<div class="col-md-6 pad-b-15 speciality-home-one">
								<span class="speciality-number-home-wrap" style="position: absolute; right: 15px; bottom: 5px;"> 
									<span class="speciality-number-home"> <?php echo $diagnostic_term->count; ?> </span> 
								</span>
							<div class="dotted" style=" padding-right: 45px;">
								
								<a class="broker-down-link speciality-name-home" href="<?php echo get_term_link($diagnostic_term->term_id); ?>">
									<i class="zmdi zmdi-minus diagnostic-minus"> </i>
									<?php echo $diagnostic_name; ?> 
								</a> 
							</div>
						</div>
						
						<?php } ?>
					<?php } ?>
						
<?php $a++; ?> <?php } ?>
				
				</div>
				
				
				<div class="row speciality-home-list speciality-home-list-last" >
					<div class="col-md-12">
						<h2 style="padding: 0px 0px 30px;"> Прочая диагностика </h2>
					</div>
					
<?php foreach ( $diagnostics_terms as $diagnostic_term ) { ?>
					
					<?php $diagnostic_term_slug = $diagnostic_term->slug; ?>
					
					<?php if( in_array($diagnostic_term_slug, $diagnostics_terms_array) ){ ?>
						
						<?php $current_parent_term_id = $diagnostic_term->term_id; ?>
						
					<?php } else { ?>
						<?php $current_parent = $diagnostic_term->parent; ?>
							<?php if($current_parent != $current_parent_term_id) { ?>
						<div class="col-md-6 pad-b-15 speciality-home-one">
								<span class="speciality-number-home-wrap" style="position: absolute; right: 15px; bottom: 5px;"> 
									<span class="speciality-number-home"> <?php echo $diagnostic_term->count; ?> </span> 
								</span>
							<div class="dotted" style=" padding-right: 45px;">
								<a class="broker-down-link speciality-name-home" href="<?php echo get_term_link($diagnostic_term->term_id);; ?>"> <?php echo $diagnostic_term->name; ?> </a> 
							</div>
						</div>
						
						<?php } ?>
					<?php } ?>
						
<?php $a++; ?> <?php } ?>
			
				</div>	
	
	
	<?php 

	$page = ob_get_contents();
	ob_end_clean();
	return $page; 
}

add_shortcode( 'diagnostic', 'diagnostic_shortcode' );  */





function table_clinic_shortcode( $atts, $content = null){
	$a = shortcode_atts(
		array(
			'id'	=> '',
			'number'	=> 7,
		), $atts
	);
ob_start(); ?>

	<div class="table-responsive">
			
			
			
			<table class="price table-striped container-mix taxonomy-diagnostic-table shortcode-table-medic" data-ref="mixitup-container" style="width: 100%;">
			
   <tbody>
	<?php $diagnostic_table_name_three = get_field('текст_колонки_даиностики', 'option'); ?>
		<tr>
			<th class="th-table-title"> <h2 class="category-tax-title"> Врач </h2> </th>
			<th class="tab-res th-table-title text-center"> <h2 class="category-tax-title"> Рейтинг </h2> </th>
			<th class="tab-res th-table-title text-center"> <h2 class="category-tax-title"> 
			<?php if($diagnostic_table_name_three) {
				echo $diagnostic_table_name_three;
			} else {
				echo "Ближайшее метро";
			} ?>
			
			</h2> </th>
			<th  class="th-table-title th-table-price"> <h2 class="category-tax-title"> Подробнее </h2> </th>
		</tr>
		
	<?php 
		
			/* 'orderby' => 'rand', */
			
			$args = array(
				'posts_per_page' => $a[number],
				'post_type' => 'clinic',
				'tax_query' => array(
					array(
						'taxonomy' => 'clinic-speciality',
						'field'    => 'term_id',
						'terms'    => $a[id],
					),
				), 
			);
			
			$recent = new WP_Query( $args );
			while($recent->have_posts()) : $recent->the_post(); 
			
				$currentshortcode_medic_id = get_the_id();
			
				$post_thumbnail_id = get_post_thumbnail_id( $currentshortcode_medic_id ); 
				if($post_thumbnail_id) { 
					$post_thumbnail_url = lazy_image_size($post_thumbnail_id, 64, 64, 1); 
					$current_image = $post_thumbnail_url[0]; 
				} else { 
					$current_image = "http://placehold.it/64x64";
				}
			
				$current_title 		= get_the_title($currentshortcode_medic_id); 
				$pieces_title 		= explode(" ", $current_title); 
			
				$wp_MetroIds 		= wp_get_post_terms( $currentshortcode_medic_id, 'metro'); 
				$wp_clinics_ids 	= get_post_meta($currentshortcode_medic_id, "wp_clinics_ids", true);
				
				
				
				$medic_array 		= get_post_meta($currentshortcode_medic_id, "array", true);
				
					$Rating 			= $medic_array->Rating; 
					$rating_percent 	= ($Rating / 5) * 100; 
					$Price 				= $medic_array->Price;
					$SpecialPrice 		= $medic_array->SpecialPrice;
					
					
			?>
			
			
			
				<tr data-price="<?php echo $diagnostic_price; ?>" class="item green mix string-medic-shortcode">
					
					<td class="td-block-diagnostic table-clinic-name shortcode-medic-first"> 
						
						<img src="<?php echo $current_image; ?>"> 
						
						<a class="shortcode-medic-title" href="<?php the_permalink(); ?>"> 
							<div> <?php the_title(); ?> </div> 
						</a> 
						
					</td>
					
					
					
		<td class="tab-res td-block-diagnostic medic-shortcode-rating"> 
			
			<div class=" pull-left rating-block-title-clinic-speciality"> <span class="number-reviews-all"><?php echo round($Rating, 2); ?></span></div>
			<div class="star-ratings-css star-ratings-css-clinic"> 
				<div class="star-ratings-css-top" style="width: <?php echo $rating_percent; ?>%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
				<div class="star-ratings-css-bottom"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
			</div> 
			
		</td>
			<td class="tab-res th-table-td-metro td-block-diagnostic table-clinic-metro"> 
	<?php foreach ($wp_MetroIds as $wp_MetroId ) { 
			$LineColor_metro = get_field('LineColor_metro', 'metro_' . $wp_MetroId->term_id);
			$clinic_station_name 		= $wp_MetroId->name; ?>
		<div class="metro-one">
	<i style="color:#<?php echo $LineColor_metro; ?>;" class="zmdi zmdi-circle"></i> <?php echo $clinic_station_name; ?> 
		</div>
		
	<?php } ?>
			</td>
			
			<td class="th-table-price-number td-block-diagnostic-price shortcode-medic-link-info">
				
				<a class="shortcode-medic-link" href="<?php the_permalink(); ?>"> Записаться </a> 
				
			</td>
				
				</tr>
			<?php endwhile; ?>
			   </tbody>
</table>
</div> 
		
	
	
	<?php 

	$page = ob_get_contents();
	ob_end_clean();
	return $page; 
}

add_shortcode( 'table_clinic', 'table_clinic_shortcode' );



function table_diagnostic_shortcode( $atts, $content = null){
	
	$a = shortcode_atts(
		array(
			'id'	=> '',
			'number'	=> 7,
		), $atts
	);
	
ob_start(); ?>
	
		<?php $shortcode_term = get_term_by('id', $a[id], 'diagnostic'); ?>
		<?php $shortcode_term_link = get_term_link( $shortcode_term->term_id ); ?>
	
	
	<div class="table-responsive">
		
			<div style="font-family: 'Open Sans Condensed', sans-serif; font-size: 36px; line-height: 42px; margin: 10px 0px 20px;"> <?php echo $shortcode_term->name; ?> </div>
			
			<table class="price table-striped container-mix taxonomy-diagnostic-table shortcode-table-medic shortcode-table-diagnostic" data-ref="mixitup-container" style="width: 100%;">
			
   <tbody>
	<?php $diagnostic_table_name_three = get_field('текст_колонки_даиностики', 'option'); ?>
		<tr>
			<th class="th-table-title"> <h2 class="category-tax-title"> Клиника </h2> </th>
			<th class="tab-res th-table-title text-center"> <h2 class="category-tax-title"> Рейтинг </h2> </th>
			<th class="tab-res th-table-title text-center"> <h2 class="category-tax-title"> 
			<?php if($diagnostic_table_name_three) {
				echo $diagnostic_table_name_three;
			} else {
				echo "Ближайшее метро";
			} ?>
			
			</h2> </th>
			<th  class="th-table-title th-table-price"> <h2 class="category-tax-title"> Цена </h2> </th>
		</tr>
		
	<?php 
		
			/* 'orderby' => 'rand', */
			$diagnostic_shortcode_docdoc_id = get_field('Id', 'diagnostic_' . $a[id]);
			
			$args = array(
				'posts_per_page' => $a[number],
				'post_type' => 'clinic',
				'tax_query' => array(
					array(
						'taxonomy' => 'diagnostic',
						'field'    => 'term_id',
						'terms'    => $a[id],
					),
				), 
			);
			
			$b=0;
			
			$recent = new WP_Query( $args );
			while($recent->have_posts()) : $recent->the_post(); 
			
				$currentshortcode_clinic_id = get_the_id();
			
				$clinic_array = get_post_meta($currentshortcode_clinic_id, "array", true);
				
				$clinic_id 		= $clinic_array->Id;
				$clinic_street 	= $clinic_array->Street; 
				$clinic_house		= $clinic_array->House; 
				$clinic_stations 	= $clinic_array->Stations;
				
				
				$diagnostic_array = $clinic_array->Diagnostics;
				
				foreach($diagnostic_array as $clinic_diagnostic) { 
						
						
					$clinic_diagnostic_name = $clinic_diagnostic->Name;
					$clinic_diagnostic_id = $clinic_diagnostic->Id;
					$clinic_diagnostic_price = $clinic_diagnostic->Price;
					$clinic_diagnostic_special_price = $clinic_diagnostic->SpecialPrice;
					
					if($diagnostic_shortcode_docdoc_id == $clinic_diagnostic_id){
						
						$shortcode_diagnostic_array[clinic_diagnostic_name][$b] = $clinic_diagnostic_name;
						$shortcode_diagnostic_array[clinic_diagnostic_id][$b] = $clinic_diagnostic_id;
						$shortcode_diagnostic_array[clinic_diagnostic_price][$b] = $clinic_diagnostic_price;
						$shortcode_diagnostic_array[clinic_diagnostic_special_price][$b] = $clinic_diagnostic_special_price;
						
						
					}
				}
				
				
				$current_diagnostic_id = $shortcode_diagnostic_array[clinic_diagnostic_id][$b];
				
				if($shortcode_diagnostic_array[clinic_diagnostic_special_price][$b]) {
					$diagnostic_price = $shortcode_diagnostic_array[clinic_diagnostic_special_price][$b];
				} else {
					$diagnostic_price = $shortcode_diagnostic_array[clinic_diagnostic_price][$b];
				}
				
				
				$post_thumbnail_id = get_post_thumbnail_id( $currentshortcode_clinic_id ); 
				if($post_thumbnail_id) { 
					$post_thumbnail_url = lazy_image_size($post_thumbnail_id, 86, 86, 0); 
					$current_image = $post_thumbnail_url[0]; 
				} else { 
					$current_image = "http://placehold.it/64x64";
				}
			
				$current_title 		= get_the_title($currentshortcode_clinic_id); 
				$pieces_title 		= explode(" ", $current_title); 
			
				$wp_MetroIds 		= wp_get_post_terms( $currentshortcode_clinic_id, 'metro'); 
				$wp_clinics_ids 	= get_post_meta($currentshortcode_clinic_id, "wp_clinics_ids", true);
				
				
				
				$medic_array 		= get_post_meta($currentshortcode_clinic_id, "array", true);
				
					$Rating 			= $medic_array->Rating; 
					$rating_percent 	= ($Rating / 5) * 100; 
					$Price 				= $medic_array->Price;
					$SpecialPrice 		= $medic_array->SpecialPrice;
					
					
			?>
		
			
			
			
			
			
			
				<tr data-price="<?php echo $diagnostic_price; ?>" class="item green mix string-medic-shortcode">
					
					<td class="td-block-diagnostic table-clinic-name shortcode-medic-first"> 
						
						<img src="<?php echo $current_image; ?>"> 
						
						<a class="shortcode-medic-title" href="<?php the_permalink(); ?>"> 
							<div> <?php the_title(); ?> </div> 
						</a> 
						<div style="clear: both;"> </div>
						<div class="table-clinic-adress-<?php echo $clinic_id; ?> m-t-10"> 
							<i class="zmdi zmdi-pin"></i> <?php echo $clinic_street; ?>, <?php echo $clinic_house; ?> 
						</div>
						
					</td>
					
		<td class="tab-res td-block-diagnostic medic-shortcode-rating"> 


		
			
			<div class=" pull-left rating-block-title-clinic-speciality"> <span class="number-reviews-all"><?php echo round($Rating, 2); ?></span></div>
			<div class="star-ratings-css star-ratings-css-clinic"> 
				<div class="star-ratings-css-top" style="width: <?php echo $rating_percent; ?>%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
				<div class="star-ratings-css-bottom"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
			</div> 
			
		</td>
			<td class="tab-res th-table-td-metro td-block-diagnostic table-clinic-metro table-clinic-metro-<?php echo $clinic_id; ?>"> 
	<?php foreach ($wp_MetroIds as $wp_MetroId ) { 
			$LineColor_metro = get_field('LineColor_metro', 'metro_' . $wp_MetroId->term_id);
			$clinic_station_name 		= $wp_MetroId->name; ?>
		<div class="metro-one">
	<i style="color:#<?php echo $LineColor_metro; ?>;" class="zmdi zmdi-circle"></i> <?php echo $clinic_station_name; ?> 
		</div>
		
	<?php } ?>
			</td>
			
			<td class="th-table-price-number td-block-diagnostic-price shortcode-medic-link-info">
				
				
				<span class="price one-raids-price"> <?php echo $diagnostic_price; ?>&nbsp;<span class="currency">Руб.</span> </span>
				
	<span class="table-diagnostic-order" data-id="<?php echo $clinic_id; ?>" data-price="<?php echo $diagnostic_price; ?>" data-diagnosticid="<?php echo $current_diagnostic_id; ?>" data-toggle="modal" data-target="#myModal"> Записаться </span>
					
					
					
					
			</td>
				
				</tr>
			<?php $b++; endwhile; ?>
			   </tbody>
</table>
</div> 

	<div class="shortcode-medic-view-all pull-right"> 
		<a href="<?php echo $shortcode_term_link; ?>"> 
			Смотреть всех диагностик по направлению <span>«<?php echo $shortcode_term->name; ?>» </span> (<?php echo $shortcode_term->count; ?>) <i class="zmdi zmdi-long-arrow-right"></i>
		</a> 
	</div>	
	
	
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog diagnostic-modal">
			  <div class="modal-content">
				
				<div class="modal-header">
				
					<div class="modal-diagnostic-name-single"> <?php echo $shortcode_term->name; ?> </div>
				 
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
				</div>
				
			  </div>
			</div>
		</div>
	
	
	<?php 

	$page = ob_get_contents();
	ob_end_clean();
	return $page; 
}

add_shortcode( 'table_diagnostic', 'table_diagnostic_shortcode' );




function table_uslugi_shortcode( $atts, $content = null){
	
	$a = shortcode_atts(
		array(
			'id'	=> '',
			'number'	=> 7,
		), $atts
	);
	
ob_start(); ?>
	
		<?php $shortcode_term = get_term_by('id', $a[id], 'uslugi'); ?>
		<?php $shortcode_term_link = get_term_link( $shortcode_term->term_id ); ?>
	
	
	<div class="table-responsive">
	
			<div style="font-family: 'Open Sans Condensed', sans-serif; font-size: 36px; line-height: 42px; margin: 10px 0px 20px;"> <?php echo $shortcode_term->name; ?> </div>
			 
			<table class="price table-striped container-mix taxonomy-diagnostic-table shortcode-table-medic shortcode-table-diagnostic" data-ref="mixitup-container" style="width: 100%;">
			
   <tbody>
	<?php $diagnostic_table_name_three = get_field('текст_колонки_даиностики', 'option'); ?>
		<tr>
			<th class="th-table-title"> <h2 class="category-tax-title"> Клиника </h2> </th>
			<th class="tab-res th-table-title text-center"> <h2 class="category-tax-title"> Рейтинг </h2> </th>
			<th class="tab-res th-table-title text-center"> <h2 class="category-tax-title"> 
			<?php if($diagnostic_table_name_three) {
				echo $diagnostic_table_name_three;
			} else {
				echo "Ближайшее метро";
			} ?>
			
			</h2> </th>
			<th  class="th-table-title th-table-price"> <h2 class="category-tax-title"> Цена </h2> </th>
		</tr>
		
	<?php 
		
			/* 'orderby' => 'rand', */
			$uslugi_shortcode_docdoc_id = get_field('Id', 'uslugi_' . $a[id]);
			
			$args = array(
				'posts_per_page' => 7,
				'post_type' => 'clinic',
				'tax_query' => array(
					array(
						'taxonomy' => 'uslugi',
						'field'    => 'term_id',
						'terms'    => $a[id],
					),
				), 
			);
			
			$b=0;
			
			$recent = new WP_Query( $args );
			while($recent->have_posts()) : $recent->the_post(); 
			
				$currentshortcode_clinic_id = get_the_id();
			
				$clinic_array = get_post_meta($currentshortcode_clinic_id, "array", true);
				
				$clinic_id 		= $clinic_array->Id;
				$clinic_street 	= $clinic_array->Street; 
				$clinic_house		= $clinic_array->House; 
				$clinic_stations 	= $clinic_array->Stations;
				
				$service_array = $clinic_array->Services->ServiceList;
				
				foreach($service_array as $clinic_service) { 
						
						$clinic_service_name = $clinic_service->ServiceName;
						$clinic_service_id = $clinic_service->ServiceId;
						$clinic_service_price = $clinic_service->Price;
						$clinic_service_special_price = $clinic_service->SpecialPrice;
						
						
						if($uslugi_shortcode_docdoc_id == $clinic_service_id){
							
							$uslugi_array[clinic_service_name][$b] = $clinic_service_name;
							$uslugi_array[clinic_service_id][$b] = $clinic_service_id;
							$uslugi_array[clinic_service_price][$b] = $clinic_service_price;
							$uslugi_array[clinic_service_special_price][$b] = $clinic_service_special_price;
							
						}
						
						
					} 
	
				$current_service_id = $uslugi_array[clinic_service_id][$b];
				
				if($uslugi_array[clinic_service_special_price][$b]) {
					$uslugi_price = $uslugi_array[clinic_service_special_price][$b];
				} else {
					$uslugi_price = $uslugi_array[clinic_service_price][$b];
				}
				
				
				$post_thumbnail_id = get_post_thumbnail_id( $currentshortcode_clinic_id ); 
				if($post_thumbnail_id) { 
					$post_thumbnail_url = lazy_image_size($post_thumbnail_id, 86, 86, 0); 
					$current_image = $post_thumbnail_url[0]; 
				} else { 
					$current_image = "http://placehold.it/64x64";
				}
			
				$current_title 		= get_the_title($currentshortcode_clinic_id); 
				$pieces_title 		= explode(" ", $current_title); 
			
				$wp_MetroIds 		= wp_get_post_terms( $currentshortcode_clinic_id, 'metro'); 
				$wp_clinics_ids 	= get_post_meta($currentshortcode_clinic_id, "wp_clinics_ids", true);
				
				
				
				$medic_array 		= get_post_meta($currentshortcode_clinic_id, "array", true);
				
					$Rating 			= $medic_array->Rating; 
					$rating_percent 	= ($Rating / 5) * 100; 
					$Price 				= $medic_array->Price;
					$SpecialPrice 		= $medic_array->SpecialPrice;
					
					
			?>
		
			
				<tr data-price="<?php echo $uslugi_price; ?>" class="item green mix string-medic-shortcode">
					
					<td class="td-block-diagnostic table-clinic-name shortcode-medic-first"> 
						
						<img src="<?php echo $current_image; ?>"> 
						
						<a class="shortcode-medic-title" href="<?php the_permalink(); ?>"> 
							<div> <?php the_title(); ?> </div> 
						</a> 
						<div style="clear: both;"> </div>
						<div class="table-clinic-adress-<?php echo $clinic_id; ?> m-t-10"> 
							<i class="zmdi zmdi-pin"></i> <?php echo $clinic_street; ?>, <?php echo $clinic_house; ?> 
						</div>
						
					</td>
					
					
					
		<td class="tab-res td-block-diagnostic medic-shortcode-rating"> 


		
			
			<div class=" pull-left rating-block-title-clinic-speciality"> <span class="number-reviews-all"><?php echo round($Rating, 2); ?></span></div>
			<div class="star-ratings-css star-ratings-css-clinic"> 
				<div class="star-ratings-css-top" style="width: <?php echo $rating_percent; ?>%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
				<div class="star-ratings-css-bottom"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
			</div> 
			
		</td>
			<td class="tab-res th-table-td-metro td-block-diagnostic table-clinic-metro table-clinic-metro-<?php echo $clinic_id; ?>"> 
	<?php foreach ($wp_MetroIds as $wp_MetroId ) { 
			$LineColor_metro = get_field('LineColor_metro', 'metro_' . $wp_MetroId->term_id);
			$clinic_station_name 		= $wp_MetroId->name; ?>
		<div class="metro-one">
	<i style="color:#<?php echo $LineColor_metro; ?>;" class="zmdi zmdi-circle"></i> <?php echo $clinic_station_name; ?> 
		</div>
		
	<?php } ?>
			</td>
			
			<td class="th-table-price-number td-block-diagnostic-price shortcode-medic-link-info">
				
				
				<span class="price one-raids-price"> <?php echo $uslugi_price; ?>&nbsp;<span class="currency">Руб.</span> </span>
				
	<span class="table-diagnostic-order table-uslugi-order" data-id="<?php echo $clinic_id; ?>" data-price="<?php echo $uslugi_price; ?>" data-servicecid="<?php echo $current_service_id; ?>" data-toggle="modal" data-target="#myModal"> Записаться </span>
					
					
					
					
			</td>
				
				</tr>
			<?php $b++; endwhile; ?>
			   </tbody>
</table>
</div> 

	<div class="shortcode-medic-view-all pull-right"> 
		<a href="<?php echo $shortcode_term_link; ?>"> 
			Смотреть все услуги по направлению <span>«<?php echo $shortcode_term->name; ?>» </span> (<?php echo $shortcode_term->count; ?>) <i class="zmdi zmdi-long-arrow-right"></i>
		</a> 
	</div>	
	
	
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog diagnostic-modal">
			  <div class="modal-content">
				
				<div class="modal-header">
				
					<div class="modal-diagnostic-name-single"> <?php echo $shortcode_term->name; ?> </div>
				 
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
					<div class="appointments">Заказать услугу</div>
					<?php echo do_shortcode( '[contact-form-7 id="212" title="Заявка на услугу"]' ); ?>
				</div>
				
			  </div>
			</div>
		</div>
	
	
	<?php 

	$page = ob_get_contents();
	ob_end_clean();
	return $page; 
}

add_shortcode( 'table_uslugi', 'table_uslugi_shortcode' );



function medic_speciality_shortcode( $atts, $content = null){
	
ob_start(); 
$specialities = get_terms( 'speciality', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0 ) );	
?>	
	
					<div class="col-md-12">
					
						<div style="margin: 30px 0px;">
						
							<h2 style="text-align: center; font-size: 50px; font-family: 'Open Sans Condensed', sans-serif; margin-top: 45px; margin-bottom: 80px;"> Направления врачей (запись на прием к платным врачам Москвы) </h2>
						
						</div>
						
					</div>
					
				<div class="speciality-home-list">
					
					<?php foreach ( $specialities as $speciality ) { ?>

						<div class="col-md-4 pad-b-15 speciality-home-one">
								<span class="speciality-number-home-wrap"> 
									<span class="speciality-number-home"> <?php echo $speciality->count; ?> </span> 
								</span>
							<div class="dotted">
								<a class="broker-down-link speciality-name-home" href="<?php echo get_term_link($speciality->term_id);; ?>"> <?php echo $speciality->name; ?></a> 
							</div>
						</div>
					
					<?php $a++; } ?>
				
				</div>	
				
<?php 
   $page = ob_get_contents();
   ob_end_clean();
	return $page; 
}

add_shortcode( 'medic_speciality', 'medic_speciality_shortcode' );

function clinic_speciality_shortcode( $atts, $content = null){
	
ob_start(); 
$clinic_specialities = get_terms( 'clinic-speciality', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0 ) ); ?>

					<div class="col-md-12">
					
						<div style="margin: 30px 0px;">
						
							<h2 style="text-align: center; font-size: 50px; font-family: 'Open Sans Condensed', sans-serif; margin-top: 45px; margin-bottom: 80px;"> Направления клиник </h2>
						
						</div>
						
					</div>

					<div class="speciality-home-list" >
<?php foreach ( $clinic_specialities as $clinic_speciality ) { ?>
						<div class="col-md-4 pad-b-15 speciality-home-one">
								<span class="speciality-number-home-wrap"> 
									<span class="speciality-number-home"> <?php echo $clinic_speciality->count; ?> </span> 
								</span>
							<div class="dotted">
								<!-- <i class="fa fa-minus" aria-hidden="true"></i> background:#F3F3F3;  -->
								<a class="broker-down-link speciality-name-home" href="<?php echo get_term_link($clinic_speciality->term_id);; ?>"> <?php echo $clinic_speciality->name; ?> </a> 
							</div>
						</div>
<?php } ?>
					</div>
					
					
<?php 

	$page = ob_get_contents();
	ob_end_clean();
	return $page; 
} 

add_shortcode( 'clinic_speciality', 'clinic_speciality_shortcode' );



function diagnostic_shortcode( $atts, $content = null){ 

	ob_start(); ?>
		
				
					<div class="col-md-12">
						<div style="margin: 90px 0px 30px;">
							<h2 style="text-align: center; font-size: 50px; font-family: 'Open Sans Condensed', sans-serif; margin-top: 30px; margin-bottom: 50px;"> Диагностические исследования </h2>
						</div>
					</div>
			
		<?php $diagnostics_terms = get_terms( 'diagnostic', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0 ) ); ?>
<?php $diagnostics_terms_array = array('mrt', 'uzi', 'komputernaya-tomografiya', 'dupleksnoe-skanirovanie', 'rentgen'); ?>

				<div class="speciality-home-list speciality-home-list-last" >
<?php foreach ( $diagnostics_terms as $diagnostic_term ) { ?>
			<?php $diagnostic_term_name = $diagnostic_term->name; ?>
			
			<?php $diagnostic_term_name_parts = explode(" ", $diagnostic_term_name); ?>
			
					
					<?php $diagnostic_term_slug = $diagnostic_term->slug; ?>
					
					<?php if( in_array($diagnostic_term_slug, $diagnostics_terms_array) ){ ?>
						<?php $current_parent_term_id = $diagnostic_term->term_id; 
						$parent_diagnostic_name = $diagnostic_term_name;
						

						
						?>

						
					<div class="col-md-12">	
						<h2 style="padding: 30px 0px;"> 
					
							<a class="home-title-diagnostic-parts" href="<?php echo get_term_link($diagnostic_term); ?>" style="font-weight: 100; font-weight: 100; font-size: 24px; font-family: 'Open Sans', sans-serif;;">
								
								<?php echo $diagnostic_term_name_parts[0];
								$b=1;
								foreach($diagnostic_term_name_parts as $diagnostic_term_name_part) {
									if($b != 1) { ?>
										<span><?php echo $diagnostic_term_name_part; ?></span>
									<?php }
								$b++; } ?>
								
							</a>
						
						</h2> 
					</div>
					
					
					<?php } else { ?>
					
					
				<?php $current_parent = $diagnostic_term->parent; ?>
						
			<?php if($current_parent == $current_parent_term_id and $current_parent_term_id != "") {
				
$diagnostic_name = $diagnostic_term->name;
$string = 'УЗИ менять';
$pattern = '/' . preg_quote($parent_diagnostic_name, '/') . '/';
$replacement = '';

$diagnostic_name =  preg_replace($pattern, $replacement, $diagnostic_name);
$diagnostic_name = trim($diagnostic_name);
$diagnostic_name = upFirstLetter($diagnostic_name);


							?>
						<div class="col-md-6 pad-b-15 speciality-home-one">
								<span class="speciality-number-home-wrap" style="position: absolute; right: 15px; bottom: 5px;"> 
									<span class="speciality-number-home"> <?php echo $diagnostic_term->count; ?> </span> 
								</span>
							<div class="dotted" style=" padding-right: 45px;">
								<!-- <i class="fa fa-minus" aria-hidden="true"></i> background:#F3F3F3;  -->
								<a class="broker-down-link speciality-name-home" href="<?php echo get_term_link($diagnostic_term->term_id); ?>"><i class="fa fa-minus home-minus" aria-hidden="true"></i><?php echo $diagnostic_name; ?> </a> 
							</div>
						</div>
						
						<?php } ?>
					<?php } ?>
						
<?php $a++; ?> <?php } ?>
				
				</div>
				
				
				<div class="speciality-home-list speciality-home-list-last" >
					<div class="col-md-12">
						<h2 style="padding: 30px 0px; font-size: 50px; font-family: 'Open Sans Condensed', sans-serif; margin-top: 30px; margin-bottom: 50px;"> Прочая диагностика </h2>
					</div>
					
<?php foreach ( $diagnostics_terms as $diagnostic_term ) { ?>
					
					<?php $diagnostic_term_slug = $diagnostic_term->slug; ?>
					
					<?php if( in_array($diagnostic_term_slug, $diagnostics_terms_array) ){ ?>
						
						<?php $current_parent_term_id = $diagnostic_term->term_id; ?>
						
					<?php } else { ?>
						<?php $current_parent = $diagnostic_term->parent; ?>
						
							<?php if($current_parent != $current_parent_term_id) { ?>
						
						<div class="col-md-6 pad-b-15 speciality-home-one">
								<span class="speciality-number-home-wrap" style="position: absolute; right: 15px; bottom: 5px;"> 
									<span class="speciality-number-home"> <?php echo $diagnostic_term->count; ?> </span> 
								</span>
							<div class="dotted" style=" padding-right: 45px;">
								<!-- <i class="fa fa-minus" aria-hidden="true"></i> background:#F3F3F3;  -->
								<a class="broker-down-link speciality-name-home" href="<?php echo get_term_link($diagnostic_term->term_id);; ?>"> <?php echo $diagnostic_term->name; ?> </a> 
							</div>
						</div>
						
						<?php } ?>
					<?php } ?>
						
<?php $a++; ?> <?php } ?>
			
				</div>

<?php
	$page = ob_get_contents();
	ob_end_clean();
	return $page; 
} 

add_shortcode( 'diagnostic', 'diagnostic_shortcode' ); 






function filter_simply_shortcode( $atts, $content = null){
	
	$a = shortcode_atts(
		array(
			'id'	=> '',
			'number'	=> 7,
		), $atts
	);
	
ob_start(); ?>


				<div class="simply-filter">
				
		<?php $all_speciality = get_terms( 'speciality', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0 ) ); ?>
		
		<?php $city_terms = get_terms( 'city', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0 ) ); ?> 
		<?php $metro_city_terms = get_terms( 'metro', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) ); ?> 
		<?php $district_city_terms = get_terms( 'district', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) ); ?> 
		<?php $city = get_field('выбор_города', 'option'); ?> 
		<?php $city = array_shift( $city ); ?> 
		
		<?php $filter_title = get_field('заголовок_для_поиска_на_главной', 'option'); ?>
		<?php $filter_text = get_field('текст_для_поиска_на_главной', 'option'); ?>
		
					<div class="col-md-12">
						
						<form action="<?php bloginfo('url'); ?>/advanced-search/" method="get">
							<div class="row">
							
								<div class="col-md-4">

									<div style="margin-bottom: 20px;" class="specialization-title"> 
										<img src="<?php bloginfo('template_url'); ?>/images/search.png" style="height: 24px;">Специальности 
									</div> 
									<select class="speciality-select js-states form-control speciality-select2 select-home-speciality" name="speciality" required="true">
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
						<option value="<?php echo $value[slug]; ?>"><?php echo $value[name]; ?></option>
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
									<button class="filter-button btn btn-primary"> Найти </button>
								</div>
							
							</div>
						
						</form>
						
					</div>
				</div>


<?php
	$page = ob_get_contents();
	ob_end_clean();
	return $page; 
} 

add_shortcode( 'filter_simply', 'filter_simply_shortcode' ); 

