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
		
	<?php 
	
	$tax_nameplural = get_field('nameplural', 'speciality_' . $curTerm_id);
	
		
		$docdoc_speciality_id = get_field('Id', 'speciality_' . $curTerm_id); 
		
		
		$hidden_map = get_field('карта_в_рубриках', 'option'); 
		
	$query_orderby				= $wp_query->query['orderby'];
	$sorting_dop				= $wp_query->query['dop'];
	$query_order 				= $wp_query->query['order'];
	
	
	if($query_orderby == "Rating") {
		$sorring_rating_active = ' sorting-class-rating';
	} 
	
	if($query_orderby == "ExperienceYear") {
		$sorring_expirience_active = ' sorting-class-expirience';
	} 
	
	if($query_orderby == "Price") {
		$sorring_price_active = ' sorting-class-price';
	} 
	
	if($query_orderby == "OpinionCount") {
		$sorring_ReviewsCount_active = ' sorting-class-reviews-count';
		$sorring_ReviewsCount_text_active = ' sorting-class-reviews-count-text';
		
	} 
	
	$specialities_docdocid_wpname = get_option('specialities_docdocid_wpname');
		
		
		
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
													<?php 
		
			if($_GET['orderby']) {
				if($_GET['order'] == "ASC") { 
					$arrow = '<i class="fa fa-angle-double-up arrow-breadcrumb" aria-hidden="true"></i>';
				} else { 
					$arrow = '<i class="fa fa-angle-double-down arrow-breadcrumb" aria-hidden="true"></i>';
				} 
			}
			
			
			if($sorting_dop == "child") {
				$sorting_dop_text = ' <i class="fa fa-plus" aria-hidden="true"></i> Детский врач';
			} 
			
			if($sorting_dop == "nadom") {
				$sorting_dop_text = ' <i class="fa fa-plus" aria-hidden="true"></i> Выезд на дом';
			} 
			
			
			if($_GET['orderby'] == "Rating") {
				
				if($_GET['order'] == "ASC") { 
					$text_after_arrow = "сначала наименее рейтинговые";
				} else {
					$text_after_arrow = "сначала самые рейтинговые";
				}
				
				$breadcrumb_name_sort = '<i class="fa fa-long-arrow-right arrow-breadcrumb" aria-hidden="true"></i> отсортированы по рейтингу ' . $arrow . '(' . $text_after_arrow . ')' . $sorting_dop_text;
				
			} 
			
			if($_GET['orderby'] == "ExperienceYear") {
				
				if($_GET['order'] == "ASC") { 
					$text_after_arrow = " сначала молодые";
				} else {
					$text_after_arrow = "сначала наиболее опытные";
				}
				
				$breadcrumb_name_sort = ' <i class="fa fa-long-arrow-right arrow-breadcrumb" aria-hidden="true"></i> отсортированы по стажу ' . $arrow . '(' . $text_after_arrow . ')' . $sorting_dop_text;
			} 
			
			if($_GET['orderby'] == "Price") {
				
				if($_GET['order'] == "ASC") { 
					$text_after_arrow = " сначала дешевые";
				} else {
					$text_after_arrow = " сначала дорогие";
				}
				
				$breadcrumb_name_sort = '<i class="fa fa-long-arrow-right arrow-breadcrumb" aria-hidden="true"></i>  отсортированы по цене ' . $arrow . '(' . $text_after_arrow . ')' . $sorting_dop_text;
			} 
			
			if($_GET['orderby'] == "OpinionCount") {
				
				if($_GET['order'] == "ASC") { 
					$text_after_arrow = "сначала врачи с меньшим количеством отзывов";
				} else {
					$text_after_arrow = "сначала врачи с большим количеством отзывов";
				}
				
				$breadcrumb_name_sort = ' <i class="fa fa-long-arrow-right arrow-breadcrumb" aria-hidden="true"></i>  отсортированы по отзывом ' . $arrow . '(' . $text_after_arrow . ')' . $sorting_dop_text;
			} 
			
		
	?>
	
								<li class="last">
									<span> <?php echo $tax_nameplural; ?> <?php echo $breadcrumb_name_sort; ?></span>
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
            clusterDisableClickZoom: true
        });
		
	myMap.behaviors.disable('scrollZoom');
	
    // Чтобы задать опции одиночным объектам и кластерам,
    // обратимся к дочерним коллекциям ObjectManager.
    objectManager.objects.options.set('preset', 'islands#greenDotIcon');
    objectManager.clusters.options.set('preset', 'islands#yellowClusterIcons');
    myMap.geoObjects.add(objectManager);

    $.ajax({
        url: "<?php bloginfo('url'); ?>/wp-content/plugins/docdoc105/json/medic-maps/medic-speciality-<?php echo $docdoc_speciality_id; ?>.json"
    }).done(function(data) {
        objectManager.add(data);
    });

}

