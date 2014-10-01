<?php
	list($width_ip, $height_ip) = getimagesize($path);	// Get width and height
	if($res_ip == 1){
		list($n_height_ip,$n_width_ip) = resize_image($height_ip,$width_ip,$max_height_ip,$max_width_ip);
	}
	else{
		$n_height_ip = $max_height_ip;
		$n_width_ip = $max_width_ip;
	}

	if($extn_ip=="jpeg" || $extn_ip=="jpg" || $extn_ip=="JPEG" || $extn_ip=="JPG"){
		$im_ip=imagecreatefromjpeg($path);
	}
	else if($extn_ip=="png" || $extn_ip=="PNG"){
		$im_ip=imagecreatefrompng($path);
	}
	else if($extn_ip=="gif" || $extn_ip=="GIF"){
		$im_ip=imagecreatefromgif($path);
	}
	$width_ip=ImageSx($im_ip); // Original picture width is stored
	$height_ip=ImageSy($im_ip); // Original picture height is stored
	$newimage_ip=imagecreatetruecolor($n_width_ip,$n_height_ip);
	imagecopyresampled($newimage_ip,$im_ip,0,0,0,0,$n_width_ip,$n_height_ip,$width_ip,$height_ip);
	if($extn_ip=="jpeg" || $extn_ip=="jpg" || $extn_ip=="JPEG" || $extn_ip=="JPG"){
		imagejpeg($newimage_ip,$final_ip,100);
	}
	else if($extn_ip=="png" || $extn_ip=="PNG"){
		imagepng($newimage_ip,$final_ip);
	}
	else if($extn_ip=="gif" || $extn_ip=="GIF"){
		imagegif($newimage_ip,$final_ip,95);
	}
	chmod("$final_ip",0777);
?>