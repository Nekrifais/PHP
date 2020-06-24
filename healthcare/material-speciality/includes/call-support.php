	
	<?php $docdoc_phone = get_field('телефон_для_записи_в_docdoc', 'option'); ?>
	
	<?php if($docdoc_phone != "") { ?>
		<div class="hot-event-block">
			<span class="event-block-link content-box">
				<img src="<?php bloginfo('template_url'); ?>/images/female-telemarketer.png">
				<span class="title">Бесплатно подберем врача, клинику или диагностический центр.</span>
				<div class="call-phone"> 
					Звоните 
					<span class="call-sup-docdoc"> <?php echo $docdoc_phone; ?> </span>
				</div>
			</span>
		</div>
	<?php } ?>
	