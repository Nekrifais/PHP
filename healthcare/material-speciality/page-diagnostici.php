<?php 
	/* 	
		Template Name: Диагностики
	*/
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
												<a href="<?php bloginfo('url'); ?> "> 
													<i class="zmdi zmdi-home"> </i> 
													Главная
												</a>
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
					
					<?php if (have_posts()) : ?>
						<?php while (have_posts()) : the_post(); ?>
						
						   <div id="content" class="container">
							  <div class="row">
								 <div class="col-xs-12 col-md-12">
									   <header class="card-heading " style="margin-top: 60px; margin-bottom: 10px; line-height: 46px;">
										  <h1 class="card-title" style="font-size: 38px; margin-top: 0px;"><?php the_title(); ?></h1>
									   </header>
									   <div class="card-body" style="margin-bottom: 60px;">
											
											<?php the_content(); ?>
											
											<?php echo do_shortcode( '[diagnostic]' ); ?>
											
									   </div>
								 </div>
							  </div>
						   </div>
						
						<?php endwhile; ?> 
					<?php endif; ?>
			   
            </div>
	
	
	
		 
<?php get_footer(); ?>
