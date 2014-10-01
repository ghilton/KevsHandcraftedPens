<?php 

//for select data from database
/* $tabl -> 'tablename', $limi -> 'linit eg. limit 0,1', $od -> 'order by eg order by time desc', $cond -> conditions eg "type='1' or relation=$uniq " */
function select_query($tabl, $limi, $od, $cond){
	$sql_sel = "SELECT * from $tabl where status='1' ";
	if(trim($cond) <> ''){
		$sql_sel .= "  AND $cond";
	}
	if(trim($od) <> ''){
		$sql_sel .= " order by $od";
	}
	if(trim($limi) <> ''){
		$sql_sel .= " limit $limi";
	}
	//echo $sql_sel;
	$exec_sel = mysql_query($sql_sel); 
	
	return $exec_sel;
	
}
//select query without status
function select_query_without_status($tabl, $limi, $od, $cond){
	$sql_sel = "SELECT * from $tabl where 1='1' ";
	if($cond <> ''){
		$sql_sel .= "  AND $cond";
	}
	if($od <> ''){
		$sql_sel .= " order by $od";
	}
	if($limi <> ''){
		$sql_sel .= " limit $limi";
	}
	//echo $sql_sel;
	$exec_sel = mysql_query($sql_sel); 
	
	return $exec_sel;
	
}

//select query for selct fields/column names
function select_query_fields($tabl, $fields, $limi, $od, $cond){
	$sql_sel = "SELECT $fields from $tabl where 1='1' ";
	if($cond <> ''){
		$sql_sel .= "  AND $cond";
	}
	if($od <> ''){
		$sql_sel .= " order by $od";
	}
	if($limi <> ''){
		$sql_sel .= " limit $limi";
	}
	//echo $sql_sel;
	$exec_sel = mysql_query($sql_sel); 
	
	return $exec_sel;
	
}

//delete  rows
function delete_query($tabl, $cond){
	$sql_delete = "update $tabl set status='0' AND archive='1' where 1=1 AND $cond";
	$exec_delete = mysql_query($sql_delete); 
	return $exec_delete;
	
}

//count  rows
function count_query($tabl, $cond){
	$sql_count = "SELECT count(*) from $tabl where status='1' AND archive='0' ";
	if(trim($cond) <> ''){
		$sql_count .= "  AND $cond";
	}
//	echo $sql_count;
	$exec_count = mysql_query($sql_count); 
	list($count) = mysql_fetch_row($exec_count);
	//echo $count;
	return $count;
	
}

//count  rows
function count_query_without_status($tabl, $cond){
	$sql_count = "SELECT count(*) from $tabl where 1='1' ";
	if(trim($cond) <> ''){
		$sql_count .= "  AND $cond";
	}
//	echo $sql_count;
	$exec_count = mysql_query($sql_count); 
	list($count) = mysql_fetch_row($exec_count);
	//echo $count;
	return $count;
	
}


//for bid left time
function remaing_time($seconds){

     $days = floor($seconds/86400);
     $hrs = floor($seconds/3600);
     $mins = intval(($seconds / 60) % 60); 
     $sec = intval($seconds % 60);

        if($days>0){
          //echo $days;exit;
          $hrs = str_pad($hrs,2,'0',STR_PAD_LEFT);
          $hours=$hrs-($days*24);
          $return_days = $days." Days ";
          $hrs = str_pad($hours,2,'0',STR_PAD_LEFT);
     }else{
      $return_days="";
      $hrs = str_pad($hrs,2,'0',STR_PAD_LEFT);
     }

     $mins = str_pad($mins,2,'0',STR_PAD_LEFT);
     $sec = str_pad($sec,2,'0',STR_PAD_LEFT);

     return $return_days.$hrs.":".$mins.":".$sec;
  }
  
//for check bid
function check_bid($user_id, $pdt_id, $amount, $resrv_price){
	//for count bid
	$sql_b = mysql_query("select count(*) from bid_by_users where product_id='".$pdt_id."' AND user_id='".$user_id."' AND status='1'");
	list($no_bid) = mysql_fetch_row($sql_b);
	//echo $no_bid;
	if($no_bid == 0){ 
		 if($amount <> 1 || $amount <> 1.00){//echo "hi";
			$bif_flg = "Error: You cannot first sit more than $1";
		 }
	}
	else if($no_bid <> 0){
		//for fetch last bis amount
		$sql_b = "select amount from bid_by_users where product_id='".$pdt_id."' AND user_id='".$user_id."' AND status='1' order by time DESC limit 0,1";
		$exec_b = mysql_query($sql_b);
		$fetch_b = mysql_fetch_assoc($exec_b);
		//echo '<br>'. $fetch_b['amount'];
		//for 10% of last bid
		 $bid_amt = $fetch_b['amount']*10; //echo $bid_amt;
		//for 10% of reserve price
		$resrv_amt = $resrv_price*10/100;
		if($amount > $bid_amt){
			$bif_flg = "Error : You cannot sit more then amount(".$bid_amt.")";
			//$bif_flg = 49;
		}
		else if($amount > $resrv_amt){
			$bif_flg = "Error : You cannot sit more then reserve amount(".$resrv_amt.")";
		}
	}
	else{
		$bif_flg = '';
	}
	return $bif_flg;
}

//count active bids
function active_bids($user_id){
	$sql_ab = "SELECT * FROM bid_by_users where user_id='".$user_id."' AND status=1 group by product_id";
	$exec_ab = mysql_query($sql_ab);
	$num_ab = mysql_num_rows($exec_ab);
	return $num_ab;
	
}


