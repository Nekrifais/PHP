<?php get_header(); ?>
		<?php $city_terms = get_terms( 'city', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0 ) ); ?> 
		<?php $metro_city_terms = get_terms( 'metro', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) ); ?> 
		<?php $district_city_terms = get_terms( 'district', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) ); ?> 
		<?php $city = get_field('выбор_города', 'option'); ?> 
		<?php $city = array_shift( $city ); ?>
	
	
	
	<?php 
		
		$curTerm 				= get_queried_object(); 
		$curterm_taxonomy 	= $curTerm->taxonomy; 
		$curterm_slug 		= $curTerm->slug; 
		$curTerm_id 			= $curTerm->term_id; 
		
			$query_clinic_speciality_term	= $wp_query->query['clinic-speciality'];

			$query_paged					= $wp_query->query['paged'];
			
			$current_query_metro 		= $wp_query->query['metro']; 
			$current_query_district 	= $wp_query->query['district'];
			
			$hidden_map = get_field('карта_в_рубриках', 'option'); 
			
$args = array(
	'taxonomy'               => array( 'metro' ),
	'meta_key'               => 'Id',
	'meta_value'             => $city,
	'hide_empty'             => false,
);

$term_query = new WP_Term_Query( $args );
	
	
			$current_city_term_id = $term_query->terms[0]->term_id;
	
			$coordinates = get_field('координаты', 'metro_' . $current_city_term_id);
			$zoom = 11;
				
			$docdoc_clinic_speciality_id = get_field('Id', 'clinic-speciality_' . $curTerm_id);
			
				
	?>
			
			
			<?php $docdoc_phone = get_field('телефон_для_записи_в_docdoc', 'option'); ?>
			
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
            $crumb = '<li><a href="' . get_term_link($tmpTerm, get_query_var('taxonomy')) . '">' . $tmpTerm->name . '</a> <i class="zmdi zmdi-home"> </i> </li>';
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
					
			<?php if($hidden_map == 2) { ?>
				
		<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
	    <script src="//yandex.st/jquery/2.2.3/jquery.min.js" type="text/javascript"></script>

    <script> ymaps.ready(init);

function init () {
    var myMap = new ymaps.Map('map', {
            center: [<?php echo $coordinates; ?>],
            zoom: <?php echo $zoom; ?>
        }, {
            searchControlProvider: 'yandex#search'
        }),
        objectManager = new ymaps.ObjectManager({
            // Чтобы метки начали кластеризоваться, выставляем опцию.
            clusterize: true,
            // ObjectManager принимает те же опции, что и кластеризатор.
            gridSize: 32,
            clusterDisableClickZoom: false
        });
		
	myMap.behaviors.disable('scrollZoom');
	
    // Чтобы задать опции одиночным объектам и кластерам,
    // обратимся к дочерним коллекциям ObjectManager.
    objectManager.objects.options.set('preset', 'islands#greenDotIcon');
    objectManager.clusters.options.set('preset', 'islands#yellowClusterIcons');
    myMap.geoObjects.add(objectManager);

    $.ajax({
        url: "<?php bloginfo('url'); ?>/wp-content/plugins/docdoc105/json/clinic-maps/clinic-speciality-<?php echo $docdoc_clinic_speciality_id; ?>.json"
    }).done(function(data) {
        objectManager.add(data);
    });

}

</script>

	<style>
        #map {
            width: 100%; height: 450px; padding: 0; margin: 0;
        }
    </style>

<div id="map"> </div>

			<?php } ?>

<?php  

$category_description = get_field('описание_категории', 'clinic-speciality_' . $curTerm_id); 

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
		$field_h1 = 'single_h1_for_clinic_speciality-' . $curTerm_id; 
		$field_textdescription = 'single_textdescription_for_clinic_speciality-' . $curTerm_id; 
		$h1 = get_option($field_h1);
		$textdescription = get_option($field_textdescription);
	}

