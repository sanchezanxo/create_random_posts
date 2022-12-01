<?php
if (!current_user_can ('manage_options')) 
		wp_die (__ ('Nothing to see here'));
?>

	<div class="wrap">
		<div class="instructions">
			<h2><?php _e( 'Create Random Posts', 'create_random_posts' ) ?></h2>
			<p><?php _e( 'With this plugin you can automatically create as many test entries as you want. It has two modes.', 'create_random_posts' ) ?></p>
			<p>
				<ul class="list-main">
					<li>
						<?php _e( 'Mode 1. Indicate the title and text model to use. ', 'create_random_posts' ) ?> 
					</li>
					<li>
						<?php _e( 'Mode 2. Let the plugin work its magic by generating random titles and texts. ', 'create_random_posts' ) ?> 
					</li>
				</ul>
			</p>
		
		</div>
	</div>
	


