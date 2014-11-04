<?php
	
	/**
	 * Retrieves the content required for the selected page and
	 * then load the style file
	 * Last Edited: 02-01-2012 22:14:58 -00:00 (2 January 2012)
	 *
	 * @author		Wader
	 * @copyright	(c) 2011 Wade Urry
	 * @license http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
	 */
	 
	# Check file isn't being accessed directly
	if (!defined('IN_CMS')) {
		print "<h1>Incorrect access</h1>You cannot access this file directly.";
		exit();
	}
	
	$cache = new FileCache(array('key' => 'article-' . $_GET['id']));
	
	if (!$cache->getCache()) {
		# No cache data or it expired. Get new data from db
		$sql = "SELECT *, UNIX_TIMESTAMP(`timestamp`) AS `timestamp` FROM `" . TB_PREFIX . "articles` WHERE `id` = :id";
		$query = $CMS->prepare_query($sql);
		$query->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
		$query->execute();
		$results = $query->fetch(PDO::FETCH_ASSOC);
		
		# Put new data into cache
		$cache->setCache($results, '+1 day', true);
	}
	else {
		# Cache data. Fetch it
		$results = $cache->getCache();
	}
	
	# Unset ready for next cache also frees resources
	unset($cache);
	
	if (isset($_GET['id']) && !isset($_GET['slug'])) {
		$link = URL . '/blog/' . $results['id'] . '-' . $results['slug'];
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $link);
		exit();
	}
	
	$cache = new FileCache(array('key' => 'comments-' . $_GET['id']));
	
	if (!$cache->getCache()) {
		# No cache data or it expired. Get new data from db
		$sql = "SELECT *, UNIX_TIMESTAMP(`timestamp`) AS `timestamp` FROM `" . TB_PREFIX . "comments` WHERE `article_id` = :id";
		$query = $CMS->prepare_query($sql);
		$query->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
		$query->execute();
		$comm_results = $query->fetchAll(PDO::PARAM_ASSOC);
		
		# Put new data into cache
		$cache->setCache($comm_results, '+1 day', true);
	}
	else {
		# Cache data exists. Fetch it
		$comm_results = $cache->getCache();
	}
	
	
	foreach ($results as $col => $v) {
		
	}
	
	# Require style file
	require(ABSPATH . TEMPLATES_PATH . $USER->style . '/viewarticle.php');
	
?>