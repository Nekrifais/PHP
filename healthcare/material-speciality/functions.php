<?php 

error_reporting(0);
register_nav_menus( array(
	'top_head_menu' => 'Меню в шапке на синем фоне',
	'under_head_menu' => 'Меню под шапкой',
	'left_home_menu' => 'Меню слева на главной',
	'best_clinic_home_menu' => 'Меню лучшие клиники главная',
	'footer_menu' => 'Меню в подвале',
) );





require_once dirname( __FILE__ ) . '/includes/widgets.php';
require_once dirname( __FILE__ ) . '/includes/shortcodes.php';
require_once dirname( __FILE__ ) . '/wp-menu-item-custom-fields-develop/menu-item-custom-fields.php';


add_theme_support( 'post-thumbnails' ); 

function lazy_image_size($image_id, $width, $height, $crop) {
    // Temporarily create an image size
    $size_id = 'lazy_' . $width . 'x' .$height . '_' . ((string) $crop);
    add_image_size($size_id, $width, $height, $crop);

    // Get the attachment data
    $meta = wp_get_attachment_metadata($image_id);

    // If the size does not exist
    if(!isset($meta['sizes'][$size_id])) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        $file = get_attached_file($image_id);
        $new_meta = wp_generate_attachment_metadata($image_id, $file);

        // Merge the sizes so we don't lose already generated sizes
        $new_meta['sizes'] = array_merge($meta['sizes'], $new_meta['sizes']);

        // Update the meta data
        wp_update_attachment_metadata($image_id, $new_meta);
    }

    // Fetch the sized image
    $sized = wp_get_attachment_image_src($image_id, $size_id);

    // Remove the image size so new images won't be created in this size automatically
    remove_image_size($size_id);
    return $sized;
}

function chti($string, $ch1, $ch2, $ch3){
	
$ff=Array('0','1','2','3','4','5','6','7','8','9');

	if(substr($string,-2, 1)==1 AND strlen($string)>1) $ry=array("0 $ch3","1 $ch3","2 $ch3","3 $ch3" ,"4 $ch3","5 $ch3","6 $ch3","7 $ch3","8 $ch3","9 $ch3");

else $ry=array("0 $ch3","1 $ch1","2 $ch2","3 $ch2","4 $ch2","5 $ch3"," 6 $ch3","7 $ch3","8 $ch3"," 9 $ch3");

	$string1=substr($string,0,-1).str_replace($ff, $ry, substr($string,-1,1));

return $string1;
}

function upFirstLetter($str, $encoding = 'UTF-8') {
    return mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding) . mb_substr($str, 1, mb_strlen($str ,$encoding), $encoding);
}


function navigation_pages() {
	global $wp_query;
	$big = 999999999; // need an unlikely integer
	$pages = paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $wp_query->max_num_pages,
			'type'  => 'array',
			'prev_text' => '«',
			'next_text' => '»',
			
		) );
		if( is_array( $pages ) ) {
			$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
			echo '<div class="pagination">';
			foreach ( $pages as $page ) {

				echo $page; 
			}
			echo '</div>';
		}
} 


function the_content_limit($max_char, $more_link_text = '(Читать полностью &rarr;)', $stripteaser = 0, $more_file = '') {
   $content = get_the_content($more_link_text, $stripteaser, $more_file);
   $content = apply_filters('the_content', $content);
   $content = str_replace(']]>', ']]&gt;', $content);
   $content = strip_tags($content);

if ((strlen($_GET['p']) > 0) && ($espacio = strpos($content, " ",
$max_char ))) {
     $content = substr($content, 0, $espacio);
     $content = $content;

     echo $content;

  }
  else if ((strlen($content)>$max_char) && ($espacio =
strpos($content, " ", $max_char ))) {
       $content = substr($content, 0, $espacio);
       $content = $content;

       echo $content;
       echo "...";

  }
  else {

     echo $content;

  }
}

