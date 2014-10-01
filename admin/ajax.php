<?php
require_once("../init.php");
require_once("../config_db.php");
require_once("include/protecteed.php");

if($_GET['do'] == 'sort'){
	@$ids = $_GET['listItem'];
	
	if($ids <> ''){
		$i = 0;
		foreach($ids as $val){
			$sql = "UPDATE categories SET sort='$i' where id='$val'";
			mysql_query($sql) or die(mysql_error());
			$i++;
		}
		echo "Success: Sorted Successfully.";
	}
	else{
		echo "Error: Sorting unsuccessful.";
	}
}

else if($_GET['do'] == 'sort_single'){
	$tabl = $_GET['tab'];
	@$ids = $_GET['listItem'];
	
	if($ids <> ''){
		$i = 0;
		foreach($ids as $val){
			$sql = "UPDATE $tabl SET sort='$i' where id='$val'";
			mysql_query($sql) or die(mysql_error());
			$i++;
		}
		echo "Success: Sorted Successfully.";
	}
	else{
		echo "Error: Sorting unsuccessful.";
	}
}

else if($_GET['do'] == 'sort_table'){
	$tabl = $_GET['tabl'];
	@$ids = $_GET['listItem'];
	
	if($ids <> ''){
		$i = 0;
		foreach($ids as $val){
			$sql = "UPDATE $tabl SET sort='$i' where id='$val'";
			mysql_query($sql) or die(mysql_error());
			$i++;
		}
		echo "Success: Sorted Successfully.";
	}
	else{
		echo "Error: Sorting unsuccessful.";
	}
}

else if($_GET['do'] == 'sort_slideshow'){
	@$ids = $_GET['listItem'];
	$type = $_GET['type'];
	$tabl = $_GET['tabl'];
	
	if($ids <> ''){
		$i = 0;
		foreach($ids as $val){
			$sql = "UPDATE $tabl SET sort='$i' where id='$val'";
			mysql_query($sql) or die(mysql_error());
			$i++;
		}
		echo "Success: Sorted Successfully.";
	}
	else{
		echo "Error: Sorting unsuccessful.";
	}
}

else if($_GET['type'] == 'category' && $_POST['do'] == 'add'){
	$name = mysql_real_escape_string($_POST['name']);
	$type = mysql_real_escape_string($_POST['type']);
	$relation = mysql_real_escape_string($_POST['relation']);
	
	if($name == ''){echo 'Error|:|Error: Please enter Category Name.'; $flag[0] = 'r';}
	else{
		$sql = "SELECT count(*) from categories where name='$name' AND relation='$relation'";
		$exec = mysql_query($sql);
		list($num) = mysql_fetch_row($exec);
		if($num > 0){echo 'Error|:|Error: Category Name exists already.'; $flag[1] = 'r';}
	}
	
	if(!empty($flag)){}
	else{
		$sql = "INSERT into categories(type, relation, name, sort, status, time) values('$type', '$relation', '$name', '$sort', '1', NOW())";
		if(mysql_query($sql)){
			echo "Success|:|Success: Category added successfully.";
		}
		else{
			echo "Error|:|Error: Category addition unsuccessful.";
		}
	}
}

else if($_GET['type'] == 'category' && $_POST['do'] == 'edit'){
	$name = mysql_real_escape_string($_POST['name']);
	$id = mysql_real_escape_string($_POST['id']);
	
	if($name == ''){echo 'Error|:|Error: Please enter Category Name.'; $flag[0] = 'r';}
	else{
		$sql = "SELECT count(*) from categories where name='$name' AND id<>'$id' AND relation='$relation'";
		$exec = mysql_query($sql);
		list($num) = mysql_fetch_row($exec);
		if($num > 0){echo 'Error|:|Error: Category Name exists already.'; $flag[1] = 'r';}
	}
	
	if(!empty($flag)){}
	else{
		$sql = "UPDATE categories SET name='$name' where id='$id'";
		if(mysql_query($sql)){
			echo "Success|:|Success: Category Edited successfully.";
		}
		else{
			echo "Error|:|Error: Category Edition unsuccessful.";
		}
	}
}

