<?php
require_once("../init.php");
require_once("../config_db.php");
require_once("include/protecteed.php");

$tabl = 'cart';
$item = 'Product';
$page_parent = 'view_order.php';
$query_string = array("search" => $_GET['search'], "page" => $_GET['page'], "cart_id" => $_GET['cart_id'], "do" => $_GET['do'], "id" => $_GET['id']);
foreach($query_string as $k=>$v){
	$q_string .= "&$k=$v";
}

$id = mysql_real_escape_string($_GET['id']);
$cart_id = mysql_real_escape_string($_GET['cart_id']);
$relation = mysql_real_escape_string($_GET['relation']);


if($_GET['do'] == 'edit'){
	$sql = "SELECT * from $tabl where id='".$cart_id."'";
	$exec = mysql_query($sql) or die(mysql_error());
	$fetch = mysql_fetch_assoc($exec);
	$dvar['Special_instructions'] = $fetch['Special_instructions'];
	$dvar['Front_message'] = $fetch['Front_message'];
	$dvar['Back_message'] = $fetch['Back_message'];
	$uniq = $fetch[uniq];
}

if($_POST['submitbut'] == 'Save'){
	$dvar['Special_instructions'] = $_POST['Special_instructions'];
	$dvar['Front_message'] = $_POST['Front_message'];
	$dvar['Back_message'] = $_POST['Back_message'];
	 
	$dvar['image_delete'] = $_POST['image_delete'];
	$image = $fetch['image'];

	/*if($dvar['name'] == ''){$flag[1] = 'r';}
	else if(!is_numeric($dvar['price'])){$flag[151] = 'r';}
//	else if($dvar['color_name'] == ''){$flag[156] = 'r';}
	else if($dvar['description'] == ''){$flag[3] = 'r';}*/
	

	if(!empty($flag)){
		$flag_r = 'r';
	}
	else{
		if($_GET['do'] == 'edit'){
			$sql_s = "select * from $tabl where id='".$id."'";
			$exec_s = mysql_query($sql_s);
			$fetch_s = mysql_fetch_assoc($exec_s);

			$add_dvar = array('time' => time());
			$remove_dvar = array('image_delete');
//			$change_dvar = array('status' => '0');
			
			$sql = "UPDATE $tabl SET ".update_query($dvar, $add_dvar, $remove_dvar, $change_dvar)." where id='".$cart_id."'";

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
		}
		else{
			$flag['q'] = 'r';
		}
	}
}

