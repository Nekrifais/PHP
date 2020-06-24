<?php
header('Content-Type: text/html; charset=utf-8', true);
require_once(dirname(__FILE__).'/../../../wp-load.php');
require_once(dirname(__FILE__).'/sdk/autoload.php');

$district_city_terms = get_terms('district', array( 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => 0, 'parent' => 0 ) );


	foreach($district_city_terms as $district_city_term) { 
		$city_name = $district_city_term->name;
		$city_term_id = $district_city_term->term_id;		
		
		$Latitude = get_field('Latitude_city', 'district_' . $city_term_id);
		$Longitude = get_field('Longitude_city', 'district_' . $city_term_id);
		
		$all_district_terms = get_terms( 'district', array( 'order' => 'ASC', 'orderby' => 'name', 'hide_empty' => 0, 'child_of' => $city_term_id ) ); 
		
		$coordinates_city = $Latitude . ', ' . $Longitude;
		
		update_field('координаты', $coordinates_city, 'district_' . $city_term_id ); 
		
		foreach($all_district_terms as $district_term) {
			$district_term_id = $district_term->term_id;
			$district_name = $city_name . ', район ' . $district_term->name;
			echo $district_name . "\n";
			$api = new \Yandex\Geo\Api();
	
			// Или можно икать по адресу
			$api->setQuery($district_name);

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
				
			update_field('координаты', $coordinate, 'district_' . $district_term_id ); 
				
				
				echo $coordinate;
			
		}
	
	}