function PostViews($post_ID) {
 
    $count_key = 'post_views_count';
    $count = get_post_meta($post_ID, $count_key, true);
 
    if($count == ''){
        $count = 0;
delete_post_meta($post_ID, $count_key);
add_post_meta($post_ID, $count_key, '0');
        return $count . '';
    }else{
        $count++;
        update_post_meta($post_ID, $count_key, $count);
        if($count == '1'){
        return $count . '';
        }
        else {
        return $count . '';
        }
    }
}

function get_PostViews($post_ID){
    $count_key = 'post_views_count';
    $count = get_post_meta($post_ID, $count_key, true);
    return $count;
}





function exclude_sort_posts($query) {
	if(is_tax('speciality') or is_tax('clinic-speciality')){
		$query->set( 'order', 'ASC' );
	}
}

add_action('pre_get_posts', 'exclude_sort_posts');




/**
 * Menu item custom fields example
 *
 * Copy this file into your wp-content/mu-plugins directory.
 *
 * @package Menu_Item_Custom_Fields_Example
 * @version 0.2.0
 * @author Dzikri Aziz <kvcrvt@gmail.com>
 *
 *
 * Plugin name: Menu Item Custom Fields Example
 * Plugin URI: https://github.com/kucrut/wp-menu-item-custom-fields
 * Description: Example usage of Menu Item Custom Fields in plugins/themes
 * Version: 0.2.0
 * Author: Dzikri Aziz
 * Author URI: http://kucrut.org/
 * License: GPL v2
 * Text Domain: menu-item-custom-fields-example
 */


/**
 * Sample menu item metadata
 *
 * This class demonstrate the usage of Menu Item Custom Fields in plugins/themes.
 *
 * @since 0.1.0
 */
class Menu_Item_Custom_Fields_Example {

	/**
	 * Holds our custom fields
	 *
	 * @var    array
	 * @access protected
	 * @since  Menu_Item_Custom_Fields_Example 0.2.0
	 */
	protected static $fields = array();


	/**
	 * Initialize plugin
	 */
	public static function init() {
		add_action( 'wp_nav_menu_item_custom_fields', array( __CLASS__, '_fields' ), 10, 4 );
		add_action( 'wp_update_nav_menu_item', array( __CLASS__, '_save' ), 10, 3 );
		add_filter( 'manage_nav-menus_columns', array( __CLASS__, '_columns' ), 99 );

		self::$fields = array(
			'FieldImage' => __( 'Картинка', 'menu-item-custom-fields-example' ),
		);
	}


	/**
	 * Save custom field value
	 *
	 * @wp_hook action wp_update_nav_menu_item
	 *
	 * @param int   $menu_id         Nav menu ID
	 * @param int   $menu_item_db_id Menu item ID
	 * @param array $menu_item_args  Menu item data
	 */
	public static function _save( $menu_id, $menu_item_db_id, $menu_item_args ) {
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}

		check_admin_referer( 'update-nav_menu', 'update-nav-menu-nonce' );

		foreach ( self::$fields as $_key => $label ) {
			$key = sprintf( 'menu-item-%s', $_key );

			// Sanitize
			if ( ! empty( $_POST[ $key ][ $menu_item_db_id ] ) ) {
				// Do some checks here...
				$value = $_POST[ $key ][ $menu_item_db_id ];
			}
			else {
				$value = null;
			}

			// Update
			if ( ! is_null( $value ) ) {
				update_post_meta( $menu_item_db_id, $key, $value );
			}
			else {
				delete_post_meta( $menu_item_db_id, $key );
			}
		}
	}


	/**
	 * Print field
	 *
	 * @param object $item  Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args  Menu item args.
	 * @param int    $id    Nav menu ID.
	 *
	 * @return string Form fields
	 */
	public static function _fields( $id, $item, $depth, $args ) {
		foreach ( self::$fields as $_key => $label ) :
			$key   = sprintf( 'menu-item-%s', $_key );
			$id    = sprintf( 'edit-%s-%s', $key, $item->ID );
			$name  = sprintf( '%s[%s]', $key, $item->ID );
			$value = get_post_meta( $item->ID, $key, true );
			$class = sprintf( 'field-%s', $_key );
			?>
				<p class="description description-wide <?php echo esc_attr( $class ) ?>">
					<?php printf(
						'<label for="%1$s">%2$s<br /><input type="text" id="%1$s" class="widefat %1$s" name="%3$s" value="%4$s" /></label>',
						esc_attr( $id ),
						esc_html( $label ),
						esc_attr( $name ),
						esc_attr( $value )
					) ?>
				</p>
			<?php
		endforeach;
	}


	/**
	 * Add our fields to the screen options toggle
	 *
	 * @param array $columns Menu item columns
	 * @return array
	 */
	public static function _columns( $columns ) {
		$columns = array_merge( $columns, self::$fields );

		return $columns;
	}
}
Menu_Item_Custom_Fields_Example::init();






