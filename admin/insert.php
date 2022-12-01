<?php
if (!current_user_can ('manage_options')) 
		wp_die (__ ('Nothing to see here'));
?>

	<div class="wrap">

		<div class="instructions">
			<h2><?php _e( 'Insert Random Posts', 'create_random_posts' ) ?></h2>
			<?php _e( 'Instructions: indicate the number of posts to create, a prefix for the title, the featured image (optional), the post category (optional) and the text of the posts.', 'create_random_posts' ) ?>
		</div>
		
		 <div class="form-container">
			<form method="post" enctype="multipart/form-data" class="form-posts">
				<label><?php _e( 'Number of posts to create (required):', 'create_random_posts' ) ?></label><br>
				<input type="number" name="num_post" required/><br>
				<label><?php _e( 'Title prefix (required):', 'create_random_posts' ) ?></label><br>
				<input type="text" name="title_prefix" required/><br>
				
				<label><?php _e( 'Featured image:', 'create_random_posts' ) ?></label><br>			
				<input type="file" name="image_post" accept="image/png, image/gif, image/jpeg, image/jpg"/><br>
			
				<label><?php _e( 'Category of the post:', 'create_random_posts' ) ?></label><br>
				<input type="text" name="category_post" /><br>			
				<label><?php _e( 'Text to be included in the posts (required):', 'create_random_posts' ) ?></label><br>
				<textarea  name="text_post" rows="6" required/></textarea><br>			
				<input type="hidden" name="insert_posts" value="1" />
				<input type="submit" value="<?php _e( 'Insert posts', 'create_random_posts' ) ?>" />
			</form>
		</div>
		</div>

		
	</div>
	
    <?php
    if(isset($_POST['insert_posts'])){
        crp_insert_posts_action();
    }
 ?>