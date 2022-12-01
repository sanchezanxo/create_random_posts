<?php

//New option in WordPress Menu
add_action('admin_menu', 'crp_menu');
function crp_menu(){
	add_menu_page( __( 'Create Random Posts', 'create_random_posts' ) , __( 'Create Random Posts', 'create_random_posts' ) , 'manage_options' , CRP_RUTA.'admin/main.php', null, 'dashicons-text');
	add_submenu_page( CRP_RUTA.'admin/main.php', __( 'Insert Random Posts', 'create_random_posts' ) , __( 'Insert Random Posts', 'create_random_posts' ) , 'manage_options' ,  CRP_RUTA.'admin/insert.php' );
	add_submenu_page( CRP_RUTA.'admin/main.php', __( 'Generate Random Posts', 'create_random_posts' ) , __( 'Generate Random Posts', 'create_random_posts' ) , 'manage_options' ,  CRP_RUTA.'admin/generate.php' );

}

//Insert posts
add_action( 'admin_post_create_posts_action', 'crp_insert_posts_action' );
function crp_insert_posts_action() {
	
	$num_post = intval($_POST['num_post']);
	$title_prefix = $_POST['title_prefix'];
	$text_post = $_POST['text_post'];
	$category_post = $_POST['category_post'];
	$image = $_FILES['image_post'];
	$id_image = '';
	
	
	//If there is an error with the image, we show the following message
	if ( $image['error'] ) {
		//Nothing to do
	} 
	else {
		//If there are no errors, we upload the image to the WordPress directory and insert it in the library
		$upload = wp_upload_bits( $image['name'], null, file_get_contents( $image['tmp_name'] ) );
		$id_image = wp_insert_attachment( array(
			'guid'           => $upload['url'], 
			'post_mime_type' => $image['type'],
			'post_title'     => sanitize_file_name($image['name']),
			'post_content'   => '',
			'post_status'    => 'inherit'
		), $upload['file'] );

		//Generate thumbnails and other information related to the image.
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		$attach_data = wp_generate_attachment_metadata( $id_image, $upload['file'] );
		wp_update_attachment_metadata( $id_image, $attach_data );		
	}	
	
	
    // Create category if not exists
    if (!term_exists($category_post, 'category')){
        wp_insert_term($category_post, 'category');
    }	
	
	for ($i = 0; $i < $num_post; $i++) {
		$title = $title_prefix . ($i + 1);
		$slug = sanitize_title($title);
		$post_data = array(
			'post_title' => $title,
			'post_name' => $slug,
			'post_content' => $text_post,
			'post_status' => 'publish',
			'post_type' => 'post',
			'post_category' => array(get_cat_ID($category_post))
		);

		$post_id = wp_insert_post($post_data);
		set_post_thumbnail($post_id, $id_image);
	}
		
	
}


//Insert posts
add_action( 'admin_post_create_posts_action', 'crp_generate_posts_action' );
function crp_generate_posts_action() {
	
	$num_post = intval($_POST['num_post']);
	$num_paragraph = intval($_POST['num_paragraph']);
	$category_post = $_POST['category_post'];
	$image = $_FILES['image_post'];
	$id_image = '';
	
	//create the URL of Lorem Ipsum API
	$url = 'https://loripsum.net/api/' . $num_paragraph . '/';
	
	//If short paragraph, then...
	if(isset($_POST['short_paragraphs']))	
		$url = $url.'short/';

	//If headers, then...
	if(isset($_POST['headers']))	
		$url = $url.'headers/';
	
	//If decoration, then...
	if(isset($_POST['decoration']))	
		$url = $url.'decoration/';	

	//If list (UL LIST), then...
	if(isset($_POST['ul_list']))	
		$url = $url.'ul/';	

	//If quotes, then...
	if(isset($_POST['quotes']))	
		$url = $url.'bq/';		
	
	//calling Lorem Ipsum API with wp_remote_get()
	//wp_remote_get return an array. we need the 2º position.
	$generate_text = wp_remote_get( $url )['body']; 
	
	
	//If there is an error with the image, we show the following message
	if ( $image['error'] ) {
		//Nothing to do
	} 
	else {
		//If there are no errors, we upload the image to the WordPress directory and insert it in the library
		$upload = wp_upload_bits( $image['name'], null, file_get_contents( $image['tmp_name'] ) );
		$id_image = wp_insert_attachment( array(
			'guid'           => $upload['url'], 
			'post_mime_type' => $image['type'],
			'post_title'     => sanitize_file_name($image['name']),
			'post_content'   => '',
			'post_status'    => 'inherit'
		), $upload['file'] );

		//Generate thumbnails and other information related to the image.
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		$attach_data = wp_generate_attachment_metadata( $id_image, $upload['file'] );
		wp_update_attachment_metadata( $id_image, $attach_data );		
	}	
	
	
    // Create category if not exists
    if (!term_exists($category_post, 'category')){
        wp_insert_term($category_post, 'category');
    }	
	
	for ($i = 0; $i < $num_post; $i++) {
		$lenght_text = strlen( $generate_text );
		$sanitize_text = sanitize_text_field( $generate_text );
		//generate random titles
		$title = substr($sanitize_text, rand(0, $lenght_text-100), rand(40, 100));
		$slug = sanitize_title($title);
		$post_data = array(
			'post_title' => $title,
			'post_name' => $slug,
			'post_content' => $generate_text,
			'post_status' => 'publish',
			'post_type' => 'post',
			'post_category' => array(get_cat_ID($category_post))
		);

		$post_id = wp_insert_post($post_data);
		set_post_thumbnail($post_id, $id_image);
	}
		
	
}

// Custom CSS in Admin plugin dashboard
function crp_load_style() {
	wp_enqueue_style('style_admin', content_url( 'plugins/create_random_posts/admin/css/style_admin.css' , __FILE__ ));
}
add_action('admin_enqueue_scripts', 'crp_load_style');

 ?>