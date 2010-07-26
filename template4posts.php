<?php
/*
Plugin Name: Template for Posts
Version: 2.1
Plugin URI: http://www.beapi.fr
Description: Define a template about a post. To use, please read the readme.txt.
Author: Be API
Author URI: http://www.beapi.fr

----

Copyright 2010 Julien Guilmont (julien.guilmont@beapi.fr)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

---
*/

// Init some constants
if (! defined ( 'T4P_FOLDER' )) {
	define ( 'T4P_FOLDER', 'template4posts' );
}

// mu-plugins or regular plugins ?
if ( is_dir(WPMU_PLUGIN_DIR . DIRECTORY_SEPARATOR . T4P_FOLDER ) ) {
	define ( 'T4P_DIR', WPMU_PLUGIN_DIR . DIRECTORY_SEPARATOR . T4P_FOLDER );
	define ( 'T4P_URL', WPMU_PLUGIN_URL . '/' . T4P_FOLDER );
} else {
	define ( 'T4P_DIR', WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . T4P_FOLDER );
	define ( 'T4P_URL', WP_PLUGIN_URL . '/' . T4P_FOLDER );
}

if (! defined ( 'T4P_JS_FOLDER' )) {
	define ( 'T4P_JS_FOLDER', T4P_URL . '/js' );
}

if (! defined ( 'T4P_TEMPLATE' )) {
	define ( 'T4P_TEMPLATE', T4P_DIR . '/template' );
}

// Call all class and functions
require ( T4P_DIR . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'admin.class.php'  );
require ( T4P_DIR . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'client.class.php'  );
require ( T4P_DIR . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'functions.php' );

add_action ( 'plugins_loaded', 'initTemplate4Posts' );
function initTemplate4Posts() {
	global $template4posts;
	
	// Load translations
	load_plugin_textdomain ( 'template4posts', str_replace ( ABSPATH, '', T4P_DIR ) . '/languages', false );
	
	// Admin
	if ( is_admin() ) {
		$template4posts['admin'] = new Template4Posts_Admin();
	}
	
	$template4posts['client'] = new Template4Posts_Client();

}
?>