// Dispatch
if($_POST['type'] == 'Order Status'){
	$order_status = mysql_real_escape_string($_POST['order_status']);
	$dispatch = mysql_real_escape_string($_POST['dispatch']);
	$delivery_date = mysql_real_escape_string($_POST['delivery_date']);
	$id = mysql_real_escape_string($_POST['id']);
	
	$sql = "SELECT * from place_order where id='$id'";
	$exec = mysql_query($sql);
	$fetch = mysql_fetch_assoc($exec);
	$dispatch_old = $fetch[dispatch];
	$email_to = $fetch[email];
	$customer_name = $fetch[first_name].' '.$fetch[last_name];
	
	$sql = "UPDATE place_order SET order_status='$order_status', delivery_date = '$delivery_date', dispatch='$dispatch' where id='$id'";
	if(mysql_query($sql)){
		if($dispatch_old == '0' && $dispatch == '1'){
			// mail code goes here
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= "From: $email_def" . "\r\n";
			$subject = 'Your Order Number '.$id.' has been dispatched';
			$message='<html>
<head>
  <title>Your Order Number '.$id.' has been dispatched</title>
</head>
<body>
<div align="center">
	<div style="width:100%; height:auto">
    	
        <div style="font-weight:bold; font-family:calibri; text-align:left; margin-top:25px">Your Order Number '.$id.' has been dispatched </div>
        
        <div style="font-style:italic; text-align:left; margin-top:10px; font-family:calibri">Dear '.$customer_name.',</div>
        
        <div style="font-style:italic; text-align:left; margin-top:10px; font-family:calibri">Greetings from Urban Diva 9!</div>
        
        <div style="font-style:italic; text-align:left; margin-top:10px; font-family:calibri">
        	This is to inform you that your order number <span style="font-weight:bold">'.$id.'</span> has been dispatched. Please expect the delivery within 14 working days. For your reference, kindly note the order tracking number as mentioned below:  
        </div>
        <div style="text-align:left; margin-top:10px">
        	<table border="1" width="600" cellpadding="5" cellspacing="5">
            	<tr style="font-weight:bold; font-style:italic; font-family:calibri">
                	<td>Order Tracking Number : <span style="color:#666; font-size:15px">'.$id.'</span></td>
                </tr>
                <tr style="font-weight:bold; font-style:italic; font-family:calibri">
                	<td>Delivery Type : <span style="color:#666; font-size:15px">Standard Delivery</span></td>
                </tr>
                
                <tr style="font-weight:bold; font-style:italic; font-family:calibri">
                	<td>
                    	<div>Expected Date of Delivery : <span style="color:#666; font-size:15px">'.$delivery_date.'</span></div>
                        <div style="font-size:12px; font-weight:normal">Delivered on or before DD/MM/YY</div>
                    </td>
                </tr>
            </table>
        </div>
        
        <div style="font-style:italic; text-align:left; margin-top:10px; font-family:calibri">
        	In the meantime, <a style="color:#000; font-weight:bold" href="'.ROOT_URL.'">click here</a> to see what\'s new on site. Go on. We won\'t tell.  
        </div>
        
        <div style="font-style:italic; text-align:left; margin-top:10px; font-family:calibri">
        	This is an auto generated email to confirm the delivery of your order and this email box is unattended, so please do not reply to this email. In case of any query you may write to us @: <a href="mailto:'.$email_def.'">'.$email_def.'</a> 
        </div>
        
        <div style="font-style:italic; text-align:left; margin-top:10px; font-family:calibri">
        	Thank you for shopping @ UrbanDiva-9. We look forward to serving you in future.
        </div>
        
        <div style="font-style:italic; text-align:left; margin-top:10px; font-family:calibri; font-weight:bold">
        	Urban Diva - 9 Customer Care
        </div>
        
        <div style="font-style:italic; text-align:left; margin-top:10px; font-family:calibri; font-weight:bold">
			<a href="'.ROOT_URL.'" target="_blank">'.ROOT_URL.'</a>
        </div>
        
        <div style="font-style:italic; text-align:left; margin-top:10px; font-family:calibri; font-weight:bold">
        	Indulgence begins here..!
        </div>
    </div>
</div>
</body></html>';
				
			if(mail($email_to, $subject, $message, $headers)){
				echo "Success|:|Success: Status added successfully. Dispatched email sent.";
			}
			else{
				echo "Error|:|Error: Dispatch email sending unsuccessfull. Please try again later.";
			}
		}
		else{
			echo "Success|:|Success: Status added successfully.";
		}
	}
}

