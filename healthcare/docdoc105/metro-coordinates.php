<?php
header('Content-Type: text/html; charset=utf-8', true);
require_once(dirname(__FILE__).'/../../../wp-load.php');
require_once(dirname(__FILE__).'/sdk/autoload.php');

$metro_city_terms = get_terms('metro', array( 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => 0, 'parent' => 0 ) );


	foreach($metro_city_terms as $metro_city_term) { 
		$city_name = $metro_city_term->name;
		$city_term_id = $metro_city_term->term_id;		
		
		$Latitude = get_field('Latitude', 'metro_' . $city_term_id);
		$Longitude = get_field('Longitude', 'metro_' . $city_term_id);
		
		$all_metro_terms = get_terms( 'metro', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'child_of' => $city_term_id ) ); 
		
		$coordinates_city = $Latitude . ', ' . $Longitude;
		
		update_field('координаты', $coordinates_city, 'metro_' . $city_term_id ); 
		
		foreach($all_metro_terms as $metro_term) {
			$metro_term_id = $metro_term->term_id;
			$metro_name = $city_name . ', метро ' . $metro_term->name;
			
			$api = new \Yandex\Geo\Api();
	
			// Или можно икать по адресу
			$api->setQuery($metro_name);

			// Настройка фильтров
			$api
				->setLimit(1) // кол-во результатов
				->setLang(\Yandex\Geo\Api::LANG_US) // локаль ответа
				->load();

			$response = $api->getResponse();
			$response->getFoundCount(); // кол-во найденных адресов
			$response->getQuery(); // исходный запрос
			$response->getLatitude(); // широта для исходного запроса
			$response->getLongitude(); // долгота для исходного запроса

			// Список найденных точек
			$collection = $response->getList();

			foreach ($collection as $item) {
				$item->getAddress(); // вернет адрес
				$item->getLatitude(); // широта
				$item->getLongitude(); // долгота
				$item->getData(); // необработанные данные
				
				$Latitude = $item->getLatitude();
				$Longitude = $item->getLongitude();
				
			}

				$Latitude = $item->getLatitude();
				$Longitude = $item->getLongitude();
				
			$coordinate = $Latitude . ', ' . $Longitude . "\n";
				
			update_field('координаты', $coordinate, 'metro_' . $metro_term_id ); 
				
				
				echo $coordinate;
			
		}
	
	}





