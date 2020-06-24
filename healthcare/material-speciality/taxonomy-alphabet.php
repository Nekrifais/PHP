<?php get_header(); ?>
		
		<?php $curTerm 				= get_queried_object(); ?>
		<?php $curterm_taxonomy 	= $curTerm->taxonomy; ?>
		<?php $curterm_slug 		= $curTerm->slug; ?>
		<?php $curTerm_id 			= $curTerm->term_id; ?>
		<?php $curTerm_name			= $curTerm->name; ?>
		
		<?php $current_query_speciality = $wp_query->query['speciality']; ?>
		<?php $current_query_metro = $wp_query->query['metro']; ?>
		<?php $current_query_district = $wp_query->query['district']; ?>
		
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
											
											<li>
												<a href="<?php bloginfo('url'); ?>/help/"> 
													Справочник заболеваний
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
					
	<?php $all_alphabets = get_terms( 'alphabet', array( 'orderby' => 'name', 'hide_empty' => 0 ) ); ?>
					
				<div id="content" class="container" style="margin-bottom: 30px;">
					<div class="row">
					
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h2 class="alphabet-title"> Справочник заболеваний </h2>
								<div class="slphabet-all">
									<div style="">
										<?php foreach($all_alphabets as $alphabet) { 
										
										$query_alphabet = $wp_query->query['alphabet'];
										$alphabet_term_id 	= $alphabet->term_id;
										$alphabet_slug 		= $alphabet->slug;
										$alphabet_name 		= $alphabet->name;
										
										if($alphabet_slug == $query_alphabet) {
											$alphabet_class = 'alphabet-letter alphabet-active';
										} else {
											$alphabet_class = 'alphabet-letter';
										}
										
										$alphabet_link 		= get_term_link($alphabet_term_id, 'alphabet'); ?>
											<a class="<?php echo $alphabet_class; ?>" href="<?php echo $alphabet_link; ?>"><?php echo $alphabet_name; ?></a>
										<?php } ?>
									</div>
								</div>
						</div>
					
					</div>
					
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">	
							
	<h3 class="tax-alphabet-title"> Все заболевания на «<?php echo $curTerm_name; ?>» </h3>
			
							</div>
						</div>
						<div class="row">
					<?php $a=0; ?>
						<?php if (have_posts()) : ?>
							<?php while (have_posts()) : the_post(); ?>
							
						<?php if(($a % 4) == 0) { ?>
							</div>
							<div class="row">
						
						<?php } ?>
								<div class="col-md-4 col-sm-12 col-xs-12">	
									<div class="post-alphabet-letter">
										<a href="<?php the_permalink(); ?>">
											<i class="zmdi zmdi-minus"></i>
											<?php the_title(); ?>
										</a>
									</div>
								</div>
								
								<?php $a++; ?>
							<?php endwhile; ?> 
						<?php endif; ?>
					
						</div>
				</div>
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
			</div>
				
		
		
		
		
<?php get_footer(); ?>