// Group/Attribute

else if($_GET['type'] == 'group' && $_POST['do'] == 'add'){
	$name = mysql_real_escape_string($_POST['name']);
	
	if($name == ''){echo 'Error|:|Error: Please enter Group Name.'; $flag[0] = 'r';}
	else{
		$sql = "SELECT count(*) from att_val where name='$name' AND relation='0'";
		$exec = mysql_query($sql);
		list($num) = mysql_fetch_row($exec);
		if($num > 0){echo 'Error|:|Error: Group Name exists already.'; $flag[1] = 'r';}
	}
	
	if(!empty($flag)){}
	else{
		$sql = "INSERT into att_val(relation, name, status, time) values('0', '$name', '1', NOW())";
		if(mysql_query($sql)){
			echo "Success|:|Success: Group added successfully.";
		}
		else{
			echo "Error|:|Error: Group addition unsuccessful.";
		}
	}
}

else if($_GET['type'] == 'group' && $_POST['do'] == 'edit'){
	$name = mysql_real_escape_string($_POST['name']);
	$id = mysql_real_escape_string($_POST['id']);
	
	if($name == ''){echo 'Error|:|Error: Please enter Group Name.'; $flag[0] = 'r';}
	else{
		$sql = "SELECT count(*) from att_val where name='$name' AND id<>'$id' AND relation='0'";
		$exec = mysql_query($sql);
		list($num) = mysql_fetch_row($exec);
		if($num > 0){echo 'Error|:|Error: Group Name exists already.'; $flag[1] = 'r';}
	}
	
	if(!empty($flag)){}
	else{
		$sql = "UPDATE att_val SET name='$name' where id='$id'";
		if(mysql_query($sql)){
			echo "Success|:|Success: Group Edited successfully.";
		}
		else{
			echo "Error|:|Error: Group Edition unsuccessful.";
		}
	}
}

// Attribute
else if($_GET['type'] == 'att' && $_POST['do'] == 'add'){
	$name = mysql_real_escape_string($_POST['name']);
	$relation = mysql_real_escape_string($_POST['relation']);
	
	if($name == ''){echo 'Error|:|Error: Please enter Attribute Name.'; $flag[0] = 'r';}
	else{
		$sql = "SELECT count(*) from att_val where name='$name' AND relation<>'0'";
		$exec = mysql_query($sql);
		list($num) = mysql_fetch_row($exec);
		if($num > 0){echo 'Error|:|Error: Attribute Name exists already.'; $flag[1] = 'r';}
	}
	
	if(!empty($flag)){}
	else{
		$sql = "INSERT into att_val(relation, name, status, time) values('$relation', '$name', '1', NOW())";
		if(mysql_query($sql)){
			echo "Success|:|Success: Attribute added successfully.";
		}
		else{
			echo "Error|:|Error: Attribute addition unsuccessful.";
		}
	}
}

else if($_GET['type'] == 'att' && $_POST['do'] == 'edit'){
	$name = mysql_real_escape_string($_POST['name']);
	$id = mysql_real_escape_string($_POST['id']);
	$relation = mysql_real_escape_string($_POST['relation']);
	
	if($name == ''){echo 'Error|:|Error: Please enter Attribute.'; $flag[0] = 'r';}
	else{
		$sql = "SELECT count(*) from att_val where name='$name' AND relation<>'0' AND id<>'$id'";
		$exec = mysql_query($sql);
		list($num) = mysql_fetch_row($exec);
		if($num > 0){echo 'Error|:|Error: Attribute exists already.'; $flag[1] = 'r';}
	}
	
	if(!empty($flag)){}
	else{
		$sql = "UPDATE att_val SET name='$name' where id='$id'";
		if(mysql_query($sql)){
			echo "Success|:|Success: Attribute Edited successfully.";
		}
		else{
			echo "Error|:|Error: Attribute Edition unsuccessful.";
		}
	}
}



