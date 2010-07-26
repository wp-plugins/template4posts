<?php
class Template4Posts_Admin {
	
	function Template4Posts_Admin() {
		add_action( 'save_post', 					array(&$this, 'save') );
		add_action( 'admin_menu', 					array(&$this, 'addpage') );
		add_action( 'post_submitbox_misc_actions', 	array(&$this, 'boxAdd') );
	}
	
	function initBox() {
		add_meta_box( 'template4posts_div', __('Post Template', 'template4posts'), array(&$this, 'blockAdmin'), 'post', 'side', 'core' );
	}
	
	/**
	 *	Add meta box in edit/add post
	 **/
	function boxAdd() {
		global $post;
		
		$post_templates = get_post_templates();
		$select = get_post_meta( $post->ID, '_post_template', true );
		if( $select == '' ) {
			$select = get_option( 'template4posts-default' );
			if( $select == '' ) {
				$option = $this->getThemeSettings();
				$select = $option['Name'];
			}
		}
		
		$settings_arr 	= $this->getThemeSettings();
		$post_templates = array_merge(array($settings_arr), $post_templates);
		?>
		<div class="misc-pub-section" style="padding:0px;"></div>
		<div class="misc-pub-section misc-pub-section-last">
			<?php _e("Listing Layout:", 'template4posts'); ?>
			
			<span id="post-posttemplate-display" style="font-weight:bold;"><?php echo $select?></span>
			<a href="#edit_posttemplate" class="edit-posttemplate hide-if-no-js" tabindex="4"><?php _e('Edit', 'template4posts') ?></a>
			
			<div id="post-template-select" class="hide-if-js">
				<select name="post_template" id="post_template">
					<?php
					foreach( $post_templates as $post_template ) {
						echo '<option value="' . esc_attr($post_template['Name']) . '" ' . selected($select, $post_template['Name'], true) . '>' . $post_template['Name'] . ($post_template['Description'] ?' - ' . $post_template['Description'] : '') . '</option>';
					}
					?>
				</select>
				
				<p>
				 <a href="#edit_posttemplate" class="save-post-template hide-if-no-js button"><?php _e('Ok', 'template4posts'); ?></a>
				 <a href="#edit_posttemplate" class="cancel-post-template hide-if-no-js"><?php _e('Cancel', 'template4posts'); ?></a>
				</p>
			</div>
		</div>
		
		<script type="text/javascript">
			jQuery('.edit-posttemplate').click(function () {
				if (jQuery('#post-template-select').is(":hidden")) {
					jQuery('#post-template-select').slideDown("normal");
					jQuery(this).hide();
				}
				return false;
			});
			jQuery('.save-post-template').click(function () {
				if (jQuery('#post-template-select').is(":visible")) {
					jQuery('#post-posttemplate-display').html(jQuery('#post_template > :selected').val() );
					jQuery('.edit-posttemplate').show();
					jQuery('#post-template-select').slideUp("normal");
				}
				return false;
			});
			jQuery('.cancel-post-template').click(function () {
				if (jQuery('#post-template-select').is(":visible")) {
					jQuery('.edit-posttemplate').show();
					jQuery('#post-template-select').slideUp("normal");
				}
				return false;
			});
		</script>
		<?php
	}
	
	/**
	 * Save the meta
	 **/
	function save( $id ) {
		if( isset($_POST['post_template']) ) {
			update_post_meta( $id, '_post_template', stripslashes($_POST['post_template']) );
		}
	}
	
	/**
	 * Add the Setting page
	 **/
	function addpage() {
		add_theme_page( __('Listing Layout Settings', 'template4posts'), __('Listing Layout Settings', 'template4posts'), 'manage_options', 'template4posts', array( &$this, 'pageOptions') );
	}
	
	function getThemeSettings() {
		return array( 'Name' => __('No Template', 'template4posts') );
	}
	
	/**
	 * View the listing layout default and can modify this.
	 **/
	function pageOptions() {
		$post_templates = get_post_templates();
		
		// Get the theme settings and add them to the database.
		$settings_arr = $this->getThemeSettings();
		add_option( 'template4posts-default', $settings_arr['Name'] );
		$post_templates = array_merge(array($settings_arr), $post_templates);
		
		// Get existing options from the database.
		$settings = get_option( 'template4posts-default' );
		
		// If the form has been set, loop through the values. Set the option in the database.
		if ( $_POST['custom_submit_hidden'] == 'Y' ) {
			update_option( 'template4posts-default', $_POST['post_template'] );
			echo '<p class="updated" style="margin:15px 0;padding:5px 10px;"><strong>' . __('Settings saved.', 'template4posts') . '</strong></p>';
		}
		?>
		<div class="wrap">
			<h2><?php _e('Listing Layout Settings', 'template4posts' ); ?></h2>
			
			<div id="poststuff" class="dlm">
				<form name="form0" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI'] ); ?>" style="border:none;background:transparent;">
					<div class="postbox open">
						<h3><?php _e('General', 'template4posts') ?></h3>
						
						<div class="inside">
							<table class="form-table">
								<tr>
									<th>
										<label for="<?php _e("Listing Layout Default",'template4posts'); ?>"><?php _e("Listing Layout Default",'template4posts'); ?></label>
									</th>
									<td>
										<select name="post_template" id="post_template">
											<?php
											foreach( $post_templates as $post_template){
												echo '<option value="' . $post_template['Name'] . '" ' . ($settings == $post_template['Name'] ? 'selected="selected"' : '') . '>' . $post_template['Name'] . ($post_template['Description'] ?' - ' . $post_template['Description'] : '') . '</option>';
											}
											?>
										</select>
									</td>
								</tr>
							</table>
						</div>
					</div>
					
					<p class="submit">
						<input type="submit" name="submit" class="button-primary" value="<?php _e('Save Changes', 'template4posts') ?>" />
						<input type="hidden" name="custom_submit_hidden" value="Y" />
					</p>
				</form>
			</div>
		</div> <!-- end of "wrap" -->
		<?php
	}

}
?>