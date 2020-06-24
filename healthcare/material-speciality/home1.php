<?php get_header(); ?>
	
			<?php $categories_option = get_field('список_рубрик_на_главной', 'option'); ?>
			<?php $titile_down_description = get_field('заголовок_для_описание_на_главной_снизу', 'option'); ?>
			<?php $text_down_description = get_field('текст_описания_на_главной_снизу', 'option'); ?>
			<?php $best_clinic_description = get_field('описание_на_главной_лучшие_клиники', 'option'); ?>
			<?php $tax_slide_id = get_field('выбор_таксономии_для_слайда_на_главной', 'option'); ?>
			<?php $tax_slide_text = get_field('текст_для_слайда_на_главной', 'option', false); ?>
			<?php $tax_slide_img = get_field('картинка_для_слайда_на_главной', 'option'); ?>
			
		
			
			<section id="content_outer_wrapper">
				<div id="content_wrapper" class="row-offcanvas">
				
					<?php require_once(dirname(__FILE__).'/includes/top-menu.php'); ?>
				
		<div class="container">
			<div class="row">
			
				<?php require_once(dirname(__FILE__).'/includes/filters/filter-home.php'); ?>
				
				<div class="col-md-3">

	<div class="useful-wrap">
	
	<?php $c =1;
		$locations = get_nav_menu_locations();
			$items = wp_get_nav_menu_object( $locations['left_home_menu'] );
			$menu_items = wp_get_nav_menu_items($items->term_id); 
			foreach ( $menu_items  as $menu_item ) {
			$value = get_post_meta( $menu_item->ID );
		    $image = $value["menu-item-FieldImage"][0]; ?>
			
				<?php if($c <= 5) { ?>
				
					<a href="<?php echo $menu_item->url; ?>">
						<div class="useful vistavka change-left change-vistavka" style="background: url(<?php echo $image; ?>) 0px 23px no-repeat;">
							<div class="name"><?php echo $menu_item->title; ?></div>
							<p class="small"><?php echo $menu_item->description; ?></p>
						</div>
					</a>
			
				<?php } ?>
			
			<?php $c++; } ?>
			
		
    </div>
				
				</div>
				
			<?php $tax_slide = get_term_by('id', $tax_slide_id, 'uslugi'); ?>
				<?php $tax_slide_term_id = $tax_slide->term_id; ?>
				<?php $tax_slide_docdoc_id = get_field('Id', 'uslugi_' . $tax_slide_term_id); ?>
				
				
				
				
<div class="col-xs-12 col-sm-12 col-md-9">
   <div id="hero" class="homebanner-holder">
      <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">
         <div class="item image-border5" style="background-image: url(<?php echo $tax_slide_img; ?>); ">
			<div style="background: rgba(0, 0, 0, 0.35) !important; height: 370px;">
				<div class="container-fluid">
				   <div class="caption bg-color vertical-center text-left">
					  <a class="sliders_link" href="">
						 <div class="big-text fadeInDown-1 shadow-black">
							<?php echo $tax_slide->name; ?>
						 </div>
						 <div class="excerpt fadeInDown-2 hidden-xs">
							<span class="shadow-black" style="font-size:20px; color: #fff;"> <?php echo $tax_slide_text; ?> </span>
						 </div>
					  </a>
					  <div class="slider-block">
					  
		<?php 
		$a=0;