// Get attributes according to group
else if($_GET['do'] == 'get_attribute'){
	$group = mysql_real_escape_string($_GET['group']);
	
	$sql = "SELECT * from att_val where relation='$group' AND status='1'";
	$exec = mysql_query($sql) or die(mysql_error());
	
	$return = '<select id="attribute" name="attribute"><option></option>';
	while($fetch = mysql_fetch_assoc($exec)){
		$return .= '<option value="'.$fetch[id].'">'.$fetch[name].'</option>';
	}
	$return .= '</select>';
	echo "Success|:|".$return;
}

// Manage currency
else if($_POST['type'] == 'Currency'){
	$tabl = 'currency';
	$sign = mysql_real_escape_string($_POST['sign']);
	$name = mysql_real_escape_string($_POST['name']);
	$code = mysql_real_escape_string($_POST['code']);
	$value = mysql_real_escape_string($_POST['value']);
	$id = mysql_real_escape_string($_POST['id']);
	
	if($_POST['do'] == 'add'){
		if($name == ''){echo 'Error|:|Error: Please enter Currency.'; $flag[0] = 'r';}
		else if($value == ''){echo 'Error|:|Error: Please enter Currency value.'; $flag[1] = 'r';}
		else if($sign == ''){echo 'Error|:|Error: Please enter Currency Sign.'; $flag[3] = 'r';}
		else if($code == ''){echo 'Error|:|Error: Please enter Currency Code.'; $flag[4] = 'r';}
		else{
			$sql = "SELECT count(*) from $tabl where name='$name'";
			$exec = mysql_query($sql);
			list($num) = mysql_fetch_row($exec);
			if($num > 0){echo 'Error|:|Error: Currency Name exists already.'; $flag[2] = 'r';}
			
			$url = "http://www.google.com/ig/calculator?hl=en&q=1USD=?$code";
			$response = trim(file_get_contents($url));
			$data1 = explode ('"', $response);
			if($data1['5'] <> '' && $data1['5'] <> '0'){echo 'Error|:|Error: Please enter correct Currency Code.'; $flag[5] = 'r';}

		}
		
		if(!empty($flag)){}
		else{
			$sql = "INSERT into $tabl(name, sign, valu, code, sort, status, time) values('$name', '$sign', '$value', '$code', '$sort', '1', NOW())";
			if(mysql_query($sql)){
				echo "Success|:|Success: Currency added successfully.";
			}
			else{
				echo "Error|:|Error: Currency addition unsuccessful.";
			}
		}
	}
	else if($_POST['do'] == 'edit'){
		if($name == ''){echo 'Error|:|Error: Please enter Currency.'; $flag[0] = 'r';}
		else if($value == ''){echo 'Error|:|Error: Please enter Currency value.'; $flag[1] = 'r';}
		else if($sign == ''){echo 'Error|:|Error: Please enter Currency sign.'; $flag[3] = 'r';}
		else if($code == ''){echo 'Error|:|Error: Please enter Currency Code.'; $flag[4] = 'r';}
		else{
			$sql = "SELECT count(*) from $tabl where name='$name' AND id<>'$id'";
			$exec = mysql_query($sql);
			list($num) = mysql_fetch_row($exec);
			if($num > 0){echo 'Error|:|Error: Currency Name exists already.'; $flag[2] = 'r';}
			
			$url = "http://www.google.com/ig/calculator?hl=en&q=1USD=?$code";
			$response = trim(file_get_contents($url));
			$data1 = explode ('"', $response);
			if($data1['5'] <> '' && $data1['5'] <> '0'){echo 'Error|:|Error: Please enter correct Currency Code.'; $flag[5] = 'r';}
		}
		
		if(!empty($flag)){}
		else{
			$sql = "UPDATE $tabl SET name='$name', sign='$sign', valu='$value', code='$code', time=NOW() where id='$id'";
			if(mysql_query($sql)){
				echo "Success|:|Success: Currency edited successfully.";
			}
			else{
				echo "Error|:|Error: Currency editing unsuccessful.";
			}
		}
	}
}


