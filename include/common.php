<?php
if (get_magic_quotes_gpc()) {
	$process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
	while (list($key, $val) = each($process)) {
		foreach ($val as $k => $v) {
			unset($process[$key][$k]);
			if (is_array($v)) {
				$process[$key][stripslashes($k)] = $v;
				$process[] = &$process[$key][stripslashes($k)];
			} else {
				$process[$key][stripslashes($k)] = stripslashes($v);
			}
		}
	}
	unset($process);
}

function connecttodb($servername,$dbname,$dbuser,$dbpassword){
	$link=mysql_connect ("$servername","$dbuser","$dbpassword");
	mysql_set_charset('utf8',$link);
	if(!$link){die("Could not connect to MySQL".mysql_error());}
	mysql_select_db("$dbname",$link) or die ("could not open db".mysql_error());
}

function random_generator($digits){
    // function starts
    srand((double) microtime() * 10000000);
    $input = array("A", "B", "C", "D", "E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","a", "b", "c", "d", "e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
    $random_generator="";
    // Initialize the string to store random numbers
    for ($i=1; $i<=$digits; $i++) {
        // Loop the number of times of required digits
        if (rand(1,2) == 1) {
            // to decide the digit should be numeric or alphabet
            // Add one random alphabet
            $rand_index = array_rand($input);
            $random_generator .=$input[$rand_index];
            // One char is added
        } else {
            // Add one numeric digit between 1 and 9
            $random_generator .=rand(1,9);
            // one number is added
        }
        // end of if else
    }
    // end of for loop
    return $random_generator;
}

//RG function to ensure uniq random entry in a table
function rg($table, $column, $length){
  $uniq = random_generator($length);
  
  $sql = "SELECT count(*) from $table where $column='$uniq'";
  $exec = mysql_query($sql);
  list($num) = mysql_fetch_row($exec);
  if($num == 0){return $uniq;}
  else{
   return rg($table, $column, $length);
  }
 }
 
 
 // Function For search suggestions
function get_suggestions_complex($q, $base_tabl, $field, $select, $field_fetch)
{
    $sql = search($q, $base_tabl, $field, $select);
    $rsd = mysql_query($sql) or die(mysql_error());
    while ($rs = mysql_fetch_assoc($rsd)) {
        $result .= $rs[$field_fetch]."\n";
    }
    return $result;
}
function get_suggestions($q, $field, $base_tabl)
{
    $b = explode(' ', $q);
    $num = count($b);
    $start = "select $field from $base_tabl where ";
    $equal = "$field = '$q'";
    $middle_fc = "$field LIKE '%$q%'";
    $i = 0;
    foreach($b as $val){
        if ($i<> 0) {
            $start_c .= " AND $field LIKE '%$val%'";
        } else {
            $start_c .= "$field LIKE '%$val%'";
        }
        if ($i<> 0) {
            $end_c .= " OR $field LIKE '%$val%'";
        } else {
            $end_c .= " $field LIKE '%$val%'";
        }
        $i++;
    }
    $sql = "($start $equal) Union ($start $middle_fc)";
    if ($num <> 0) {
        $sql .= "Union ($start $start_c) Union ($start $end_c)";
    }
    $rsd = mysql_query($sql) or die(mysql_error());
    while ($rs = mysql_fetch_assoc($rsd)) {
        $result .= $rs[$field]."\n";
    }
    return $result;
}
function xport_excel($sql, $var_arr, $header)
{
    $exec = mysql_query($sql);
    $arr_count = count($var_arr);
    // Insert header in $content
    $head_count = count($header);
    $j = 0;
    while ($j < $head_count) {
        $contents .= $header[$j]." \t ";
        $j++;
    }
    $contents .= "\n ";
    while ($fetch = mysql_fetch_assoc($exec)) {
        //feed the final array to our formatting function...
        $i = 0;
        while ($i < $arr_count) {
            $val = $var_arr[$i];
            $contents .= $fetch[$val]." \t ";
            $i++;
        }
        $contents .= "\n ";
    }
    $filename = "myExcelFile.xls";
    //prepare to give the user a Save/Open dialog...
    header("Content-type: application/msexcel");
    header("Content-Disposition: attachment; filename=".$filename);
    //setting the cache expiration to 30 seconds ahead of current time. an IE 8 issue when opening the data directly in the browser without first saving it to a file
    $expiredate = time() + 30;
    $expireheader = "Expires: ".gmdate("D, d M Y G:i:s",$expiredate)." GMT";
    header($expireheader);
    //output the contents
    echo $contents;
    exit;
}
function xport_csv($sql, $var_arr, $header)
{
    $exec = mysql_query($sql);
    $arr_count = count($var_arr);
    // Insert header in $content
    $head_count = count($header);
    $j = 0;
    while ($j < $head_count) {
        $contents .= $header[$j]." , ";
        $j++;
    }
    $contents .= "\n ";
    while ($fetch = mysql_fetch_assoc($exec)) {
        //feed the final array to our formatting function...
        $i = 0;
        while ($i < $arr_count) {
            $val = $var_arr[$i];
            $contents .= $fetch[$val]." , ";
            $i++;
        }
        $contents .= "\n ";
    }
    $filename = "myExcelFile.csv";
    //prepare to give the user a Save/Open dialog...
    header("Content-type: application/msexcel");
    header("Content-Disposition: attachment; filename=".$filename);
    //setting the cache expiration to 30 seconds ahead of current time. an IE 8 issue when opening the data directly in the browser without first saving it to a file
    $expiredate = time() + 30;
    $expireheader = "Expires: ".gmdate("D, d M Y G:i:s",$expiredate)." GMT";
    header($expireheader);
    //output the contents
    echo $contents;
    exit;
}
function search($q, $table_name, $fields, $select)
{
    $b = explode(' ', $q);
    $num = count($b);
    $start = "select $select from $table_name where ";
    $equal = "$fields = '$q'";
    $middle_fc = "$fields LIKE '%$q%'";
    $i = 0;
    foreach($b as $val){
        if ($i<> 0) {
            $start_c .= " AND $fields LIKE '%$val%'";
        } else {
            $start_c .= "$fields LIKE '%$val%'";
        }
        if ($i<> 0) {
            $end_c .= " OR $fields LIKE '%$val%'";
        } else {
            $end_c .= " $fields LIKE '%$val%'";
        }
        $i++;
    }
    $sql1 = "($start $equal) Union ($start $middle_fc)";
    if ($num <> 0) {
        $sql1 .= " Union ($start $start_c) Union ($start $end_c)";
    }
    return $sql1;
}
function stcom($page, $perpage)
{
    if ($page == '' || !ctype_digit($page)) {
        $page='1';
    }
    $stcom = ($page - 1) * $perpage;
    return $stcom;
}
// Single File Upload
function single_file($field_name, $path_folder, $path_db, $relation, $rel_id,$ip, $name)
{
    $filename = $_FILES[$field_name][name];
    $file_size = $_FILES[$field_name][size];
    if ($file_size == '') {
        // this will check if any blank field is entered
        return 'error';
    }
    $exp = explode(".", $filename);
    $ext = $exp[count($exp) - 1];
    $num_arr = count($exp);
    $z = 0;
    $filename = '';
    while ($z < $num_arr-1) {
        $filename .= $exp[$z];
        $z++;
    }
    if (trim($name) == '') {
        $rand1 = random_generator(10);
    } else {
        $rand1 = $name;
    }
    $filename = $rand1.'.'.$ext;
    $path = $path_folder.$filename;
    $path_db_n = $path_db.$filename;
    $uniq = random_generator(32);
    $sql1 = "INSERT into files(uniq_id, relation, rel_id, file_name, location, file_size, ext, ip, time) values('$uniq', '$relation', '$rel_id', '$filename', '$path_db_n', '$file_size', '$ext', '$ip', NOW())";
    if (mysql_query($sql1)) {
        copy($_FILES[$field_name][tmp_name], $path);
        //  upload the file to the server
        chmod("$path",0777);
        // set permission to the file.
        return $uniq;
    } else {
        die(mysql_error());
    }
}
// Multiple Upload FIles
function multiple_files($field_name, $path_folder, $path_db, $relation, $rel_id,$ip)
{
    $j = 0;
    $y = 0;
    while (list($key,$value) = each($_FILES[$field_name][name])) {
        unset($flaz['9']);
        unset($flaz['2']);
        unset($flaz['3']);
        $file_size[$j] = $_FILES[$field_name][size][$key];
        if ($file_size[$j] == '') {
            // this will check if any blank field is entered
            $flaz[9] = 'red';
        } else {
            $filename[$j] = $value;
            // filename stores the value
            $exp = explode(".", $filename[$j]);
            $ext[$j] = $exp[count($exp) - 1];
            $num_arr = count($exp);
            $z = 0;
            $filename[$j] = '';
            while ($z < $num_arr-1) {
                $filename[$j] .= $exp[$z];
                $z++;
            }
            if ($file_size[$j] == '0') {
                $flaz[4] = 'red';
            } else {
                $file_size[$j] = round($file_size[$j]/1024);
            }
        }
        if (!empty($flaz)) {
        } else {
            // Add _ inplace of non supported chars in file name, you can remove this line
            $filename[$j] = preg_replace('/[^a-zA-Z0-9-_.]/', '', $filename[$j]);
            if ($filename[$j] == '') {
                $filename[$j] = 'image'.rand(1,999999);
            }
            $filename[$j] .= "-".date("F_j_Y-g_i_s_a");
            $filename[$j] .= '.'.$ext[$j];
            $path = $path_folder.$filename[$j];
            $path_db_n = $path_db.$filename[$j];
            $uniq = random_generator(32);
            $sql1 = "INSERT into files(uniq_id, relation, rel_id, file_name, location, file_size, ext, ip, time) values('$uniq', '$relation', '$rel_id', '$filename[$j]', '$path_db_n', '$file_size[$j]', '$ext[$j]', '$ip', NOW())";
            if (mysql_query($sql1)) {
                copy($_FILES[$field_name][tmp_name][$key], $path);
                //  upload the file to the server
                chmod("$path",0777);
                // set permission to the file.
                $uniq_id[$y] = $uniq;
                $y++;
            } else {
                die(mysql_error());
            }
        }
        $j++;
    }
    return $uniq_id;
}
function resize_image($old_h, $old_w, $h, $w)
{
    if ($old_h > $old_w) {
        $new_w = $h/$old_h * $old_w;
        $new_h = $h;
        if ($new_w > $w) {
            $new_h = $w/$old_w * $old_h;
            $new_w = $w;
        }
    } else {
        $new_h = $w/$old_w * $old_h;
        $new_w = $w;
        if ($new_h > $h) {
            $new_w = $h/$old_h * $old_w;
            $new_h = $h;
        }
    }
    $new_h = round($new_h);
    $new_w = round($new_w);
    return array($new_h,$new_w);
}
function delete_file_db($id, $root)
{
    $sql = "SELECT location from files where rel_id='$id'";
    $exec = mysql_query($sql);
    list($loc) = mysql_fetch_row($exec);
    $filepath = $root.'/'.$loc;
    if (file_exists($filepath)) {
        unlink($filepath);
        $success = TRUE;
    }
    $sql = "DELETE from files where rel_id='$id'";
    mysql_query($sql) or die(mysql_error());
}
function curr_val($price, $conv)
{
    return round($price * $conv, 2);
}
function redirect_loggedin($page, $user_status)
{
    if ($page == '') {
        $page='index.php';
    }
    if ($user_status == '1') {
        header("Location: $page");
    }
}
function protected_page($user_status)
{
    if ($user_status <> 1) {
        header("Location: login.php");
		die;
    }
}
function get_string_between($string, $start, $end, $pos)
{
    $string = " ".$string;
    $i = 0;
    while ($i < $pos) {
        $ini = strpos($string, $start, $ini+1);
        $i++;
    }
    if ($ini == 0) {
        return "";
    }
    $ini += strlen($start);
    $len = strpos($string,$end,$ini) - $ini;
    return substr($string,$ini,$len);
}

function validate_file($file, $allowed_ext, $allowed_size, $required){
	$flag = '';
	$file_size = $_FILES[$file][size];
	if(($file_size == '' || $file_size == '0') && $required == '1'){
		$flag = '2';	// No file uplaoded.
	}
	else if(($file_size == '' || $file_size == '0') && $required == '0'){   // this will check if any blank field is entered
		//do nothing
	}
	else{
		$filename = $_FILES[$file][name];
		$ext = end(explode(".", $filename));

		if(!in_array($ext,$allowed_ext)){$flag = '3';}
		if(($file_size > $allowed_size) && $allowed_size <> '0'){$flag = '4';}
	}
	if($flag == ''){
		$result[0] = '1';	// Conditions satisfied.
	}
	else{
		$result[0] = $flag;
	}
	$result[1] = $filename;	// if file present then file name OTHERWISE empty
	$result[2] = $ext;
	$result[3] = $file_size;
	
	return $result;
}

function print_messages($flag, $error_message, $success_message){
	ksort($flag);
	if($flag['g'] <> ''){
		$result = '<div class="success">'.$success_message[$flag['g']].'</div>';
	}
	else if($flag <> ''){
		if(is_array($flag)){
			foreach($flag as $k => $v){
				if($k == 'file'){
					$result = '<div class="error">'.$error_message['file'][$v].'</div>';
				}
				else if($k == 'd' || $k == 'ed' || $k == 'ad'){
					$result = '<div class="success">'.str_replace('[var1]', $v, $success_message[$k]).'</div>';
				}
				else if($k == 'z'){
					$result = '<div class="error">'.str_replace('[var1]', $v, $error_message[$k]).'</div>';
				}
				else if($k <> 'r'){
					$result = '<div class="error">'.$error_message[$k].'</div>';
				}
			}
		}
	}
	return $result;
}

// login, protected functions here
function user_login($uniq){
	$_SESSION['user'] = $uniq;
}

// out put CSV
function outputCSV($data) {
	$outstream = fopen("php://output", 'w');
	function __outputCSV(&$vals, $key, $filehandler) {
		fputcsv($filehandler, $vals, ',', '"');
	}
	array_walk($data, '__outputCSV', $outstream);
	fclose($outstream);
}

function translate($data, $language){
	return $data;
}

function update_query($dvar, $add_dvar, $remove_dvar, $change_dvar){
	$sub_sql = '';
	foreach($dvar as $k => $v){
		if(!in_array($k, $remove_dvar)){ // if not in remove array
			if(array_key_exists($k, $change_dvar)){$v = $change_dvar[$k];}
			$v = mysql_real_escape_string($v);
			$sub_sql[] = " $k='$v'";
		}
	}
	foreach($add_dvar as $k => $v){
		$v = mysql_real_escape_string($v);
		$sub_sql[] = " $k='$v'";
	}
	return implode(", ", $sub_sql);
}

function insert_query($dvar, $add_dvar, $remove_dvar, $change_dvar){
	foreach($dvar as $k => $v){
		if(!in_array($k, $remove_dvar)){ // if not in remove array
			if(array_key_exists($k, $change_dvar)){$v = $change_dvar[$k];}
			$v = mysql_real_escape_string($v);
			$sub_sql[] = " $k";
			$sub_sql1[] = " '$v'";
		}
	}
	foreach($add_dvar as $k => $v){
		$v = mysql_real_escape_string($v);
		$sub_sql[] = " $k";
		$sub_sql1[] = " '$v'";
	}
	return array(implode(',', $sub_sql), implode(',', $sub_sql1));
}

//for html email
function sendHTMLemail($HTML,$from,$to,$subject){

    $headers = "From: $from\r\n"; 
    $headers .= "MIME-Version: 1.0\r\n"; 
    $boundary = uniqid("HTMLEMAIL"); 
    $headers .= "Content-Type: multipart/alternative;".
                "boundary = $boundary\r\n\r\n"; 
    $headers .= "This is a MIME encoded message.\r\n\r\n"; 
    $headers .= "--$boundary\r\n".
                "Content-Type: text/plain; charset=ISO-8859-1\r\n".
                "Content-Transfer-Encoding: base64\r\n\r\n"; 
    $headers .= chunk_split(base64_encode(strip_tags($HTML))); 
    $headers .= "--$boundary\r\n".
                "Content-Type: text/html; charset=ISO-8859-1\r\n".
                "Content-Transfer-Encoding: base64\r\n\r\n"; 
    $headers .= chunk_split(base64_encode($HTML)); 
    mail($to,$subject,"",$headers);
}

// file attach in email  for csv
function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {
    $file = $path.$filename;
    $file_size = filesize($file);
    $handle = fopen($file, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $content = chunk_split(base64_encode($content));
    $uid = md5(uniqid(time()));
    $name = basename($file);
    $header = "From: ".$from_name." <".$from_mail.">\r\n";
    $header .= "Reply-To: ".$replyto."\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
    $header .= "This is a multi-part message in MIME format.\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $header .= $message."\r\n\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
    $header .= "Content-Transfer-Encoding: base64\r\n";
    $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
    $header .= $content."\r\n\r\n";
    $header .= "--".$uid."--";
   if (mail($mailto, $subject, "", $header)) {
        $flag[g] = '15';
    } else {
         $flag[g] = '15';
    }
}

// remove a directory
function rrmdir($dir) { 
  foreach(glob($dir . '/*') as $file) { 
    if(is_dir($file)) rrmdir($file); else unlink($file); 
  } rmdir($dir); 
}


// add friends/check already in friend list
function already_friend($friend1, $friend2){
	$sql_fr = "select count(*) from friend_list where (user='".$friend1."' AND friend='".$friend2."') OR (user='".$friend2."' AND friend='".$friend1."')";
	$exec_fr = mysql_query($sql_fr);
	list($fetch_fr) = mysql_fetch_row($exec_fr); 
	if($fetch_fr == 0){ 
		$req = "true";
		return $fetch_fr;
	}
	else{
		$req = "false";
	}
}
// before add friends check already in friend list
function add_friend($friend1, $friend2){
	$sql_fr = "select count(*) from neighbourhood where (frendreq_reciv='$friend1' AND frendreq_sender='$friend2') OR (frendreq_reciv='$friend2' AND frendreq_sender='$friend1') AND status='1'";
	$exec_fr = mysql_query($sql_fr);
	list($fetch_fr) = mysql_fetch_row($exec_fr); 
	if($fetch_fr == 0){ 
		$req = "true";
		return $fetch_fr;
	}
	else{
		$req = "false";
	}
}

function already_requested($friend1, $friend2){
	$sql_fr = "select count(*) from neighbourhood where (frendreq_reciv='".$friend1."' AND frendreq_sender='".$friend2."') OR (frendreq_reciv='".$friend2."' AND frendreq_sender='".$friend1."') AND status='0'";
	$exec_fr = mysql_query($sql_fr);
	list($fetch_fr) = mysql_fetch_row($exec_fr); 
	if($fetch_fr == 0){ 
		$req = "true";
		return $fetch_fr;
	}
	else{
		$req = "false";
	}
}
// new message notification
function notifi_sms($uniq){
	$sql_sms = "select count(*) from message where mesg_reciever='$uniq' AND status='0'"; 
	$exec_sms = mysql_query($sql_sms);
	list($new_sms) = mysql_fetch_row($exec_sms);
	return $new_sms; 
}

// new friend request notification
function notifi_frnd_request($id){
  $sql_fend = "select count(*) from friend_req where reciever='".$id."'"; 
	  $exec_fend = mysql_query($sql_fend);
	  list($new_fend) = mysql_fetch_row($exec_fend); 
	  return $new_fend; 
}


//count mutual friend
function mutual_friend($user, $friend){
	$sql_mf = "select count(*) from friend_list where ((friend='".$friend."') OR (user='".$friend."')) AND (user != '".$user."') AND status='1'";
	$exec_mf = mysql_query($sql_mf);
	list($fetch_mf) = mysql_fetch_row($exec_mf); 
	if($fetch_mf > 0){
		$sql = "select * from friend_list where ((friend='".$friend."') OR (user='".$friend."')) AND (user != '".$user."') AND status='1'";
		$exec = mysql_query($sql);
		$fetch = mysql_fetch_assoc($exec);
		if($fetch['friend'] == $friend){
			$sql1 = "select * from users where uniq='".$fetch['user']."' AND status='1'"; 
		}
		if($fetch['user'] == $friend){
			$sql1 = "select * from users where uniq='".$fetch['user']."' AND status='1'"; 
		}
		$exec1 = mysql_query($sql1);
		$fetch1 = mysql_fetch_assoc($exec1);
	}
	if($fetch_mf > 1){
		$mutual = "<a href='#'>".$fetch1['first_name']."&nbsp;".$fetch1['last_name']."</a>&nbsp;and<a href='#'> ".$fetch_mf."</a> other mutual friends";
		return $mutual; 
	}
	if($fetch_mf == 1){
		$mutual = "<a href='#'>".$fetch1['first_name']."&nbsp;".$fetch1['last_name']."</a>&nbsp; mutual friend";
		return $mutual; 
	}
	else{
		$mutual = "No mutual friends";
		return $mutual; 
	}
}

//count no of groups created by user
function count_groups_created($id){
	$sql = "SELECT count(*) from groups where user_uniq='".$id."' ANd status='1'";
	$exec = mysql_query($sql);
	list($no_groups) = mysql_fetch_row($exec);
	return $no_groups;
}
//count no of total my groups
function total_groups($id){
	$sql_total = "SELECT groups.* FROM users_groups left outer join groups on users_groups.group_n=groups.uniq where groups.status='1' AND users_groups.user='".$id."' OR groups.user_uniq='".$id."' group by  groups.id";
	$exec_total = mysql_query($sql_total);
	$total_groups = mysql_num_rows($exec_total);
	return $total_groups; 
}
//count no of joined groups
function joined_groups($id){
	$sql_j = "SELECT groups.* from users_groups left outer join groups on groups.uniq=users_groups.group_n where groups.status='1' AND users_groups.user='".$id."' AND groups.user_uniq !='".$id."' ";
	$exec_j = mysql_query($sql_j);
	$joined = mysql_num_rows($exec_j);
	return $joined;
}

// count no of unread group message
function unread_message($uniq){
	$sql_unread = "SELECT count(*) from message where user_uniq_receiver='".$uniq."' AND status=0";
	$exec_unread = mysql_query($sql_unread);
	list($unread_mesg) = mysql_fetch_row($exec_unread);
	return $unread_mesg;
}
// count TOAL no of neighbour 
function total_frnd($id){
	$sql_tfrnd = "select count(*) from friend_list where (user='".$id."') OR (friend='".$id."')";
	$exec_tfrnd = mysql_query($sql_tfrnd);
	list($tfrnd) = mysql_fetch_row($exec_tfrnd);
	return $tfrnd;
}

//for no of college contact
function my_college_contact($uniq){
	$sql_tfrnd = "select count(*) from friend_list where (user='".$uniq."') OR (friend='".$uniq."') AND user_type='0'";
	$exec_tfrnd = mysql_query($sql_tfrnd);
	list($tfrnd) = mysql_fetch_row($exec_tfrnd);
	return $tfrnd;
}

//for check already group joined
function check_alredyjoined_group($user_id, $group_id){
	$sql_joined = "select count(*) from users_groups where user='".$user_id."' AND group_n='".$group_id."' ";
	$exec_joined = mysql_query($sql_joined);
	list($fetch_joined) = mysql_fetch_row($exec_joined);
	return $fetch_joined;
}

//for total no of user of group
function no_of_groupuser($group_id){
	$sql_tu = "select count(*) from users_groups where group_n='".$group_id."' AND blocked='0'";
	$exec_tu = mysql_query($sql_tu);
	list($fetch_tu) = mysql_fetch_row($exec_tu);
	return $fetch_tu;
}

?>