/*
    Prevent the email sending step for specific form
*/
add_action("wpcf7_before_send_mail", "wpcf7_do_something_else");

function wpcf7_do_something_else($cf7) {
    $submission = WPCF7_Submission::get_instance();
    // get the contact form object
    $wpcf = WPCF7_ContactForm::get_current();
    if ($submission) {
        $posted_data = $submission -> get_posted_data();
    }
	$form_id = $posted_data['_wpcf7'];
	$form_title = get_the_title($form_id);
    // if you wanna check the ID of the Form $wpcf->id
    $diagnostic = $posted_data['text-diagnostic'];
	
	if($form_title == "Отзыв"){
		// Создаём объект записи
		$my_post = array(
			'post_title' => $posted_data['your-name'],
			'post_content' => $posted_data['your-message'],
			'post_type' => 'reviews',
			'post_status' => 'publish'
		);

		// Вставляем запись в базу данных
		$post_id = wp_insert_post( $my_post );
		
		
		update_post_meta( $post_id, 'RatingQlf', $posted_data['rating-Qlf'] );
		update_post_meta( $post_id, 'RatingAtt', $posted_data['rating-Att'] );
		update_post_meta( $post_id, 'RatingRoom', $posted_data['rating-Room'] );
		update_post_meta( $post_id, 'DoctorId', $posted_data['text-review'] );
		
		
		function my_skip_mail($f){
			$submission = WPCF7_Submission::get_instance();
				return true; // DO NOT SEND E-MAIL  
		}
		add_filter('wpcf7_skip_mail','my_skip_mail');
			
			
			return $wpcf;
		
	}
	


    if ($diagnostic != "") {

        $send_array[name] = $posted_data['your-name'];
		$phone_clear = preg_replace("/[^0-9]/","", $posted_data['text-phone']);
        $send_array[phone] = $phone_clear;
        
		
        $send_array[clinic] = $posted_data['text-clinic'];

        $send_array[diagnostics] = $posted_data['text-diagnostic'];
        $send_array[kind] = "diagnostic";


        $json_send_array = json_encode($send_array);



    } else {
		
        $send_array[name] = $posted_data['your-name'];
		$phone_clear = preg_replace("/[^0-9]/","", $posted_data['text-phone']);
        $send_array[phone] = $phone_clear;

        if ($posted_data['text-medic']) {
            $send_array[doctor] = $posted_data['text-medic'];
        }
		
        if ($posted_data['text-city']) {
			$send_array[city] = $posted_data['text-city'];
		}

        if ($posted_data['text-clinic']) {
            $send_array[clinic] = $posted_data['text-clinic'];
        }

        if ($posted_data['text-time']) {
            $send_array[date] = $posted_data['text-time'];
        }

        if ($posted_data['text-service']) {
            $send_array[service] = $posted_data['text-service'];
        }
		
        $json_send_array = json_encode($send_array);
    }

        $login = get_field('логин', 'option');
        $password = get_field('пароль', 'option');

		$url = 'https://' . $login . ':' . $password . '@back.docdoc.ru/api/rest/1.0.6/json/request';


        $headers = 'Content-Type: application/json; charset='.get_option('blog_charset');

		$response = wp_remote_post($url, array('headers' => $headers, 'body' => $json_send_array)); 
        file_put_contents('log_request_d1.txt', print_r($posted_data, true), FILE_APPEND);
		file_put_contents('log_request_d.txt', print_r($json_send_array, true), FILE_APPEND);
        file_put_contents('log_response_d.txt', print_r($response, true), FILE_APPEND);

	function my_skip_mail($f){
		$submission = WPCF7_Submission::get_instance();
			return true; // DO NOT SEND E-MAIL  
	}
	add_filter('wpcf7_skip_mail','my_skip_mail');
	
	
	$my_post = array(
		'post_title' => $form_title,
		'post_status' => 'publish',
		'post_type' => 'orders',
	);
	
	$post_id = wp_insert_post( $my_post );
	
	if ($posted_data['text-medic']) {
		$args = array("post_type" => "medic", "meta_key" => "Id", "meta_value" => $posted_data['text-medic']);
		$medic = get_posts($args);
		$medic_post_id = $medic[0]->ID;	

		update_post_meta( $post_id, 'врач', $medic_post_id );

	}	
		
	if ($posted_data['text-clinic']) {
		$args = array("post_type" => "clinic", "meta_key" => "Id", "meta_value" => $posted_data['text-clinic']);
		$clinic = get_posts($args);
		$clinic_post_id = $clinic[0]->ID;	

		update_post_meta( $post_id, 'клиника', $clinic_post_id );
	
	}
		
	if ($diagnostic != "") {
		$taxonomy = 'diagnostic';
			$args = array(	'taxonomy' => $taxonomy,
				'meta_key' => 'Id',
				'meta_value' => $diagnostic,
				'hide_empty' => true,
			);
		$terms = get_terms($args); // Get all terms of a taxonomy
		$diagnostic_term_id = $terms[0]->term_id;
		update_post_meta( $post_id, 'диагностика', $diagnostic_term_id );
	}	
	
	if ($posted_data['text-service'] != "") {
		$taxonomy = 'uslugi';
			$args = array(	'taxonomy' => $taxonomy,
				'meta_key' => 'Id',
				'meta_value' => $posted_data['text-service'],
				'hide_empty' => false,
			);
		$terms = get_terms($args); // Get all terms of a taxonomy
		$usluga_term_id = $terms[0]->term_id;
		update_post_meta( $post_id, 'услуга', $usluga_term_id );
	}	
	
	
	$current_time = date('d-m-Y H:i:s');
	
	update_post_meta( $post_id, 'форма_заявки', $posted_data['_wpcf7'] );
	update_post_meta( $post_id, 'имя', $posted_data['your-name'] );
	update_post_meta( $post_id, 'телефон', $posted_data['text-phone'] );
	update_post_meta( $post_id, 'дата_заявки', $current_time );
	update_post_meta( $post_id, 'запрос', $json_send_array );

	
	$json_response = $response[body];
	$json_result = json_decode($json_response);
	$docdoc_order_status 	= $json_result->Response->status;
	$docdoc_order_message 	= $json_result->Response->message;
	$docdoc_order_id 		= $json_result->Response->id;
	
	
	update_post_meta( $post_id, 'статус', $docdoc_order_status );
	update_post_meta( $post_id, 'ответ_docdoc', $docdoc_order_message );
	update_post_meta( $post_id, 'id_заявки', $docdoc_order_id );
	
	
	
	
	
	
	
	
    return $wpcf;
}








								
// clinic-speciality search

