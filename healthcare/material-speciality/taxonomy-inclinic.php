<?php get_header(); ?>
		
		<?php $docdoc_phone = get_field('телефон_для_записи_в_docdoc', 'option'); ?>
		
		<?php $city_terms = get_terms( 'city', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0 ) ); ?> 
		<?php $metro_city_terms = get_terms( 'metro', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) ); ?> 
		<?php $district_city_terms = get_terms( 'district', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) ); ?> 
		<?php $city = get_field('выбор_города', 'option'); ?> 
		
		<?php $city = array_shift( $city ); ?>
		
		<?php $curTerm 				= get_queried_object(); ?>
		<?php $curterm_taxonomy 	= $curTerm->taxonomy; ?>
		<?php $curterm_slug 		= $curTerm->slug; ?>
		<?php $curTerm_id 			= $curTerm->term_id; ?>
		
		<?php // sorting start
			$query_speciality_term		= $wp_query->query['speciality'];
			$query_metro_term			= $wp_query->query['metro'];
			$query_district_term		= $wp_query->query['district'];
		// sorting end ?>
		
		<?php $current_query_speciality = $wp_query->query['speciality']; ?>
		<?php $current_query_metro = $wp_query->query['metro']; ?>
		<?php $current_query_district = $wp_query->query['district']; ?>
		
	<?php $docdoc_speciality_id = get_field('Id', 'speciality_' . $curTerm_id); 
		
		$docdoc_inclinic_id = get_field('id_клиники_в_базе_docdoc', 'inclinic_' . $curTerm_id);
		$specialities_docdocid_wpname = get_option('specialities_docdocid_wpname');
		
		
				?>
			
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
		
		$breadcrumb_speciality_get_term_by 		= get_term_by('slug', $current_query_speciality, 'speciality');
		$breadcrumb_speciality_term_id	 		= $breadcrumb_speciality_get_term_by->term_id;
		$breadcrumb_speciality_branchname 		= get_field('branchname', 'speciality_' . $breadcrumb_speciality_term_id);
		$breadcrumb_branchalias 		= get_field('branchalias', 'speciality_' . $breadcrumb_speciality_term_id);
		$breadcrumb_link = get_term_link($breadcrumb_speciality_term_id, 'speciality'); 
		
		
		
        $tmpTerm = $term;
        $tmpCrumbs = array();
        while ($tmpTerm->parent > 0){
            $tmpTerm = get_term($tmpTerm->parent, get_query_var("taxonomy"));
            $crumb = '<li><a href="' . get_term_link($tmpTerm, get_query_var('taxonomy')) . '">' . $tmpTerm->name . '</a> </li>';
            array_push($tmpCrumbs, $crumb);
        }
        echo implode('', array_reverse($tmpCrumbs));
		
		if($current_query_speciality != "") { ?>
		

			<li><a href="<?php bloginfo('url'); ?>/clinic-speciality/<?php echo $breadcrumb_branchalias; ?>/"><?php echo $breadcrumb_speciality_branchname; ?></a>  </li>
			
			
		<?php }
		
		
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
	
	$category_description = get_field('описание_категории', 'speciality_' . $curTerm_id);
	
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
		$field_h1 = 'single_h1_for_speciality-' . $curTerm_id; 
		$field_textdescription = 'single_textdescription_for_speciality-' . $curTerm_id; 
		$h1 = get_option($field_h1);
		$textdescription = get_option($field_textdescription);
		
	}

