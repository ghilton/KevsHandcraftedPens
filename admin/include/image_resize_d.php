<?php
	list($width_d, $height_d) = getimagesize($path_d);	// Get width and height
	if($res_d == 1){
		list($n_height_d,$n_width_d) = resize_image($height_d,$width_d,$max_height_d,$max_width_d);
	}
	else{
		$n_height_d = $max_height_d;
		$n_width_d = $max_width_d;
	}

	if($extn_d == "jpeg" || $extn_d == "jpg" || $extn_d == "JPEG" || $extn_d == "JPG"){
		$im_d = imagecreatefromjpeg($path);
	} 
	else if($extn_d == "png" || $extn_d == "PNG"){
		$im_d = imagecreatefrompng($path);
	}
	else if($extn_d == "gif" || $extn_d == "GIF"){
		$im_d = imagecreatefromgif($path);
	}
	$width_d = ImageSx($im_d); // Original picture width is stored
	$height_d = ImageSy($im_d); // Original picture height is stored
	$newimage_d = imagecreatetruecolor($n_width_d,$n_height_d);
	imagecopyresampled($newimage_d,$im_d,0,0,0,0,$n_width_d,$n_height_d,$width_d,$height_d);
	if($extn_d == "jpeg" || $extn_d == "jpg" || $extn_d == "JPEG" || $extn_d == "JPG"){
		imagejpeg($newimage_d,$final_d,100);
	}
	else if($extn_d=="png" || $extn_d=="PNG"){
		imagepng($newimage_d,$final_d);
	}
	else if($extn_d=="gif" || $extn_d=="GIF"){
		imagegif($newimage_d,$final_d,95);
	}
	chmod("$final_d",0777);
?>