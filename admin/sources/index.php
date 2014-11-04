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
	
	$cache = new FileCache(array('key' => 'homepage-articles'));
	
	if (!$cache->getCache()) {
		# No cache data or it expired. Get new data from db
		$sql = "SELECT *, UNIX_TIMESTAMP(`timestamp`) AS `timestamp` FROM `" . TB_PREFIX . "articles` ORDER BY :order LIMIT :limit";
		$query = $CMS->prepare_query($sql);
		$query->bindValue(':order', '`timestamp` DESC', PDO::PARAM_STR);
		$query->bindValue(':limit', 5, PDO::PARAM_INT);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		
		# Put new data into cache
		$cache->setCache($results, '+15 mins', true);
	}
	else {
		# Cache data. Fetch it
		$results = $cache->getCache();
	}
	
	unset($cache);
	
	$articles = array();
	foreach ($results as $id => $v) {
		
		if ($USER->access >= $v['access_level']) {
			# Create article link
			$v['link'] = URL . '/blog/' . $v['id'] . '-' . $v['slug'];
			
			# Convert UNIX_TIMESTAMP() to human readable
			$v['timestamp'] = date("d M Y H:i:s", $v['timestamp']);
			
			# Get author details
			$cache = new FileCache(array('key' => 'author-' . $v['author']));
			if (!$cache->getCache()) {
				# No cache data or it expired. Get new data from db
				$sql = "SELECT `ID`,`username` FROM `" . TB_PREFIX . "users` WHERE `ID` = :id";
				$auth_query = $CMS->prepare_query($sql);
				$auth_query->bindValue(':id', $v['author'], PDO::PARAM_INT);
				$auth_query->execute();
				$auth_results = $auth_query->fetch(PDO::FETCH_ASSOC);
				# Put new data into cache
				$cache->setCache($auth_results, '+15 mins', true);
			}
			else {
				# Cache data. Fetch it
				$auth_results = $cache->getCache();
			}
			
			unset($cache);
			
			# Create author link
			$v['author_link'] = URL . '/user/' . $auth_results['ID'] . '-' . $auth_results['username'];
			$v['author_name'] = $auth_results['username'];
			
			# Get post comments
			$sql = "SELECT COUNT(*) FROM `" . TB_PREFIX . "comments` WHERE `article_id` = :id";
			$comm_query = $CMS->prepare_query($sql);
			$comm_query->bindValue(':id', $v['id'], PDO::PARAM_INT);
			$comm_query->execute();
			
			$articles[] = array(
				'ID'			=>	$v['id'],
				'LINK'			=>	$v['link'],
				'TIME'			=>	$v['timestamp'],
				'TITLE'			=>	$v['title'],
				'SUMMARY'		=>	$v['summary'],
				'CONTENT'		=>	nl2br($v['content']),
				'AUTHOR'		=>	$v['author_name'],
				'AUTHOR_URL'	=>	$v['author_link'],
				'NUM_COMMENTS'	=>	$comm_query->fetchColumn()
			);
		}
	}
	
	# Free resources. Also for security so no extra querys can be executed
	unset($query, $auth_query, $comm_query);
	
	# Require style file
	require(ABSPATH . TEMPLATES_PATH . $USER->style . '/index.php');
	
?>