</script>

<div id="map"> </div>
	
	<style>
        #map {
            width: 100%; height: 450px; padding: 0; margin: 0;
        }
    </style>
	
	<?php } ?>
	
<?php 
	
	$category_description = get_field('описание_категории', 'speciality_' . $curTerm_id);
	
global $seo_data_array;

$query_dop = $wp_query->query['dop'];
$dop_meta = 2;

	if($query_orderby != "") {
		if($query_orderby == "Rating" and $query_order == "") {
			$dop_meta = 3;
		}
		
		if($query_orderby == "ExperienceYear" and $query_order == "") {
			$dop_meta = 3;
		}
		
		if($query_orderby == "Price" and $query_order == "ASC") {
			$dop_meta = 3;
		}
		
		if($query_orderby == "OpinionCount" and $query_order == "") {
			$dop_meta = 3;
		}

	}
	
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
		
		if ($query_dop != "") {
			
			$h1 = (string) $seo_data_array[$curTerm_id][h1];
			$textdescription = (string) $seo_data_array[$curTerm_id][textdescription];
			
		} elseif($query_orderby != "" and $dop_meta == 3) {
			
			$h1 = (string) $seo_data_array[$curTerm_id][h1];
			$textdescription = (string) $seo_data_array[$curTerm_id][textdescription];
			
		} else {
			
			$field_h1 = 'single_h1_for_speciality-' . $curTerm_id; 
			$field_textdescription = 'single_textdescription_for_speciality-' . $curTerm_id; 
			$h1 = get_option($field_h1);
			$textdescription = get_option($field_textdescription);
			
		} 
		
	}

