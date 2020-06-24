				
				

		
				
				<div class="clearfix"> </div>
				
<?php $footer_text		= get_field('текст_в_подвале', 'option'); ?> 							
<?php $footer_social 	= get_field('социальные_сети_в_подвале', 'option', false); ?> 
				
				
				<footer id="footer_wrapper" style=" padding: 0px; background: transparent; border-top: 3px solid #2196f3;">
					<div class="footer-content">
						<div class="container">
							<div class="row copy-wrapper footer-menu-wrapper">

								<div class="col-md-12">
								
									<ul class="footer-menu">
										<?php $defaults = array(
											'container'       => true, 
											'items_wrap'      => '%3$s',
											'theme_location'  => 'footer_menu'
											); ?>
										<?php wp_nav_menu( $defaults ); ?>
									</ul>
								</div>
							</div>
						</div>
				    </div>
						
					<div style="border-bottom: 1px solid #e5e5e5;"> </div>
								
						<div class="container">
						   <div class="row">
							  <div class="copyright-bar" style="background:#fff; padding: 35px 0px;">
								 <div class="container">
									<div class="row">
									   <div class="col-xs-12 col-sm-12 col-md-3">
											<div class="logo">
												<a href="#">
													<div class="" style="background:#8e8e8e; height:75px; "> </div>
												</a>
											</div>
									   </div>
									   <div class="col-xs-12 col-sm-12 col-md-3">
											<div class="logo">
												<a href="#">
													<div class="" style="background:#8e8e8e; height:75px; "> </div>
												</a>
											</div>
									   </div>
									   <div class="col-xs-12 col-sm-12 col-md-3">
											<div class="logo">
												<a href="#">
													<div class="" style="background:#8e8e8e; height:75px; "> </div>
												</a>
											</div>
									   </div>
									   
							
										<div class="col-xs-12 col-sm-6 col-md-3 pull-right no-padding social" style="line-height: 75px;">
											<ul class="link">
												<?php echo $footer_social; ?>
											</ul>
										</div>
									</div>
									<div class="footer-text">
										
										<?php echo $footer_text; ?>
										
									</div>
									
								 </div>
							  </div>
						   </div>
						</div>
					
				  </footer>
			</section>
			
			
		</div>
		
<script>

 /* Set the width of the side navigation to 250px and the left margin of the page content to 250px  */
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
   
}

 /* Set the width of the side navigation to 0 and the left margin of the page content to 0  */
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
  
}

</script>
		
			<script src="<?php bloginfo('template_url'); ?>/assets/js/mixiup/mixitup.min.js"></script>
		<?php if(is_tax('diagnostic') or is_tax('uslugi')) { ?>
			<script src="<?php bloginfo('template_url'); ?>/assets/js/mixiup/mixitup.min.js"></script>
		<?php } ?>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
		<script src="<?php bloginfo('template_url'); ?>/assets/js/theme-functions.js"></script> 
		<script src="<?php bloginfo('template_url'); ?>/assets/js/bootstrap-dropdownhover.min.js"></script>
		
		<?php wp_footer(); ?>
		
		<?php require_once(dirname(__FILE__).'/includes/user-footer/user-footer.php'); ?>
			
	</body>
</html>
