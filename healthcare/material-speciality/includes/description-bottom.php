	
	<?php $title_description_bottom = get_field('заголовок_для_описание_снизу', 'option'); ?>
	<?php $text_description_bottom = get_field('текст_описания_снизу', 'option'); ?>
	
	<?php if($title_description_bottom or $text_description_bottom) { ?>
	
		<div class="bottom-page-info">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<h2 class="bottom-page-title"><?php echo $title_description_bottom; ?></h2>
						<div class="bottom-page-description">
							<div class="row">
								<div class="col-md-12">
								
									<?php echo $text_description_bottom; ?>
								
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	<?php } ?>