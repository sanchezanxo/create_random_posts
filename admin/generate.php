<?php
if (!current_user_can ('manage_options')) 
		wp_die (__ ('Nothing to see here'));
?>

	<div class="wrap">
		<div class="instructions">
			<h2><?php _e( 'Generate Random Posts', 'create_random_posts' ) ?></h2>
			<?php _e( 'Instructions: indicate the number of posts to create, the number of paragraphs of each text and the rest of the options are optional. <br> Configure it as you want and the plugin will do the rest.', 'create_random_posts' ) ?>
		</div>

		 <div class="form-container">
			<form method="post" enctype="multipart/form-data" class="form-posts">
				<label><?php _e( 'Number of posts to generate (required):', 'create_random_posts' ) ?></label><br>
				<input type="number" name="num_post" required/><br>
				
				<label><?php _e( 'Number of paragraph to generate (required):', 'create_random_posts' ) ?></label><br>
				<input type="number" name="num_paragraph" required/><br>		
				
				<label><?php _e( 'Featured image:', 'create_random_posts' ) ?></label><br>			
				<input type="file" name="image_post" accept="image/png, image/gif, image/jpeg, image/jpg"/><br>
				
				<label><?php _e( 'Category of the post:', 'create_random_posts' ) ?></label><br>
				<input type="text" name="category_post" /><br>									
			
				<div class="form-checkbox">
					<input type="checkbox" name="short_paragraphs" value="short_paragraphs"/>
					<label><?php _e( 'Do you want short paragraphs?', 'create_random_posts' ) ?></label><br>	
				</div>

				<div class="form-checkbox">
					<input type="checkbox" name="headers" value="headers"/>
					<label><?php _e( 'Do you want headers in the text?', 'create_random_posts' ) ?></label><br>	
				</div>
				
				<div class="form-checkbox">
					<input type="checkbox" name="decoration" value="decoration"/>
					<label><?php _e( 'Do you want styles (bold, italic...) in the text?', 'create_random_posts' ) ?></label><br>	
				</div>				
				
				<div class="form-checkbox">
					<input type="checkbox" name="ul_list" value="ul_list"/>
					<label><?php _e( 'Do you want lists in the text?', 'create_random_posts' ) ?></label><br>	
				</div>	

				<div class="form-checkbox last-checkbox">
					<input type="checkbox" name="quotes" value="quotes"/>
					<label><?php _e( 'Do you want quotes in the text?', 'create_random_posts' ) ?></label><br>	
				</div>						

				<input type="hidden" name="generate_posts" value="1" />
				<input type="submit" value="<?php _e( 'Generate posts', 'create_random_posts' ) ?>" />
			</form>
		</div>

		
	</div>
	
    <?php
    if(isset($_POST['generate_posts'])){
        crp_generate_posts_action();
    }
 ?>