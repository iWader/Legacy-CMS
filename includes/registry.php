<?php
	
	/**
	 * Set-up all required details from user information and settings
	 * to the page content
	 * Last Edited: 31-12-2011 18:47:59 -00:00 (31 December 2011)
	 *
	 * @author		Wader
	 * @copyright	(c) 2011 Wade Urry
	 * @license http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
	 */
	if (!defined('IN_CMS')) {
		print "<h1>Incorrect access</h1>You cannot access this file directly.";
		exit();
	}
	
	# Block prefetch requests
	if (isset($_SERVER['HTTP_X_MOZ']) && $_SERVER['HTTP_X_MOZ'] == 'prefetch') {
		header('HTTP/1.1 403 Prefetching Forbidden');
		
		#Send no-cache headers
		header('Expries: Thu, 21 Jul 1977 07:30:00 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragme: no-cache'); # HTTP/1.0 compability
		die();
	}
	
	# Require CACHE class
	require(ABSPATH . INCLUDES_PATH . 'cache.class.php');
	
	# Require CMS class
	require(ABSPATH . INCLUDES_PATH . 'cms.class.php');
	
	# Require USER class
	require(ABSPATH . INCLUDES_PATH . 'user.class.php');
	
?>