?> 

		<div class="container">
			<div class="row">
				
					<div class="col-md-12">
						
						<div class="themeum-title yes taxonomy taxonomy-clinic-speciality">
							<h3 class="style-title">
							
						<?php if($h1) {
							 echo $h1;
						} else { 
							single_cat_title(); 
						} ?> </h3>
							
							<div class="taxonomy-description"> 		
							<?php $current = get_query_var('paged'); ?>
							<?php if($current == 0){ ?>
								<?php if($query_metro_term != "" or $query_district_term != ""){
									echo $textdescription; 
								 } else { 
									if($category_description) {
										echo $category_description; 
									} else {
										echo $textdescription;
									}
								} ?>
								<?php } ?>
							</div>
							
						</div>
						
					</div>
				
				<div class="clearfix"> </div>
				
					<?php require_once(dirname(__FILE__).'/includes/filters/filter-clinic-speciality.php'); ?>
				
				<?php $post_count_output = get_option('posts_per_page'); ?>
				
				<div class="col-md-9">
					<div class="taxonomy-block">
						<?php $betwen = 1; ?>
			<?php if (have_posts()) { ?>
				<?php while (have_posts()) : the_post(); ?>
					
					
					<?php $post_thumbnail_id = get_post_thumbnail_id( $post->ID ); ?> 
					<?php if($post_thumbnail_id) { 
						$post_thumbnail_url = lazy_image_size($post_thumbnail_id, 162, 162, 0); 
						$current_image = $post_thumbnail_url[0]; 
					} else { 
						$current_image = "http://placehold.it/162x162";
					} 
					
					$current_title 		= get_the_title($post->ID); 
					$pieces_title 		= explode(" ", $current_title); ?>
					
					
					
							<?php $wp_MetroIds = wp_get_post_terms( $post->ID, 'metro'); ?>
							<?php $clinic_array = get_post_meta($post->ID, "array", true); ?> 
								<?php $Description 			= $clinic_array->Description; ?>
								<?php $Price 				= $clinic_array->Price; ?>
								<?php $SpecialPrice 		= $clinic_array->SpecialPrice; ?>
								<?php $PhoneAppointment 	= $clinic_array->PhoneAppointment; ?>
								<?php $TypeOfInstitution 	= $clinic_array->TypeOfInstitution; ?>
								<?php $Rating 				= $clinic_array->Rating; ?>
								<?php $rating_percent = $Rating * 10; ?>
								<?php $rating_number 	= $Rating / 2; ?>
								
		<?php $clinic_street 	= $clinic_array->Street; ?>
		<?php $clinic_streetId 	= $clinic_array->StreetId; ?>
		<?php $clinic_house		= $clinic_array->House; ?>
		<?php $clinic_stations 	= $clinic_array->Stations; ?>
								
								
		<?php 
						
						if($docdoc_phone) {
							$call_phone = $docdoc_phone;
						} else {
							$call_phone = $PhoneAppointment;
						}
						
						
						
		?>
								
					
								
						<div class="taxonomy-item">
							<div class="col-md-12">
								<div class="row">

									<div class="container-fluid taxonomy-photo-clinic">
										<div class="row-fluid single-logo clinic-speciality-logo">
											<div class="centering text-center photo-img">
												<img class="img-clinic-logo-single" src="<?php echo $current_image; ?>">
											</div>
										</div>
									</div>
									
									<div class="taxonomy-info">
										<div class="info-title sign-up-titile-clinic underline-title">
											<a href="<?php the_permalink(); ?>" class=""> <span> <?php echo $pieces_title[0]; ?> </span>
											
												<?php $a=1; foreach($pieces_title as $piece_title) {
												if($a != 1) {
													echo $piece_title . ' ';
												} $a++; } ?> 
													
											</a>
										</div>
										
										<div class="info-clinic-type">
											<span><?php echo $TypeOfInstitution; ?></span>
										</div>
	<div class="tax-clinic-rating">				
		<div class="pull-left rating-block-title-clinic-speciality"> Рейтинг <span class="number-reviews-all"><?php echo round($rating_number, 2); ?></span></div>
		<div class="star-ratings-css star-ratings-css-clinic"> 
			<div class="star-ratings-css-top" style="width: <?php echo $rating_percent; ?>%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
			<div class="star-ratings-css-bottom"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
		</div> 
	</div> 	
										
										<div>
											<div class="info-phone">
												<i class="zmdi zmdi-tablet-mac"></i> <?php echo $call_phone; ?>
											</div>
										</div>
									</div>
										<div class="clearfix"> </div> 
										<div class="info-description">
											<?php the_content(); ?>
										</div>
								</div>
							</div>
							
						
							<div class="taxonomy-adres">
								<div class="adres-clinic">
									<i class="zmdi zmdi-pin"></i>
							<?php echo $clinic_street; ?> <?php echo $clinic_house; ?> 
							<?php if($wp_MetroIds) { ?>
								<img src="<?php bloginfo('template_url'); ?>/images/metro-logo.png"> Метро :
								<?php foreach($clinic_stations as $clinic_station) { 
									
									$clinic_station_name 		= $clinic_station->Name; 
									$clinic_station_LineColor 	= $clinic_station->LineColor; ?>
									
									 <i style=" color:#<?php echo $clinic_station_LineColor; ?>;" class="zmdi zmdi-circle"></i> <?php echo $clinic_station_name; ?> 
								<?php } 
									
							} else { 
									
								$wp_DistrictIds = wp_get_post_terms( $post->ID, 'district'); 
								foreach($wp_DistrictIds as $wp_DistrictId){ 
									echo " <span class=\"pull-right\">Район - " . $wp_DistrictId->name . "</span>";  
								} 
							} ?>
									
								</div>

							</div>
							
							
						</div>
						<?php if($betwen != $post_count_output) { ?>
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
				
				<div class="col-md-3">
				
					<?php if ( is_active_sidebar( 'right_clinic_speciality' ) ) : ?>
						<?php dynamic_sidebar( 'right_clinic_speciality' ); ?>
					<?php endif; ?>
					
				</div>
				
			</div>
		</div>
				
				
				
				</div>
				
				
		
				
				
				
				
<?php get_footer(); ?>