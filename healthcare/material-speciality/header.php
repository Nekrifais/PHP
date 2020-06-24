<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' - '; } ?> <?php bloginfo('name'); ?></title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700|Poppins:300,400,500,600" rel="stylesheet">
	<link rel="icon" href="<?php bloginfo('template_url'); ?>/assets/img/favicon.ico" type="image/x-icon">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700&amp;subset=cyrillic-ext" rel="stylesheet">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/css/vendor.bundle.css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/css/app.bundle.css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/css/theme-a.css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css">
	
	
	
	<?php if(is_singular('medic')) {
		
		/* 130x173 */
		$seo_id 	= get_the_id();
		$seo_title 	= get_the_title($seo_id);
		$post_thumbnail_id = get_post_thumbnail_id( $seo_id );  
			if($post_thumbnail_id) { 
				$post_thumbnail_url = lazy_image_size($post_thumbnail_id, 0, 0, 0); 
				$current_image = $post_thumbnail_url[0]; 
			} else { 
				$current_image = "http://placehold.it/162x162";
			} 
		
		$seo_rating 	= get_field("Rating", $seo_id, true);
		$seo_reviews 	= get_field("OpinionCount", $seo_id, true);
		$seo_Price 		= get_field("Price", $seo_id, true);
		
		
	?>
	
	<script type="application/ld+json">
    {
      "@context": "http://schema.org/",
      "@type": "LocalBusiness",
      "name": "<?php echo $seo_title; ?>",
      "image":"<?php echo $current_image; ?>",
      "priceRange": "от <?php echo $seo_Price; ?> руб"
            ,
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "<?php echo $seo_rating; ?>",
        "reviewCount": "<?php echo $seo_reviews; ?>",
        "worstRating": 1,
        "bestRating": 5
      }}
  </script>
  <?php 
		$page_class = "page-profile";
	} ?>
	<?php $city_select = get_field('выбор_города', 'option'); ?>
	<?php $img_logo = get_field('картинка_логотипа', 'option'); ?>
	<?php $text_logo = get_field('текст_логотипа', 'option'); ?>
	
	<?php wp_head(); ?>
	
	<?php require_once(dirname(__FILE__).'/includes/user-header/user-header.php'); ?>
	
</head>