?>
	
	
		<div class="container">
			<div class="row">
				<!--
					<div class="col-md-12">
						
						<div class="themeum-title yes taxonomy">
							
							<h3 class="style-title"> 
								<?php if($h1) {
									 echo $h1;
								} else { 
									single_cat_title(); 
								} ?>
							</h3>
							
							
						</div>
						
					</div> 
				
				<div style="clear: both;"> </div>
				 -->

		<?php
		
			$breadcrumb_speciality_get_term_by 		= get_term_by('slug', $current_query_speciality, 'speciality');
			$breadcrumb_speciality_term_id	 		= $breadcrumb_speciality_get_term_by->term_id;
			$breadcrumb_speciality_branchname 		= get_field('branchname', 'speciality_' . $breadcrumb_speciality_term_id);
			$breadcrumb_speciality_nameplural 		= get_field('nameplural', 'speciality_' . $breadcrumb_speciality_term_id); 
		
		?>
				
	<?php $namepluralgenitive = get_field('namepluralgenitive', 'speciality_' . $curTerm_id); ?>
				
			<?php $post_count_output = get_option('posts_per_page'); ?>
				
				
				
					<?php $recent = new WP_Query("posts_per_page=1&post_type=clinic&p=" . $curterm_slug);
						while($recent->have_posts()) : $recent->the_post(); ?>
				
				
				
					<?php 	
				$clinic_array = get_post_meta($post->ID, "array", true);
				$Id_clinic_docdoc = get_post_meta($post->ID, "Id", true);
				
				
				
				$clinic_longitude 			= round($clinic_array->Longitude, 6);
				$clinic_latitude 			= round($clinic_array->Latitude, 6);
				
				$clinic_longitude_center	= $clinic_longitude - 0.005723;
				$clinic_latitude_center		= $clinic_latitude - 0.000279; 
				
				$current_clinic_id = get_the_id();
					
					$city	 			= $clinic_array->City; 
					$street 			= $clinic_array->Street; 
					$house 				= $clinic_array->House; 
					
					$clinic_city	 	= $clinic_array->City; 
					$clinic_street 		= $clinic_array->Street; 
					$clinic_house 		= $clinic_array->House; 
					
					$Email 				= $clinic_array->Email; 
					$PhoneAppointment 	= $clinic_array->PhoneAppointment; 
					$clinic_stations 	= $clinic_array->Stations; 
					
						$docdoc_phone = get_field('телефон_для_записи_в_docdoc', 'option'); 
						
						if($docdoc_phone) {
							$call_phone = $docdoc_phone;
						} else {
							$call_phone = $PhoneAppointment;
						}
					
					?>
				
					<?php $post_thumbnail_id = get_post_thumbnail_id( $post->ID ); ?> 
					<?php if($post_thumbnail_id) { 
						$post_thumbnail_url = lazy_image_size($post_thumbnail_id, 0, 0, 0); 
						$current_image = $post_thumbnail_url[0]; 
					} else { 
						$current_image = "http://placehold.it/162x162";
					} 
					$clinic_title = get_the_title($post->ID); 
					$pieces_title = explode(" ", $clinic_title);
					
					$current_title_clinic = $clinic_title;
					
		?> 
						

						
                        <div class="col-md-12 col-lg-12">
						
							<h1 class="single-clinic-title">
								<?php if($breadcrumb_speciality_nameplural) { 
									echo $breadcrumb_speciality_nameplural;  
								} else { ?>
										Врачи
								<?php } ?>
								в «<?php echo $current_title_clinic; ?>» 
							</h1>
							
							
							
						</div>
				
				<?php endwhile; ?>
				</div>
				
				
				
			<div class="betwen-section"> </div>
				
				
				
				<div class="row">
				
				
				
				
				
				
				
				
				
				
				<div class="">
					<div class="taxonomy-block">
						<?php $betwen = 1; ?>
			<?php if (have_posts()) { ?>
				<?php while (have_posts()) : the_post(); ?>
				
					<?php $post_thumbnail_id = get_post_thumbnail_id( $post->ID ); ?> 
					<?php if($post_thumbnail_id) { 
						$post_thumbnail_url = lazy_image_size($post_thumbnail_id, 162, 162, 1); 
						$current_image = $post_thumbnail_url[0]; 
					} else { 
						$current_image = "http://placehold.it/162x162";
					} 
					
					$current_title 		= get_the_title($post->ID); 
					$pieces_title 		= explode(" ", $current_title); 
					
					$reviews_array = get_post_meta($post->ID, "reviews_array", true);
					
					$medic_docdoc_id = get_post_meta($post->ID, "Id", true);
					$medic_array 		= get_post_meta($post->ID, "array", true); 
						$medic_Category 	= $medic_array->Category;
						$Price 				= $medic_array->Price;
						$SpecialPrice 		= $medic_array->SpecialPrice;
						$ExperienceYear 	= $medic_array->ExperienceYear; 
						$Rating 			= $medic_array->Rating; 
						$OpinionCount 		= $medic_array->OpinionCount;
						$Clinics 			= $medic_array->Clinics;
						$ClinicsInfo 		= $medic_array->ClinicsInfo;
						
						$rating_percent 	= ($Rating / 5) * 100; 
						$wp_clinics_ids 	= get_post_meta($post->ID, "wp_clinics_ids", true); ?>
					
				<?php 
				
				if($SpecialPrice != 0 or $Price != 0) {
					if($SpecialPrice) {
						$modal_price = $SpecialPrice;
					} else {
						$modal_price = $Price;
					} 
				} else {
					$modal_price = "Бесплатно";
				}
				
				
				?>
					
					
					
						<div class="taxonomy-item">
							<div class="col-md-8 col-xs-12">
								<div class="">
									<div style="overflow: hidden; clear: both;">
										<div class="taxonomy-photo">
											
											<div class="photo-img">
												<img src="<?php echo $current_image; ?>">
											</div>
											
											<div class="photo-expirience">
												<div class="photo-expirience-number">
													Стаж <?php echo chti($ExperienceYear,'год','года','лет'); ?>
												</div>
											</div>
											
										</div>
										
										<div class="taxonomy-info">
										
											<div class="info-title">
											
												<a href="<?php the_permalink(); ?>"> <span> <?php echo $pieces_title[0]; ?> </span>
												
													<?php $a=1; foreach($pieces_title as $piece_title) {
													if($a != 1) {
														echo $piece_title . ' ';
													} $a++; } ?> 
														
												</a>
												
											</div>
											
											<div class="info-category tax-speciality-cat">
												
								<?php $a=1; ?> 
					<?php $term_speciality_fields = wp_get_post_terms($post->ID, 'speciality', array("fields" => "all")); ?>
								<?php foreach($term_speciality_fields as $term_speciality_field) { ?><?php if($a != 1) { ?>, <?php } ?><a href="<?php echo get_term_link($term_speciality_field->term_id, 'speciality'); ?>"><?php echo $term_speciality_field->name; ?></a>
								    <?php if($a != 1) { ?><?php $categoies_data .= ', '; ?> <?php } ?>
									<?php $categoies_data .= $term_speciality_field->name; ?>
								<?php $a++; ?>
								
								
								
								
								
								<?php } ?>
											
											</div>
											
		<div class="taxonomy-info-rating">
			<div class=" pull-left rating-block-title-clinic-speciality"> Рейтинг <span class="number-reviews-all"><?php echo round($Rating, 2); ?></span></div>
			<div class="star-ratings-css star-ratings-css-clinic"> 
				<div class="star-ratings-css-top" style="width: <?php echo $rating_percent; ?>%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
				<div class="star-ratings-css-bottom"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
			</div> 
			<div class="pull-right info-rating-reviews"> <i class="zmdi zmdi-comment-alt-text"></i> Отзывов <a href="<?php the_permalink(); ?>"><span class="info-rating-reviews-number"><?php echo $OpinionCount; ?></span></a> </div>
		</div> 
			
											<div>
												<a href="<?php the_permalink(); ?>" class="tax-sign-up btn btn-primary pull-right"> Онлайн запись <i class="zmdi zmdi-arrow-right"></i> 
												</a>
												<div class="info-price">
													<div class="info-price-title"> Цена первичного приема </div> <div class="info-price-number">	
										<?php if(($Price or $SpecialPrice) == 0) { ?>
											Бесплатно
										<?php } else { ?>
										
								<?php echo ($SpecialPrice ?  '<s>' . $Price . '</s>' . $SpecialPrice : $Price );  ?>
											
												<span class="info-price-curency"> руб. </span> 
											
										<?php } ?>
													
												</div>
												</div>
											</div>
											
											<?php if($docdoc_phone) { ?>
											
												<div class="day-schedule">
												
													<span>  Вы можете записаться к этому врачу по телефону 
														<span class="day-sceldule-number"> 
															<i class="zmdi zmdi-phone-in-talk"></i> 
															<?php echo $docdoc_phone; ?> 
														</span> 
													</span> 
													
												</div>
												
											<?php } ?>
										
										</div>
									</div>
									
									<div class="clearfix"> </div>
									
										<div class="info-description">
											<b> <?php echo $medic_Category; ?> </b> <?php the_content(); ?>
										</div>
								</div>
							
					<?php foreach($ClinicsInfo as $ClinicInfo) { 
						$ClinicId 					= $ClinicInfo->ClinicId;
						$ClinicInfo_Specialities 	= $ClinicInfo->Specialities; 
						
						
						foreach($ClinicInfo_Specialities as $ClinicInfo_Speciality) { 
						
							$Clinic_SpecialityId 	= $ClinicInfo_Speciality->SpecialityId;
							$Clinic_Price 			= $ClinicInfo_Speciality->Price;
							$Clinic_SpecialPrice 	= $ClinicInfo_Speciality->SpecialPrice; 
							
				$array_ClinicIds_price[$ClinicId][$Clinic_SpecialityId][Price]			= $Clinic_Price; 
				$array_ClinicIds_price[$ClinicId][$Clinic_SpecialityId][SpecialPrice] 	= $Clinic_SpecialPrice; 
							
						} 
					} ?>
					
		<?php $array_clinics_speciality = $array_ClinicIds_price[$docdoc_inclinic_id]; ?>
					
				<h3 class="taxonomy-list-clinics-medic"> Этот врач ведёт прём в следующих клиниках: </h3>
		<?php if(is_array($array_clinics_speciality)) { ?>
			<?php foreach($array_clinics_speciality as $key => $value) { ?>
				<?php if($value[Price] != "" ) { ?>
				
					<div class="price-speciality-medic-clinic inclinic-tax-medic">
						<div class="first-visit-speciality-title">
							<div class="visit-speciality-title-line">Первичный прием по специализации - <?php echo $specialities_docdocid_wpname[$key];  ?></div>
						</div>
						<div class="medic-all-prices-line">
							<span class="medic-one-prices-line">
						<img src="<?php bloginfo('template_url'); ?>/images/double-left-arrowheads.png">
						<?php if ($value[SpecialPrice]) { ?>
								<s> <?php echo $value[Price]; ?> </s><?php echo $value[SpecialPrice]; ?>  руб.
									<?php $popup_price_clinic_visit = $value[SpecialPrice]; ?>
						<?php } else { ?>
							<?php echo $value[Price]; ?> руб.
						<?php } ?>
							</span>	
						</div>
					</div>
				
				<?php } ?>
			<?php } ?>
		<?php } ?>
		
			<div class="taxonomy-adres">
				<div class="block-buttons">
					
					<div class="wrap-taxonomy-order-in">
						<span class="taxonomy-order-in" data-image="<?php echo $current_image; ?>" data-title="<?php echo $current_title; ?>" data-categoies="<?php echo $categoies_data; ?>" data-expicience="<?php echo $ExperienceYear; ?>" data-price="<?php echo $modal_price; ?>" data-clinic="<?php echo $Id_clinic_docdoc; ?>" data-medic="<?php echo $medic_docdoc_id; ?>" data-clinicname="<?php echo $current_title_clinic; ?>" data-clinicstreet="<?php echo $clinic_city; ?>, <?php echo $clinic_street; ?> <?php echo $clinic_house; ?>" data-toggle="modal" data-target="#myModal">
							Записаться онлайн на приём онлайн
						</span>
					</div>
					
					<?php if($docdoc_phone) { ?>
					
						<?php $number = preg_replace("/[^0-9]/","",$docdoc_phone); ?>
						
						<div class="tax-buttons-or"> или </div>
						<div class="wrap-taxonomy-button-phone">
							<span class="button-phone" href="tel:+<?php echo $number; ?>">
								<i class="zmdi zmdi-phone"></i>
								<?php echo $docdoc_phone; ?>
							</span>
						</div>
					<?php } ?>
						
				</div>
			</div>
			
			<?php unset($categoies_data); ?>
					
					
							</div>
							
							
						<div class="col-md-4 col-xs-12">
							<?php $review_one=1; ?>
							<?php foreach($reviews_array->ReviewList as $review) { ?>
			
			<?php if($review_one == 1) { ?>
			<?php $RatingQlf 		= $review->RatingQlf; ?>
			<?php $RatingAtt 		= $review->RatingAtt; ?>
			<?php $RatingRoom 		= $review->RatingRoom; ?>
			<?php $fullRatingDoctor = $review->RatingDoctor; ?>
			<?php $RatingDoctor_number 	= $fullRatingDoctor / 2;   ?>
			<?php $RatingDoctor 	= round($RatingDoctor_number, 0);   ?>
			
			<?php $RatingQlf_percent 	= ($RatingQlf / 5) * 100; ?>
			<?php $RatingAtt_percent 	= ($RatingAtt / 5) * 100; ?>
			<?php $RatingRoom_percent 	= ($RatingRoom / 5) * 100; ?>
			
			<?php $Client_name 	= $review->Client; ?>
			<?php $Date 		= $review->Date; ?>
			<?php $Text 		= $review->Text; ?>
			
								<div class="reviews-inclinic-star">
							  
									<div class="last-review-title"> 
		<i class="fa fa-comments-o" aria-hidden="true"></i> Последний отзыв </div>
									<div class="inclinic-star-review-top">
										<b> <?php echo $Client_name; ?> </b>
										<div class="pull-right"> <?php echo $Date; ?> </div> 
									</div>
									<div class="reviews-inclinic-text"> <?php echo $Text; ?> </div>
									
						<div class="b-opininons_rating__item in-bl reviews-block-rating rating-ico">
							<div class="name-type-review"> Квалификация </div>
							<div class="b-rating b-ico in-bl rating-ico">
								<div style="width:<?php echo $RatingQlf_percent; ?>%" class="b-ico reviews-text-ico"> </div>
							</div>
						</div>
						
						<div class="b-opininons_rating__item in-bl">
							<div class="name-type-review"> Внимание </div>
							<div class="b-rating b-ico in-bl">
								<div style="width:<?php echo $RatingAtt_percent; ?>%" class="b-ico"></div>
							</div>
						</div>
						
						<div class="b-opininons_rating__item in-bl">
							<div class="name-type-review"> Цена-качество </div>
							<div class="b-rating b-ico in-bl">
								<div style="width:<?php echo $RatingRoom_percent; ?>%" class="b-ico"></div>
							</div>
						</div>
						
								</div>
							  
							  
							  
			<?php } ?>
			<?php $review_one++; ?>
			<?php } ?>
						</div>
							
							
							
							
						</div>
						
						
						
						<?php if($betwen == 1) { 
							
							if($docdoc_phone != "") {
								echo "<div class=\"betwen-section\"> </div>";
								require_once(dirname(__FILE__).'/includes/call-support.php'); 
							}
						} 

						if($betwen != $post_count_output) { ?>
							<div class="betwen-section"> </div>
						<?php } ?>
					<?php $betwen++; ?>
					
					<?php endwhile; ?> 
					
			<?php } else { ?>
				
					<span class="title-not-found"> К сожалению, по вашему запросу ничего не найдено. </span>
				
			<?php } ?>
						
					</div>
			<?php if( function_exists('navigation_pages') ) { navigation_pages(); } ?>
				</div>
				
				
				
				
				
				

				
				
			</div>
			
						<div class="row">
		
			
		<div class="col-md-12">
			<h2 id="specialization-title-list-medic" style="margin-top: 0px; font-size: 38px; font-family: 'Open Sans Condensed', sans-serif; margin-bottom: 30px;">
				Специализации клиники <?php echo $clinic_speciality_alias; ?> 
			</h2>
		</div>
			
			
		<?php $clinic_specialities = wp_get_post_terms( $current_clinic_id, 'clinic-speciality');
		$a=1;
		foreach($clinic_specialities as $clinic_speciality) { 
		
		$clinic_speciality_name = $clinic_speciality->name; 
		$clinic_speciality_term_id = $clinic_speciality->term_id; 
		$clinic_speciality_slug = $clinic_speciality->slug; 
		$clinic_speciality_alias = get_field('alias', 'clinic-speciality_' . $clinic_speciality_term_id); 
		
		
					$args = array(
						'posts_per_page' => '0',
						'post_type' => 'medic',
						'tax_query' => array(
							'relation' => 'AND',
							array(
								'taxonomy' => 'speciality',
								'field'    => 'slug',
								'terms'    => $clinic_speciality_alias,
							),
							array(
								'taxonomy' => 'inclinic',
								'field'    => 'slug',
								'terms'    => $curterm_slug,
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
					
		$number_medic_posts = $recent->found_posts; ?>
			
			<?php if($number_medic_posts != 0) { ?>
				<div class="col-md-3">
					<div class="specialization-item-list-medic ">
						<i class="fa fa-minus" aria-hidden="true"> </i>
						<a href="<?php bloginfo('url'); ?>/speciality/<?php echo $clinic_speciality_alias; ?>/inclinic/<?php echo $curterm_slug; ?>/"><?php echo $clinic_speciality_name; ?> 
							<div class="speciality-count-medic-inlinic pull-right"><?php echo $number_medic_posts; ?> </div>
						</a>
					</div>
				</div>
			<?php } ?>
			
		<?php $a++; } ?>
		
		
	
</div>
			
			
			
		<div class="betwen-section"> </div>
			
			
			

			
			
			
			
			
		</div>
				
				
				
				</div>
				
				
			
		
		
		
		

		
		
		
	<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog taxonomy-modal medic-modal">
			  <div class="modal-content">
				
				<div class="modal-header">
				
					<div class="modal-single-medic">
					   <figure class="th-autherdp single-plugin-image taxonomy-modal-image"> 
							
					   </figure>
						<div class="th-authorcontent block-info-details">
							<div class="th-authorhead">
								<h2 class="modal-title modal-medic-title-top">  <span class="title-part-blue">
									
										</span>
								</h2>
							</div>
						  <div class="medic-speciality-list modal-medic-speciality-list"> 

							 
						  </div>
							<p class="expicience"> Стаж <span class="modal-expicience"> </span> лет </p>
							<div class="medic-prise">
								<span class="cost-medic">
									Стоимость приема - <span class="price modal-price"> </span>
									
									<span class="currency">Руб.</span> 
									
								</span>
							</div>
						</div>
					</div> 

					<div class="clear-both"> </div>
					
		<div class="adress-clinic">
		
				
					<div class="adress-clinic-one adress-clinic-popup">
						
						<div class="adress-clinic-one-link modal-adress-clinic-one-link"> </div>
						
							<div class="street modal-street"> </div>
								
					</div>
	
					<div class="clear-both"> </div>
			
		</div>
				</div>
				
				<div class="clear-both"> </div>
					
				<div class="modal-footer">
					<div class="appointments">Запись на приём</div>
					<?php echo do_shortcode( '[contact-form-7 id="1371" title="Медик большая"]' ); ?>
					<center class="agreement-text">
Нажимая на "Отправить", вы даете <a href="<?php bloginfo('url'); ?>/agreement/"><b>согласие</b></a> на обработку своих персональных данных.
</center>  
				</div>
				
				<div class="modal-footer-second">
				
					<?php echo $TextUnderSignIn; ?>
					
                </div>
				
			  </div>
			</div>
		</div>
		
		
		
		
		
		
		
		
		
		
		
			
<?php get_footer(); ?>