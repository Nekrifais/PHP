<?php 
	/* 	
		Template Name: Карта
	*/
get_header(); 


	$current_page_id = get_the_id();
	$current_link = get_permalink($current_page_id);

	$city = get_field('выбор_города', 'option');
	$city = array_shift( $city );
	
	
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
												<a href="<?php bloginfo('url'); ?> "> <i class="zmdi zmdi-home"> </i>  Главная</a>
											</li>
											
											<li class="last">
												<span><?php the_title(); ?></span>
											</li>
											
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				
				
				
			<div class="container">
				<div class="row">
				
					<div class="col-md-12">
					
					<?php if (have_posts()) : ?>
						<?php while (have_posts()) : the_post(); ?>
					
						<div class="top-map">
							<div class="row top-search">
								<div class="col-md-12 header-text">
									<h1 class="top-map-title"><?php the_title(); ?> </h1>
								</div>
								
								
					

					
		<?php $all_specialities = get_terms( 'speciality', array( 'orderby' => 'count', 'hide_empty' => 1 ) );
		
	foreach ( $all_specialities as $speciality ) {  
	
		$speciality_wp_id = $speciality->term_id;
		$speciality_name = $speciality->name;
		$speciality_docdoc_id = get_field('Id', 'speciality_' . $speciality_wp_id); ?>
		
		<?php if($_GET['speciality-id'] == $speciality_docdoc_id) { ?>
		
			<style>
			
				#speciality-id-<?php echo $speciality_docdoc_id; ?>{
					color: #2196f3;;
				}
				
			</style>
			
		<?php } ?>
		
		<div class="col-md-4">
			<i id="speciality-id-<?php echo $speciality_docdoc_id; ?>" class="zmdi zmdi-minus map-minus"> </i>  
			<a id="speciality-id-<?php echo $speciality_docdoc_id; ?>" href="<?php echo $current_link; ?>/?speciality-id=<?php echo $speciality_docdoc_id; ?>"> <?php echo $speciality_name; ?> </a>
		</div>
		
	<?php } 

	$post_object = get_post( $current_page_id );
	$map_content = $post_object->post_content; 
	
								if($map_content) { ?>
								
									<div class="col-md-12">
										
										<div class="top-map-description">
											<?php the_content(); ?>
										</div>
										
									</div>
									
								<?php } ?>
								
							</div>
							
						</div>
						
						<?php endwhile; ?> 
					<?php endif; ?>
						
						
						
						<div>
						
		
	<?php if($_GET['speciality-id']) { 
		
		$map_id = $_GET['speciality-id'];
		
	} else {
		
		$map_id = $speciality_docdoc_id;
		
	} ?>
						
						
						
		<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
		<script src="//yandex.st/jquery/2.2.3/jquery.min.js" type="text/javascript"></script>

	<script> 
		
		ymaps.ready(init);

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
			url: "<?php bloginfo('url'); ?>/wp-content/plugins/docdoc105/json/medic-maps/medic-speciality-<?php echo $map_id; ?>.json"
		}).done(function(data) {
			objectManager.add(data);
		});

	}

	</script>

<div id="map"> </div>

	<style>
        #map {
            width: 100%; height: 450px; padding: 0; margin: 0; margin-bottom: 60px;
        }
    </style>
						</div>
						
					</div>
					
				</div>
			</div>
					
			   
            </div>
			
	<?php get_footer(); ?>