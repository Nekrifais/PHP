<?php get_header(); ?>
	
	
			<?php $categories_option = get_field('список_рубрик_на_главной', 'option'); ?>
			<?php $titile_down_description = get_field('заголовок_для_описание_на_главной_снизу', 'option'); ?>
			<?php $text_down_description = get_field('текст_описания_на_главной_снизу', 'option'); ?>
			<?php $best_clinic_description = get_field('описание_на_главной_лучшие_клиники', 'option'); ?>
			<?php $tax_slide_id = get_field('выбор_таксономии_для_слайда_на_главной', 'option'); ?>
			<?php $tax_slide_text = get_field('текст_для_слайда_на_главной', 'option', false); ?>
			<?php $tax_slide_img = get_field('картинка_для_слайда_на_главной', 'option'); ?>
			<?php $docdoc_phone = get_field('телефон_для_записи_в_docdoc', 'option'); ?>
			
			<section id="content_outer_wrapper">
				<div id="content_wrapper" class="row-offcanvas">
				
					<?php require_once(dirname(__FILE__).'/includes/top-menu.php'); ?>
						
						<div class="container">
						
							<div class="row">
							
								<?php require_once(dirname(__FILE__).'/includes/filters/filter-home-catalog.php'); ?>
								
							
			<?php if($docdoc_phone != "") { ?>
			
				<?php $city_select = get_field('выбор_города', 'option'); ?>
				
				<div class="col-md-8">
					<div class="home-call-support">
						<?php include(dirname(__FILE__).'/includes/call-support.php');  ?>	
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="home-call-back">
						<div class="hot-event-block">
							<div class="event-block-link content-box modal-default-cursor-point" data-currentcity="<?php echo $city_select[0]; ?>" data-toggle="modal" data-target="#myModal">
								<img src="<?php bloginfo('template_url'); ?>/images/smartphone.png">
								<span class="title">Заказать обратный</span>
								<div class="call-phone"> 
									звонок
								</div>
							</div>
						</div>
					</div>
				</div>
				
			<?php } ?>
		

								<?php echo do_shortcode( '[medic_speciality]' ); ?>
								
							</div>
				
		<?php if($docdoc_phone != "") { ?>
			<div class="row">
				<div style="margin-top: 30px;">
				
					<div class="col-md-8">
						<div class="home-call-support">
							<?php include(dirname(__FILE__).'/includes/call-support.php');  ?>	
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="home-call-back">
							<div class="hot-event-block">
								<div class="event-block-link content-box modal-default-cursor-point" data-currentcity="<?php echo $city_select[0]; ?>" data-toggle="modal" data-target="#myModal">
									<img src="<?php bloginfo('template_url'); ?>/images/smartphone.png">
									<span class="title">Заказать обратный</span>
									<div class="call-phone"> 
										звонок
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		
		<?php } ?>
		
						</div>
						
				</div>
			<?php require_once(dirname(__FILE__).'/includes/description-bottom.php'); ?>
		
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog medic-modal">
				<div class="modal-content">
					
				<div class="modal-footer">
					<div class="appointments">Запись на приём</div>
					<?php echo do_shortcode( '[contact-form-7 id="207" title="Форма в шапке"]' ); ?>
				</div>
				
				<div class="modal-footer-second">
				
					<?php echo $TextUnderSignIn; ?>
					
                </div>
				
				</div>
			</div>
		</div>
		
<?php get_footer(); ?>