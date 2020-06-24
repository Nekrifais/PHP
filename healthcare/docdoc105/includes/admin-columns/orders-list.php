<?php 


add_filter('manage_orders_posts_columns', 'bs_orders_table_head');
function bs_orders_table_head( $defaults ) {
    $defaults['orders_id']  = 'Ид заявки';
    $defaults['status']    	= 'Статус';
    $defaults['phone']    	= 'Телефон';
    $defaults['name']    	= 'Ф.И.О';

    return $defaults;
}



add_action( 'manage_orders_posts_custom_column', 'bs_orders_table_content', 10, 2 );

function bs_orders_table_content( $column_name, $post_id ) {

    if ($column_name == 'orders_id') {
		$orders_id = get_post_meta( $post_id, 'id_заявки', true );
		echo '<b>' . $orders_id . '</b>';
    }
	
    if ($column_name == 'status') {
		$status = get_post_meta( $post_id, 'статус', true );
		if($status == "success") {
			echo '<b style="color:green;">Успешно</b>';
		} else {
			echo '<b style="color:red;">Ошибка</b>';
		}
		
    }
	
	if ($column_name == 'phone') {
		$orders_phone = get_post_meta( $post_id, 'телефон', true );
		echo $orders_phone;
    }
	
	if ($column_name == 'name') {
		$orders_name = get_post_meta( $post_id, 'имя', true );
		echo $orders_name;
    }


}

