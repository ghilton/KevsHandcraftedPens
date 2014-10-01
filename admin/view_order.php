<?php
include "../init.php";// include init
include "../config_db.php";// database connection details stored here
include "include/protecteed.php";// page protect function here

$id = mysql_real_escape_string($_GET['id']);

$tabl = 'place_order';
$item = 'Order Management';
$query_string = array("search" => "$search_txt");
foreach($query_string as $k=>$v){
	$q_string .= "&$k=$v";
}
$q_string_pg = $q_string."&page=$page";		// value inside pages
$stcom = stcom($page, $perpage);

if($_POST['submitbut'] == "Close"){
	header("location: manage_orders.php?1=1$q_string_pg");
}
else
{
	if($_GET['do'] == 'enable'){
		$id = $_GET['id'];
		$sql = "UPDATE $tabl SET status='2' where id = '$id'";
		mysql_query($sql) or die(mysql_error());
	}
	
	if($_GET['do'] == 'disable'){
		$id = $_GET['id'];
		$sql = "UPDATE $tabl SET status='1' where id = '$id'";
		mysql_query($sql) or die(mysql_error());
	}

	$sql = "SELECT * from $tabl where id='".$id."'";
	$exec = mysql_query($sql) or die(mysql_error());
	$fetch = mysql_fetch_assoc($exec);
	$name = $fetch['first_name'].' '.$fetch['last_name'];
	$address = $fetch['address'];
	$address1 = $fetch['address1'];
	$city = $fetch['city'];
	$state = $fetch['suburb'];
	$zip_code = $fetch['post_code'];
	$phone = $fetch['phone_no'];
	$email = $fetch['email'];
	$cart_session = $fetch['session'];
	$comment = $fetch['comment'];
	$quantity = $fetch['quantity'];
	$total_amount = $fetch['amount'];
	$status = $fetch['status'];
	
}

//for order status message
 $sql_up = "select * from order_status_msg where relation='".$fetch['id']."' AND rel_uniq_id='".$fetch['uniq']."' order by time DESC limit 0,1";
$exec_up = mysql_query($sql_up);
$num_msg = mysql_num_rows($exec_up);
$fetch_up = mysql_fetch_assoc($exec_up);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View <?php echo $item; ?></title>
<?php include("include/head.php"); ?>
<script type="text/javascript">
		function dis_fun(){
			if(confirm("Are you sure you want to mark this order as In Progress?")){
				return true;
			}
			else{
				return false;
			}
		}

		function enb_fun(){
			if(confirm("Are you sure you want to mark this order as Complete?")){
				return true;
			}
			else{
				return false;
			}
		}
