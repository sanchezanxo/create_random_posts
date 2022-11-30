<?php

//New option in WordPress Menu
add_action('admin_menu', 'crp_menu');
function crp_menu(){
	add_menu_page('Create Random Posts', 'Create Random Posts', 'manage_options', CRP_RUTA.'admin/configuration.php', null, 'dashicons-text');
}

//Create posts
add_action( 'admin_post_create_posts_action', 'create_posts_action' );
add_action( 'admin_post_nopriv_create_posts_action', 'create_posts_action' );
function create_posts_action() {
	
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

// Custom CSS in Admin plugin dashboard
function load_style() {
	wp_enqueue_style('style_admin', content_url( 'plugins/create_random_posts/admin/css/style_admin.css' , __FILE__ ));
}
add_action('admin_enqueue_scripts', 'load_style');

 ?>