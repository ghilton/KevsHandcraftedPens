<?php
include "../init.php";// database connection details stored here
include "../config_db.php";// database connection details stored here
include "include/protecteed.php";// page protect function here
$tabl = 'place_order';

// Config. for pagination //
$page = $_GET['page'];				// get variable for page
$perpage = '50';						// Show per page
$base_tabl = $tabl;				// table name for query
$item = 'Order';				// table name for query
$namep = "manage_order.php";					// Page name
//Get stcom value
$query_string = array("search" => "$search_txt");
foreach($query_string as $k=>$v){
	$q_string .= "&$k=$v";
}
$q_string_pg = $q_string."&page=$page";		// value inside pages
$stcom = stcom($page, $perpage);

// Select Query part for every query related to this page
$select = "* ";
$from = "  $base_tabl where status <> 0 ";

if($_GET['search'] == '' || $_GET['search'] == 'search'){
	// Make query to select records
	$sql1 = "SELECT $select from $from";	// SQL query to select rows.
}
else{
	$search_txt = $search_init = $_GET['search'];
	if($search_txt == "Complete" || $search_txt == "complete"){$search_txt = '2';}
	else if($search_txt == "Incomplete" || $search_txt == "incomplete"){$search_txt = '1';}
	 $sql1 = "SELECT $select from $from AND (first_name like '%$search_txt%' OR last_name like '%$search_txt%' OR id like '%$search_txt%'  OR status like '%$search_txt%')";
	$search_txt = $search_init = $_GET['search'];
}
if($_POST['Delete'] == 'Delete Selected'){
	@$chk = $_POST['chk'];
	$i='0';
	if( is_array($chk)){
		while (list ($key, $val) = each ($chk)) {
			if($val <> ''){
				$chk_arr[$i] = $val;
			}
			$i++;
		}
	}
	$arr_num = count($chk_arr);
	if($arr_num > 0){
		$sql_s = "SELECT image from $base_tabl where id in (";
		$sql = "DELETE from $base_tabl where id in (";
		$j = 0;
		while($j<$arr_num){
			if($j<>0){$sql_sub = $sql_sub.",";}
			$sql_sub = $sql_sub."$chk_arr[$j]";
			$j++;
		}
		$sql = $sql.$sql_sub.')';
		$sql_s = $sql_s.$sql_sub.')';
		//delete images/files
		$exec_s = mysql_query($sql_s);
		while($fetch_s = mysql_fetch_assoc($exec_s)){
			unlink('../pics/'.$fetch_s[image]);
			unlink('../thumb/'.$fetch_s[image]);
		}
		if(mysql_query($sql) or die(mysql_error())){$flagp = 'green';}
		else{$flag_q = 'r';}
	}
	else{$flag_r = 'r';}
}

//If Delete button is pressed for one row

if($_GET['do'] == 'delete' && ctype_digit($_GET['id'])){
	$id = $_GET['id'];
	$sql = "SELECT image from $base_tabl where id='$id'";
	$exec = mysql_query($sql);
	list($image) = mysql_fetch_row($exec);
	
	unlink('../pics/'.$image);
	unlink('../thumb/'.$image);
	
	$sql = "DELETE from $base_tabl where id='$id'"; 
	mysql_query($sql);
	$flagp = 'green';
}


if($_GET['do'] == 'enable'){
	$id = $_GET['id'];
	$sql = "UPDATE $tabl SET status='2' where id = '$id'";
	mysql_query($sql) or die(mysql_error());
}

if($_GET['do'] == 'disable'){
	$id = $_GET['id'];
	$sql = "UPDATE $tabl SET status='1' where id = '$id' ";
	mysql_query($sql) or die(mysql_error());
}

$sqlq = $sql1;
$sql2 = $sql1." ORDER BY time DESC LIMIT $stcom , $perpage"; //echo $sql2;
// pagination file include
include "include/pagination.php";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage<?php echo $item; ?></title>
<?php include("include/head.php"); ?>
<script type="text/javascript">
		function reload_win(){
			location.reload();
		}
		$(document).ready(function() {
			$("#mainchbx").click(function() {
				var checked_status = this.checked;
				var checkbox_name = this.name;
				$("input[name=" + checkbox_name + "[]]").each(function() {
					this.checked = checked_status;
				});
			});
			$("input[name='chk[]']").click(function() {
				$("#mainchbx").attr('checked', false);
			});
			setTimeout(function() {
				$('.success').fadeOut('fast');
			}, 3000);
			setTimeout(function() {
				$('.error').fadeOut('fast');
			}, 3000);
		});
		function del_fun(){
			if(confirm("Are you sure you want to delete this <?php echo $item; ?>?")){
				return true;
			}
			else{
				return false;
			}
		}

		function dis_fun(){
			if(confirm("Are you sure you want to Disable this <?php echo $item; ?>?")){
				return true;
			}
			else{
				return false;
			}
		}

		function enb_fun(){
			if(confirm("Are you sure you want to Enable this <?php echo $item; ?>?")){
				return true;
			}
			else{
				return false;
			}
		}
