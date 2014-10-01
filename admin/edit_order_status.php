<?php
require_once("../init.php");
require_once("../config_db.php");
require_once("include/protecteed.php");

$tabl = 'place_order';
$item = 'Order Status';
$page_parent = 'view_order.php';
$query_string = array("search" => $_GET['search'], "page" => $_GET['page'], "uniq_id" => $_GET['uniq_id'], "do" => $_GET['do'], "id" => $_GET['id']);
foreach($query_string as $k=>$v){
	$q_string .= "&$k=$v";
}

$id = mysql_real_escape_string($_GET['id']);
$relation = mysql_real_escape_string($_GET['uniq_id']);

if($_GET['go'] == 'delete'){ 
	$msg_id = mysql_real_escape_string($_GET['msg_id']);
	 $sql = "Delete from order_status_msg where id='".$msg_id."'";
	$exec = mysql_query($sql) or die(mysql_error());
	if($exec){
		header("location: edit_order_status.php?1=1$q_string");
	}
}

if($_GET['do'] == 'edit'){
	$sql = "SELECT * from $tabl where id='".$id."'";
	$exec = mysql_query($sql) or die(mysql_error());
	$fetch = mysql_fetch_assoc($exec);
	$dvar['status'] = $fetch['status'];
	$uniq = $fetch[uniq];
}

if($_POST['submitbut'] == 'Save'){
	@$description = $_POST['description']; //print_r($color_name);
	$dvar['status'] = $_POST['status'];
	 
	if(!empty($flag)){
		$flag_r = 'r';
	}
	else{
		if($_GET['do'] == 'edit'){
			$add_dvar = array( 'time' => time());
//			$remove_dvar = array('image_delete');
//			$change_dvar = array('status' => '0');
			
			$sql = "UPDATE $tabl SET ".update_query($dvar, $add_dvar, $remove_dvar, $change_dvar)." where id='".$id."'";

			$fg = 'ed';
		}
		else{
			$uniq = random_generator(10);
			$add_dvar = array('time' => time());
			$remove_dvar = array('image_delete');
//			$change_dvar = array('status' => '1');

			list($insert_q[0], $insert_q[1]) = insert_query($dvar, $add_dvar, $remove_dvar, $change_dvar);
			
		 	$sql = "INSERT into $tabl(sort, $insert_q[0]) SELECT max(sort)+1, $insert_q[1] from $tabl";
			$fg = 'ad';
		}
		if(mysql_query($sql)){
			$flag[$fg] = $item;
			$sql_del = "delete from order_status_msg where relation='".$id."' AND rel_uniq_id='".$relation."'";
			mysql_query($sql_del);
			if(is_array($description)){
				foreach($description as $k => $v){$db_v = mysql_real_escape_string($v);
				if($db_v <> ''){
				 $sql_ins = "insert into order_status_msg(relation, rel_uniq_id, description, time) values('".$id."', '".$relation."', '".$db_v."', '".time()."')";
				 mysql_query($sql_ins);
				}
				}
			}
		}
		else{
			$flag['q'] = 'r';
		}
	}
}

if($_GET['do'] == 'edit' && ($flag[$fg] <> '')){
	$sql = "SELECT * from $tabl where id='$id'";
	$exec = mysql_query($sql) or die(mysql_error());
	$fetch = mysql_fetch_assoc($exec);
	$dvar['status'] = $fetch['status'];
	$uniq = $fetch[uniq];
}

$sql_up = "select * from order_status_msg where relation='".$id."' AND rel_uniq_id='".$relation."' order by time DESC";
$exec_up = mysql_query($sql_up);
$num = mysql_num_rows($exec_up);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add/Edit <?php echo $item; ?></title>
<?php include("include/head.php"); ?>
<script type="text/javascript">
	var i;
	$(document).ready(function(){
		$('#tb_clone_click').click(function(){
			$("#table-data tr:first").clone().find("input").each(function() {
				$(this).val('').attr('id', function(_, id) { return id + i });
			}).end().appendTo("#table-data");
		var rowCount = document.getElementById('table-data').rows.length; 
		});
	});
	
</script>
<?php if($flag[$fg] <> ''){ ?>
<meta http-equiv="refresh" content="3; URL=<?php echo $page_parent."?1=1".$q_string; ?>">
<?php } ?>
</head>

<body>
<div align="center">
  <div class="container">
	<?php $pg_active['order'] = 'active'; require_once('include/header.php'); ?>
    <div class="content">
      <div style="margin-top:10px">
      <?php echo print_messages($flag, $error_message, $success_message); ?>
      </div>
      <div class="form5">
        <form id="add" name="add" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?1=1<?php echo $q_string; ?>" enctype="multipart/form-data">
            <table width="1150" border="0" cellpadding="5" id="">
               <tr>                
                  <td align="right" style="width:<?php if($num == 0){ echo '93px'; } else{ echo '136px'; } ?>" class="label_form">Order Status: </td>
                  <td style="width:390px"><select name="status" style="height:30px; width:300px">
                        <option value="1" <?php if($dvar['status'] == '1'){ echo 'selected="selected"'; } ?> >New Order</option>
                        <option value="2" <?php if($dvar['status'] == '2'){ echo 'selected="selected"'; } ?> >Under Progress</option>
                        <option value="3" <?php if($dvar['status'] == '3'){ echo 'selected="selected"'; } ?> >On Hold</option>
                        <option value="4" <?php if($dvar['status'] == '4'){ echo 'selected="selected"'; } ?> >Complete</option>
                  </select><br class="clear" /></td>
              </tr>
            <?php /*} else{*/ while($fetch_up = mysql_fetch_assoc($exec_up)){?>
              <tr >                
                <td align="right" valign="top"  class="label_form">Message: </td>
                <td class="txt1input"  ><textarea  name="description[]" style="height:100px; width:400px; margin-top:0px;"><?php echo $fetch_up['description'];?></textarea><a style="margin:0px 10px;" href="edit_order_status.php<?php echo '?go=delete&msg_id='.$fetch_up['id'].$q_string; ?>" title="Delete" onclick="return del_fun();"> <img src="images/delete.png" /> </a>
                </td>
              </tr>
            <?php } /*}*/ ?>
              </table>
            <table border="0" cellpadding="5" id="table-data">
            <?php /*if($num == 0){ */ ?>
              <tr class="tr_clone">                
                  <td align="right" valign="top"  class="label_form">Message: </td>
                  <td class="txt1input"  ><textarea  name="description[]" style="height:100px; width:400px; margin-top:0px;"><?php echo $dvar['description'];?></textarea>
                  </td>
              </tr>
            </table>
            <table>   
           <tr>
                <td >&nbsp;</td>
                <td>
                    <input class="button" name="button" value="Add More" type="button" id="tb_clone_click" />
                    <input class="button" name="submitbut" value="Save" type="submit" />
                    <a class="a_button" href="<?php echo $page_parent."?1=1".$q_string; ?>">Cancel</a>
                </td>
              </tr>
            </table>
        </form>
      </div>
      <?php // include "include/footerlogo.php"; ?>
    </div>
    <div class="clear"></div>
  </div>
</div>
</body>
</html>