$args = array(
	'post_type' => 'clinic',
	'posts_per_page' => 3,
	'tax_query' => array(
		array(
			'taxonomy' => 'uslugi',
			'field'    => 'term_id',
			'terms'    => array( $tax_slide_term_id ),
		),
	),
);
		
		$recent = new WP_Query( $args );
		while($recent->have_posts()) : $recent->the_post(); ?>
		
		<?php if($a == 0) {
			$html_class = "left-home-slider-first";
		} else { 
			$html_class = "left-home-slider";
		} 
		
		$clinic_array = get_post_meta($post->ID, "array", true);
		
		$service_array = $clinic_array->Services->ServiceList;
		
		?> 
		
					<?php foreach($service_array as $clinic_service) { 
						
						$clinic_service_name = $clinic_service->ServiceName;
						$clinic_service_id = $clinic_service->ServiceId;
						$clinic_service_price = $clinic_service->Price;
						$clinic_service_special_price = $clinic_service->SpecialPrice;
						
						
						if($tax_slide_docdoc_id == $clinic_service_id){
							
							$slide_array[clinic_service_name][$a] = $clinic_service_name;
							$slide_array[clinic_service_id][$a] = $clinic_service_id;
							$slide_array[clinic_service_price][$a] = $clinic_service_price;
							$slide_array[clinic_service_special_price][$a] = $clinic_service_special_price;
							
						}
						
						
					} 
					
					
					?>
					
					
					
					
						 <div class="<?php echo $html_class; ?>">
							<i class="fa fa-minus slider-minus" aria-hidden="true"></i> 
							<span class="broker-down-link slider-sub-title"> 
								<a class="slide-goods-link" href="<?php the_permalink(); ?>" style="color: #fff;">
									<i class="zmdi zmdi-minus"> </i> 
									<?php the_title(); ?> 
								</a> 
							</span>
							<span class="price slider-price"> от 
							
							<?php 
							
								if($slide_array[clinic_service_special_price][$a]) { ?>
									<s> <?php echo $slide_array[clinic_service_price][$a] ?> </s> <?php echo $slide_array[clinic_service_special_price][$a]; ?>
								<?php } else { 
									
									echo $slide_array[clinic_service_price][$a]; 
									
								} ?> руб.
							</span>
							<div class="clearfix"> </div>
						 </div>
						 
				
					
		<?php $a++; ?> <?php endwhile; ?>
					  
					  
					  </div>
				   </div>
				</div>
			</div>
         </div>
      </div>
   </div>
	<div class="info-boxes wow fadeInUp">
	
	
	
		<div class="info-boxes-inner info-box-0055 bottom-slider-support">
			
			<?php require_once(dirname(__FILE__).'/includes/call-support.php');  ?>
			
			
		</div>
	
	
	
   </div>
