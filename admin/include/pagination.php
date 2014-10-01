<?php
// Do Not Edit Below. //
	$query_string = array("search" => "$search_txt", "type" => '1', "alb_id" => $alb_id);
	foreach($query_string as $k=>$v){
		$q_string .= "&$k=$v";
	}
	$q_string_pg = $q_string."&page=$page";	
	
if($page == '' || !ctype_digit($page)){ $page='1';}
$stcom = ($page - 1) * $perpage;
$num_sel=mysql_query($sqlq);
$num=mysql_num_rows($num_sel);
if($stcom >$num){ header("Location: $namep?page=1");}
$z = $num / $perpage;
$pg_n=(int)$z;
	if($pg_n<>$z){
	$pg_n++;
	}
if($pg_n=='0'){$pg_n='1';}
$prev=$page-1;
$nex=$page+1;
if($page=='1'){$ps="<span class='disabled_tnt_pagination'>&laquo; Prev</span>";}
else{$ps="<a href='$namep?page=$prev&order=$order&field=$field&search=$search_txt$p_var$q_string_pg' title='previous'>&laquo; Prev</a>";}
if($page==$pg_n){$nx="<span class='disabled_tnt_pagination'>Next &raquo;</span>";}
else{$nx="<a href='$namep?page=$nex&order=$order&field=$field&search=$search_txt$p_var$q_string_pg' title='next'>Next &raquo;</a>";}

	$tot = $pg_n;	
	$const_c = $curr = $page;
	
	if($curr > 6){
		$arr[0] = 1;
		$arr[1] = 2;
		$arr[2] = 3;
		$arr[3] = '...';
		$arr[4] = $curr - 2;
		$arr[5] = $curr - 1;
		$arr[6] = $curr;
		$i = 7;
	}
	else{
		$i = '0';	$j = 1;
		while($i<$curr){
			$arr[$i] = $j;
			$j++; $i++;
		}
	}
	
	if($curr < $tot - 5){
		$arr[$i] = $curr + 1;
		$arr[$i+1] = $curr + 2;
		$arr[$i+2] = '...';
		$arr[$i+3] = $tot - 2;
		$arr[$i+4] = $tot - 1;
		$arr[$i+5] = $tot;
	}
	else{
	
		while($curr < $tot){
			$arr[$i] = $curr + 1;
			$i++; $curr++;
		}
	}
	
	$k='1';	$l='0';		$cnt = count($arr);
		while($l < $cnt){
			if($arr[$l]==$const_c){$pgs[$l]="<span class='active_tnt_link'>$arr[$l]</span>";}
			else if($arr[$l]=='...'){$pgs[$l]="$arr[$l]";}
			else{$pgs[$l]="<a href='$namep?page=$arr[$l]&order=$order&field=$field&search=$search_txt$p_var$q_string_pg'>$arr[$l]</a>";}
			$k++; 
			$l++;
		}
	
/*
$k='1';	$l='0';
while($k<=$pg_n){
	if($k==$page){$pgs[$l]="<li  class='less3'><a id='active' href='#'>$k</a>";}
	else{$pgs[$l]="<li class='less3'><a href='$namep?page=$k&order=$order&field=$field&search=$search_txt'>$k</a></li>";}
$k++; 
$l++;
}
*/
?>