<?php 

function true_register_wp_sidebars() {
 
	register_sidebar(
		array(
		'id' => 'right_speciality',
		'name' => "Страница специализаций",
		'description' => '',
		
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'before_title' => '<div class="default-sidget-title">', 
		'after_title' => '</div>',
        'after_widget' => '</div>',
		)
	); 
	
	register_sidebar(
		array(
		'id' => 'right_clinic_speciality',
		'name' => "Страница специализаций клиник",
		'description' => '',
		
		'before_widget' => '',
		'before_title' => '', 
		'after_title' => '',
        'after_widget' => '',
		)
	);
	
}
 
add_action( 'widgets_init', 'true_register_wp_sidebars' );



class my_speciality_metro_widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'speciality_metro',
			__('Специализации метро', 'wordpress'),
			array( 'description' => __( 'Выводит все метро по текущей специализации', 'wordpress' ), )
		);
	}
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $title ) ) echo $args['before_title'] . $title . $args['after_title']; 
		
		$curTerm 				= get_queried_object();
		$curTerm_id 			= $curTerm->term_id;
		$curterm_slug 		= $curTerm->slug;
		$docdoc_nameplural = get_field('nameplural', 'speciality_' . $curTerm_id); 
		
			$city = get_field('выбор_города', 'option'); 
			$city = array_shift( $city ); ?>
			
			
		<aside class="right-side-taxonomy" style="overflow: visible; background: #eceff4;">
	   <div tabindex="0" style="max-height: none;">
		  <div style="position: relative; top: 0px; left: 0px;" dir="ltr">

			 
	<?php $metro_city_terms = get_terms( 'metro', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) ); ?>
	<?php $district_city_terms = get_terms( 'district', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) ); ?>
	
			 <div class="card alt-card" style="margin-bottom: 0px;">
				<div class="card-body">
				   <nav class="submenu">
					  <ul class="list-group note-labels">
						
						<span class="tax-sidebar-title"> 
							<span> <?php echo $docdoc_nameplural; ?> </span> 
							<br> 
							около метро: 
						</span>
						
				<?php foreach($metro_city_terms as $metro_city_term) { ?>
					<?php $current_city = get_field('Id', 'city_' . $metro_city_term->term_id); ?>
					
					<?php if($current_city == $city) { ?>
					
<?php $metro_terms = get_terms( 'metro', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'child_of' => $metro_city_term->term_id ) ); ?>
						
						
						<?php foreach ( $metro_terms as $metro_term ) { ?>
							<?php $LineColor_metro = get_field('LineColor_metro', 'metro_' . $metro_term->term_id); ?>
								<?php $speciality_link = get_term_link($metro_term->term_id, 'speciality'); ?>
								
			<?php $metro_term_slug = $metro_term->slug;  
			
			$metro_slug_explode = explode("_", $metro_term_slug);
			$end = end($metro_slug_explode);
				
			if(is_numeric($end)){
				continue;
			} ?>
								
							
								<li class="list-group-item" style="padding: 6px 0px;">
									<a href="<?php bloginfo('url'); ?>/speciality/<?php echo $curterm_slug; ?>/metro/<?php echo $metro_term->slug; ?>/">
										<i class="zmdi zmdi-label-alt" style="color: #<?php echo $LineColor_metro; ?>;"> </i> 
										<?php echo $metro_term->name; ?> 
									</a>
								</li>
									
								
						<?php } ?>
					
					<?php } ?>
				<?php } ?>
					
						

					  </ul>
				   </nav>
				</div>
			</div>
			

		  </div>
	   </div>
	</aside>
		
		<?php echo $args['after_widget'];
	}
	public function form( $instance ) {

		?>

		<?php
	}
	public function update( $new_instance, $old_instance ) {
		$instance = array();

		return $instance;
	}	
}
function load_my_speciality_metro_widget() {
	register_widget( 'my_speciality_metro_widget' );
}
add_action( 'widgets_init', 'load_my_speciality_metro_widget' );




class my_clinic_district_widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'clinic_district',
			__('Клиники районы', 'wordpress'),
			array( 'description' => __( 'Выводит все районы по текущему направлению', 'wordpress' ), )
		);
	}
	public function widget( $args, $instance ) {

		echo $args['before_widget'];
		if ( ! empty( $title ) ) echo $args['before_title'] . $title . $args['after_title']; 
		
		$curTerm 			= get_queried_object();
		$curTerm_id 		= $curTerm->term_id;
		$curterm_slug 		= $curTerm->slug;
		
		$docdoc_clinic_speciality_branchname = get_field('branchname', 'clinic-speciality_' . $curTerm_id);
		
			$city = get_field('выбор_города', 'option'); 
			$city = array_shift( $city ); ?>
			
			
	<aside class="right-side-taxonomy">
		<div tabindex="0" style="max-height: none;">
			<div style="position: relative; top: 0px; left: 0px;" dir="ltr">
			
	<?php $metro_city_terms = get_terms( 'metro', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) ); ?>
	<?php $district_city_terms = get_terms( 'district', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) ); ?>
			
				<div class="card alt-card">
					<div class="card-body">
						<nav class="submenu">
							<span class="tax-sidebar-title"> <span> <?php echo $docdoc_clinic_speciality_branchname; ?> </span> <br> в Районе </span>
							<ul class="list-group note-labels">
					  
						<?php foreach($district_city_terms as $district_city_term) { ?>
						
							<?php $current_city = get_field('Id_city', 'district_' . $district_city_term->term_id); ?>
							
							<?php if($current_city == $city) { ?>
							
								<?php $district_terms = get_terms( 'district', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'child_of' => $district_city_term->term_id ) ); ?>
										
								<?php foreach($district_terms as $district) { ?>
									<li class="list-group-item">
										<a href="<?php bloginfo('url'); ?>/clinic-speciality/<?php echo $curterm_slug; ?>/district/<?php echo $district->slug; ?>/">
											<i class="zmdi zmdi-flag"></i>
											<?php echo $district->name; ?>
										</a>
									</li>
								<?php } ?>
					
							<?php } ?>
						<?php } ?>
					  
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</aside>
		
		<?php echo $args['after_widget'];
	}
	public function form( $instance ) {
		?>

		<?php
	}
	public function update( $new_instance, $old_instance ) {
		$instance = array();

		return $instance;
	}	
}
function load_my_clinic_district_widget() {
	register_widget( 'my_clinic_district_widget' );
}
add_action( 'widgets_init', 'load_my_clinic_district_widget' );







