<?php
// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_book_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "book"
function create_book_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	
		
		$labels = array(
			'name'              => _x( 'Клиники', 'taxonomy general name' ),
			'singular_name'     => _x( 'Клиника', 'taxonomy singular name' ),
			'search_items'      => __( 'Найти клинику' ),
			'all_items'         => __( 'Все клиникы' ),
			'parent_item'       => __( 'Parent Genre' ),
			'parent_item_colon' => __( 'Parent Genre:' ),
			'edit_item'         => __( 'Редактировать клинику' ),
			'update_item'       => __( 'Обновить клинику' ),
			'add_new_item'      => __( 'Добавить новую клинику' ),
			'new_item_name'     => __( 'Имя новой клиники' ),
			'menu_name'         => __( 'Клиника' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'inclinic' ),
		);

		register_taxonomy( 'inclinic', array( 'medic' ), $args );

	
	$labels = array(
		'name'              => _x( 'Специализация', 'taxonomy general name' ),
		'singular_name'     => _x( 'Специализация', 'taxonomy singular name' ),
		'search_items'      => __( 'Найти специализацию' ),
		'all_items'         => __( 'Все специализации' ),
		'parent_item'       => __( 'Parent Genre' ),
		'parent_item_colon' => __( 'Parent Genre:' ),
		'edit_item'         => __( 'Редактировать специализацию' ),
		'update_item'       => __( 'Обновить специализацию' ),
		'add_new_item'      => __( 'Добавить новую специализацию' ),
		'new_item_name'     => __( 'Имя новой специализации' ),
		'menu_name'         => __( 'Специализация' ),
	);

	$args = array(
	    'publicly_queryable'      => true,
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'speciality' ),
	);

	register_taxonomy( 'speciality', array( 'medic' ), $args );	
	
	$labels = array(
		'name'              => _x( 'Специализация', 'taxonomy general name' ),
		'singular_name'     => _x( 'Специализация', 'taxonomy singular name' ),
		'search_items'      => __( 'Найти специализацию' ),
		'all_items'         => __( 'Все специализации' ),
		'parent_item'       => __( 'Parent Genre' ),
		'parent_item_colon' => __( 'Parent Genre:' ),
		'edit_item'         => __( 'Редактировать специализацию' ),
		'update_item'       => __( 'Обновить специализацию' ),
		'add_new_item'      => __( 'Добавить новую специализацию' ),
		'new_item_name'     => __( 'Имя новой специализации' ),
		'menu_name'         => __( 'Специализация' ),
	);

	$args = array(        
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'clinic-speciality' ),
	);

	register_taxonomy( 'clinic-speciality', array( 'clinic' ), $args );
	
	$labels = array(
		'name'              => _x( 'Диагностика', 'taxonomy general name' ),
		'singular_name'     => _x( 'Диагностика', 'taxonomy singular name' ),
		'search_items'      => __( 'Найти диагностику' ),
		'all_items'         => __( 'Все диагностики' ),
		'parent_item'       => __( 'Parent Genre' ),
		'parent_item_colon' => __( 'Parent Genre:' ),
		'edit_item'         => __( 'Редактировать диагностику' ),
		'update_item'       => __( 'Обновить диагностику' ),
		'add_new_item'      => __( 'Добавить новую диагностику' ),
		'new_item_name'     => __( 'Имя новой диагностики' ),
		'menu_name'         => __( 'Диагностика' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'diagnostic' ),
	);

	register_taxonomy( 'diagnostic', array( 'clinic' ), $args );
		
	$uslugi_option = get_field('выгрузить_услуги_для_клиник', 'option');
		
	if($uslugi_option == 2) { 
		
		$labels = array(
			'name'              => _x( 'Услуги', 'taxonomy general name' ),
			'singular_name'     => _x( 'Услуги', 'taxonomy singular name' ),
			'search_items'      => __( 'Найти услугу' ),
			'all_items'         => __( 'Все услуги' ),
			'parent_item'       => __( 'Parent Genre' ),
			'parent_item_colon' => __( 'Parent Genre:' ),
			'edit_item'         => __( 'Редактировать услугу' ),
			'update_item'       => __( 'Обновить услугу' ),
			'add_new_item'      => __( 'Добавить новую услугу' ),
			'new_item_name'     => __( 'Имя новой услуги' ),
			'menu_name'         => __( 'Услуги' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'uslugi' ),
		);

		register_taxonomy( 'uslugi', array( 'clinic' ), $args );
	
	}
	
	$labels = array(
		'name'              => _x( 'Город', 'taxonomy general name' ),
		'singular_name'     => _x( 'Город', 'taxonomy singular name' ),
		'search_items'      => __( 'Найти город' ),
		'all_items'         => __( 'Все города' ),
		'parent_item'       => __( 'Parent Genre' ),
		'parent_item_colon' => __( 'Parent Genre:' ),
		'edit_item'         => __( 'Редактировать город' ),
		'update_item'       => __( 'Обновить город' ),
		'add_new_item'      => __( 'Добавить новый город' ),
		'new_item_name'     => __( 'Имя нового города' ),
		'menu_name'         => __( 'Город' ),
	);

	$args = array(
	    'public'     		 => false,
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'city' ),
	);

	register_taxonomy( 'city', array( 'clinic', 'medic' ), $args );	
	
	
	$labels = array(
		'name'              => _x( 'Метро', 'taxonomy general name' ),
		'singular_name'     => _x( 'Метро', 'taxonomy singular name' ),
		'search_items'      => __( 'Найти метро' ),
		'all_items'         => __( 'Все метро' ),
		'parent_item'       => __( 'Parent Genre' ),
		'parent_item_colon' => __( 'Parent Genre:' ),
		'edit_item'         => __( 'Редактировать метро' ),
		'update_item'       => __( 'Обновить метро' ),
		'add_new_item'      => __( 'Добавить новое метро' ),
		'new_item_name'     => __( 'Имя нового метро' ),
		'menu_name'         => __( 'Метро' ),
	);

	$args = array(
	    'public'     		 => false,
	    'publicly_queryable'      => true,
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'metro' ),
	);

	register_taxonomy( 'metro', array( 'clinic', 'medic' ), $args );
	
		$labels = array(
		'name'              => _x( 'Район', 'taxonomy general name' ),
		'singular_name'     => _x( 'Район', 'taxonomy singular name' ),
		'search_items'      => __( 'Найти район' ),
		'all_items'         => __( 'Все районы' ),
		'parent_item'       => __( 'Parent Genre' ),
		'parent_item_colon' => __( 'Parent Genre:' ),
		'edit_item'         => __( 'Редактировать район' ),
		'update_item'       => __( 'Обновить район' ),
		'add_new_item'      => __( 'Добавить новое район' ),
		'new_item_name'     => __( 'Имя нового района' ),
		'menu_name'         => __( 'Район' ),
	);

	$args = array(
	    'public'     		 => false,
		'publicly_queryable'      => true,
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'district' ),
	);

	register_taxonomy( 'district', array( 'clinic', 'medic' ), $args );
	
		
		$labels = array(
			'name'              => _x( 'Дополнительные параметры', 'taxonomy general name' ),
			'singular_name'     => _x( 'Дополнительный параметр', 'taxonomy singular name' ),
			'search_items'      => __( 'Найти дополнительный параметр' ),
			'all_items'         => __( 'Все дополнительные параметры' ),
			'parent_item'       => __( 'Parent Genre' ),
			'parent_item_colon' => __( 'Parent Genre:' ),
			'edit_item'         => __( 'Редактировать дополнительный параметр' ),
			'update_item'       => __( 'Обновить дополнительный параметр' ),
			'add_new_item'      => __( 'Добавить новый дополнительный параметр' ),
			'new_item_name'     => __( 'Имя нового дополнительного параметра' ),
			'menu_name'         => __( 'Дополнительные параметры' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'dop' ),
		);

		register_taxonomy( 'dop', array( 'medic' ), $args );

	$labels = array(
		'name'              => _x( 'Алфавитный указатель', 'taxonomy general name' ),
		'singular_name'     => _x( 'Алфавитный указатель', 'taxonomy singular name' ),
		'search_items'      => __( 'Найти указатель' ),
		'all_items'         => __( 'Все указатели' ),
		'parent_item'       => __( 'Parent Genre' ),
		'parent_item_colon' => __( 'Parent Genre:' ),
		'edit_item'         => __( 'Редактировать указатель' ),
		'update_item'       => __( 'Обновить указатель' ),
		'add_new_item'      => __( 'Добавить новое указатель' ),
		'new_item_name'     => __( 'Имя нового указателя' ),
		'menu_name'         => __( 'Алфавитный указатель' ),
	);

	$args = array(
	    'public'     		 => true,
		'publicly_queryable'      => true,
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'alphabet' ),
	);

	register_taxonomy( 'alphabet', array( 'help' ), $args );
		
		
}