<?php get_header(); ?>
		 
		
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
					
<?php echo do_shortcode( '[contact-form-7 id="43259" title="test"]' ); ?>

								
							<div id="content" class="container page-template">
								<div class="row">
								
					<?php if (have_posts()) : ?>
						<?php while (have_posts()) : the_post(); ?>
								
									<div class="col-xs-12 col-md-12">
										<header class="card-heading">
											<h1 class="card-title"><?php the_title(); ?></h1>
										</header>
										<div class="card-body">
											<?php the_content(); ?>
										</div>
									</div>
									
						<?php endwhile; ?> 
					<?php endif; ?>
									
									
									
									
									
								</div>
							</div>
						
			   
			   
			   
            </div>
			
	<?php get_footer(); ?>