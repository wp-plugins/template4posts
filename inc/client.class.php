<?php
class Template4Posts_Client {
	
	function template4posts_client() {
		add_action ( 'template4posts', array (&$this, 'get_post_template' ), 10, 2 );
	}
	
	/**
	 * Retrieve path of page template in current or parent template.
	 *
	 * Will first look for the specifically assigned post template
	 *
	 */
	function get_post_template( $force_template = '' ) {
		global $post;
		
		$template = get_post_meta ( $post->ID, '_post_template', true );
		$pagename = get_post_templates ();
		if ('' == $template)
			//$template = '';
			$template = get_option( 'template4posts-default' );
		if ($force_template != '' && $pagename [$force_template] ['url']) {
			$template = $force_template;
		}
		
		if (! empty ( $pagename ) && ! validate_file ( $pagename [$template] ['url'] ) && $template != 'No Template') {
			include get_template_directory () . apply_filters('template4posts_pagename', $pagename [$template] ['url']);
			return true;
		} else {
			if (function_exists ( 'get_generic_template' )) {
				get_generic_template ( 'loop', 'index' );
				return true;
			}
		}
		return 'No Template';
	}

}

?>