?>
	
	
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
							
							<div class="taxonomy-description"> 
							<?php $current = get_query_var('paged'); ?>
							<?php if($current == 0){ ?>
								<?php if($query_metro_term != "" or $query_district_term != ""){
									echo $textdescription; 
									
								} elseif($query_dop != "") {
									
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
				
				<div style="clear: both;"> </div>
				
					<?php require_once(dirname(__FILE__).'/includes/filters/filter-speciality.php'); ?>
				
				<?php 
				
$b=1; $d=1; 
if($query_metro_term == "" and $query_district_term == "") {
	$sorting_link = get_bloginfo('url') . '/speciality/' . $query_speciality_term . '/';
	$b=2;
	
}

if($query_speciality_term) {
	$sorting_link = get_bloginfo('url') . '/speciality/' . $query_speciality_term . '/';
	$b=2;
}

if($query_metro_term) {
	$sorting_link = get_bloginfo('url') . '/speciality/' . $query_speciality_term . '/metro/' . $query_metro_term . '/';
	$b=2;
} 
	
if($query_district_term) {
	$sorting_link = get_bloginfo('url') . '/speciality/' . $query_speciality_term . '/district/' . $query_district_term . '/';
	$b=2;
} 

if($b != 2) {
	$sorting_link = $sorting_link . "?orderby=" . $_GET['orderby'];
	$d=2;
}



	
	if($_GET['order'] == "DESC" or $_GET['order'] == "") {
		$order_ASC_DESC = '&order=ASC';
	} else {
		$order_ASC_DESC = '';
	}
	
	if($_GET['orderby'] == "") {
		if($_GET['order'] == "ASC" or $_GET['order'] == "") {
			$default_order_ASC_DESC = '?order=DESC';
		} else {
			$default_order_ASC_DESC = '';
		}	
	}
	
	
	
	?>
			
				
	<?php $namepluralgenitive = get_field('namepluralgenitive', 'speciality_' . $curTerm_id); ?>
		
				<?php if($wp_query->found_posts != 0) { ?>
				
					<div class="col-md-12">
						
						<div style=" margin-bottom: 25px; font-size: 18px;"> Сортировать врачей - <?php echo $namepluralgenitive;  echo $_GET['speciality']; ?> по: </div>
						
						<div class="sorting-field">
							<?php if($_GET['orderby'] == "") { ?>
							
								<span class="sotring-link first <?php if($_GET['orderby'] == "") echo "active"; ?>" href="<?php echo get_bloginfo('url') . '/speciality/' . $query_speciality_term . '/'; ?><?php if($_GET['orderby'] == "") echo $default_order_ASC_DESC; ?>"> Популярности </span>
								
							<?php } else { ?>
							
								<a class="sotring-link first" href="<?php echo get_bloginfo('url') . '/speciality/' . $query_speciality_term . '/'; ?><?php if($_GET['orderby'] == "") echo $default_order_ASC_DESC; ?>"> Популярности </a>
								
							<?php } ?>
							<a class="sotring-link <?php if($_GET['orderby'] == "Rating") echo "active"; ?>" href="<?php echo $sorting_link ; ?>?orderby=Rating<?php if($_GET['orderby'] == "Rating") echo $order_ASC_DESC; ?>"> Рейтингу 
							
							
							<?php if($_GET['orderby'] == "Rating") { ?>
								<?php if($_GET['order'] == "ASC") { ?>
									<i class="zmdi zmdi-long-arrow-up"></i>
								<?php } else { ?>
									<i class="zmdi zmdi-long-arrow-down"></i>
								<?php } ?>
							<?php } ?>
							</a>
							<a class="sotring-link <?php if($_GET['orderby'] == "ExperienceYear") echo "active"; ?>" href="<?php echo $sorting_link; ?>?orderby=ExperienceYear<?php if($_GET['orderby'] == "ExperienceYear") echo $order_ASC_DESC; ?>">
							 Стажу
							<?php if($_GET['orderby'] == "ExperienceYear") { ?>
								<?php if($_GET['order'] == "ASC") { ?>
									<i class="zmdi zmdi-long-arrow-up"></i>
								<?php } else { ?>
									<i class="zmdi zmdi-long-arrow-down"></i>
								<?php } ?>
							<?php } ?>
							</a>
							
							<a class="sotring-link <?php if($_GET['orderby'] == "Price") echo "active"; ?>" href="<?php echo $sorting_link; ?>?orderby=Price<?php if($_GET['orderby'] == "Price") echo $order_ASC_DESC; ?>"> Стоимости 
							
							<?php if($_GET['orderby'] == "Price") { ?>
								<?php if($_GET['order'] == "ASC") { ?>
									<i class="zmdi zmdi-long-arrow-up"></i>
								<?php } else { ?>
									<i class="zmdi zmdi-long-arrow-down"></i>
								<?php } ?>
							<?php } ?>
							
							</a>
							<a class="sotring-link last <?php if($_GET['orderby'] == "OpinionCount") echo "active"; ?>" href="<?php echo $sorting_link; ?>?orderby=OpinionCount<?php if($_GET['orderby'] == "OpinionCount") echo $order_ASC_DESC; ?>"> Отзывам 
							
							<?php if($_GET['orderby'] == "OpinionCount") { ?>
								<?php if($_GET['order'] == "ASC") { ?>
									<i class="zmdi zmdi-long-arrow-up"></i>
								<?php } else {?> 
									<i class="zmdi zmdi-long-arrow-down"></i>
								<?php } ?>
							<?php } ?>
							
							</a>
						
						</div>
						
					</div>
						
			<?php } ?>
				
				
				
				
			<?php $post_count_output = get_option('posts_per_page'); ?>
				
				<div class="col-md-9">
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
				
/* 				if($SpecialPrice != 0 or $Price != 0) {
					if($SpecialPrice != 0) {
						$modal_price = $SpecialPrice;
					} else {
						$modal_price = $Price;
					} 
				} else {
					$modal_price = "Бесплатно";
				} */
				/* print_r($medic_array); */
				
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
			<div class="info-rating-reviews"> <i class="zmdi zmdi-comment-alt-text"></i> Отзывов <a href="<?php the_permalink(); ?>"><span class="info-rating-reviews-number"><?php echo $OpinionCount; ?></span></a> </div>
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
									<?php if($SpecialPrice != 0 or $Price != 0) { ?>
										<?php if ($value[SpecialPrice] != 0) { ?>
												<s> <?php echo $value[Price]; ?> </s><?php echo $value[SpecialPrice]; ?>  руб.
												<?php $modal_price = $value[SpecialPrice]; ?>
										<?php } else { ?>
												<?php echo $value[Price]; ?> руб.
												
												<?php $modal_price = $value[Price]; ?>
												
										<?php } 
									} else {  
										$modal_price = "По договоренности."; 
									} ?>
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
					
					<?php endwhile; ?> 
					
			<?php } else { ?>
				
							<span class="title-not-found"> К сожалению, по вашему запросу ничего не найдено. </span>
		<?php 
		
	$else_betwen=1;
	

	if($query_metro_term) {
		
		$file_path = dirname(__FILE__) . '/../../plugins/docdoc105/json/near/metro/' . $curTerm_id . '.txt';
		
		$near_metro_serialize = file_get_contents($file_path);
		
		$near_metro_unserialize = unserialize($near_metro_serialize);
		
		$get_metro_by_slug 		= get_term_by('slug', $query_metro_term, 'metro');
		$get_metro_by_slug_id 	= $get_metro_by_slug->term_id;
		
		$posts_for_query = $near_metro_unserialize[$get_metro_by_slug_id];
		/* print_r($posts_for_query); */
		
		$args = array(
			'post_type' 		=> 'medic',
			'post__in' 			=> $posts_for_query,
		); 
	}


	if($query_district_term) {
		
		$file_path = dirname(__FILE__) . '/../../plugins/docdoc105/json/near/district/' . $curTerm_id . '.txt';
		
		
		
		$near_district_serialize = file_get_contents($file_path);
		
		
		
		$near_district_unserialize = unserialize($near_district_serialize);
		$get_district_by_slug = get_term_by('slug', $query_district_term, 'district');
		
		$posts_for_query = $near_district_unserialize[$get_district_by_slug->term_id];
		
		$args = array(
			'post_type' 		=> 'medic',
			'post__in' 			=> $posts_for_query,
		); 
	}


	if($posts_for_query != ""){
		
	
	
?>
				
		
				
		<?php $recent = new WP_Query($args);
		while($recent->have_posts()) : $recent->the_post(); 
			
			include(dirname(__FILE__).'/includes/else-medic.php'); ?>
			
				<div class="clear-both"> </div>
				<div class="betwen-section"> </div> 
			<?php $else_betwen++;
		endwhile; ?> 
				
				
				
				
				
				
			<?php } ?>
			<?php } ?>
						
					</div>
			<?php if( function_exists('navigation_pages') ) { navigation_pages(); } ?>
				</div>
				
				
				<div class="col-md-3">
					
					<?php if ( is_active_sidebar( 'right_speciality' ) ) : ?>
						<?php dynamic_sidebar( 'right_speciality' ); ?>
					<?php endif; ?>
					
				</div>
				
				
			</div>
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