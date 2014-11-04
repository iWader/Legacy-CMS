<?php
	
	/**
	 * Initialization file
	 * Last Edited: 31-12-2011 18:45:10 -00:00 (31 December 2011)
	 *
	 * @author		Wader
	 * @copyright	(c) 2011 Wade Urry
	 * @license http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
	 */
	 
	# Check is file is not being accessed directly
	if (!defined('IN_CMS')) {
		print "<h1>Incorrect access</h1>You cannot access this file directly.";
		exit();
	}
	
	# Turn off magic_quotes_runtime
	if (get_magic_quotes_runtime())
		@ini_set('magic_quotes_runtime', false);
	
	# Strip slashes from GET/POST/COOKIE (if magic_quotes_gpc is enabled)
	if (get_magic_quotes_gpc()) {
		function stripslashes_array($array) {
			return is_array($array) ? array_map('stripslashes_array', $array) : stripslashes($array);
		}
		
		$_GET = stripslashes_array($_GET);
		$_POST = stripslashes_array($_POST);
		$_COOKIE = stripslashes_array($_COOKIE);
	}
	
	# Buffer output. We only want headers sent at this point.
	ob_start();
		 
	# Defines the Absolute file path from the Systems root directory.
	define('ABSPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
	
	# Defines the site URL
	define('URL', 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['SERVER_NAME']);
	
	# Load global settings as defined by the user.
	require('conf-global.php');
		
	# Check if debug mode is enabled
	if (DEBUG_MODE == true) {
		ini_set('display_errors', 1);
		error_reporting(E_ALL);
	}
	
	# Load registry to prepare for output
	require(ABSPATH . INCLUDES_PATH . 'registry.php');
	
	# Load rewrite file
	require('rewrite.php');

	# Display output and clean buffer.
	$output = ob_get_contents();
	ob_end_clean();
	print $output;
	
?>