</div>
				
				
				<?php $best_clinic = get_terms( 'clinic-speciality', array( 'hide_empty' => 0, 'orderby' => 'count', 'order' => 'DESC'  ) ); ?>
				
		<?php $best_clinic_slug = $best_clinic[0]->slug; ?>
				
					<div class="col-md-12 col-xs-12">
						
						<div class="themeum-title yes ">
							<div class="best-clinic-home">
								<img style="top: 11px;" class="left-icon-home" src="<?php bloginfo('template_url'); ?>/images/best-clinic.png"> 
								<h3 class="style-title">Лучшие клиники</h3>
								<a href="<?php bloginfo('url'); ?>/clinic-speciality/<?php echo $best_clinic_slug; ?>/" class="title-link pull-right hidden-xs hidden-sm">Просмотреть все клиники
									<img src="<?php bloginfo('template_url'); ?>/images/double-angle-pointing-to-right.png"> 
								</a>
							</div>
							<div class="best-clinic-description">
								<?php echo $best_clinic_description; ?>
							</div>
							
						</div>
						
						<div class="row">
						
						<?php $locations = get_nav_menu_locations();
							$items = wp_get_nav_menu_object( $locations['best_clinic_home_menu'] );
							$menu_items = wp_get_nav_menu_items($items->term_id); 
							foreach ( $menu_items  as $menu_item ) { ?>

								<?php $post_thumbnail_id = get_post_thumbnail_id( $menu_item->object_id ); ?> 
									<?php if($post_thumbnail_id) { 
										$post_thumbnail_url = lazy_image_size($post_thumbnail_id, 200, 150, 0); 
										$current_image = $post_thumbnail_url[0]; 
									} else { 
										$current_image = "http://placehold.it/200x150";
									} 
								
								$clinic_array = get_post_meta($menu_item->object_id, "array", true); 
									$Rating 			= $clinic_array->Rating; 
									$rating_percent 	= $Rating * 10; 
									$rating_number 		= $Rating / 2; 
									
									
									?>
							
								<div class="col-md-3">
									<div class="home-block-show">
										<div class="top-show-block">
											<div class="container-fluid">
												<div class="row-fluid">
													<div class="centering text-center image-top-show">
														<img class="slider-image-home" src="<?php echo $current_image; ?>">
													</div>
												</div>
											</div>
											<div class="show-block-gradient"> </div>
										</div>
										<div class="bottom-show-block">
											<span class="home-show-title">
												<a href="<?php echo $menu_item->url; ?>"><?php echo $menu_item->title; ?></a>
											</span>
											<div class="under-title"> Рейтинг <?php echo round($rating_number, 2); ?>
											
												<div class="star-ratings-css pull-right"> 
													<div class="star-ratings-css-top" style="width: <?php echo $rating_percent; ?>%">
														<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
													</div>
													<div class="star-ratings-css-bottom">
														<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
													</div>
												</div>
											
											</div>
											
											
									<a href="<?php echo $menu_item->url; ?>" class="btn btn-primary btn-block button-slide-home-more"> Подробнее</a>
										</div>
										
									</div>
								</div>
						
							<?php } ?>
							
						</div>
					</div>
				
			</div>
		</div>
			
			
			
		<?php $title_green = get_field('заголовок', 'option'); ?>
		<?php $description_green = get_field('описание', 'option'); ?>
		<?php $rows_green = get_field('списки', 'option'); ?>
		
			<div class="green-bottom-block">
				<div class="container">
					<div class="row">	
						
						<div class="col-md-12 green-description">
							<div class="green-home-title"> <?php echo $title_green; ?> </div>
							<?php echo $description_green; ?>
						</div>
						
					<?php if($rows_green) { ?>
					<?php $a=1; ?>
						<?php foreach($rows_green as $row) { 

							$green_id = $row['выберите_страницу_или_запись']; 
								$green_list_title = get_the_title($green_id); 
								$green_list_link = get_permalink($green_id); ?>
							
							<div class="col-md-3"> 
								<div class="list-bottom"> 
									<a href="<?php echo $green_list_link; ?>"> 
										<i class="zmdi zmdi-minus"></i> 
										<span><?php echo $green_list_title; ?></span> 
									</a> 
								</div> 
							</div> 
							
						<?php $a++; ?><?php } ?>
					<?php } ?>
					
					</div>
				</div>
			</div>
				<div style="margin-bottom: 30px;">
					<div class="container">
						<div class="row"> 
						
							<div class="col-md-12">
							
								<div class="themeum-title yes clinic-themeum-title">
									<img class="left-icon-home" src="<?php bloginfo('template_url'); ?>/images/star.png" style="position:relative; padding-right: 10px; top: 10px;"><h3 class="style-title">Статьи</h3>
									<a href="<?php echo get_post_type_archive_link( 'post' ); ?>" class="title-link pull-right hidden-xs hidden-sm">Просмотреть все статьи<img src="<?php bloginfo('template_url'); ?>/images/double-angle-pointing-to-right.png"> </a>
								</div>
								<ul class="list-unstyled list-inline text-left best-clinic-cat">
										<li class="clinic-cat-item first">
											<a href="#"> Последние </a>
										</li>
									<?php foreach($categories_option as $cat_one) { 
										$cat_link = get_category_link( $cat_one ); 
										$cat_title = get_cat_name( $cat_one ); 
										if($categories_option[0] == $cat_one) {
											$html_list_class = "clinic-cat-item first";
										} else {
											$html_list_class = "clinic-cat-item";
										}
									?>
										
										<li class="clinic-cat-item">
											<a href="<?php echo $cat_link; ?>"> <?php echo $cat_title; ?></a>
										</li>
										
									<?php } ?>
									
								</ul>
								
							</div>
							
						</div>
						
						
			<?php $big_posts 	= get_field('количество_постов_на_главной_больших', 'option'); ?>
			<?php $small_posts	= get_field('количество_постов_на_главной_маленьких', 'option'); ?>
						
			<?php if($big_posts) { ?>
				<div class="row">
			<?php $a=0; ?>
		<?php $recent = new WP_Query("showposts=" . $big_posts);
		while($recent->have_posts()) : $recent->the_post(); ?>
			<?php $post_thumbnail_id = get_post_thumbnail_id( $post->ID ); ?> 
			<?php if($post_thumbnail_id) { 
				$post_thumbnail_url = lazy_image_size($post_thumbnail_id, 555, 420, 1); 
				$current_image = $post_thumbnail_url[0]; 
			} else { 
				$current_image = "http://placehold.it/555x420";
			} ?> 
			
			<?php if(($a % 3) == 0) { ?>
				
				</div>
				
				<div class="row">
				
			<?php } ?>
			
			<div class="col-md-6">
				
				<div class="home-big-post">
				   <div class="wand-item">
					  <div class="background-slider" style="background-image:url('<?php echo $current_image; ?>');"> </div>
						<div class="rst_inner_info2">
							<span class="rst_category_name"><?php $category = get_the_category();  if($category[0]){
		echo '<a style="padding: 2px 10px 2px; border-radius: 3px; line-height: 18px !important; background-color: #81b43a; color: #fff;" href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>'; } ?></span>										
							<div class="box-title-sldier">
								<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							</div>
							<p class="rst-inner-meta-info">
								<?php the_content_limit(230, "..."); ?>
							</p>
						</div>
				   </div>
				</div>
				
			</div>
	
		<?php $a++; ?><?php endwhile; ?>
			</div>
			<?php } ?>
			
		<?php if($small_posts) { ?>
			<div class="row">
			<?php $a=0; ?>
			<?php $recent = new WP_Query("showposts=" . $small_posts .  "&offset=" . $big_posts );
			while($recent->have_posts()) : $recent->the_post(); ?>
			<?php $post_thumbnail_id = get_post_thumbnail_id( $post->ID ); ?> 
			<?php if($post_thumbnail_id) { 
				$post_thumbnail_url = lazy_image_size($post_thumbnail_id, 555, 420, 1); 
				$current_image = $post_thumbnail_url[0]; 
			} else { 
				$current_image = "http://placehold.it/555x420";
			} ?> 
			
			<?php if(($a % 3) == 0) { ?>
				
				</div>
				
				<div class="row">
				
			<?php } ?>
			
				<div class="col-md-4">
					<div class="home-small-post">
						<img src="<?php echo $current_image; ?>">
						<div class="comment-view-block">
							<div class="comment-view-info">
								<i class="zmdi zmdi-comment-alt"></i>
								<span><?php echo rand(1, 50); ?></span>
							</div>
							<div class="comment-view-info">
								<i class="zmdi zmdi-eye"></i>
								<span><?php echo get_PostViews($post->ID); ?></span>
							</div>
						</div>
						<a class="home-small-post-title" href="<?php the_permalink(); ?>"><h3 class="lead__title"><?php the_title(); ?></h3></a>
						<p class="home-small-post-text"><?php the_content_limit(230, "..."); ?></p>
					</div>
				</div> 
			
			
			<?php $a++; ?><?php endwhile; ?>
		
						</div>
		<?php } ?>	
					
					</div>
				</div>
					
				
				</div>
				
			<?php require_once(dirname(__FILE__).'/includes/description-bottom.php'); ?>
		
		
		
<?php get_footer(); ?>