</script>
</head>
<body>
<div align="center">
  <div class="container">
    <?php $pg_active['order'] = 'active'; require_once('include/header.php'); ?>
    <div class="content">
      <div style="margin-top: 20px;">
        <?php
              if($flagp == 'green'){
        ?>
        <div class="success">Success: <?php echo $item; ?> Deleted Successfully.</div>
        <?php }	else if($flagg == 'g'){ 	?>
        <div class="success">Success: <?php echo $item; ?> Deleted Successfully.</div>
        <?php } else if($flagr == 'r'){ ?>
        <div class="error">Error: No <?php echo $item; ?> selected</div>
        <?php }	else if($flag_r == 'r'){   ?>
        <div class="error">Error: No <?php echo $item; ?> selected</div>
        <?php }  // else if($flag[9] == 'r'){ ?>
        <!--        	<div class="error">Error: Only 4 Advertisements can be displayed. Please uncheck already shown advertisement to make room for new one.</div>
-->
        <?php //	} ?>
      </div>
      <div class="down_category" style="margin-top:30px">
        <div class="head"> <span class="head_text"><?php echo $item; ?></span> 
          <!-- <div class="add"> <a href="add_edit_<?php echo strtolower($item); ?>.php"> <span class="add1"> <span class="head_text1"> <?php echo $item; ?></span> </span> </a> </div>-->
          <div class="resetallpage"><a href="<?php echo $namep; ?>">Reset</a></div>
          <div class="search">
            <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
              <input type="text" name="search" value="<?php if($search_txt ==''){$search_txt = 'search';}  echo $search_txt; ?>" onfocus="if(this.value=='search'){this.value=''}" onblur="if(this.value==''){this.value='search'}"/>
              <input type="submit" value="Search" name="Submitbut" class="side_search"  />
            </form>
          </div>
        </div>
        <br/>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>?order=<?php echo $order.'&field='.$field.'&search='.$search_txt; ?>" method="post" name="<?php echo $item; ?>">
          <input name="done" type="hidden" value="send" />
          <table width="100%"  cellspacing="0" cellpadding="8px"  class="maintbl" >
            <tr class="fstrow"  >
              <td width="5%"> &nbsp;<!--<input class="check" type="checkbox" id="mainchbx" name="chk" />--></td>
              <td align="left" width="19%"> Order No. </td>
              <td align="left" width="19%"> Order Date </td>
              <td align="left" width="29%"> Name </td>
              <!--<td align="left" width="12%">
          	Company Name
          </td>-->
              <td align="center" width="5%"> Order Status </td>
              <td align="center" width="30%"> Actions </td>
            </tr>
            <?php
                $exec = mysql_query($sql2) or die(mysql_error());
				if(mysql_num_rows($exec) == 0){
					echo '<tr><td colspan="6" align="center"><div style="margin-top:10px;">No Result Found</div></td></tr>';
				}
                $z = 0;
                while($fetch = mysql_fetch_assoc($exec)){
            ?>
            <tr class="scndrow <?php echo $z%2 ? '' : 'alternate';?>">
              <div class="blue2">
                <td>&nbsp;<!--<input type='checkbox' name='chk[]' value='<?php echo $fetch[id] ?>' id='checkme<?php echo $z; ?>' />--></td >
                <td align="left" style="padding-left:2px"><div class="n_1"><?php echo $fetch[id]; ?></div></td>
                <td align="left" style="padding-left:2px"><div class="n_1"><?php echo date("j M Y", $fetch['time']); ?></div></td>
                <td align="left" style="padding-left:2px"><div class="n_1"><?php echo ucwords($fetch['first_name'].' '.$fetch['last_name']); ?></div></td>
                <!-- <td align="left" style="padding-left:2px">
                <div class="n_1"><?php //echo $fetch['last_name']; ?></div>
                </td>-->
                <td align="center"><div class="n3" style="padding-left:18px;">
                   <?php if($fetch['status'] == 1){ echo 'New Order';}
					  else if($fetch['status'] == 2){ echo 'Under Progress';}
					  else if($fetch['status'] == 3){ echo 'On Hold'; }
					  else if($fetch['status'] == 4){ echo 'Complete'; }
		     	 ?>
                  </div></td>
                <td align="left"><!--<div  style="margin-left:10px; float:left;  margin-top:7px; " class="managetipsdiv"><div class="view"> <a href="add_edit_<?php echo strtolower($item); ?>.php?type=submenu&do=edit&id=<?php echo $fetch[id].'&rel='.$fetch[id]; ?>" title="Edit"> <img src="images/edit.png" /> </a> </div></div>-->
                  
                  <div align="center" style=" float:left; margin-top:7px;" class="managetipsdiv">
                    <div class="view"> <a href="view_<?php echo strtolower($item); ?>.php?id=<?php echo $fetch[id]; ?>" title="View"> <img src="images/view.png" /> </a> </div>
                  </div>
                  <div style="margin-left:3px; float:left; margin-top:7px; " class="managetipsdiv">
                    <!--<div class="view"> <a href="<?php echo $_SERVER['PHP_SELF'].'?do=delete&id='.$fetch[id]; ?>" title="Delete" onclick="return del_fun();"> <img src="images/delete.png" /> </a> </div>-->
                  </div></td>
              </div>
            </tr>
            <?php $z++; } ?>
          </table>
          <!--<div class="slideshowdelend">
            <input onclick="return del_fun();" type="submit" name="Delete" value="Delete Selected" class="formbutton" />
          </div>-->
        </form>
      </div>
      <?php require("include/pagination_show.php"); ?>
    </div>
    <div class="clear"></div>
  </div>
</div>
</body>
</html>