if ( strpos($_SERVER["REQUEST_URI"], '/advanced-clinic-search/')!==false ) {
	$metro = $_GET['metro'];
	$clinic_speciality = $_GET['clinic-speciality'];
	
	if (preg_match("/metroterm-/i", $metro)) {
	$metro = preg_replace("/metroterm-/i", '', $metro);
	$redirect = 2;
} else {
	
    $district = preg_replace("/districtterm-/i", '', $metro);
	
}
if($metro != "" or $district != ""){
if($redirect == 2){
	$url = get_bloginfo('url') . '/clinic-speciality/' . $clinic_speciality . '/metro/' . $metro . "/";
} else { 
	$url = get_bloginfo('url') . '/clinic-speciality/' . $clinic_speciality . '/district/' . $district . "/";
}
} else {

	$url = get_bloginfo('url') . '/clinic-speciality/' . $clinic_speciality . "/";
	
}

wp_redirect( $url, 301 );
	exit;
	
}



// speciality search

if ( strpos($_SERVER["REQUEST_URI"], '/advanced-search/')!==false ) {
	$metro = $_GET['metro'];
	$speciality = $_GET['speciality'];
	$dop = $_GET['dop'];
	if (preg_match("/metroterm-/i", $metro)) {
		
	$metro = preg_replace("/metroterm-/i", '', $metro);
	$redirect = 2;
	
    } else {
		
    $district = preg_replace("/districtterm-/i", '', $metro);
}

	$link = '/speciality/' . $speciality;
	
	if($district != "" ){
		$link .= '/district/' . $district;	
	} elseif($metro != "" ){
		$link .= '/metro/' . $metro;	
	}
	
	if($dop != "" ){
		if ($dop[0] != "" and $dop[1] != "") {
			$link .= '/' . $dop[0] . '+' . $dop[1];	
		} else {
			$link .= '/' . $dop[0];	
		}
	}
	
	$url = get_bloginfo('url') . $link . '/';
	
	wp_redirect( $url, 301 );
	exit;
	
}


