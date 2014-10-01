<div id="tnt_pagination">
  <div align="center">
    <?php 
	if($l > '1'){
	 echo $ps.' ';	$m='0';
	
	 while($m < $l){echo $pgs[$m].' ';	$m++;}
	
	 echo $nx.' ';
	}
	?>
  </div>
</div>
