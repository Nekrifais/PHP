					<?php $post_thumbnail_id = get_post_thumbnail_id( $post->ID ); ?> 
					<?php if($post_thumbnail_id) { 
						$post_thumbnail_url = lazy_image_size($post_thumbnail_id, 162, 162, 1); 
						$current_image = $post_thumbnail_url[0]; 
					} else { 
						$current_image = "http://placehold.it/162x162";
					} 
					
					$current_title 		= get_the_title($post->ID); 
					$pieces_title 		= explode(" ", $current_title); 
					 
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
							<div class="col-md-12 col-xs-12">
								<div class="row">
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
												<a href="<?php the_permalink(); ?>">

			<?php $dopparametrs_terms =  wp_get_post_terms($post->ID, 'dop', array("fields" => "all")); ?>
				
				<?php foreach($dopparametrs_terms as $dopparametr_term) { ?>
						<?php $check_slug = $dopparametr_term->slug; ?>
						
						<?php if($check_slug == "nadom") { ?>
							<img src="<?php bloginfo('template_url'); ?>/images/ambulance.png" style="position: relative; bottom: 2px; margin-right: 3px;">
						<?php } ?>
						
						<?php if($check_slug == "child") { ?>
							<img src="<?php bloginfo('template_url'); ?>/images/nipple.png" style="position: relative; bottom: 2px; margin-right: 3px;">
						<?php } ?>
						
				<?php } ?>

												<span> <?php echo $pieces_title[0]; ?> </span>
												
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
					
						<h3 class="taxonomy-list-clinics-medic"> Этот врач ведёт прём в следующих клиниках <img src="<?php bloginfo('template_url'); ?>/images/level-down-arrow.png" style="height: 26px; position: relative; top: 9px;"> </h3>
						
					<?php $a=1; ?>
					<?php foreach ($wp_clinics_ids as $key => $wp_clinic_id) { ?> 
						
						<?php 
						
						if(!empty($wp_clinic_id)) {
						
							$wp_MetroIds 		= wp_get_post_terms( $post->ID, 'metro'); 
							$clinic_array 		= get_post_meta($wp_clinic_id, "array", true); 
							$clinic_id 			= get_post_meta($wp_clinic_id, "Id", true);
							$clinik_link 		= get_permalink($wp_clinic_id); 
							
							$clinic_name 		= $clinic_array->Name; 
							$clinic_city 		= $clinic_array->City; 
							$clinic_street 		= $clinic_array->Street; 
							$clinic_streetId 	= $clinic_array->StreetId; 
							$clinic_house		= $clinic_array->House; 
							$clinic_stations 	= $clinic_array->Stations; 
							
							if($a != 1){
								$adress_class =' adress-plus'; 
							} else {
								$adress_class =''; 
							}
							
							?>
							
							
							
							<div class="taxonomy-adres<?php echo $adress_class; ?>">
								<span class="adres-clinic-title">Приём в «<a href="<?php echo $clinik_link; ?>"><?php echo $clinic_name; ?></a>» </span>
								<div class="adres-clinic">
									<i class="zmdi zmdi-pin"></i>
							<?php echo $clinic_street; ?> <?php echo $clinic_house; ?> 
							<?php if($wp_MetroIds) { ?>
								
								<img src="<?php bloginfo('template_url'); ?>/images/metro-logo.png" style="position: relative; bottom: 2px; width: 26px; margin-right: 10px; padding-left: 5px; margin-left: 15px;"> Метро :
								<?php foreach($clinic_stations as $clinic_station) { 
									
									$clinic_station_name 		= $clinic_station->Name; 
									$clinic_station_LineColor 	= $clinic_station->LineColor; ?>
									
									 <i style="color:#<?php echo $clinic_station_LineColor; ?>;" class="zmdi zmdi-circle"></i> <?php echo $clinic_station_name; ?> 
								<?php } 
									
							} else { 
									
								$wp_DistrictIds = wp_get_post_terms( $post->ID, 'district'); 
								foreach($wp_DistrictIds as $wp_DistrictId){ 
									echo " <span class=\"pull-right\">Район - " . $wp_DistrictId->name . "</span>";  
								} 
							} ?>
									
								</div>
								
								
						<?php $array_clinics_speciality = $array_ClinicIds_price[$clinic_id]; ?>
						<div class="row">
							<?php foreach($array_clinics_speciality as $key => $value) { ?>
								<?php if($value[Price]) { ?>
								
								<div class="col-md-12">
								
									
									<div class="price-speciality-medic-clinic">
										<div class="first-visit-speciality-title">
											<div class="visit-speciality-title-line">Первичный прием по специализации - <?php echo $specialities_docdocid_wpname[$key];  ?></div>
										</div>
										<div class="medic-all-prices-line">
											<span class="medic-one-prices-line">
												<img src="<?php bloginfo('template_url'); ?>/images/double-left-arrowheads.png">
									<?php if ($value[SpecialPrice]) { ?>
											<s> <?php echo $value[Price]; ?> </s><?php echo $value[SpecialPrice]; ?>  руб.
									<?php } else { ?>
											<?php echo $value[Price]; ?> руб.
									<?php } ?>
											</span>	
										</div>
									</div>
									
								</div>
								
								<?php } ?>
								
								
							
							<?php } ?>
								</div>
						
								
								
								<div class="block-buttons">
									
									<div class="wrap-taxonomy-order-in">
										<span class="taxonomy-order-in" data-image="<?php echo $current_image; ?>" data-title="<?php echo $current_title; ?>" data-categoies="<?php echo $categoies_data; ?>" data-expicience="<?php echo $ExperienceYear; ?>" data-price="<?php echo $modal_price; ?>" data-clinic="<?php echo $clinic_id; ?>" data-medic="<?php echo $medic_docdoc_id; ?>" data-clinicname="<?php echo $clinic_name; ?>" data-clinicstreet="<?php echo $clinic_city; ?>, <?php echo $clinic_street; ?> <?php echo $clinic_house; ?>" data-toggle="modal" data-target="#myModal">
											Записаться на приём онлайн
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
						
					<?php } $a++; } ?>
							<?php unset($array_ClinicIds_price); ?>
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
					