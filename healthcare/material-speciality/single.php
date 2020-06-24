<?php if(function_exists('PostViews')) { PostViews(get_the_ID()); } 

get_header(); ?>
		 
		 
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
											
											<?php $categories = get_the_category(); ?>
											<?php foreach($categories as $category ) { ?>
												
												<li>
													<a href="<?php echo get_category_link($category->term_id); ?> "> <?php echo $category->cat_name; ?> </a>
												</li>
												
											<?php } ?>
											
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
						
							<div id="content" class="container">
								  <div class="row">
									<div class="col-xs-12 col-md-12">
									 
										<div class="single-post">
											
										   <header class="card-heading">
											  <h1 class="card-title"><?php the_title(); ?></h1>
										   </header>
										   
										   <div class="card-body">
												<?php the_content(); ?>
										   </div>
											 <?php comments_template(); // Get wp-comments.php template ?>
										</div>

									</div>
								</div>
							</div>
						
						<?php endwhile; ?> 
					<?php endif; ?>
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
			   						<!--	<div id="content" class="container">
								  <div class="row">
									<div class="col-xs-12 col-md-12">
									
									
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
				'posts_per_page' => 5,
				'post_type' => 'clinic',
				'orderby' => 'rand',
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
									
									
									
									
									            </div>
            </div>
            </div> -->
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									

            </div>
			
	<?php get_footer(); ?>