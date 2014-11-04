<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>iWader</title>
		<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
		<link rel="stylesheet" href="/static/style.css" type="text/css" media="all" />
	</head>

<body>
	<div id="wrap">
    	<a name="top"></a>
		<div id="header">
			<h1 id="logo-text">
				<a href="#">iWader</a>
			</h1>
			<p id="slogan">Insert Slogan Here</p>
			<form id="quick-search" action="#" method="get">
				<p>
					<label for="query">Search:</label>
					<input class="tbox" id="query" type="text" name="query" value="Search..." onclick="this.value='';" onblur="this.value='Search...';" title="Start typing what you want to search for" />
					<input class="btn" alt="Search" type="image" name="searchsubmit" title="Search" src="/static/img/search.png" />
				</p>
			</form>
		</div>
<?php require(ABSPATH . TEMPLATES_PATH . 'Default/resources/nav.php'); ?>