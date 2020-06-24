<?php get_header(); ?>
 <section id="content_outer_wrapper">
	<div id="content_wrapper" class="card-overlay">
	 				
				<?php $specialities_docdocid_wpname = get_option('specialities_docdocid_wpname'); ?>
				
		
				<?php require_once(dirname(__FILE__).'/includes/top-menu.php'); ?>
					
					<div class="custom-breadcrumb">
						<div class="container">
							<div class="row">
								<div class="col-xs-12">
									<div class="breadcrumb-list">
										<ul class="list-unstyled breadcrumb breadcrumb-custom">
											<li class="first" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
												<a href="<?php bloginfo('url'); ?> " itemprop="url"> 
												<span itemprop="title"> <i class="zmdi zmdi-home"></i> Главная </span></a> 
											</li>
									<?php $a=1; ?>
								<?php $medic_specialities = wp_get_post_terms( $post->ID, 'speciality');
									foreach($medic_specialities as $medic_speciality) {  ?>
									
										<?php $near_medic_speciality[] = $medic_speciality->term_id; ?>
						
										<?php if($a <= 2) { ?>
										
											<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
												<a itemprop="url" href="<?php echo get_term_link($medic_speciality->term_id); ?>"><span itemprop="title"> <?php echo $medic_speciality->name; ?></span></a>
											</li>
											
										<?php } ?>
									<?php $a++; } ?>
									
											<li class="last" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
												<span itemprop="title"><?php the_title(); ?></span>
											</li>
											
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
								
		
	<?php $docdoc_phone = get_field('телефон_для_записи_в_docdoc', 'option'); ?>
		
      <div id="content" class="container">
         <div class="row">
            <div class="col-xs-12">
               <div class="card card-transparent medic-single">
                  <div class="wrapper">
                     <div class="row">
					 
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
					<?php $wp_clinics_ids = get_post_meta($post->ID, "wp_clinics_ids", true); 
						$wp_clinics_ids = array_filter($wp_clinics_ids);
							
					$term_speciality_fields = wp_get_post_terms($post->ID, 'speciality', array("fields" => "all")); 
					$wp_MetroIds = wp_get_post_terms( $post->ID, 'metro'); 
					$medic_docdoc_id = get_post_meta($post->ID, "Id", true);
					
					$current_medic_id = get_the_id();
					
					foreach($wp_MetroIds as $wp_MetroId) {
						$medic_near_metro[] = $wp_MetroId->term_id;
					}
					
					$post_thumbnail_id = get_post_thumbnail_id( $post->ID ); 
					if($post_thumbnail_id) { 
						$post_thumbnail_url = lazy_image_size($post_thumbnail_id, 162, 162, 1); 
						$current_image = $post_thumbnail_url[0]; 
					} else { 
						$current_image = "http://placehold.it/162x162";
					} 
					$current_title = get_the_title($post->ID); 
					$pieces_title = explode(" ", $current_title); 
					
					$reviews_array = get_post_meta($post->ID, "reviews_array", true); 
					$isActive = get_post_meta($post->ID, "isActive", true);	
					
				$medic_array = get_post_meta($post->ID, "array", true); 
					$medic_Category 	= $medic_array->Category;
					$ExperienceYear 	= $medic_array->ExperienceYear; 
					$Rating 			= $medic_array->Rating; 
					$OpinionCount 		= $medic_array->OpinionCount;
					$Price 				= $medic_array->Price;
					$SpecialPrice 		= $medic_array->SpecialPrice;
					
					$rating_percent 	= ($Rating / 5) * 100; 
					
						
						
					
					
					
		?>
				
				
				
				<?php $medic_arraydetailed = get_post_meta($post->ID, "arraydetailed", true); ?> 
				
				<?php $TextEducation 	= $medic_arraydetailed->Doctor[0]->TextEducation;  ?>
				<?php $TextCourse 		= $medic_arraydetailed->Doctor[0]->TextCourse; ?>
				<?php $TextSpec 		= $medic_arraydetailed->Doctor[0]->TextSpec; ?>
				<?php $TextExperience 	= $medic_arraydetailed->Doctor[0]->TextExperience; ?>
				
				
				<?php $user_description = get_post_meta($post->ID, "пользовательский_description", true); ?> 
				<?php $user_texteducation = get_post_meta($post->ID, "пользовательский_texteducation", true); ?> 
				<?php $user_textcourse = get_post_meta($post->ID, "пользовательский_textcourse", true); ?>
				<?php $user_textspec = get_post_meta($post->ID, "пользовательский_textspec", true); ?> 
				<?php $user_textexperience = get_post_meta($post->ID, "пользовательский_textexperience", true); ?> 
				
				
                 
					
						
					<div class="col-md-12 col-lg-8 col-xs-12">
							
							
						
							
								
	<div class="medic-info medic-info-top">
					
								<div class="medic-info-photo">
									<img src="<?php echo $current_image; ?>" alt="" class="img-circle">
									<div class="photo-expirience">
										<div class="photo-expirience-number">
											Стаж <?php echo chti($ExperienceYear,'год','года','лет'); ?>
										</div> 
									</div>
								</div>
						
		<h1 class="info-title">
			 <span> <?php echo $pieces_title[0]; ?> </span> 												
				<?php $a=1; foreach($pieces_title as $piece_title) {
				if($a != 1) {
					echo $piece_title . ' ';
				} $a++; } ?> 
			
		</h1>
		<div class="info-category">
			<?php $a=1; ?> 
			<?php $term_speciality_fields = wp_get_post_terms($post->ID, 'speciality', array("fields" => "all")); ?>
			<?php foreach($term_speciality_fields as $term_speciality_field) { ?><?php if($a != 1) { ?>, <?php } ?><?php $near_spec_current_medic[] = $term_speciality_field->term_id; ?><a href="<?php echo get_term_link($term_speciality_field->term_id, 'speciality'); ?>"><?php echo $term_speciality_field->name; ?></a><?php $a++; ?><?php } ?>
			
		</div>
		
		<div class="medic-info-rating">
			<div class=" pull-left rating-block-title-clinic-speciality"> Рейтинг <span class="number-reviews-all"><?php echo round($Rating, 2); ?></span></div>
			<div class="star-ratings-css star-ratings-css-clinic"> 
				<div class="star-ratings-css-top" style="width: <?php echo $rating_percent; ?>%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
				<div class="star-ratings-css-bottom"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
			</div> 
			<div class="info-rating-reviews"> <i class="zmdi zmdi-comment-alt-text"></i> Отзывов <a href="<?php the_permalink(); ?>"><span class="info-rating-reviews-number"><?php echo $OpinionCount; ?></span></a> </div>
		</div> 
		
		<div>
			<div class="info-price">
				<div class="info-price-title"> Цена первичного приема </div> 
				<div class="info-price-number">	
					<?php if(($Price or $SpecialPrice) == 0) { ?>
							Бесплатно
					<?php } else { ?>
						<?php echo ($SpecialPrice ?  '<s>' . $Price . '</s>' . $SpecialPrice : $Price );  ?>
						<span class="info-price-curency"> руб. </span> 
					<?php } ?>
				</div>
			</div>
		</div>
		
		
	</div>
	
	<script> 
		
		jQuery(document).ready(function ($) {
			$(".medic-form-right-top").find("p").contents().unwrap();
		});
		
	</script>
	
	
	<?php require_once(dirname(__FILE__).'/includes/call-support.php'); ?>
	
	
							<div class="description-medic-single" style="padding-top: 30px;">
								<b> <?php echo $medic_Category; ?> </b> <?php the_content(); ?>
							</div>
							
					</div>
					

					
					
					
					<!-- -->
					
					
					
					
		<div class="col-lg-4 col-xs-12 pull-right">
	
	
	<?php if($isActive) { ?>
	
	<?php ob_start(); ?> 
	
	<?php if(!isset($wp_clinics_ids[1])) { 
		$hidden_class = "radio-hidden";
	} else {
		$hidden_class = "";
	} ?>

		<div class="wpcf7-form-control-wrap my-radio-change <?php if(!isset($wp_clinics_ids[1])) echo " radio-hidden"; ?>"> <div class="wpcf7-form-control wpcf7-radio"><div style="font-size: 24px; margin-bottom: 10px;"> Выберите клинику </div>
				<?php $isFirst = true; ?>
			<?php foreach ($wp_clinics_ids as $wp_clinic_id) { ?>
				
				<?php $current_clinic = get_the_title($wp_clinic_id); ?>
				<?php $clinic_id = get_post_meta($wp_clinic_id, "Id" , true); ?>
				<?php 
				
				
	if($isFirst){
		$checked = "checked=\"checked\"";
	} else {
		$checked = "";
	}
				
				$isFirst = false;
				?>

				<span class="wpcf7-list-item">
					<input type="radio" name="text-clinic" value="<?php echo $clinic_id; ?>" <?php echo $checked; ?>>
					<span class="wpcf7-list-item-label">Приём в «<?php echo $current_clinic; ?>»</span>
				</span>
				
			<?php } ?>
				
			</div>
		</div>
	<input type="hidden" name="text-medic" value="<?php echo $medic_docdoc_id; ?>" class="wpcf7-form-control wpcf7-hidden form-medic-medicfield">
	
	<?php $clinics_form = ob_get_contents();
			ob_end_clean(); ?>
					
						<div class="agent-widget medic-widget">
							<div class="agent-title">
									<h4>Онлайн запись к врачу</h4>
									<div class="agent-title-medic"> <span> <?php echo $pieces_title[0]; ?> </span> 												
				<?php $a=1; foreach($pieces_title as $piece_title) {
				if($a != 1) {
					echo $piece_title . ' ';
				} $a++; } ?> </div>

								<div class="clearfix"></div>
							</div>
					
	<?php ob_start(); 	
			
		echo do_shortcode( '[contact-form-7 id="7663" title="Справа медик" html_class="medic-form-right-top"]' ); 
	
	$contact_form = ob_get_contents();
		ob_end_clean();
		
	$bodytag = str_replace("%body%", $clinics_form, $contact_form);
		
		echo $bodytag; ?>
	
	<center class="agreement-text right-send-form">
		Нажимая на "Отправить", вы даете <a href="<?php bloginfo('url'); ?>/agreement/"><b>согласие</b></a> на обработку своих персональных данных.
	</center>
	
	<?php if($sign_up_docdoc) { ?>
								<div class="sign-up-phone-option"> 
									<div class="sign-up-phone-title"> Или запишитесь по телефону </div>
									<div class="sign-up-phone-number"> <?php echo $docdoc_phone; ?> </div>
								</div>
	<?php } ?>
					</div>
				
			<?php } else { ?>
			
				<div style="padding: 35px 35px 35px; text-align: center; background: #f5f5f5; margin-bottom: 45px; margin-top: 60px;">
					<img src="<?php bloginfo('template_url'); ?>/images/alert.png">
					<div style="padding-top:35px;">Уважаемые посетители, запись к данному врачу не ведётся.</div>
				</div>
			
			<?php } ?>
				
				</div> 
					
					<?php if($isActive) { ?>
						
						<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
							
							<?php $d=1; ?>
							<?php foreach ($wp_clinics_ids as $wp_clinic_id) { ?>
							
								<?php $clinic_id = get_post_meta($wp_clinic_id, "Id" , true); ?>
								<?php $clininc_title = get_the_title($wp_clinic_id); ?>
								<?php $map_array = get_post_meta($wp_clinic_id, "array" , true); ?>
								
								<?php $clinic_longitude = round($map_array->Longitude, 6); ?>
								<?php $clinic_latitude = round($map_array->Latitude, 6); ?>
								
								
								<?php $content_post = get_post($wp_clinic_id); ?>
								<?php $clininc_content = $content_post->post_content; ?>
								<?php $clinic_link = get_permalink($wp_clinic_id); ?>
								
								<?php if($d == 1){ 
									$table_sceldue_map = "sign-up-titile-clinic underline-title";
								} else { 
									$table_sceldue_map = "sign-up-titile-clinic sign-up-titile-clinic-many underline-title";
								} ?>
								
					<div class="col-lg-12 col-xs-12">
						<div class="table-sceldut-map-top">
							
							<h2 class="<?php echo $table_sceldue_map; ?>"> 
								<a href="<?php echo $clinic_link; ?>">
									Приём в <span> «<?php echo $clininc_title; ?>» </span> 
								</a> 
							</h2>
							
							<div class="clinic-content-sceldue"> 
								<?php  echo $clininc_content; ?> 
							</div>
							
						</div>
						
						
						
					<div class="row">
					<div class="col-lg-7 col-xs-12">
							
								<div class="table-responsive">
							
							<?php $clinic_city			= $map_array->City;
							$clinic_street				= $map_array->Street;
							$clinic_house 				= $map_array->House;
							$clinic_PhoneAppointment 	= $map_array->PhoneAppointment;
							$clinic_Email 				= $map_array->Email; 
						
							$clinic_stations 	= $map_array->Stations; 
							
							?>
							
							
				<?php  $medic_times = get_post_meta($post->ID, "slot_clinic_" . $clinic_id, true); ?>
				
				
					<?php foreach($medic_times->SlotList as $medic_time){
						$StartTime = $medic_time->StartTime;
						$date_StartTime = DateTime::createFromFormat('Y-m-d H:i:s', $StartTime);
						$formated_StartTime = $date_StartTime->format('Ymd');	
						$array_medic_times[$formated_StartTime][] = $date_StartTime->format('YmdHis');
						
						$FinishTime = $medic_time->FinishTime;
						$date_FinishTime = DateTime::createFromFormat('Y-m-d H:i:s', $FinishTime);
						$formated_FinishTime = $date_FinishTime->format('Ymd');	
						$array_medic_times[$formated_FinishTime][] = $date_FinishTime->format('YmdHis');
						
					} 

					if($array_medic_times){

					?>
	
									<table class="table-sceldue-medic table table-responsive "> <!-- table table-striped sign-up-table -->
										<thead>
											<tr>
												<th colspan="4">Расписание врача</th>
											</tr>
											<tr>
												<th>Дата</th>
												<th>День недели</th>
												<th>Расписание</th>
												<th>Запись на приём</th>
											</tr>
										</thead>
										<tbody>
										
										

		
<?php $start_date = date('Y-m-d');
$end_date = date('Y-m-d', strtotime('+2 week'));
			$begin = new DateTime( $start_date );
			$end   = new DateTime( $end_date );

			for($i = $begin; $i <= $end; $i->modify('+1 day')){
			$formated_date = $i->format("Ymd");
			
			$current_date = $array_medic_times[$formated_date];


	if($current_date) {		
	
$min = min($current_date);
		$min_date = DateTime::createFromFormat('YmdHis', $min);
		$formated_min_date = $min_date->format('H:i');	
		
$max = max($current_date);
		$max_date = DateTime::createFromFormat('YmdHis', $max);
		$formated_max_date = $max_date->format('H:i');	
		
	}

setlocale(LC_TIME, "ru_RU.UTF-8");	?>
										
											<tr>
												<td scope="row"><?php echo $i->format("d.m.Y");  ?></td>
												<td><?php echo strftime("%A", strtotime($i->format("m/d/Y"))); ?></td>
												<?php if($current_date ) { ?>
													<td><?php echo $formated_min_date; ?> - <?php echo $formated_max_date; ?> </td>
	<td> <span data-clinic="<?php echo $clinic_id; ?>" data-medic="<?php echo $medic_docdoc_id; ?>" data-class=".address-clinic-popup-id-<?php echo $clinic_id; ?>" data-time="<?php echo $i->format("Y-m-d");  ?>" data-toggle="modal" data-target="#myModal" class="btn-primary button-small-sign-up open-modal-medic"> Записаться</span> 
													
													
													</td>
													
												<?php } else { ?>
													<td>Нет приёма</td>
													<td>------------</td>
												<?php } ?>
										
							<?php } ?>

												
											</tr>
										
										
										
										</tbody>
									</table>
									<?php } else { ?>
					<div class="no-sceldue-medic">
						<div class="no-sceldue-medic-title"> Для записи к этому врачу нажмите на книпку ниже. </div>
						<div class="no-sceldue-medic-button">
							<button class="no-order-sceldue open-modal-medic" data-clinic="<?php echo $clinic_id; ?>" data-medic="<?php echo $medic_docdoc_id; ?>"  data-class=".address-clinic-popup-id-<?php echo $clinic_id; ?>" data-toggle="modal" data-target="#myModal" class="medic-info-order open-modal-medic">Записаться на прием</button>
						</div>
					</div>
					<?php } ?>
								</div>

					</div>
			
	<div class="col-lg-5 col-xs-12">
	
		<div class="detail-sidebar">
			<section class="shadow">
				<div> 
				
	<?php 
		
		
	$clinic_Id					= $map_array->Id;
	
	$map_clinic_Id 				= "'map-medic-single-$clinic_Id'"; 
	
	$clinic_city				= $map_array->City;
	$clinic_street				= $map_array->Street;
	$clinic_house 				= $map_array->House;
	
	if($sign_up_docdoc) {
		$clinic_PhoneAppointment 	= $sign_up_docdoc; 
	} else {
		$clinic_PhoneAppointment 	= $map_array->PhoneAppointment;
	} 
	
	$clinic_coordinate = $clinic_latitude . ', ' . $clinic_longitude; ?>
	
	
	
	<script>
	ymaps.ready(function () {
    var myMap = new ymaps.Map(<?php echo $map_clinic_Id; ?>, {
            center: [<?php echo $clinic_coordinate; ?>],
            zoom: 15
        }, {
            searchControlProvider: 'yandex#search'
        }),
		
		
		
        // Создаём макет содержимого.
        MyIconContentLayout = ymaps.templateLayoutFactory.createClass(
            '<div style="color: #FFFFFF; font-weight: bold;">$[properties.iconContent]</div>'
        ),
		
        myPlacemarkWithContent = new ymaps.Placemark([<?php echo $clinic_coordinate; ?>], {
            hintContent: '<?php echo $clininc_title; ?>',
            balloonContent: '<?php echo $clinic_street; ?>, <?php echo $clinic_house; ?>',
        },
	
		{
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
	
    <div id="map-medic-single-<?php echo $clinic_Id; ?>"> </div>
	
	<style>
	
        #map-medic-single-<?php echo $clinic_Id; ?>{
            width: 100%;
			height: 400px;
			padding: 0;
			margin: 0;
        }
		
    </style> 
	
	</div>
				<div class="content">

					<hr class="sidebar-divider-two">
								<div class="adres-clinic-block-single-medic">
								
									<?php if($clinic_PhoneAppointment or $docdoc_phone) { ?>
										<div class="m-b-10">
											<span class="adres-clinic-single-medic"><i class="zmdi zmdi-tablet-mac"></i> Телефон</span> 
											
										<?php if($docdoc_phone) {
												echo $docdoc_phone;
											} else {
												echo $clinic_PhoneAppointment;
											} ?>
											
										</div>
									<?php } ?>
									
									<?php if($clinic_street or $clinic_house) { ?>
										<div class="m-b-10">
											<span class="adres-clinic-single-medic"><i class="zmdi zmdi-pin"></i> Адрес</span> <?php echo $clinic_street; ?>, <?php echo $clinic_house; ?>.
										</div>
									<?php } ?>
									
									<?php if($clinic_Email) { ?>
										<div class="m-b-10">
											<span class="adres-clinic-single-medic"><i class="zmdi zmdi-email"></i> Email</span> <?php echo $clinic_Email; ?>
										</div>
									<?php } ?>
									
									<div class="map-medic-slots-metro"> 
										<div class="metro-station-title"> Метро: </div>
										<?php foreach($clinic_stations as $clinic_station) { ?>
										
										<?php $clinic_station_name 		= $clinic_station->Name; ?>
										<?php $clinic_station_LineColor 	= $clinic_station->LineColor; ?>
											<div class="m-b-10 metro-station">
												<i style="color:#<?php echo $clinic_station_LineColor; ?>;" class="zmdi zmdi-circle"></i> <?php echo $clinic_station_name; ?> 
											</div>
												
										<?php } ?>
									
									</div>
									
								</div>
				</div>
				
			</section>
		</div>
		
	</div>
	</div> </div> 
								
								<?php $d++; } ?>
								
									<?php } else { ?>
									
										<div class="col-md-12">
										
											<div style="padding: 35px 35px 35px; text-align: center; background: #f5f5f5; margin-bottom: 45px;">
												<img src="<?php bloginfo('template_url'); ?>/images/alert.png">
												<div style="padding-top:35px;">Уважаемые посетители, запись к данному врачу не ведётся.</div>
											</div>
											
										</div>
									
									<?php } ?>
								
								<div class="col-lg-12 col-xs-12">
								
						
								<?php if($TextEducation or $user_texteducation or $TextCourse or $user_textcourse or $TextExperience or $user_textexperience or $TextSpec or $user_textspec) { ?>
								
								 	<div class="row medic-detailed-info">
										<div class="col-md-12">
											<h2 class="underline-title more-info-medic-title-all">Подробная информация о враче</h2>
										</div>	
										<?php if($TextEducation or $user_texteducation) { ?>
										
											<div class="col-md-3">
												<span class="more-info-medic-title"> Образование </span>
											</div>
											
											<div class="col-md-9">
												<?php if($TextEducation) { 
													echo $TextEducation; 
												} else {
													echo $user_texteducation;
												} ?>
												
											</div>	
											
											<div class="col-md-12">
												<div class="betwen-section"> </div>
											</div>
											
										<?php } ?>
										<?php if($TextCourse or $user_textcourse) { ?>
											<div class="col-md-3"> 
												<span class="more-info-medic-title"> Курсы повышения квалификации </span>
											</div>
											<div class="col-md-9">
												<?php if($TextCourse) { 
													echo $TextCourse; 
												} else {
													echo $user_textcourse;
												} ?>
											</div> 
											
											<div class="col-md-12">
												<div class="betwen-section"> </div>
											</div>
											
										<?php } ?>
										<?php if($TextExperience or $user_textexperience) { ?>
											<div class="col-md-3"> 
												<span class="more-info-medic-title"> Опыт работы </span>
											</div>
											<div class="col-md-9">
												<?php if($TextExperience) { 
													echo $TextExperience; 
												} else {
													echo $user_textexperience;
												} ?>
											</div> 
											
											<div class="col-md-12">
												<div class="betwen-section"> </div>
											</div>
											
										<?php } ?>
										<?php if($TextSpec or $user_textspec) { ?>
										<div class="col-md-3"> 
										<span class="more-info-medic-title"> Специализация </span>
										</div>
										<div class="col-md-9" >
											 	<?php if($TextSpec) { 
													echo $TextSpec; 
												} else {
													echo $user_textspec;
												} ?>
										
										</div> 
										
											<div class="col-md-12">
												<div class="betwen-section"> </div>
											</div>
										
										<?php } ?>

								  </div>
								  
								<?php } ?>			
						
			<h2 class="review-medic-title underline-title reviews-medic-docdoc-id" data-medicid="<?php echo $medic_docdoc_id; ?>"> Отзывы </h2>
			
		<?php $reviews_switch = get_field('добавление_отзывов_через_сайт', 'option'); ?>
			
			<?php if($reviews_switch == 2) { ?>
		
	<script> 
	 jQuery(document).ready(function ($) {

	$(".wpcf7-form.reviews-form").find("p").contents().unwrap();

	});</script>

				<?php echo do_shortcode( '[contact-form-7 id="30598" title="Отзыв" html_class="reviews-form"]' ); ?>
				
				<br>
				<br>
				
				<div style="clear:both;"> </div>
		
	<?php $recent = new WP_Query("showposts=-1&post_type=reviews&meta_key=DoctorId&meta_value=" . $medic_docdoc_id);
			while($recent->have_posts()) : $recent->the_post(); ?>
			
			<?php $RatingQlf 		= get_post_meta($post->ID, "RatingQlf", true); ?>
			<?php $RatingAtt 		= get_post_meta($post->ID, "RatingAtt", true); ?>
			<?php $RatingRoom 		= get_post_meta($post->ID, "RatingRoom", true); ?>
			
	<?php 
		
		$reviews_radio_one 			= $RatingQlf * 20;
		$reviews_radio_two 			= $RatingAtt * 20;
		$reviews_radio_three 		= $RatingRoom * 20; 
		
	?> 
			
				
				<article class="review-medic-block">
				   <div class="card card-comment" data-timeline="comment">
						<header class="card-heading mw-lightGray review-title-medic">
							<h2 style=" display: inline; line-height: 26.4px;" class="card-title m-t-5"><?php the_title(); ?></h2>
							<span class="pull-right reviews-single-date"> <?php echo $Date; ?> </span>
						</header>
						<div class="card-body">
							<p> <?php the_content(); ?> </p>
						</div>
						<div class="card-footer mw-lightGray p-10 rating-medic-single">
							<div class="row">
								<div class="col-md-4"> 
									<div class="rating-number-block">
										<div class="title-rating-single-comment"> Квалификация </div>
										<div class="under-title">  
											<div class="star-ratings-css"> 
												<div class="star-ratings-css-top" style="width: <?php echo $reviews_radio_one; ?>%">
													<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
												</div>
												<div class="star-ratings-css-bottom">
													<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
												</div>
											</div>
										</div>
									</div>
									
								</div>
								<div class="col-md-4"> 
									<div class="rating-number-block">
										<div class="title-rating-single-comment"> Внимание </div>
										<div class="under-title">  
											<div class="star-ratings-css"> 
												<div class="star-ratings-css-top" style="width: <?php echo $reviews_radio_two; ?>%">
													<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
												</div>
												<div class="star-ratings-css-bottom">
													<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">  
									<div class="rating-number-block">
										<div class="title-rating-single-comment"> Цена-качество </div>
										<div class="under-title">  
											<div class="star-ratings-css"> 
												<div class="star-ratings-css-top" style="width: <?php echo $reviews_radio_three; ?>%">
													<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
												</div>
												<div class="star-ratings-css-bottom">
													<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
					  </div>
				   </div>
				</article>
			
			
			<?php endwhile; ?>
			
			<?php } ?>
			
	<?php if($reviews_array->ReviewList) { ?>	
			<!-- <h2 class="review-medic-title underline-title"> Отзывы </h2> -->
			
			
			
			
			
		<?php foreach($reviews_array->ReviewList as $review) { 

			$RatingQlf 			= $review->RatingQlf; 
			$RatingAtt 			= $review->RatingAtt; 
			$RatingRoom 		= $review->RatingRoom; 

			$RatingQlf_percent 		= ($RatingQlf / 5) * 100; 
			$RatingAtt_percent 		= ($RatingAtt / 5) * 100; 
			$RatingRoom_percent 	= ($RatingRoom / 5) * 100; 

			$Client_name 	= $review->Client; 
			$Date 			= $review->Date; 
			$Text 			= $review->Text; 
			
$reviews_array_list = $reviews_array->ReviewList;

if($review == end($reviews_array_list)) {
	$html_comment_class = "card-comment card-comment-last";
} else {
	$html_comment_class = "card-comment";
}

?>
				
				
				<article class="review-medic-block">
				   <div class="card <?php echo $html_comment_class; ?>" data-timeline="comment">
						<header class="card-heading mw-lightGray review-title-medic">
							<h2 style=" display: inline; line-height: 26.4px;" class="card-title m-t-5"><?php echo $Client_name; ?></h2>
							<span class="pull-right reviews-single-date"> <?php echo $Date; ?> </span>
						</header>
						<div class="card-body">
							<p> <?php echo $Text; ?> </p>
						</div>
						<div class="card-footer mw-lightGray p-10 rating-medic-single">
							<div class="row">
								<div class="col-md-4"> 
									<div class="rating-number-block">
										<div class="title-rating-single-comment"> Квалификация </div>
										<div class="under-title">  
											<div class="star-ratings-css"> 
												<div class="star-ratings-css-top" style="width: <?php echo $RatingQlf_percent; ?>%">
													<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
												</div>
												<div class="star-ratings-css-bottom">
													<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
												</div>
											</div>
										</div>
									</div>
									
								</div>
								<div class="col-md-4"> 
									<div class="rating-number-block">
										<div class="title-rating-single-comment"> Внимание </div>
										<div class="under-title">  
											<div class="star-ratings-css"> 
												<div class="star-ratings-css-top" style="width: <?php echo $RatingAtt_percent; ?>%">
													<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
												</div>
												<div class="star-ratings-css-bottom">
													<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">  
									<div class="rating-number-block">
										<div class="title-rating-single-comment"> Цена-качество </div>
										<div class="under-title">  
											<div class="star-ratings-css"> 
												<div class="star-ratings-css-top" style="width: <?php echo $RatingRoom_percent; ?>%">
													<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
												</div>
												<div class="star-ratings-css-bottom">
													<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
					  </div>
				   </div>
				</article>
					
		<?php } ?> 
			
	<?php } ?>	
						
                        </div>
						
						
						
						
				<?php endwhile; ?> 
			<?php endif; ?>
				
					</div>	

                  </div>
               </div>
				
            </div>
			
			<div style="clearfix"> </div>
			
            </div>
			
			
	<?php
			
			
$term_list = wp_get_post_terms($post->ID, 'speciality', array("fields" => "all"));

$near_term_list = wp_get_post_terms($post->ID, 'metro', array("fields" => "all"));

$items_term_list = wp_get_post_terms($post->ID, 'metro', array("fields" => "all"));
$switch = "metro";

if($items_term_list === array()) {
	$items_term_list = wp_get_post_terms($post->ID, 'district', array("fields" => "all"));
	$switch = "district";
}



foreach($items_term_list as $value) {
	$point_array[] = $value->term_id;	
}



foreach ($term_list as $value) {
	$term_id = $value->term_id;
	$count = $value->count;
	$term_list_array[$term_id] = $count;	
}

arsort ($term_list_array);


reset($term_list_array); 
$near_cat = key($term_list_array);

if($near_cat) {
	
	$my_plugins_folder = WP_PLUGIN_DIR;
	$near_path = $my_plugins_folder . '/docdoc105/json/near/' . $switch . '/' . $near_cat . '.txt';

}

		
	$near_speciality = file_get_contents($near_path);
	$near_speciality_serialize = unserialize($near_speciality);

	
foreach($point_array as $value) {
	$tmp_array = $near_speciality_serialize[$value];
	foreach($tmp_array as $tmp_value) {
		$near_post_ids_array[] = $tmp_value;
	}
	
}	



$near_post_ids_array = array_unique($near_post_ids_array);

shuffle($near_post_ids_array);
$near_post_ids_array = array_slice($near_post_ids_array, 0, 8);



	?>
			
			<div class="row">
				<div class="col-md-12 ofh col-xs-12">
					<h2 class="underline-title"> Врачи поблизости </h2>
				</div>
			</div>
<?php 
	
	
	
	if($near_post_ids_array) {
		$args = array( 
			'post_type' => 'medic',
			'post__in' => $near_post_ids_array, 
			'post__not_in' => array($current_medic_id) 
		);
		
		
	} else {
		$args = array( 
			'post_type' => 'medic',
			'posts_per_page' => 7,
			'orderby' => 'rand',
			'tax_query' => array(
				array(
					'taxonomy' => 'speciality',
					'field'    => 'term_id',
					'terms'    => $near_spec_current_medic,
					'operator' => 'IN',
				),
			),
		);
		
		
	}
		
		
		$b=1; $c=1; $num=0;
	$recent = new WP_Query($args);
	while($recent->have_posts()) : $recent->the_post(); 
			
			$near_post_thumbnail_id = get_post_thumbnail_id( $post->ID ); 
			if($near_post_thumbnail_id) { 
					$post_thumbnail_url = lazy_image_size($near_post_thumbnail_id, 162, 162, 1); 
					$near_current_image = $post_thumbnail_url[0]; 
				} else { 
					$near_current_image = "http://placehold.it/120x120";
				} 
				
				$near_current_title 		= get_the_title($post->ID); 
				$near_pieces_title 			= explode(" ", $near_current_title); 
				
				$near_wp_clinics_ids 	= get_post_meta($post->ID, "wp_clinics_ids", true);
				
				$near_medic_MetroIds = wp_get_post_terms( $post->ID, 'metro'); 
				
				$near_medic_array = get_post_meta($post->ID, "array", true); 
					$near_ExperienceYear 	= $near_medic_array->ExperienceYear;
					$near_Price 			= $near_medic_array->Price;
					$near_SpecialPrice 		= $near_medic_array->SpecialPrice;
					$near_Rating 			= $near_medic_array->Rating; 
					$near_ClinicsInfo 		= $near_medic_array->ClinicsInfo;
					$near_OpinionCount 		= $near_medic_array->OpinionCount;
					
					$near_rating_percent 	= ($near_Rating / 5) * 100; 
					
					$near_reviews_array = get_post_meta($post->ID, "reviews_array", true); 
				
			if($b >= 5) {
				$html_class = "60px";
			} else { 
				$html_class = "30px";
			} 
		
		if(($near_Price or $near_SpecialPrice) and $c <= 6) { 
			
		
		
	?>
	
	<div class="row">
	
	<?php if($c != 1) {  ?>
		<div class="col-md-12">
			<div class="clear-both"> </div>
			<div class="betwen-section"> </div>
			<div class="clear-both"> </div>
		</div>
	<?php } ?>
	
		<div class="col-md-8 col-sm-12 col-xs-12">
			<div class="near-single-medic" style="margin-bottom: 30px; overflow: hidden;">
				<div class="near-single-medic-title"> <a href="<?php the_permalink(); ?>"><span><?php echo $near_pieces_title[0]; ?> </span> <?php $a=1; 
					foreach($near_pieces_title as $near_piece_title) {
						if($a != 1) {
							echo $near_piece_title . ' ';
						} $a++;
					} ?> </a> </div>
				
				
				
				<div class="clearfix"> </div>
				
				<div class="near-medic-photo">
					<img src="<?php echo $near_current_image; ?>" alt="" class="img-circle">
					<div class="photo-expirience">
						<div class="photo-expirience-number">
							Стаж <?php echo chti($near_ExperienceYear,'год','года','лет'); ?>
						</div> 
					</div>
				</div>
				
				<div class="near-medic-category">
					<?php $a=1; 
				$near_term_speciality_fields = wp_get_post_terms($post->ID, 'speciality', array("fields" => "all")); 
					foreach($near_term_speciality_fields as $near_term_speciality_field) { ?>
						<?php if($a <= 3) {
							if($a != 1) { echo ", "; } ?>
							<a href="<?php echo get_term_link($near_term_speciality_field->term_id, 'speciality'); ?>"><?php echo $near_term_speciality_field->name; ?></a>
						<?php } $a++; } ?>
				</div>
				
				<div class="medic-info-rating">
					<div class=" pull-left rating-block-title-clinic-speciality"> Рейтинг <span class="number-reviews-all"><?php echo round($near_Rating, 2); ?></span></div>
					<div class="star-ratings-css star-ratings-css-clinic"> 
						<div class="star-ratings-css-top" style="width: <?php echo $near_rating_percent; ?>%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
						<div class="star-ratings-css-bottom"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
					</div> 
					
					<div class="info-rating-reviews"> 
						<i class="zmdi zmdi-comment-alt-text"></i> Отзывов 
						<a href="<?php the_permalink(); ?>"><span class="info-rating-reviews-number"><?php echo $near_OpinionCount; ?></span></a>
					</div>
					
				</div>
				
				
				
				
				<div class="near-medic-price">
					
					<div class="info-price">
						<div class="info-price-title"> Цена первичного приема </div> 
						<div class="info-price-number">	
							<?php echo ($near_SpecialPrice ?  '<s>' . $near_Price . '</s>' . $near_SpecialPrice : $near_Price );  ?>	
							<span class="info-price-curency"> руб. </span> 
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
		
					<?php 
					
					foreach($near_ClinicsInfo as $ClinicInfo) { 
						$ClinicId 					= $ClinicInfo->ClinicId;
						$ClinicInfo_Specialities 	= $ClinicInfo->Specialities; 
						
						
						
						foreach($ClinicInfo_Specialities as $ClinicInfo_Speciality) { 
							$Clinic_SpecialityId 	= $ClinicInfo_Speciality->SpecialityId;
							$Clinic_Price 			= $ClinicInfo_Speciality->Price;
							$Clinic_SpecialPrice 	= $ClinicInfo_Speciality->SpecialPrice; 
							
				$array_ClinicIds_price[$ClinicId][$Clinic_SpecialityId][Price]			= $Clinic_Price; 
				$array_ClinicIds_price[$ClinicId][$Clinic_SpecialityId][SpecialPrice] 	= $Clinic_SpecialPrice; 
							
						} 
					} 
						
						unset($near_ClinicsInfo);
					
					?>
					
						<h3 class="taxonomy-list-clinics-medic appoiment-near-change"> Этот врач ведёт прём в следующих клиниках <img src="<?php bloginfo('template_url'); ?>/images/level-down-arrow.png" style="height: 26px; position: relative; top: 9px; "> </h3>
						
					<?php $a=1; ?>
					<?php foreach ($near_wp_clinics_ids as $key => $wp_clinic_id) { ?> 
						
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
							
							
							
							<div class="taxonomy-adres near-single-adres-medic<?php echo $adress_class; ?>">
								<span class="adres-clinic-title" style=" font-size: 26px;
    font-family: 'Open Sans Condensed', sans-serif;">Приём в «<a href="<?php echo $clinik_link; ?>" style="    color: #2196f3;"><?php echo $clinic_name; ?></a>» </span>
								<div class="adres-clinic" style=" background: #eceff4; padding: 15px 15px 15px 20px; border-radius: 3px; margin-top: 10px; /* margin-bottom: 10px; */ line-height: 28px; font-family: 'Open Sans Condensed', sans-serif; font-size: 20px;">
									<i class="zmdi zmdi-pin" style="    padding-right: 10px;"></i>
							<?php echo $clinic_street; ?> <?php echo $clinic_house; ?> 
							<?php if($wp_MetroIds) { ?>
								
								<img src="<?php bloginfo('template_url'); ?>/images/metro-logo.png" style="position: relative; bottom: 2px; width: 26px; margin-right: 10px; padding-left: 5px; margin-left: 15px;"> Метро :
								<?php foreach($clinic_stations as $clinic_station) { 
									
									$clinic_station_name 		= $clinic_station->Name; 
									$clinic_station_LineColor 	= $clinic_station->LineColor; ?>
									
									
									<i style="color:#<?php echo $clinic_station_LineColor; ?>;font-size: 12px; position: relative; bottom: 2px; padding: 0px 5px 0px 10px;" class="zmdi zmdi-circle"></i> <?php echo $clinic_station_name; ?> 
									
								<?php } 
									
							} else { 
									
								$wp_DistrictIds = wp_get_post_terms( $post->ID, 'district'); 
								foreach($wp_DistrictIds as $wp_DistrictId){ 
									echo " <span class=\"pull-right\">Район - " . $wp_DistrictId->name . " </span>";  
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
									<?php if($SpecialPrice != 0) { ?>
										
												<s> <?php echo $value[Price]; ?> </s><?php echo $value[SpecialPrice]; ?>  руб. 
												
									<?php } else { ?>
									
										<?php echo $value[Price]; ?> руб.
											
									<?php }  ?>
										
											</span>	
										</div>
									</div>
									
								</div>

								<?php } ?>
								
							<?php } ?>
								</div>
						

								
							</div>
							
						
						
					<?php } $a++; } ?>
		

		
		</div>
		
						<div class="col-md-4 col-xs-12">
							<?php $review_one=1; ?>
							
							<?php $is_empty = $near_reviews_array->ReviewList; ?>
							
						<?php if($is_empty){ ?>
					<?php foreach($near_reviews_array->ReviewList as $review) { ?>
			
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
				<?php } else { ?>
			
				<div class="reviews-inclinic-star">
					
					<div class="last-review-title"> О данном враче пока нет отзывов. </div>
					
				</div>
			<?php } ?>
			
						</div>
		</div>

		
		
		
		
	<?php $c++; $num++; } $b++; endwhile; ?>
			
		<div class="row">
			<div class="clear-both"> </div>
			<div class="col-md-12">
				<?php include(dirname(__FILE__).'/includes/call-support.php');  ?>	
			</div>
			
		</div>
		
				
		
		
		
		
		
      </div>
	  
   </div>
	
	
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog medic-modal">
			  <div class="modal-content">
				
				<div class="modal-header">
				
					<div class="modal-single-medic">
					   <figure class="th-autherdp single-plugin-image"> 
							<img src="<?php echo $current_image; ?>">
					   </figure>
						<div class="th-authorcontent block-info-details">
							<div class="th-authorhead">
								<h2 class="modal-title"><?php echo $pieces_title[0]; ?> <span class="title-part-blue">
									<?php 
									$a=1; 
									foreach($pieces_title as $piece_title) {
										if($a != 1) {
											echo $piece_title . ' ';
										}
									$a++; } ?>
										</span>
								</h2>
							</div>
						  <div class="medic-speciality-list"> 
							 <?php $a=1; ?>
					<?php foreach($term_speciality_fields as $term_speciality_field) { ?>
						<span style="color: #688696; font-size: 14px;">
							<?php if($a != 1) { ?>, <?php } ?>		
							<?php echo $term_speciality_field->name; ?> 
						</span>
					<?php $a++; ?> <?php } ?>
							
						  </div>
					<?php $Price 	= $medic_array->Price; 
					 $SpecialPrice 	= $medic_array->SpecialPrice; 
					
						if($Price != 0 or $SpecialPrice != 0) {
							if($SpecialPrice) {
								$price_for_form = $SpecialPrice;
							} else {
								$price_for_form = $Price;
							}
						} else {
							$price_for_form = "Бесплатно";
						}
					?>
							<p class="expicience"> Стаж <?php echo chti($ExperienceYear,'год','года','лет'); ?> </p>
							<div class="medic-prise">
								<span class="cost-medic">
									Стоимость приема - 
									<span class="price"><?php echo $price_for_form; ?></span> 
									<?php if($Price != 0 or $SpecialPrice != 0) { ?>
									<span class="currency">Руб.</span> 
									<?php } ?>
								</span>
							</div>
						</div>
					</div> 

					<div class="clear-both"> </div>
					
		<div class="adress-clinic">
		
		
		
	<?php foreach ($wp_clinics_ids as $wp_clinic_id) { ?> 
		
		<?php $clinic_array 	= get_post_meta($wp_clinic_id, "array", true); ?> 
		<?php $clinik_link 		= get_permalink($wp_clinic_id); ?>
	
		
		<?php $clinic_Id 		= $clinic_array->Id; ?>
		<?php $clinic_name 		= $clinic_array->Name; ?>
		<?php $clinic_city 		= $clinic_array->City; ?>
		<?php $clinic_street 	= $clinic_array->Street; ?>
		<?php $clinic_streetId 	= $clinic_array->StreetId; ?>
		<?php $clinic_house		= $clinic_array->House; ?>
		<?php $clinic_stations 	= $clinic_array->Stations; ?>
				
					<div class="adress-clinic-one adress-clinic-popup address-clinic-popup-id-<?php echo $clinic_Id; ?>">
						
						<span class="adress-clinic-one-link"> 
							Приём в «<?php echo $clinic_name; ?>» <br>
						</span>
						
							<div class="street"> <?php echo $clinic_city; ?>, <?php echo $clinic_street; ?> <?php echo $clinic_house; ?> </div>
								
							<div class="clear-both"> </div>
					
							<div class="metro-all">
								<?php foreach($clinic_stations as $clinic_station) { ?>
									
									<?php $clinic_station_name 		= $clinic_station->Name; ?>
									<?php $clinic_station_LineColor = $clinic_station->LineColor; ?>
									<span class="metro-one"> 
										<i style=" color:#<?php echo $clinic_station_LineColor; ?>;" class="zmdi zmdi-circle"> </i> <?php echo $clinic_station_name; ?> 
									</span>
								<?php } ?>
							</div>
					</div>
		
	<?php } ?>
		
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