<body class="body-class" data-city="<?php echo $city_select[0]; ?>">
	<div id="app_wrapper" class="<?php echo $page_class; ?>">
		<header id="app_topnavbar-wrapper" class="top-block">
			<nav role="navigation" class="navbar topnavbar">
				<div class="nav-wrapper container">
					<span style="position: absolute; bottom: 18px; line-height: 22px; cursor: pointer; left: 19px;" class="visible-xs visible-sm" onclick="openNav()"> <i style="font-size: 26px;" class="mdi mdi-backburger"> </i> </span>
					
					<div id="logo_wrapper" class="nav navbar-nav">
						<a href="<?php bloginfo('url'); ?>">
							<span class="brand-text">
							
	<img class="logotype" src="<?php echo $img_logo; ?>"><?php echo $text_logo; ?> 
	
							</span>
						</a>
					</div>
					
	
	<div class="dropdown dropdown-inline">
		<ul class="nav mini-menu navbar-nav pull-right visible-lg visible-md" style="display:inline-block" >
			<?php $a=1; ?>
			<?php $locations = get_nav_menu_locations();
			$items = wp_get_nav_menu_object( $locations['top_head_menu'] );
			$menu_items = wp_get_nav_menu_items($items->term_id); 
			
			foreach($menu_items as $menu_item) {
				if($menu_item->menu_item_parent == 0){
					$menu_id_array[] = $menu_item->ID;
				} 
				$submenu[$menu_item->menu_item_parent][] = $menu_item->ID;
				$data_array[$menu_item->ID][href] = $menu_item->url;
				$data_array[$menu_item->ID][title] = $menu_item->title;
			}
			
			foreach ( $menu_items  as $menu_item ) { 
			
				 if (in_array($menu_item->ID, $menu_id_array)) { 
						
					} else {
						continue;
					}
					
				$value = get_post_meta( $menu_item->ID );
				$image = $value["menu-item-FieldImage"][0]; ?>
				

					

				
		
					
					<li class="menu-mini-block dropdown"> 
						<a class="testing dropdown-toggle" data-hover="dropdown" data-animations="zoomIn zoomIn zoomIn zoomIn" style="padding-left: 70px; background:url(<?php echo $image; ?>) no-repeat 10% center;" href="<?php echo $menu_item->url; ?>"> 
							<span class="top"> <?php echo $menu_item->title; ?> </span> 
							<span class="bottom"> <?php echo $menu_item->description; ?> <span class="pull-right"> </span></span> 
						</a>
						
						<?php if(isset($submenu[$menu_item->ID])) { ?>
							<ul class="dropdown-menu dropdownhover-bottom" role="menu">
							
							<?php foreach($submenu[$menu_item->ID] as $submenu_item) { ?>
							
								<li><a href="<?php echo $data_array[$submenu_item][href]; ?>"> <i class="zmdi zmdi-minus"></i> <?php echo $data_array[$submenu_item][title]; ?> </a> </li>
								
							<?php } ?>
							
							
							</ul>
						<?php } ?>
						
					
					</li>
						
		
				
			<?php $a++; } ?>
			
		</ul>
	</div> 
	
		
		

	<div id="mySidenav" class="sidenav card card-off-canvas is-active">
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
			<?php $a=1; ?>
			<?php $locations = get_nav_menu_locations();
			$items = wp_get_nav_menu_object( $locations['top_head_menu'] ); ?>
		<h1 style="padding-left: 30px;"> <?php echo $items->name; ?> </h1>
		<div class="card-body p-0">
			<nav class="submenu">
				<ul style="padding-left: 0px;">
								
			<?php
			
			foreach($menu_items as $menu_item) {
				if($menu_item->menu_item_parent == 0){
					$menu_id_array[] = $menu_item->ID;
				} 
				$submenu[$menu_item->menu_item_parent][] = $menu_item->ID;
				$data_array[$menu_item->ID][href] = $menu_item->url;
				$data_array[$menu_item->ID][title] = $menu_item->title;
			}
			
			$menu_items = wp_get_nav_menu_items($items->term_id); 
			foreach ( $menu_items  as $menu_item ) { 
			
				if (in_array($menu_item->ID, $menu_id_array)) { 
					
				} else {
					continue;
				} ?>
				
					<li>
					
						<a href="<?php echo $menu_item->url; ?>" style="padding-bottom: 0px;">
							<i class="zmdi zmdi-circle"> </i>
							<span class="p-l-10"> <?php echo $menu_item->title; ?> </span>
						</a>
						
						<?php if(isset($submenu[$menu_item->ID])) { ?>
							<ul class="submenu">
							<?php $total = count($submenu[$menu_item->ID]);
							$counter = 0; ?>
							<?php foreach($submenu[$menu_item->ID] as $submenu_item) { ?>
								<?php $counter++; 
								
									if($counter == $total) { 
										$first_last_class = 'class="last"';
									} else {
										$first_last_class = '';
									}
								
									if($submenu[$menu_item->ID][0] == $submenu_item) {
										$first_last_class = 'class="first"';
									} else {
										$first_last_class = '';
									}
								
								?>
								
								<li <?php echo $first_last_class; ?>><a href="<?php echo $data_array[$submenu_item][href]; ?>"> <i class="zmdi zmdi-minus"></i> <?php echo $data_array[$submenu_item][title]; ?> </a> </li>
								
							<?php } ?>
							
							
							</ul>
						<?php } ?>

					</li>
				
			<?php $a++; } ?>
			
					<li class="divider"> </li>
					
						<?php $locations = get_nav_menu_locations();
							$items = wp_get_nav_menu_object( $locations['under_head_menu'] );
							$menu_items = wp_get_nav_menu_items($items->term_id); 
							foreach ( $menu_items  as $menu_item ) { ?>
							
						<li>
							<a href="<?php echo $menu_item->url; ?>">
								<i class="zmdi zmdi-settings"></i>
								<span class="p-l-20"> <?php echo $menu_item->title; ?> </span>
							</a>
						</li>
						
					<?php } ?>
					
				</ul>
			</nav>
		</div>
	</div>
	
				</div>
			
			</nav>
		</header>
		
		
		