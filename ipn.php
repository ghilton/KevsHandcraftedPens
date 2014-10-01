<?php
require_once("init.php");
require_once("config_db.php");
require_once("config.php");

require_once('paypal-1.3.0/paypal.class.php');  // include the class file

$p = new paypal_class;             // initiate an instance of the class
//$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
//$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
if($sandbox_env == '1'){
	$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
}
else{
	$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
}
// echo $cart_sess;
 $uniq_id = $_GET['cart'];
 $tabl = 'place_order';
 
	 $sql1 = "UPDATE place_order SET status='1' where session='".$uniq_id."'";
	 $exec1 = mysql_query($sql1);

 $sql1 = "SELECT * from $tabl where session='".$uniq_id."'";
 $exec1 = mysql_query($sql1);
 if(mysql_num_rows($exec1) == 1){	 
	 $fetch1 = mysql_fetch_assoc($exec1);
	 $to = $fetch1['email'];    //  your email
		//for page content
	$sql_cart = "select * from cart where session='".$cart_sess."' order by time DESC";	
	$exec_cart = mysql_query($sql_cart);
	$num_cart = mysql_num_rows($exec_cart);
	
	//for total amount
	$sql_t = "select sum(t_price) as tamount, sum(quantity) as tquantity from cart where session='".$cart_sess."'";
	$exec_t = mysql_query($sql_t);
	$fetch_t = mysql_fetch_assoc($exec_t);
	//print_r($fetch_t);
	
	

	$sql_ck = "select * from $tabl where session='".$cart_sess."'";
	$exec_ck = mysql_query($sql_ck);
	$num_ck = mysql_num_rows($exec_ck);
	$fetch_ck = mysql_fetch_assoc($exec_ck);

	 $subject = 'Order placed succesully';
	 $body =  '<table cellpadding="0" border="0" cellspacing="0">
	 			 <tr style="background: #ddd;">
				  <td style="font-weight: bold; text-align: center;">Hi '.ucwords($fetch_ck['first_name'].' '.$fetch_ck['last_name']).'</td>
				 </tr>
				 <tr><td colspan="5" >&nbsp;</td></tr>
				 <tr>
                  <td colspan="5" align="center"  style="font-weight: bold; text-align: center;" >Your order placed successfully. order details are below</td>
                </tr>
	 </table>
	 
	 <table cellpadding="0" border="0" cellspacing="0">
                <tr style="background: #ddd;">
				  <td style="font-weight: bold; text-align: center;">Order Id</td>
                  <td style="text-align:left; padding-left:15px; font-weight: bold; text-align: center;">Order Details</td>
                  <td style="font-weight: bold; text-align: center;">Qty</td>
                  <td style="font-weight: bold; text-align: center;">Price/Unit</td>
                  <td style="font-weight: bold; text-align: center;">Total</td>
                </tr>';
                if($num_cart == 0){ 
    $body .=    '<tr>
                  <td colspan="5" align="center"  style="font-weight: bold; text-align: center;" ><h1>No item found</h1></td>
                </tr>';
			 }else{ while($fetch_cart = mysql_fetch_assoc($exec_cart)){   
						$sql_pdt = "select image, id, name  from products where id='".$fetch_cart['product']."' AND status='1'";
						$exec_pdt = mysql_query($sql_pdt);
						$fetch_pdt = mysql_fetch_assoc($exec_pdt);
      $body .= '<tr>
	  			 <td  style=" text-align:center">'.$fetch_ck['id'].'</td>
                  <td  style="font-weight: bold; text-align: center;"><div style="width: 300px; font-size: 12px; margin-top: 15px;
"><img class="my_cart_item_img" src="'.ROOT_URL.'/pics/'.$fetch_pdt['image'].'" width="88" >
                     	 <h3>'.$fetch_pdt['name'].'</h3>
                       </div>
                  </td>
                  <td  style="font-weight: bold; text-align: center;">'.$fetch_cart['quantity'].'" </td>
                  <td  style=" text-align:center">$ '.$fetch_cart['price'].'</td>
                  <td  style=" text-align:center">$ '. $fetch_cart['t_price'].'</td>
                </tr>';
                 } } 
         $body .= '<tr>
                	  <td colspan="5">&nbsp;</td>
                   </tr>
                <tr style="background: #ddd;">
                  <td  style="font-weight: bold; text-align: center; text-align:left; padding-left:15px;">Total</td>
                  <td  style="font-weight: bold; text-align: center;" >Qty:'.$fetch_t['tquantity'].'</td>
                  <td  style="font-weight: bold; text-align: center;"></td>
                  <td  style="font-weight: bold; text-align: center;">$'.$fetch_t['tamount'].'</td>
                  <td  style="font-weight: bold; text-align: center;"></td>
                </tr>
              </table>';
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From: '.$site_name.'<'.$email_def.'>'. "\r\n";
			 mail($to, $subject, $body, $header);
	 
	 //for update order status 
	/* $sql1 = "UPDATE place_order SET status='1' where session='".$uniq_id."'";
	 $exec1 = mysql_query($sql1);*/
	 
 }
	 
 
?>