<?php get_header(); ?>
<section id="content_outer_wrapper">
	<div id="content_wrapper" class="card-overlay">
	 
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
									<?php $a=1; ?>
								<?php $medic_specialities = wp_get_post_terms( $post->ID, 'clinic-speciality');
									foreach($medic_specialities as $medic_speciality) {  ?>
										<?php if($a <= 2) { ?>
											<li>
												<a href="<?php echo get_term_link($medic_speciality->term_id); ?>"><?php echo $medic_speciality->name; ?></a>
											</li>
										<?php } ?>
									<?php $a++; } ?>
											<li class="last">
												<span><?php the_title(); ?></span>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					
			

				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
			
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
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
				
	
		
      <div id="content" class="container">
         <div class="row">
            <div class="col-xs-12">
               <div class="card card-transparent">
                  <div class="wrapper">
					<div class="row">
					
					
					
					<?php $post_thumbnail_id = get_post_thumbnail_id( $post->ID ); ?> 
					<?php if($post_thumbnail_id) { 
						$post_thumbnail_url = lazy_image_size($post_thumbnail_id, 0, 0, 0); 
						$current_image = $post_thumbnail_url[0]; 
					} else { 
						$current_image = "http://placehold.it/162x162";
					} 
					$clinic_title = get_the_title($post->ID); 
					$pieces_title = explode(" ", $clinic_title); 
					
					 ?> 
						
			<div class="col-md-12 col-lg-3 col-xs-12 pull-right">
		
				<div class=" single-photo-clinic">
					<div class="row-fluid single-clinic-logo clinic-speciality-logo">
						<div class="centering text-center photo-img">
						<img class="img-clinic-logo-single" src="<?php echo $current_image; ?>">
						</div>
					</div>
				</div>
			
			</div>
						
                        <div class="col-md-12 col-lg-9">
							<h1 class="single-clinic-title"><?php the_title(); ?></h1>
							<div class="description-medic-single">
								<?php the_content(); ?>
							</div>
							
							<div class="">
								
								<div class="adres-clinic-block-single-medic">
									<div class="adres-clinic-block-single-medic-title underline-title-second"> Контактная информация </div>
									<?php if($PhoneAppointment or $call_phone) { ?>
										<div class="m-b-10">
											<span class="adres-clinic-single-medic"><i class="zmdi zmdi-tablet-mac"></i> Телефон</span> <?php echo $call_phone; ?>
										</div>
									<?php } ?>
									
									<?php if($street or $house) { ?>
										<div class="m-b-10">
											<span class="adres-clinic-single-medic"><i class="zmdi zmdi-pin"></i> Адрес</span> <?php echo $street; ?>, <?php echo $house; ?>.
										</div>
									<?php } ?>
									
									<?php if($Email) { ?>
										<div class="m-b-10">
											<span class="adres-clinic-single-medic"><i class="zmdi zmdi-email"></i> Email</span> <?php echo $Email; ?>
										</div>
									<?php } ?>
								</div>
								
							</div>
							
							
						</div>
							
	
			
		<div class="col-md-12 col-lg-12">
		
			<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
		
	<script>
	ymaps.ready(function () {
    var myMap = new ymaps.Map('map', {
            center: [<?php echo $clinic_latitude; ?>, <?php echo $clinic_longitude; ?>],
            zoom: 11
        }, {
            searchControlProvider: 'yandex#search'
        }),
		
		
		
        // Создаём макет содержимого.
        MyIconContentLayout = ymaps.templateLayoutFactory.createClass(
            '<div style="color: #FFFFFF; font-weight: bold;">$[properties.iconContent]</div>'
        ),
		
        myPlacemarkWithContent = new ymaps.Placemark([<?php echo $clinic_latitude; ?>, <?php echo $clinic_longitude; ?>], {
            hintContent: '<?php the_title(); ?>',
            balloonContent: '<?php echo $street; ?>, <?php echo $house; ?>',
        }, {
            // Опции.
            // Необходимо указать данный тип макета.
            iconLayout: 'default#image',


            // Макет содержимого.
            iconContentLayout: MyIconContentLayout
        });

    myMap.geoObjects
        .add(myPlacemarkWithContent);
});
	</script>
	
    <div id="map"> </div>
	
	<style>
        #map {
            width: 100%; height: 400px; padding: 0; margin: 0px 0px 60px 0px;
        }
    </style>
	
		</div>
			
						<div class="col-md-12 col-lg-12">
							

						
						
						
	<div class="tabs">
		
		<div style="margin-bottom: 15px;">
			<h3 class="clinic-diagnostic-table-name underline-title-second">Диагностика</h3>
		</div>
		<div class="row">
		<ul class="tabs__caption clinic-diagnostic-list " style="padding-left: 0px;">
		
		<?php $Diagnostics_terms_all = get_terms( 'diagnostic', array( 'parent' => 0 ) ); ?>
		
		<?php $all_terms = get_terms( 'diagnostic' ); ?>
	
		
		<?php foreach($all_terms as $all_term) { 
		
		$id_diagnostic_wp = $all_term->term_id; 
		
		$parent_diagnostic = $all_term->parent; 
		
		
		$id_diagnostic_docdoc = get_field('Id', 'diagnostic_' . $id_diagnostic_wp);
		
		if($parent_diagnostic == 0) { 
		
				$first_array_id_diagnostic_docdoc[$id_diagnostic_docdoc] = $id_diagnostic_wp;
				$second_array_id_diagnostic_docdoc[$id_diagnostic_wp][] = $id_diagnostic_docdoc;
				
			 } else {
				 
				$first_array_id_diagnostic_docdoc[$id_diagnostic_docdoc] = $parent_diagnostic;
				$second_array_id_diagnostic_docdoc[$parent_diagnostic][] = $id_diagnostic_docdoc;
			 } 

		}
		
			 ?>
			 
			<?php foreach($clinic_array->Diagnostics as $diagnostic_clinic) { 
				
				$id_diagnostic_clinic[$diagnostic_clinic->Id][Name] = $diagnostic_clinic->Name;
				$id_diagnostic_clinic[$diagnostic_clinic->Id][Price] = $diagnostic_clinic->Price;
				
				$wp_id = $first_array_id_diagnostic_docdoc[$diagnostic_clinic->Id];
				
				$array_one[] = $wp_id;
			} 