</script>
<style>
.cart_font_colr {
	margin-left: 10px;
	width: 30px;
	height: 20px;
	float: left;
	border: 1px solid #017ec8;
}
</style>
<style type="text/css">
	table.bottomBorder { border-collapse:collapse; }
	table.bottomBorder td, table.bottomBorder  tr{ border-bottom:1px dotted black;padding:5px; color:#333; }
</style>
</head>
<body>
<div align="center">
  <div class="container">
    <?php $pg_active['order'] = 'active'; require_once('include/header.php');  ?>
    <div class="content">
      <div class="viewform" style="margin-top:20px;">
        <table width="414" cellpadding="5" cellspacing="0" align="left" >
          <tr>
            <td align="right"><strong>Status:</strong></td>
            <td><?php if($fetch['status'] == 1){ echo 'New Order';}
					  else if($fetch['status'] == 2){ echo 'Under Progress';}
					  else if($fetch['status'] == 3){ echo 'On Hold'; }
					  else if($fetch['status'] == 4){ echo 'Complete'; }
			 ?> <a style="margin:0px 10px;" href="edit_order_status.php?do=edit&id=<?php echo $fetch['id'];?>&uniq_id=<?php echo $fetch['uniq'].$q_string_pg; ?>" title="Edit"> <img src="images/edit.png" /> </a>
			</td>
          </tr>
         <?php if($num_msg <> 0){ ?> 
          <tr>
            <td width="120" align="right"><strong>Status Message:</strong></td>
            <td width="308"><?php echo nl2br($fetch_up['description']); ?></td>
          </tr>
          <?php } ?>
          <tr>
            <td width="120" align="right"><strong>Order Id:</strong></td>
            <td width="308"><?php echo $id; ?></td>
          </tr>
          <tr>
            <td width="120" align="right"><strong>Total Amount:</strong></td>
            <td width="308">$<?php echo $total_amount; ?></td>
          </tr>
          <tr>
            <td width="120" align="right"><strong>Address:</strong></td>
            <td width="308"><?php echo ucwords($address); ?></td>
          </tr>
          <tr>
            <td width="187" align="right"><strong>Address Line1:</strong></td>
            <td width="341"><?php echo $address1; ?></td>
          </tr>
        </table>
        <table width="550" cellpadding="5" cellspacing="0" align="right">
          <tr>
            <td align="right" valign="top"><strong>Full Name:</strong></td>
            <td><?php echo ucwords($name); ?></td>
          </tr>
          <tr>
            <td align="right"><strong>Email:</strong></td>
            <td><?php echo $email; ?></td>
          </tr>
          <tr>
            <td width="187" align="right"><strong>Suburb:</strong></td>
            <td width="341"><?php echo $state; ?></td>
          </tr>
          <tr>
            <td width="187" align="right"><strong>Post Code:</strong></td>
            <td width="341"><?php echo ucwords($zip_code); ?></td>
          </tr>
          <tr>
            <td width="187" align="right"><strong>Phone No:</strong></td>
            <td width="341"><?php echo ucwords($phone); ?></td>
          </tr>
        </table>
        <div style="clear:both;"></div>
        <table border="0" cellspacing="0" cellpadding="5" width="950" style="margin:20px auto; background-color:#DCDCDC;">
          <tbody>
            <tr>
              <th width="8%">S.No</th>
              <th width="20%" align="left">Product</th>
              <th width="35%" align="left">Image</th>
              <th width="10%">Qty.</th>
              <th width="11%">Total</th>
            </tr>
        <?php
			$sql_cart = "SELECT * from cart where session='".$cart_session."' order by id ASC
";
				$exec_cart = mysql_query($sql_cart);
				$count = mysql_num_rows($exec_cart);
				if($count == 0){
					echo '<div style="color:#f00;">No Item in cart</div>';
				}
				else{
		            echo '<table class="tbbl" width="100%" cellpadding="5">';
					
					$i=1;	$s = $q = 0;
					while($fetch_cart = mysql_fetch_assoc($exec_cart)){
						$sql_pdt = "select image, id, name  from products where id='".$fetch_cart['product']."' AND status='1'";
						$exec_pdt = mysql_query($sql_pdt);
						$fetch_pdt = mysql_fetch_assoc($exec_pdt);
				?>
        <tr class="tr1" align="center">
          <td width="8%" valign="top"><?php echo $i++;?></td>
          <td  width="20%" align="left" valign="top"><div class="suit_txt1"><span class="dish"><?php echo $fetch_pdt['name'] ?></span></div></td>
          <td width="35%" align="left"><img src="../pics/<?php echo $fetch_pdt['image'] ?>" width="88" />
          </td>
          <td width="10%"><?php echo $fetch_cart['quantity']; ?></td>
          <td width="11%">$<?php echo $fetch_cart['price'];  ?></td>
        </tr>
        <?php   }	?>
        </table>
        <table class="tbbbl" width="97%" style="margin:20px auto; background-color:#DCDCDC;">
          <tr>
            <td width="8%"></td>
            <td width="33%"></td>
            <td width="27%" align="right">SUBTOTAL</td>
            <td width="10%" align="center"><?php echo $quantity;?></td>
            <td width="11%">&nbsp;</td>
            <td width="11%" align="center">$<?php echo $total_amount ;?></td>
          </tr>
        </table>
        <div class="ryt_cart">
          <table width="280" cellpadding="2" class="tbl11" align="right">
            <tr>
              <td align="left"><strong>Total</strong></td>
              <td class="clr" align="center"><strong>$<?php echo $total_amount  ; ?></strong></td>
            </tr>
          </table>
          <div class="clear"></div>
        </div>
        <?php } ?>
        <table border="0" cellspacing="0" cellpadding="5"  width="950">
          <tr  style="margin:20px auto; background-color:#DCDCDC;">
            <th width="100%">Comment</th>
          </tr>
          <tr>
            <td><?php echo nl2br($comment); ?></td>
          </tr>
        </table>

      </div>
      <?php
	  	 include "include/footerlogo.php";
	  ?>
    </div>
  </div>
  <div class="clear"></div>
</div>
</div>
</body>
</html>