//chk for hit reserve 
function reserve_bids($pdt_id){
	$sql_rb = "SELECT sum(amount) as tamount FROM bid_by_users where product_id='".$pdt_id."'";
	$exec_rb = mysql_query($sql_rb);
	$fetch_rb = mysql_fetch_assoc($exec_rb);
	$rb = $fetch_rb['tamount'];
	return $rb;
}

//chk for minmum sit 
function minimum_bids($pdt_id){
	$sql_mb = "select min(amount) as min_amt, id as pid from (
	SELECT id, amount,count(*) cnt FROM `bid_by_users` 
	where product_id='".$pdt_id."'
	group by amount
	having count(*)=1
	)a";
	$exec_mb = mysql_query($sql_mb);
	$fetch_mb = mysql_fetch_assoc($exec_mb);
	$mb = $fetch_mb['pid'];
	return $mb;
}

//for update sit status   
function update_bids_status($pdt_id, $status){
	if($status == 0){
		$sql_chk = "SELECT count(*) FROM products where id='".$pdt_id."' AND auction_status=0";
		$exec_chk = mysql_query($sql_chk);
		list($num_chk) = mysql_fetch_row($exec_chk);
		if($num_chk <> 0){
			$sql_up = "update bid_by_users set status='0' where product_id='".$pdt_id."'";
			mysql_query($sql_up);
			//for winner
			sit_winner($pdt_id);
		}
	}
	else{
		$sql_chk = "SELECT count(*) FROM products where id='".$pdt_id."' AND auction_status=1";
		$exec_chk = mysql_query($sql_chk);
		list($num_chk) = mysql_fetch_row($exec_chk);
		if($num_chk <> 0){
			$sql_up = "update bid_by_users set status='1' where product_id='".$pdt_id."'";
			mysql_query($sql_up);
		}
	}
	
	return $num_chk;
}

//for sit winner
function sit_winner($pid){
	$sit_id = minimum_bids($pid);
	//for sit details
	$sql_sit =  "select * from bid_by_users where id='".$sit_id."'";
	$exec_sit = mysql_query($sql_sit);
	$fetch_sit = mysql_fetch_assoc($exec_sit);
	
	$sql_chk = "select count(*) from bid_winner where product_id='".$pid."'";
	$exec_chk = mysql_query($sql_chk);
	list($n_chk) = mysql_fetch_row($exec_chk);
	if($n_chk == 0){
	//entry in winner table
	$sql_w = "insert into bid_winner(winner_id, product_id, amount, time) values('".$fetch_sit['user_id']."', '".$fetch_sit['product_id']."', '".$fetch_sit['amount']."', '".time()."')"; 
	}
	else{
		$sql_w = "update bid_winner set winner_id='".$fetch_sit['user_id']."', amount='".$fetch_sit['amount']."' where product_id='".$fetch_sit['product_id']."'";
	}
	$exce_w = mysql_query($sql_w);
	if($exce_w){
		$sit_winner1 = true;
	}else{
		$sit_winner1 = mysql_error();
	}
	
	return $sit_winner1;
}


//for sit winner
function sit_winner_name($pid){
	//for sit details
	$sql_sit =  "select winner_id from bid_winner where product_id='".$pid."'";
	$exec_sit = mysql_query($sql_sit);
	$fetch_sit = mysql_fetch_assoc($exec_sit);
	
	//winner data from user table
	$sql_w = "select user_name from users where id='".$fetch_sit['winner_id']."'"; 
	$exce_w = mysql_query($sql_w);
	$fetch_w = mysql_fetch_assoc($exce_w);
	$sit_winner1 = $fetch_w['user_name'];
	return $sit_winner1;
}


//for current lowest unique bidder
function current_unique_bidder($id){
	$uid = minimum_bids($id);
	//for sit details
	$sql_sit =  "select user_id from bid_by_users where id='".$uid."'";
	$exec_sit = mysql_query($sql_sit);
	$fetch_sit = mysql_fetch_assoc($exec_sit);
	
	$sql_w = "select user_name from users where id='".$fetch_sit['user_id']."'"; 
	$exce_w = mysql_query($sql_w);
	$fetch_w = mysql_fetch_assoc($exce_w);
	$sit_winner1 = $fetch_w['user_name'];
	
	return $sit_winner1;
	
}

//for email from 112
function send_email_smtp($email_to, $subject, $message_f, $file, $cc){

	//$message_f = wordwrap($message_f, 70);
	$mail = new PHPMailer(); // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true; // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 465; // or 587
	$mail->IsHTML(true);
	$mail->Username = "testing.slinfy02@gmail.com";
	$mail->Password = "slinfy007";
	$mail->SetFrom($email_to);
	$mail->Subject = $subject;
	$mail->Body = $message_f;
	$mail->AddAddress($email_to);
	if($cc <> ''){
		$mail->AddCC($cc);
	}
	if(trim($file) <> ''){
		$mail->AddAttachment($file); //Attach a file here if any or comment this line, 
	}
	 if(!$mail->Send()){
		 return false;
		//echo "Mailer Error: " . $mail->ErrorInfo;
	}
	else{
		 return true;
		//echo "Message has been sent";
	}
}


//for user login
/*function user_login($table, $cond){
	$sql = "select * from $table where 1=1 ";
	if(trim($cond <> ''){
		$sql .= $cond;
	}
	$exec = mysql_query($sql);
	$fetch = mysql_fetch_assoc($exec);
}*/

function chk_view($view){
	if($_GET['view'] == "gallery"){
		$view = "list";
	}else{
		$view = "gallery";
	}

 return $view;
}
function chk_status($status){
	if($status == "1"){
		$view = "Pending";
	}
	else if($status == "2"){
		$view = "Live";
	}
	else if($status == "3"){
		$view = "Banned";
	}
	else if($status == "4"){
		$view = "Expired";
	}

 return $view;
}


?>