$array_one = array_unique($array_one);
			?>	
			
	
			

			<?php $a=1; ?>
			<?php foreach($Diagnostics_terms_all as $diagnostic_term) { ?>
			
			<?php if (in_array($diagnostic_term->term_id, $array_one)) { ?>
				
					<li class="col-md-4 diagnostic-item<?php if($a == 1) { echo " active"; } ?>"> 
						<span class="diagnostic-title"> <?php echo $a; ?>. <?php echo $diagnostic_term->name; ?> </span> 
					</li>
				
			<?php $a++; ?><?php } ?>
			
	        <?php } ?>
		
		</ul>
		</div>
		<div class="clear-both"> </div>
		
		
		
		<?php $a=1; ?>	
		
			<?php foreach($Diagnostics_terms_all as $diagnostic_term) { ?>
		
			<?php if (in_array($diagnostic_term->term_id, $array_one)) { ?>
		<div class="tabs__content<?php if($a == 1) echo " active"; ?>">
				<table class="table table-striped sign-up-table table-responsive">
					<thead>
						<tr>
							<th>Диагностика</th>
							<th>Цена</th>
							<th>Запись на приём</th>
						</tr>
					</thead>
					<tbody>
			<?php $current_terms = $second_array_id_diagnostic_docdoc[$diagnostic_term->term_id]; ?>
			
			<?php foreach($current_terms as $current_term) { ?>
			
				<?php if(isset($id_diagnostic_clinic[$current_term])) { ?>
				
				<?php $price_diagconstic = $id_diagnostic_clinic[$current_term][Price]; ?>
				<?php $name_diagconstic = $id_diagnostic_clinic[$current_term][Name]; ?>
				
						<tr>
						
							<th scope="row"><?php echo $name_diagconstic; ?></th>
							<th><?php echo $price_diagconstic; ?> Руб.</th>
							<th><span class="btn btn-primary sign-up-scinic-table" data-price="<?php echo $price_diagconstic; ?>" data-clinic="<?php echo $Id_clinic_docdoc; ?>" data-diagnostic="<?php echo $name_diagconstic; ?>" data-diagconsticid="<?php echo $current_term; ?>" data-toggle="modal" data-target="#myModal"> Записаться </span></th>
							
						</tr>
					
				<?php } ?>
			<?php } ?>
			
					</tbody>
				</table>
		</div>
		
		<?php $a++; ?>
		
	<?php } ?>
	
	<?php } ?>
	
	
	</div>
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

		<script>
			(function($) {
$(function() {

  $('ul.tabs__caption').on('click', 'li:not(.active)', function() {
    $(this)
      .addClass('active').siblings().removeClass('active')
      .closest('div.tabs').find('div.tabs__content').removeClass('active').eq($(this).index()).addClass('active');
  });

});
})(jQuery);
		</script>
			
			</div>
			
			
			
			
			
			
			
			
			
			
			
			
		<div style="margin-bottom: 30px; display: inline-block;">
			<div class="col-md-12">
				<h2 id="specialization-title-list-medic" class="underline-title-second" style="font-size: 38px;">
					<a href="<?php bloginfo('url'); ?>/inclinic/<?php echo $current_clinic_id; ?>"> Врачи в клинике «<?php the_title(); ?>» </a>
				</h2>
			</div>
		
	<?php $clinic_specialities_single = wp_get_post_terms( $current_clinic_id, 'clinic-speciality');
		$a=1;
		foreach($clinic_specialities_single as $clinic_speciality_single) { 
		
		$clinic_speciality_name 		= $clinic_speciality_single->name; 
		$clinic_speciality_term_id 		= $clinic_speciality_single->term_id; 
		$clinic_speciality_slug 		= $clinic_speciality_single->slug; 
		$clinic_speciality_alias 		= get_field('alias', 'clinic-speciality_' . $clinic_speciality_term_id); 
		$clinic_speciality_nameplural 	= get_field('nameplural', 'clinic-speciality_' . $clinic_speciality_term_id); 
		
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
								'terms'    => $current_clinic_id,
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
					<div class="specialization-item-list-medic single-clinic">
						<i class="fa fa-minus" aria-hidden="true"> </i> 
						<a href="<?php bloginfo('url'); ?>/speciality/<?php echo $clinic_speciality_alias; ?>/inclinic/<?php echo $current_clinic_id; ?>/"><?php echo $clinic_speciality_nameplural; ?> 
							<div class="speciality-count-medic-inlinic pull-right"> <?php echo $number_medic_posts; ?> </div>
						</a>
					</div>
				</div>
			<?php } ?>
			
		<?php $a++; } ?>
			
			</div>
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
		<div class="col-md-12">
				
			<div class="card" style="box-shadow: none;">
					<div class="tab-content">
					<h2 class="underline-title-second" style="font-size: 38px;"> Лучшие врачи в клинике - <span style="color: #2196f3;">«<?php the_title(); ?>»</span> </h2>
						<div class="tab-pane fadeIn active" id="profile-contacts">
						   <div class="">
						   
						   
		<?php 
		