if($_GET['do'] == 'edit' && ($flag[$fg] <> '')){
	$sql = "SELECT * from $tabl where id='".$cart_id."'";
	$exec = mysql_query($sql) or die(mysql_error());
	$fetch = mysql_fetch_assoc($exec);
	$dvar['Front_message'] = $fetch['Front_message'];
	$dvar['Special_instructions'] = $fetch['Special_instructions'];
	$dvar['Back_message'] = $fetch['Back_message'];
	$uniq = $fetch[uniq];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add/Edit <?php echo $item; ?></title>
<?php include("include/head.php"); ?>
<!--For choose font dropdown code start here-->
<link rel="stylesheet" href="../css/font_dropdown.css">
	<script type='text/javascript'><!--
			$(document).ready(function() {
				enableSelectBoxes();
			});
			
			function enableSelectBoxes(){
				$('div.selectBox').each(function(){
					$(this).children('span.selected').html($(this).children('div.selectOptions').children('span.selectOption:first').html());
					$(this).attr('value',$(this).children('div.selectOptions').children('span.selectOption:first').attr('value'));
					
					$(this).children('span.selected,span.selectArrow').click(function(){
						if($(this).parent().children('div.selectOptions').css('display') == 'none'){
							$(this).parent().children('div.selectOptions').css('display','block');
						}
						else
						{
							$(this).parent().children('div.selectOptions').css('display','none');
						}
					});
					
					$(this).find('span.selectOption').click(function(){
						$(this).parent().css('display','none');
						$(this).closest('div.selectBox').attr('value',$(this).attr('value'));
						$(this).parent().siblings('span.selected').html($(this).html());
						$('#font-type').attr('value',$(this).attr('value')).trigger('change');
						setTimeout(function () { $("#tpf p").bigText();}, 4000);
						setTimeout(function () { $("#tpb p").bigText(); }, 4000);

					});
				});				
			}//-->
		</script>
<!--For choose font dropdown code end here--><div class="header2">

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
	<?php $pg_active['pdt'] = 'active'; require_once('include/header.php'); ?>
    <div class="content">
      <div style="margin-top:10px">
      <?php echo print_messages($flag, $error_message, $success_message); ?>
      </div>
      <div class="form5">
        <form id="add" name="add" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?1=1<?php echo $q_string; ?>" enctype="multipart/form-data">
            <table width="1150" border="0" cellpadding="5">
            <tr>                
              <td align="right" class="label_form">Front Message: </td>
              <td><input name="Front_message" type="text" class="input_text" value="<?php echo $dvar['Front_message'];?>"/><br class="clear" /></td>
            </tr>
            <tr>                
                  <td align="right" class="label_form">Back Message: </td>
                  <td><input name="Back_message" type="text" class="input_text" value="<?php echo $dvar['Back_message'];?>"/><br class="clear" /></td>
              </tr>
              <tr>                
                    <td valign="top" align="right" class="label_form">Special Instructions: </td>
                    <td style="width:860px;" class="txt1input"><textarea name="Special_instructions" style="height:100px; width:380px; margin-top:0px;"><?php echo $dvar['Special_instructions'];?></textarea>
                    </td>
              </tr>
               <!--<tr>                
                    <td valign="top" align="right" style="padding-top:25px" class="label_form">Choose A Font: </td>
                    <td style="width:860px;"  class="txt1input"><div class='selectBox'>
                        <span class='selected'></span>
                        <span class='selectArrow'>&#9660</span>
                        <div class="selectOptions" >
                            <span class="selectOption" value="" style="margin-top:21px;"><img src="../font_images/select-font1.png"  /></span>
                            <span class="selectOption" value="Aclonica"><img src="../font_images/f1.png" /></span>
                            <span class="selectOption" value="Aguafina Script"><img src="../font_images/f2.png" /></span>
                            <span class="selectOption" value="Aladin"><img src="../font_images/f3.png" /></span>
                            <span class="selectOption" value="Anton"><img src="../font_images/f23.png" /></span>
                            <span class="selectOption" value="Archivo"><img src="../font_images/f18.png" /></span>
                            <span class="selectOption" value="Alfa Slab One"><img src="../font_images/f4.png" /></span>
                            <span class="selectOption" value="Arizonia"><img src="../font_images/f5.png" /></span>
                            <span class="selectOption" value="Bangers"><img src="../font_images/f6.png" /></span>
                            <span class="selectOption" value="Black Ops One"><img src="../font_images/f7.png" /></span>
                            <span class="selectOption" value="Boogaloo"><img src="../font_images/f20.png" /></span>
                            <span class="selectOption" value="Butcherman"><img src="../font_images/f8.png" /></span>
                            <span class="selectOption" value="Cabin"><img src="../font_images/f21.png" /></span>
                            <span class="selectOption" value="Caesar Dressing"><img src="../font_images/f9.png" /></span>
                            <span class="selectOption" value="Candal"><img src="../font_images/f10.png" /></span>
                            <span class="selectOption" value="Carter One"><img src="../font_images/f11.png" /></span>
                            <span class="selectOption" value="Ceviche One"><img src="../font_images/f12.png" /></span>
                            <span class="selectOption" value="Chewy"><img src="../font_images/f22.png" /></span>
                            <span class="selectOption" value="Francois One"><img src="../font_images/f24.png" /></span>
                            <span class="selectOption" value="Galindo"><img src="../font_images/f25.png" /></span>
                            <span class="selectOption" value="Gochi Hand"><img src="../font_images/f19.png" /></span>
                            <span class="selectOption" value="Graduate"><img src="../font_images/f26.png" /></span>
                            <span class="selectOption" value="Hanalei Fill"><img src="../font_images/f13.png" /></span>
                            <span class="selectOption" value="Lily Script One"><img src="../font_images/f14.png" /></span>
                            <span class="selectOption" value="Lobster"><img src="../font_images/f27.png" /></span>
                            <span class="selectOption" value="Maven Pro"><img src="../font_images/f28.png" /></span>
                            <span class="selectOption" value="Oleo Script"><img src="../font_images/f29.png" /></span>
                            <span class="selectOption" value="Passion One"><img src="../font_images/f30.png" /></span>
                            <span class="selectOption" value="Permanent Marker"><img src="../font_images/f31.png" /></span>
                            <span class="selectOption" value="Poller One"><img src="../font_images/f33.png" /></span>
                            <span class="selectOption" value="Press Start 2P"><img src="../font_images/f15.png" /></span>
                            <span class="selectOption" value="Racing Sans"><img src="../font_images/f34.png" /></span>
                            <span class="selectOption" value="Rammentto"><img src="../font_images/f35.png" /></span>
                            <span class="selectOption" value="Sansitia"><img src="../font_images/f36.png" /></span>
                            <span class="selectOption" value="Sqada"><img src="../font_images/f37.png" /></span>
                            <span class="selectOption" value="Squada One"><img src="../font_images/f16.png" /></span>
                        </div>
                    </div>
                    </td>
              </tr>-->
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
      <?php // include "include/footerlogo.php"; ?>
    </div>
    <div class="clear"></div>
  </div>
</div>
</body>
</html>
