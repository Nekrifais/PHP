<?php 
	header('Content-Type: text/html; charset=utf-8', true);
	require_once(dirname(__FILE__).'/../../../wp-load.php');
/**
  *
  * This is a quick way to turn a simple text file
  * with a very long list of urls in a text file (sitemap-urls.txt)
  * Where "very long" is an expected url number greater than 10,000
  * If loaded without a valid query parameter "page" it will load a
  * Site Index site map, otherwise load the individual XML site map
  * 10,000 urls into a valid XML Sitemap:
  * http://en.wikipedia.org/wiki/Sitemaps
  * Put this file sitemap.xml.php and sitemap-urls.txt at
  * the webroot http://example.com/sitemap.xml.php
  * Then add the text in quotes below to your robots.txt file as a new line:
  * "Sitemap: http://example.com/sitemap.xml.php"
  * 
  * Questions? email joe@artlung.com
  * 
  * Based on https://gist.github.com/artlung/210438
*/


	$city = get_field('выбор_города', 'option');
	$city = $city[0];
		
$metro_city_terms = get_terms( 'metro', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => 0 ) );

	foreach($metro_city_terms as $metro_city_term) { 
	
		$current_city = get_field('Id', 'city_' . $metro_city_term->term_id); 
		if($current_city == $city) { 
			$current_metro_city_term_id = $metro_city_term->term_id;
		}
	}


					



$city = get_field('выбор_города', 'option');

$args = array(
	'taxonomy'               => array( 'metro' ),
	'meta_key'               => 'Id',
	'meta_value'             => $city,
	'hide_empty'             => false,
);

$term_query = new WP_Term_Query( $args );
	
$current_metro_city_term_id = $term_query->terms[0]->term_id;

$args = array(
	'taxonomy'               => array( 'district' ),
	'meta_key'               => 'Id',
	'meta_value'             => $city,
	'hide_empty'             => false,
);

$term_query = new WP_Term_Query( $args );

$current_district_city_term_id = $term_query->terms[0]->term_id;	
	
	
	
	$all_speciality_terms = get_terms('speciality', array( 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => 0 ) );
	
	$all_clinic_speciality_terms = get_terms('clinic-speciality', array( 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => 0 ) );
	
	$all_diagnostic_terms = get_terms('diagnostic', array( 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => 0 ));
	
	
	$metro_city_terms = get_terms('metro', array( 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => 0, 'parent' => $current_metro_city_term_id ) );

	$district_city_terms = get_terms( 'district', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'parent' => $current_district_city_term_id ) );

	$base_url = get_bloginfo('url');
	
foreach($all_speciality_terms as $speciality_term) {
	$speciality_slug = $speciality_term->slug;
	
	$array_urls[] = $base_url . '/speciality/' . $speciality_slug;
	
	foreach($metro_city_terms as $metro_term) {
		$metro_slug = $metro_term->slug;
		
		$array_urls[] = $base_url . '/speciality/' . $speciality_slug . '/metro/' . $metro_slug . '/';
		
	}

	foreach($district_city_terms as $district_term) {
		$district_slug = $district_term->slug;

		$array_urls[] = $base_url . '/speciality/' . $speciality_slug . '/district/' . $district_slug . '/';
		
	}
	
}

foreach($all_clinic_speciality_terms as $clinic_speciality_term) {
	$clinic_speciality_slug = $clinic_speciality_term->slug;
	
	$array_urls[] = $base_url . '/clinic-speciality/' . $clinic_speciality_slug;
	
	foreach($metro_city_terms as $metro_term) {
		$metro_slug = $metro_term->slug;
	
		$array_urls[] = $base_url . '/clinic-speciality/' . $clinic_speciality_slug . '/metro/' . $metro_slug . '/';
		
	}
	
	foreach($district_city_terms as $district_term) {
		$district_slug = $district_term->slug;
	$array_urls[] = $base_url . '/clinic-speciality/' . $clinic_speciality_slug . '/district/' . $district_slug . '/';
	}
	
}


 foreach($all_diagnostic_terms as $diagnostic_term) {
	$diagnostic_slug = $diagnostic_term->slug;
	$array_urls[] = $base_url . '/diagnostic/' . $diagnostic_slug;
	foreach($metro_city_terms as $metro_term) {
		$metro_slug = $metro_term->slug;
		
		$array_urls[] = $base_url . '/diagnostic/' . $diagnostic_slug . '/metro/' . $metro_slug . '/';
		
	}
	
	foreach($district_city_terms as $district_term) {
		$district_slug = $district_term->slug;
		
		$array_urls[] = $base_url . '/diagnostic/' . $diagnostic_slug . '/district/' . $district_slug . '/';
		
	}
	
}  




$per_page = 1000;
$urls = $array_urls;


$page = (int)$_GET['page'];


$sitemap = array();
foreach($urls as $url) {
    if ($url != '') {
        $priority = '0.5';
        $sitemap[] = array(
          'loc' => $url,
          'lastmod' => date('Y-m-d',$filectime),
          'changefreq' => 'weekly',
          'priority' => $priority,
        );
    }
}

$pages = array_chunk($sitemap, $per_page);


$page_numbers = range(1, count($pages));
header('Content-Type: text/xml');
echo '<?xml version=\'1.0\' encoding=\'UTF-8\'?>';
echo "\n";
$path = explode('?', $_SERVER['REQUEST_URI']);
$path = array_shift($path);
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $path . "?page=";
$lastmod = date('Y-m-d',$filectime);
if (!in_array($page, $page_numbers)) {
    // Valid Page Number
    echo '<sitemapindex xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd">';
    echo "\n";
    foreach ($page_numbers as $pg_num) {
        echo "\t<sitemap>\n";
        echo "\t\t<loc>" . htmlentities($url) . $pg_num . "</loc>\n";
        echo "\t</sitemap>\n";
    }
    echo '</sitemapindex>';
} else {
    // Output the Site Map
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
         xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
    echo "\n";
    foreach ($pages[$page-1] as $link) {
        echo "\t<url>\n";
        echo "\t\t<loc>" . htmlentities($link['loc']) . "</loc>\n";
        echo "\t\t<changefreq>{$link['changefreq']}</changefreq>\n";
        echo "\t\t<priority>{$link['priority']}</priority>\n";
        echo "\t</url>\n";
    }
    echo '</urlset>';
}