// Manage Shipping
else if($_GET['type'] == 'shipping' && ($_POST['do'] == 'add' || $_POST['do'] == 'edit')){
	$tabl = 'shipping';		$id = $_POST['id'];
	$from = mysql_real_escape_string($_POST['from_limit']);
	$to = mysql_real_escape_string($_POST['to_limit']);
	$charges = mysql_real_escape_string($_POST['charges']);
	
	if($from == ''){echo 'Error|:|Error: Please enter From Limit.'; $flag[0] = 'r';}
	else if($to == ''){echo 'Error|:|Error: Please enter To Limit.'; $flag[1] = 'r';}
	else if($charges == ''){echo 'Error|:|Error: Please enter Charges.'; $flag[2] = 'r';}
	
	if(!empty($flag)){}
	else{
		if($_POST['do'] == 'add'){
			$sql = "INSERT into $tabl(from_limit, to_limit, charges, time) values('$from', '$to', '$charges', NOW())";
		}
		elseif($_POST['do'] == 'edit'){
			$sql = "UPDATE $tabl SET from_limit='$from', to_limit='$to', charges='$charges', time=NOW() where id='$id'";
		}
		if(mysql_query($sql)){
			echo "Success|:|Success: Shipping Detail added successfully.";
		}
		else{
			echo "Error|:|Error: Shipping Detail addition unsuccessful. ".mysql_error();
		}
	}
}
// Next posts on click of more
else if($_GET['do'] == 'update' && $_GET['type'] == 'posts_next'){
	$tabl = "posts";
	$timestamp= $_GET['timestamp'];
	$group = mysql_real_escape_string($_GET['group_id']);
	$message = array();

	$page = $_GET['page'];
	$perpage = 9;
	$offset = $page * $perpage;
		
//	if(!ctype_digit($timestamp)){$timestamp = 0;}

	$sql="SELECT count(*) from $tabl left outer join signup on signup.uniq=posts.user_uniq where posts.group_uniq='$group' AND posts.timestamp < '$timestamp' AND $tabl.type='1'";
	$exec = mysql_query($sql);
	list($num) = mysql_fetch_row($exec);
	
	$sql = "SELECT *, signup.* from $tabl left outer join signup on signup.uniq=posts.user_uniq where posts.group_uniq='$group' AND posts.timestamp < '$timestamp' AND $tabl.type='1' order by timestamp DESC LIMIT 0, $perpage";
	$exec = mysql_query($sql);
	$message[1]  = '';	$message[4]  = '';
	while($fetch = mysql_fetch_assoc($exec)){
		$message[1] .= '<li class="post_li" id="'.$fetch[timestamp].'" alt="'.$fetch[id].'"><div class="landmidpagediv">
			<div class="landmidpagediv1" ><a href="user.php?id='.$fetch[uniq].'"><img src="thumb/'.$fetch[image].'" width="37" height="37" alt="image" /></a></div>
			<div class="landmidpagediv2" ><a href="user.php?id='.$fetch[uniq].'">'.$fetch[name].'</a> <span class="landmidpagediv3" >@'.$fetch[username].'</span>';
			if($user_uniq == $fetch_group[user_uniq]){$message[1] .= '<span id="timestamp" class="landmidpagediv4"><img title="Delete Post" src="images/delete_icon.png" width="18" height="19" onclick="delete_post(\''.$fetch[id].'\')" alt="Delete"></span>';}
		$message[1] .= '<span id="timestamp" class="landmidpagediv4" style="margin-right:5px" title="'.date("j M Y, h:i:s A", $fetch[timestamp]).'">'.date("j M", $fetch[timestamp]).'</span>
			</div>
			<div class="landmidpagediv5" >'.nl2br($fetch[post]).'</div>
			</div>
  
			<div class="landmidpagediv6" >
				<a onclick="delacc1(\''.$fetch[username].'\')" >
				<span style="float:left"><img src="images/reply_icon.png" width="15" height="14" alt="Reply" /></span><span style="margin-left:2px;float:left;margin-top:-1px"  >Reply</span></a>
			</div>
		</div>
		<div class="clear"></div>
		</li>';
	}
	if($num <= $perpage){
		$message[2] = 'r';
	}
	else{
		$message[2] = 'g';
	}
	
	$message[0] = 'Success';
	
	ksort($message);

	$message_arr = implode('|::|', $message);
	echo $message_arr;
}