// diagnostic search
if ( strpos($_SERVER["REQUEST_URI"], '/advanced-diagnostic-search/')!==false ) {
	
	$metro = $_GET['metro'];
	$diagnostic = $_GET['diagnostic'];
	
	if (preg_match("/metroterm-/i", $metro)) {

	$metro = preg_replace("/metroterm-/i", '', $metro);
	$redirect = 2;
} else {

    $district = preg_replace("/districtterm-/i", '', $metro);

}
if($metro != "" or $district != ""){
if($redirect == 2){
	$url = get_bloginfo('url') . '/diagnostic/' . $diagnostic . '/metro/' . $metro . "/";
} else { 
	$url = get_bloginfo('url') . '/diagnostic/' . $diagnostic . '/district/' . $district . "/";
}

} else {

	$url = get_bloginfo('url') . '/diagnostic/' . $diagnostic . "/";
	
}
wp_redirect( $url, 301 );
	exit;

	
}



function custom_rewrite_rules() {
 	add_rewrite_rule('^clinic-speciality/([^/]+)/metro/([^/]+)/?$', 'index.php?clinic-speciality=$matches[1]&metro=$matches[2]', 'top');
	add_rewrite_rule('^clinic-speciality/([^/]+)/metro/([^/]+)/page/([0-9]+)?$', 'index.php?clinic-speciality=$matches[1]&metro=$matches[2]&paged=$matches[3]', 'top');
	
	add_rewrite_rule('^clinic-speciality/([^/]+)/district/([^/]+)/?$', 'index.php?clinic-speciality=$matches[1]&district=$matches[2]', 'top');
	add_rewrite_rule('^clinic-speciality/([^/]+)/district/([^/]+)/page/([0-9]+)?$', 'index.php?clinic-speciality=$matches[1]&district=$matches[2]&paged=$matches[3]', 'top');
	
	
	
    add_rewrite_rule('^speciality/([^/]+)/metro/([^/]+)/?$', 'index.php?speciality=$matches[1]&metro=$matches[2]', 'top');
	add_rewrite_rule('^speciality/([^/]+)/metro/([^/]+)/page/([0-9]+)?$', 'index.php?speciality=$matches[1]&metro=$matches[2]&paged=$matches[3]', 'top');
	
	add_rewrite_rule('^speciality/([^/]+)/district/([^/]+)/?$', 'index.php?speciality=$matches[1]&district=$matches[2]', 'top');
	add_rewrite_rule('^speciality/([^/]+)/district/([^/]+)/page/([0-9]+)?$', 'index.php?speciality=$matches[1]&district=$matches[2]&paged=$matches[3]', 'top');
	
	
 	add_rewrite_rule('^diagnostic/([^/]+)/metro/([^/]+)/?$', 'index.php?diagnostic=$matches[1]&metro=$matches[2]', 'top');
	add_rewrite_rule('^diagnostic/([^/]+)/metro/([^/]+)/page/([0-9]+)?$', 'index.php?diagnostic=$matches[1]&metro=$matches[2]&paged=$matches[3]', 'top');
	
	add_rewrite_rule('^diagnostic/([^/]+)/district/([^/]+)/?$', 'index.php?diagnostic=$matches[1]&district=$matches[2]', 'top');
	add_rewrite_rule('^diagnostic/([^/]+)/district/([^/]+)/page/([0-9]+)?$', 'index.php?diagnostic=$matches[1]&district=$matches[2]&paged=$matches[3]', 'top'); 
	
	// Доп 
	add_rewrite_rule('^speciality/([^/]+)/([^/]+)/?$', 'index.php?speciality=$matches[1]&dop=$matches[2]', 'top');
	add_rewrite_rule('^speciality/([^/]+)/([^/]+)/page/([0-9]+)?$', 'index.php?speciality=$matches[1]&dop=$matches[2]&paged=$matches[3]', 'top');
	
	// Доп метро
	add_rewrite_rule('^speciality/([^/]+)/metro/([^/]+)/([^/]+)/?$', 'index.php?speciality=$matches[1]&metro=$matches[2]&dop=$matches[3]', 'top');
	add_rewrite_rule('^speciality/([^/]+)/metro/([^/]+)/([^/]+)/page/([0-9]+)?$', 'index.php?speciality=$matches[1]&metro=$matches[2]&dop=$matches[3]&paged=$matches[4]', 'top');
	
	// Доп район
	add_rewrite_rule('^speciality/([^/]+)/district/([^/]+)/([^/]+)/?$', 'index.php?speciality=$matches[1]&district=$matches[2]&dop=$matches[3]', 'top');
	add_rewrite_rule('^speciality/([^/]+)/district/([^/]+)/([^/]+)/page/([0-9]+)?$', 'index.php?speciality=$matches[1]&district=$matches[2]&dop=$matches[3]&paged=$matches[4]', 'top');
	
	
	// Врачи в клинике
    add_rewrite_rule('^speciality/([^/]+)/inclinic/([^/]+)/?$', 'index.php?speciality=$matches[1]&inclinic=$matches[2]', 'top');
	add_rewrite_rule('^speciality/([^/]+)/inclinic/([^/]+)/page/([0-9]+)?$', 'index.php?speciality=$matches[1]&inclinic=$matches[2]&paged=$matches[3]', 'top');
	
}
add_action('init', 'custom_rewrite_rules', 10, 0);




function wpse139657_orderby(){
    if( isset($_GET['orderby']) ){
        $order = $_GET['order'] or 'DESC';
        set_query_var('orderby', 'meta_value_num');
        set_query_var('meta_key', $_GET['orderby']);
        set_query_var('order', $order);
    } else {
		if( isset($_GET['orderby']) ){
			$order = $_GET['order'] or 'DESC';
			 set_query_var('order', $order);
		}
	}
}

add_filter('pre_get_posts','wpse139657_orderby');




function my_scripts_method() {
	wp_enqueue_script(
		'custom-script',
		'//api-maps.yandex.ru/2.1/?lang=ru_RU',
		array('jquery')
	);
}
add_action('wp_enqueue_scripts', 'my_scripts_method');


