$args = array(
	'showposts'   => 5,
	'post_type' => 'medic',
	'tax_query' => array(
		array(
			'taxonomy' => 'inclinic',
			'field'    => 'slug',
			'terms'    => $current_clinic_id,
		),
	),
	'orderby' => 'Rating',
); ?>

		<?php $d=1; ?>
	<?php $recent = new WP_Query($args);
		while($recent->have_posts()) : $recent->the_post(); ?>
		
		
		
		
		
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
					
		
						<?php if ($d != 1) { ?>
							<div class="clearfix"> </div>
							<div class="betwen-section"></div>
							<div class="clearfix"> </div>
						<?php } ?>
						
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
			<div class="info-rating-reviews clinic-change-info"> <i class="zmdi zmdi-comment-alt-text"></i> Отзывов <a href="<?php the_permalink(); ?>"><span class="info-rating-reviews-number"><?php echo $OpinionCount; ?></span></a> </div>
		</div> 
			
											<div>
												<a href="<?php the_permalink(); ?>" class="tax-sign-up btn btn-primary pull-right"> Онлайн запись <i class="zmdi zmdi-arrow-right"></i> 
												</a>
												<div class="info-price">
													<div class="info-price-title"> Цена первичного приема </div> <div class="info-price-number">	
										<?php if(($Price or $SpecialPrice) == 0) { ?>
											Бесплатно
										<?php } else { ?>
										
								<?php echo ($SpecialPrice ?  '<s>' . $Price . '</s>' . $SpecialPrice : $Price ); ?>
											
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
									
								</div>
							</div>
							
						</div>
						
		
	

		
		
		

		
		
		
		
		<?php $d++; ?><?php endwhile; ?> 
				
				
				
				
						   </div>
						   
						   
						   
						</div>
					 </div>

			</div>
			
		</div>
					


					
					
					
					
					
					
					
					
					
					















					

	
					</div>					 
					 
                  </div>
               </div>
            </div>
         </div>
      </div>
	  
			<?php endwhile; ?> 
		<?php endif; ?>
   </div> 
	
	   
   
	
	
	
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog clinic-modal">
			  <div class="modal-content">
				
				<div class="modal-header">
				
					<div class="modal-diagnostic-name-single"> </div>
				 
					<div class="dotted m-t-5 one-block-raids dotted-one-clinic">
						<span class="broker-down-link one-raids-link">Цена</span>
						<span class="one-raids-price-wrap">
							<span class="price one-raids-price modal-diagnostic-price-single"></span>
						</span>
					</div>
					
					<div class="clear-both"> </div>
					
			<div class="adress-clinic">
				
				<div class="adress-clinic-one">
				
					<span class="adress-clinic-one-link"> 
						<?php echo $clinic_title; ?> <br>
					</span>
					<div class="street"><?php echo $city; ?>, <?php echo $street; ?> <?php echo $house; ?> </div>
							
						<div class="clear-both"> </div>
				
						<div class="metro-all">
							<?php foreach($clinic_stations as $clinic_station) { ?>
								
								<?php $clinic_station_name 		= $clinic_station->Name; ?>
								<?php $clinic_station_LineColor = $clinic_station->LineColor; ?>
								<span class="metro-one"> <i style=" color:#<?php echo $clinic_station_LineColor; ?>;" class="zmdi zmdi-circle"></i> <?php echo $clinic_station_name; ?> </span>
							<?php } ?>
						</div>
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
				<?php if($TextUnderSignIn) { ?>
					<div class="modal-footer-second">
						<?php echo $TextUnderSignIn; ?>
					</div>
				<?php } ?>
			  </div>
			</div>
		</div>

   
   
   
   <?php get_footer(); ?>