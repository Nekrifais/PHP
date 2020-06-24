					<div class="top-line visible-lg visible-md">
						<div class="container">
							<div class="row">
								<div class="col-xs-12">
									<ul style=" display: inline-block; list-style: none; padding-left: 0px;">
										<li style=" display: inline-block; padding-right: 20px;">
											<i class="fa fa-home" aria-hidden="true" style=" font-size: 18px; color: #fff; padding-right: 5px;"></i> <a style="color: #fff; font-size: 18px;" href="<?php bloginfo('url'); ?>">Главная</a>
										</li>
										<?php $locations = get_nav_menu_locations();
										$items = wp_get_nav_menu_object( $locations['under_head_menu'] );
										$menu_items = wp_get_nav_menu_items($items->term_id); 
										foreach ( $menu_items  as $menu_item ) { ?>
											<li style=" display: inline-block; padding-right: 25px;">
												<a style="color: #fff; font-size: 18px;" href="<?php echo $menu_item->url; ?>"><?php echo $menu_item->title; ?></a>
											</li>
										
										<?php } ?>
										
									</ul>
									
									
								</div>
							</div>
						</div>
					</div>