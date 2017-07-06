<?php
// Require the i18n Class
require 'src/i18n.class.php';

// Defining the language
// For the example, we change the language using a GET parameter
$langList = array('en', 'fr');
if(isset($_GET['lang']) && in_array($_GET['lang'], $langList))
    $lang = $_GET['lang'];
else 
    $lang = 'en';

// Define some varialbles we'll be using in the getPlural method example
$nbUsers = 666;
$nbAdmins = 1;

// $l : New i18n object for the Layout Translation
// $u : New i18n object for the User List page Translation
$l = new i18n($lang, "layout/get");
//echo '<pre>';print_r($l);echo'</pre>';

$u = new i18n($lang, "user/getList");
//echo '<pre>';print_r($u);echo'</pre>';
?>

<html>
	<head>
		<title><?= $u->ph('title') ?></title>
	</head>	
	<body>
		<h1><?= $l->ph('welcomemsg') ?></h1>
		<ul>
			<li><?= $l->ph('menu.home') ?></li>
			<li><?= $l->ph('menu.users') ?></li>
		</ul>
		
		<hr>
		
		<h2><?= $u->ph('title') ?></h2>		
		<p><?= $u->pl('totalusers', $nbUsers) ?></p>
		<p><?= $u->pl('totaladmins', $nbAdmins) ?></p>
		
		<hr>
		
		<footer>
			<ul>
				<li><?= $l->ph('footer.contact') ?></li>
				<li><?= $l->ph('footer.privacypolicy') ?></li>
				<li><?= $l->ph('footer.backtotop') ?></li>
				<li>
					<a href="index.php?lang=fr">Français</a> - <a href="index.php?lang=en">English</a>
				</li>
			</ul>
		</footer>
	</body>
</html>
