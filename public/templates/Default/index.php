<?php
	
	/**
	 * Displays the output of the site index
	 * Last Edited: 02-01-2012 22:17:21 -00:00 (2 January 2012)
	 *
	 * @author		Wader
	 * @copyright	(c) 2011 Wade Urry
	 * @license http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
	 */
	
	# Check script isnt being accessed directly
	if (!defined('IN_CMS')) {
		print "<h1>Incorrect access</h1>You cannot access this file directly.";
		exit();
	}
	
	require(ABSPATH . TEMPLATES_PATH . 'Default/resources/head.php');
		
?>
		<div id="content-wrap">
			<div id="main">
				<a name="content"></a>
                <?php
					foreach ($articles as $article => $param) {
						$link = $param['LINK'];
						$summary = $param['SUMMARY'];
						$title = $param['TITLE'];
						$author_url = $param['AUTHOR_URL'];
						$author = $param['AUTHOR'];
						$content = $param['CONTENT'];
						$num_comments = $param['NUM_COMMENTS'];
						$timestamp = $param['TIME'];
						
						print <<<ARTICLE
							<h2><a href="$link" rel="$summary">$title</a></h2>
							<p class="post-info">Posted by <a href="$author_url" title="View Profile: $author">$author</a></p>
							<p>$content</p>
							<p class="post-footer"><a href="$link#content" title="Read more" class="readmore">Read more</a> | <a href="$link#comments" title="View comments" class="comments">Comments ($num_comments)</a> | <span title="Posted on $timestamp" class="date">$timestamp</span></p>
ARTICLE;
					}
				?>
			</div>
            <?php require(ABSPATH . TEMPLATES_PATH . 'Default/resources/sidebar.php'); ?>
			<div class="clearer"></div>
		</div>
        <?php require(ABSPATH . TEMPLATES_PATH . 'Default/resources/footer.php'); ?>
	</div>
</body>
</html>
<?php print $CMS::$num_querys; ?>