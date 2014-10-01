<?php
error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR);
$servername='localhost';

if($_SERVER['HTTP_HOST'] == 'localhost'){
	$dbusername='root';
	$dbpassword='';
	$dbname='handcrafted_pens_new';
}
else{
	$dbusername='kevshand_root';
	$dbpassword='bel1978!';
	$dbname='kevshand_handcrafted_pens';

	/*if (substr($_SERVER['HTTP_HOST'], 0, 4) == 'www.') {

		header('Location: http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 's':'').'://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

		exit;

	}*/
}

//Include common files
require_once(ROOT_DIR."/include/common.php"); // page protect function here
require_once(ROOT_DIR."/include/message.php"); // page protect function here
connecttodb($servername,$dbname,$dbusername,$dbpassword);
require_once(ROOT_DIR."/include/functions.php"); // page protect function here

?>