if($_REQUEST['do']=='chkAvail')
{
	$acrossid = $_REQUEST['acrossid'];  #Start Location(x1)
	$dwnid = $_REQUEST['dwnid']; 		#Start Location (y1)
	 	
	$widh = $_REQUEST['widh'];
	$heigt = $_REQUEST['heigt'];
	$page = $_REQUEST['page'];
	
	if($page == '-1')
	{	
		$message[0] = 'Error';
		$message[1] = "Select Page first";
		
		$message_arr = implode('|::|', $message);
		echo $message_arr;
		die;			
	}
	else if($acrossid == '')
	{
		$message[0] = 'Error';
		$message[1] = "Select Across";
		
		$message_arr = implode('|::|', $message);
		echo $message_arr;
		die;	
	}
	else if($dwnid == '')
	{
		$message[0] = 'Error';
		$message[1] = "Select Down";
		
		$message_arr = implode('|::|', $message);
		echo $message_arr;
		die;	
	}
	else if($widh == '')
	{
		$message[0] = 'Error';
		$message[1] = "Select Width";
		
		$message_arr = implode('|::|', $message);
		echo $message_arr;
		die;
	}
	else if($heigt == '')
	{
	
		$message[0] = 'Error';
		$message[1] = "Select Height";
		
		$message_arr = implode('|::|', $message);
		echo $message_arr;
		die;	
		
	}
	else if(($acrossid != '') && ($dwnid != '') && ($widh != '') && ($heigt != ''))
	{
	
	$acrossid = $acrossid-1;  #Start Location(x1)
	$dwnid = $dwnid-1; 		#Start Location (y1)
	
	/*$acrossid = $acrossid;  #Start Location(x1)
	$dwnid = $dwnid; 		#Start Location (y1)*/
			
	$x_limit = $acrossid + $widh;      #end Location(x2)
	$y_limit = $dwnid + $heigt;		   #end Location (y2)
	
	#To check the availability in place_order tbl
	
	for($x_cord = $acrossid; $x_cord < $x_limit; $x_cord++ )
	{		
		for($y_cord = $dwnid; $y_cord < $y_limit; $y_cord++)
		{
			//$across_x = $x_cord * 10;
			//$across_y = $y_cord * 10;

			# to check selected size pixels for an image are available for user image or not
			$chkAvailQry = "SELECT pixels.*, place_order.id FROM `pixels`, place_order where pixels.page='".$page."' and pixels.x='".$x_cord."' and pixels.y = '".$y_cord."' and pixels.status = '1' and pixels.place_orderId = place_order.id and place_order.archived  != '1'";
			#$chkAvailQry = "select * from pixels where x = '".$x_cord."' and y = '".$y_cord."' and page = '".$page."' and status = '1' and place_orderId in(select id from place_order where archived != '1' )";
			$chkAvailSql = mysql_query($chkAvailQry) or die(mysql_error());
			if(mysql_num_rows($chkAvailSql) > 0)
			{
				$message[0] = 'Error';
				$message[1] = 'Block across '.($x_cord+1).', down '.($y_cord+1).' occupied already. ';
				
				$message_arr = implode('|::|', $message);
				echo $message_arr;
				die;	
			}
		}
		
	}
	
	$x = $acrossid * 10;
	$y = $dwnid * 10;
	
	#To get the 
	$width = $widh*10;
	$height = $heigt*10;
	
	#To find the price 1 block = 10*10 
	$blocks = ($widh *$heigt) *10;
	$totalamount = $blocks * 10;
	//echo "Across: ".$acrossid." Down : ".$dwnid." Width : ".$widh." Height: ".$heigt."x limit : ".$x_limit."y Limit : ".$y_limit."Price: ".$totalamount;
	
	$message[0] = 'Success';
	$message[1] = 'Available';
	
	$message_arr = implode('|::|', $message);
	echo $message_arr;
	//price according to selected width and height multiple by 10
	}
}
?>