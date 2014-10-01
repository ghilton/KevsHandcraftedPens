<?php
require_once("../init.php");
require_once("../config_db.php");
require_once("include/protecteed.php");

$base_tabl='admin';

if ($_POST['submitbut'] == 'Submit'){
	$dvar['password1'] = md5($_POST['password1']);
	$dvar['password2'] = $_POST['password2'];
	$dvar['password3'] = $_POST['password3'];
	$dvar['userid'] = $_POST['userid'];

	if($dvar['password1'] == ''){$flag[100] = 'r';}
	else if($dvar['password2'] == '' && $dvar['userid'] == ''){$flag[101] = 'r';}

	if($dvar['password2'] <> $dvar['password3']){
		$flag[109] = 'r';
	}
	if(!ctype_alnum($dvar['userid']) && $dvar['userid'] <> ''){
		$flag[110]= 'r';
	}

	$sql = "SELECT count(*) from $base_tabl where uniq_id='$uniq_val' AND password='".$dvar['password1']."'";
	$exec = mysql_query($sql);
	list($num) = mysql_fetch_row($exec);
	if($num == 0){
		$flag[111] = 'r';
	}

	if(!empty($flag)){
	  $flag['r'] = 'r';
	}

	else{
		if($dvar['userid'] <> '' && $dvar['password2'] <> ''){
			$dvar['password2'] = md5($dvar['password2']);
			$sql = "UPDATE $base_tabl SET userid='".$dvar['userid']."', password='".$dvar['password2']."' where uniq_id='$uniq_val'";
		}
		else if($dvar['userid'] <> '' && $dvar['password2'] == ''){
			$sql = "UPDATE $base_tabl SET userid='".$dvar['userid']."' where uniq_id='$uniq_val'";
		}
		else if($dvar['userid'] == '' && $dvar['password2'] <> ''){
			$dvar['password2'] = md5($dvar['password2']);
			$sql = "UPDATE $base_tabl SET password='".$dvar['password2']."' where uniq_id='$uniq_val'";
		}
		if(mysql_query($sql)){
			$flag['g'] = '7';
		}
		else{
			$flag['q'] = 'r';
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Update Profile</title>
<?php include("include/head.php"); ?>
</head>
<body>
<div align="center">
  <div class="container">
    <?php
    $ast = 'active';
    require_once('include/header.php'); 
    ?>
    <div class="content">
	<?php
    echo print_messages($flag, $error_message, $success_message);
    ?>
      <div class="form5">
        <form name="update" class="upload" action="<?php $_SERVER['PHP_SELF']; ?>" method='post'>
          <table border="0" cellpadding="0" cellspacing="10" align="center">
            <tbody>
              <tr>
                <td width="200" class="login1"><span class="black"><span class="red">*</span> Required Fields</span></td>
                <td colspan="2" class="logintxt"></td>
                <td></td>
              </tr>
              <tr class="blacktext">
                <td width="200" class="login1"><b>Current Password:</b></td>
                <td colspan="2" class="logintxt"><input class="field" type="password" name="password1" autocomplete="off"></td>
                <td><span class="red1">*</span></td>
              </tr>
              <tr class="blacktext">
                <td atd width="200" class="login1"><b>New UserId:</b></td>
                <td width="400" class="logintxt"><input class="field" type="text"  name="userid" autocomplete="off">
                  <br />
                  (Leave Blank, If you don't want to change userid) </td>
              </tr>
              <tr class="blacktext">
                <td td width="200" class="login1"><b>New Password:</b></td>
                <td width="400" class="logintxt"><input class="field" type=password  name="password2" autocomplete="off">
                  <br />
                  (Leave Blank, If you don't want to change Password) </td>
              </tr>
              <tr class="blacktext">
                <td td width="200" class="login1"><b>Confirm Password:</b></td>
                <td width="400" class="logintxt"><input class="field" type=password  name="password3" autocomplete="off">
                  <br />
                  (Leave Blank, If you don't want to change Password) </td>
              </tr>
              <tr>
                <td  class=" login3"><input name="submitbut" value="Submit" type="submit"  /></td>
              </tr>
            </tbody>
          </table>
        </form>
      </div>
      <?php
	  	include "include/footerlogo.php";
	  ?>
    </div>
    <div class="clear"></div>
  </div>
</div>
</body>
</html>
