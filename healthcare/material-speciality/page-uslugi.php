<?php 
	/* 	
		Template Name: Услуги
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
					
					
					
	<?php $select_uslugi = get_field('выбор_услуг', 'option'); 
				
	foreach($select_uslugi as $usluga) {
		
		$select_usluga 			= get_term_by('id', $usluga, 'uslugi');
		$head_usluga_link 		= get_term_link($select_usluga->term_id, 'uslugi'); 
		
		
		?>
		
<?php $child_uslugi = get_terms( 'uslugi', array( 'hide_empty' => 0, 'orderby' => 'name', 'pad_counts' => true, 'parent' => $usluga ) );	


	  //The args. Don't set parent
    $args = array(
        'hide_empty'  => 0,  
        'orderby'     => 'name',
        'order'       => 'ASC',
        'taxonomy'    => 'uslugi',
        'pad_counts'  => 1
    );

    //I'll leave it to you to check for error objects etc.
    $categories = get_terms($args);
    $categories = wp_list_filter($categories,array('parent'=>$usluga));
	
	
	
	$child_uslugi_count = $child_uslugi->count; ?>	
	
			<div class="row">
				<div class="speciality-home-list">

					<div class="col-md-12">
						<h2 style="padding: 30px 0px;"><a href= "<?php echo $head_usluga_link; ?>"><?php echo $select_usluga->name; ?></a></h2>
					</div>
					
 
		
		<?php foreach($child_uslugi as $child_usluga) { 
			$usluga_name 		= $child_usluga->name;
			$usluga_term_id 	= $child_usluga->term_id;
			$usluga_count 		= $child_usluga->count; 
			$usluga_link 		= get_term_link($usluga_term_id, 'uslugi');
			$term_children 		= get_term_children($usluga_term_id, 'uslugi');
			
				?>
				
				
				<div class="col-md-6 pad-b-15 speciality-home-one">
					<span class="speciality-number-home-wrap" style="position: absolute; right: 15px; bottom: 5px;"> 
						<span class="speciality-number-home"> 
							
							<?php if($term_children) { ?>
								<i class="zmdi zmdi-long-arrow-right"></i>
							<?php  } else { 
								echo $usluga_count;
							} ?>
							
						</span> 
					</span>
					<div class="dotted" style=" padding-right: 45px;">
								
						<a class="broker-down-link speciality-name-home" href="<?php echo $usluga_link; ?>">
							<i class="zmdi zmdi-minus diagnostic-minus"> </i>
							<?php echo $usluga_name; ?>
						</a> 
					</div>
				</div>
				
				
		<?php } ?>
				
				</div>
			</div>
				
	<?php } ?>



									   
										
											<?php the_content(); ?>
											
									   </div>
								 </div>
							  </div>
						   </div>
						
						<?php endwhile; ?> 
					<?php endif; ?>
			   
            </div>
	
		 
<?php get_footer(); ?>
