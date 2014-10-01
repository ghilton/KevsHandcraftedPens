<?php
session_start();
/************ CMS v3.1 *************/
/*
-There are few changes in how sessions in admin panel work. Now you need to specify session name in init for admin panel.
-check_login file name changed
*/

define('ROOT_DIR', dirname(__FILE__));
define('ADMIN_SESSION', 'admin_session');
if($_SERVER['HTTP_HOST'] == 'localhost'){
	define('ROOT_URL', 'http://localhost/khp');
}
else if($_SERVER['SERVER_NAME'] == 'kevshandcraftedpens.com' || $_SERVER['SERVER_NAME'] == 'www.kevshandcraftedpens.com'){
	define('ROOT_URL', 'http://www.kevshandcraftedpens.com');
}
$site_name = "Kev's Handcrafted Pens";
$email_def = 'admin@kevshandcraftedpens.com';
$sandbox_env = '0';
$email_merchant = 'madkev.hilton@gmail.com';

?>