<?php get_header(); 

		$curTerm 		= get_queried_object(); 
		$curTerm_id 	= $curTerm->term_id; ?>
		
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
											<li class="last">
												<span><?php single_cat_title(); ?></span>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>

								
					
		<div class="container">
			<div class="row">
				
				<?php $category_description = get_field('описание_категории', 'category_' . $curTerm_id); ?>
				
				<div class="col-md-12">
				

						
					<div class="themeum-title yes taxonomy archive-category">
						<h3 class="style-title"><?php single_cat_title(); ?></h3>
							
						<div class="taxonomy-description"> 
							<?php echo $category_description; ?>
						</div>
							
					</div>
						
				
					<div class="row">
				<div class="col-md-12"> 
				
					<?php $post_count_output = get_option('posts_per_page'); ?>
					<?php $betwen = 1; ?>
					
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
				
					<?php $post_thumbnail_id = get_post_thumbnail_id( $post->ID ); ?> 
					<?php if($post_thumbnail_id) { 
						$post_thumbnail_url = lazy_image_size($post_thumbnail_id, 360, 206, 1); 
						$current_image = $post_thumbnail_url[0]; 
					} else { 
						$current_image = "http://placehold.it/360x206";
					} ?>
				
				<div class="row">
					<div class="archive-item">
						
						<div class="col-md-4">
							<div class="archive-photo">
								<div class="row-fluid archive-logo clinic-speciality-logo">
									<div class="centering text-center photo-img">
										<img src="<?php echo $current_image; ?>">
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-md-8">
							<div class="archive-item-info">
							
								<div class="comment-view-block">
									<div class="comment-view-info" style="display: none;">
										<i class="zmdi zmdi-comment-alt"></i>
										<span><?php echo rand(1, 50); ?></span>
									</div>
									<div class="comment-view-info">
										<i class="zmdi zmdi-eye"></i>
										<span><?php echo get_PostViews($post->ID); ?></span>
									</div>
								</div>
							
								<div class="archive-item-info-title"> 
									<a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a> 
								</div>
								<div> <?php the_content_limit(700, "..."); ?> </div>
								
							</div>
						</div>
						
					</div>
				</div>
				
					<?php if($betwen != $post_count_output) { ?>
						<div class="betwen-section"> </div>
					<?php } ?>
					

					
					<?php $betwen++; ?><?php endwhile; ?> 
				<?php endif; ?>
						
				</div>		
				

				
					<?php if( function_exists('navigation_pages') ) { navigation_pages(); } ?>
				
				</div>
				
				</div>
				
			</div>
		</div>
				
				</div>
				
<?php get_footer(); ?>