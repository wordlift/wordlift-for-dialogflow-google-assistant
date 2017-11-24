<div class="cl-form">
	<div class="wrap">
		<h2>
			<?php echo $this->get_menu_title(); ?>
		</h2>

		<form method="post" action="options.php">
			<?php 
			settings_fields( $this->get_menu_id() );
			
			do_settings_sections( $this->get_menu_id() );

			submit_button(__('Save', 'cl')); 
			?>
		</form>
	</div>
</div>