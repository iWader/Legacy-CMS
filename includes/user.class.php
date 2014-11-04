<?php
	
	/**
	 * Set-up all required details from user information and settings
	 * to the page content
	 * Last Edited: 31-12-2011 18:51:24 -00:00 (31 December 2011)
	 *
	 * @author		Wader
	 * @copyright	(c) 2011 Wade Urry
	 * @license http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
	 */
	if (!defined('IN_CMS')) {
		print "<h1>Incorrect access</h1>You cannot access this file directly.";
		exit();
	}
	
	class USER {
			
			# Stores the users set style
			public $style = "Default";
			
			# Stores the users IP address
			public $ip = null;
			
			# Stores the users USER_AGENT
			public $user_agent = null;
			
			# Stores the users access level
			public $access = 0;
			
			# Constructor function
			public function __construct() {
				# Assume user is guest 
				$this->style = "Default";
				$this->ip = $_SERVER['REMOTE_ADDR'];
				$this->uagent = $_SERVER['HTTP_USER_AGENT'];
				$this->access = 0;
			}
			
	}
	
	$USER = new USER();
	
?>