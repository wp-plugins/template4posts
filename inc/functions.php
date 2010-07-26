<?php
/**
 * Get the Post Templates available in this theme
 *
 */
function get_post_templates() {
	$themes = get_themes ();
	$theme = apply_filters( 'current_theme', get_current_theme () );
	$templates = $themes [$theme] ['Template Files'];
	$page_templates = array ();
	
	if (is_array ( $templates )) {
		
		foreach ( $templates as $template ) {
			$template_data = implode ( '', file ( $template ) );
			$name = '';
			if (preg_match ( '|Template Post Name:(.*)$|mi', $template_data, $name ))
				$name = _cleanup_header_comment ( $name [1] );
			
			if (! empty ( $name )) {
				$str = get_file_data ( $template, array ('Name' => 'Template Post Name', 'Description' => 'Description' ) );
				$template2 = str_replace ( '.php', '', $template );
				$template2 = str_replace ( get_template_directory (), '', $template2 );
				$page_temp ['slug'] = str_replace ( '/', '', $template2 );
				$page_temp ['url'] = str_replace ( get_template_directory (), '', $template );
				$page_templates [trim ( $name )] = array_merge ( $page_temp, $str );
			}
		}
	}
	
	return $page_templates;
}

function get_template4posts( $template = null ) {
	return do_action ( 'template4posts', $template );
}
?>