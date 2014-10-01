<?php
require_once("../init.php");
require_once("../config_db.php");
require_once("include/protecteed.php");

$tabl = 'content';
$item = 'Terms & Condition';
$page_parent = 'edit_terms.php';
$query_string = array("search" => $_GET['search'], "page" => $_GET['page'], "rel_id" => $_GET['rel_id'], "do" => $_GET['do'], "id" => $_GET['id']);
foreach($query_string as $k=>$v){
	$q_string .= "&$k=$v";
}

$id = mysql_real_escape_string($_GET['id']);
$relation = mysql_real_escape_string($_GET['relation']);


if($_GET['do'] == 'edit'){
	$sql = "SELECT * from $tabl where id='$id'";
	$exec = mysql_query($sql) or die(mysql_error());
	$fetch = mysql_fetch_assoc($exec);
	$dvar['name'] = $fetch['name'];
	$dvar['description'] = $fetch['description'];
}
if($_POST['submitbut'] == 'Save'){
	$dvar['name'] = $_POST['name'];
	$dvar['description'] = $_POST['description'];

	if($dvar['name'] == ''){$flag[1] = 'r';}
	else if($dvar['description'] == ''){$flag[5] = 'r';}
	if(!empty($flag)){
		$flag_r = 'r';
	}
	else{
		if($_GET['do'] == 'edit'){
			$add_dvar = array('time' => time(), 'status' => '1');
//			$remove_dvar = array('status');
//			$change_dvar = array('status' => '0');
			
			$sql = "UPDATE $tabl SET ".update_query($dvar, $add_dvar, $remove_dvar, $change_dvar)." where id='$id'";

			$fg = 'ed';
		}
		else{
			$add_dvar = array('time' => time(), 'status' => '1');
//			$remove_dvar = array('status');
//			$change_dvar = array('status' => '1');

			list($insert_q[0], $insert_q[1]) = insert_query($dvar, $add_dvar, $remove_dvar, $change_dvar);
			
			$sql = "INSERT into $tabl(sort, $insert_q[0]) SELECT max(sort)+1, $insert_q[1] from $tabl";
			$fg = 'ad';
		}
		if(mysql_query($sql)){
			$flag[$fg] = $item;
		}
		else{
			$flag['q'] = 'r';
		}
	}
}

if($_GET['do'] == 'edit' && ($flag['g'] <> '')){
	$sql = "SELECT * from $tabl where id='$id'";
	$exec = mysql_query($sql) or die(mysql_error());
	$fetch = mysql_fetch_assoc($exec);
	$dvar['name'] = $fetch['name'];
	$dvar['description'] = $fetch['description'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add/Edit <?php echo $item; ?></title>
<?php include("include/head.php"); ?>

<?php
if($flag[$fg] <> ''){
?>
<meta http-equiv="refresh" content="3; URL=<?php echo $page_parent."?1=1".$q_string; ?>">
<?php } ?>
</head>

<body>
<div align="center">
  <div class="container">
	<?php
    $pg_active['con'] = 'active';
    require_once('include/header.php'); 
    ?>
    <div class="content">
      <div style="margin-top:10px">
      <?php
        echo print_messages($flag, $error_message, $success_message);
		?>
      </div>
      <div class="form5">
        <form id="add" name="add" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?1=1<?php echo $q_string; ?>" enctype="multipart/form-data">
            <table width="950" border="0" cellpadding="5">
              <tr>                
                <td align="right" class="label_form"> </td>
                <td><u><?php echo $item; ?></u><br class="clear" /></td>
              </tr>
              <tr>
                <td align="right" class="label_form" valign="top">Name: </td>
                <td><input name="name" type="text" class="input_text" value="<?php echo $dvar['name'];?>" /><br class="clear" /></td>
              </tr>

              <tr>
                <td align="right" class="label_form" valign="top">Description: </td>
                <td><textarea name="description" class="ckeditor"><?php echo $dvar['description'];?></textarea></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>
                    <div class="btn">
                        <input class="button" name="submitbut" value="Save" type="submit" />
                        <a class="a_button" href="<?php echo $page_parent."?1=1".$q_string; ?>">Cancel</a>
                    </div>
                </td>
              </tr>
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
