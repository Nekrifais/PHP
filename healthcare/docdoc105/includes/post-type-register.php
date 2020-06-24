<?php 
	add_action( 'init', 'codex_book_init' );
/**
 * Register a book post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function codex_book_init() {
	$labels = array(
		'name'               => _x( 'Врачи', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Врач', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Врачи', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Врач', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Добавить нового', 'book', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Добавить нового врача', 'your-plugin-textdomain' ),
		'new_item'           => __( 'Новый врач', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Редактировать врача', 'your-plugin-textdomain' ),
		'view_item'          => __( 'Просмотреть врача', 'your-plugin-textdomain' ),
		'all_items'          => __( 'Все врачи', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Найти врача', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'Не найденно врачей', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'Не найденно врачей в корзине.', 'your-plugin-textdomain' )
	); 

	$args = array(
		'labels'             => $labels,
                'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'medic' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'medic', $args );
	
	$labels = array(
		'name'               => _x( 'Клиники', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Клиника', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Клиники', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Клиника', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Добавить новую', 'book', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Добавить новую клинику', 'your-plugin-textdomain' ),
		'new_item'           => __( 'Новая клиника', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Редактировать клинику', 'your-plugin-textdomain' ),
		'view_item'          => __( 'Просмотреть клинику', 'your-plugin-textdomain' ),
		'all_items'          => __( 'Все клиники', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Найти клинику', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'Не найденно клиник', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'Не найденно клиник в корзине.', 'your-plugin-textdomain' )
	); 

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'clinic' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'clinic', $args );	
	
	$labels = array(
		'name'               => _x( 'Отзывы', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Отзывы', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Отзывы', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Отзывы', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Добавить новый', 'book', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Добавить новый отзыв', 'your-plugin-textdomain' ),
		'new_item'           => __( 'Новый отзыв', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Редактировать отзыв', 'your-plugin-textdomain' ),
		'view_item'          => __( 'Просмотреть отзыв', 'your-plugin-textdomain' ),
		'all_items'          => __( 'Все отзывы', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Найти отзыв', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'Не найденно отзыв', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'Не найденно отзыв в корзине.', 'your-plugin-textdomain' )
	); 

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => false,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'reviews' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'reviews', $args );
		
	$labels = array(
		'name'               => _x( 'Заявки', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Заявка', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Заявки', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Заявка', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Добавить новый', 'book', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Добавить новый заявку', 'your-plugin-textdomain' ),
		'new_item'           => __( 'Новая заявка', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Редактировать заявку', 'your-plugin-textdomain' ),
		'view_item'          => __( 'Просмотреть заявку', 'your-plugin-textdomain' ),
		'all_items'          => __( 'Все заявки', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Найти заявку', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'Не найдено заявок', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'Не найдено заявок в корзине.', 'your-plugin-textdomain' )
	); 

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => false,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'orders' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title' )
	);

	register_post_type( 'orders', $args ); 
	
	$labels = array(
		'name'               => _x( 'Шаблоны', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Шаблон', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Шаблоны', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Шаблон', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Добавить новый', 'book', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Добавить новый шаблон', 'your-plugin-textdomain' ),
		'new_item'           => __( 'Новый шаблон', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Редактировать шаблон', 'your-plugin-textdomain' ),
		'view_item'          => __( 'Просмотреть шаблон', 'your-plugin-textdomain' ),
		'all_items'          => __( 'Все шаблоны', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Найти шаблон', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'Не найдено шаблонов', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'Не найдено шаблонов в корзине.', 'your-plugin-textdomain' )
	); 

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => false,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'templates' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title' )
	);

	register_post_type( 'templates', $args );
	
	$labels = array(
		'name'               => _x( 'Справочник заболеваний', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Справочник заболеваний', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Справочник заболеваний', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Справочник заболеваний', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Добавить новый', 'book', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Добавить новую справку', 'your-plugin-textdomain' ),
		'new_item'           => __( 'Новыая справка', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Редактировать справку', 'your-plugin-textdomain' ),
		'view_item'          => __( 'Просмотреть справку', 'your-plugin-textdomain' ),
		'all_items'          => __( 'Все справки', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Найти справку', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'Не найдено справок', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'Не найдено справок в корзине.', 'your-plugin-textdomain' )
	); 

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'help' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail', )
	);

	register_post_type( 'help', $args );
	
}




 





























