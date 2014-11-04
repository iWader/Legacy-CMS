<?php
	
	/**
	 * CMS class
	 * Last Edited: 31-12-2011 01:13:39 -00:00 (31 December 2011)
	 *
	 * @author		Wader
	 * @copyright	(c) 2011 Wade Urry
	 * @license http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
	 */
	if (!defined('IN_CMS')) {
		print "<h1>Incorrect access</h1>You cannot access this file directly.";
		exit();
	}
	
	# Make sure PHP has been built with PDO() enabled.
	if (!class_exists('PDO')) {
		print 'This PHP environment is not PDO() capable. See: http://php.net/manual/en/pdo.installation.php';
		die();
	}
	
	class CMS {
		
		# Database var. Stores the active database PDO connection
		public $DB = null;
		
		# Number of SQL querys executed
		public static $num_querys;
		
		public function __construct() {
			$this->db_connect();
		}
		
		public function __destruct() {
			
		}
		
		public function db_connect() {
			$dsn = DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_NAME;
			try {
				$this->DB = new PDO($dsn, DB_USER, DB_PASS);
			}
			catch (PDOException $err) {
				print 'Database Connection Failed: ' . $err->getMessage();
				die();
			}
		}
		
		public function prepare_query($sql) {
			self::$num_querys++;
			return $this->DB->prepare($sql);
		}
	}
	
	$CMS = new CMS();
	
?>