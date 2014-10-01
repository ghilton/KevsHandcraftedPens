<?php
	list($width, $height) = getimagesize($path);	// Get width and height
	if($res == 1){
		list($n_height,$n_width) = resize_image($height,$width,$max_height,$max_width);
	}
	else{
		$n_height = $max_height;
		$n_width = $max_width;
	}

	if($extn=="jpeg" || $extn=="jpg" || $extn=="JPEG" || $extn=="JPG"){
		$im=imagecreatefromjpeg($path);
	}
	else if($extn=="png" || $extn=="PNG"){
		$im=imagecreatefrompng($path);
	}
	else if($extn=="gif" || $extn=="GIF"){
		$im=imagecreatefromgif($path);
	}
	$width=ImageSx($im); // Original picture width is stored
	$height=ImageSy($im); // Original picture height is stored
	$newimage=imagecreatetruecolor($n_width,$n_height);
	imagecopyresampled($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
	if($extn=="jpeg" || $extn=="jpg" || $extn=="JPEG" || $extn=="JPG"){
		imagejpeg($newimage,$final,100);
	}
	else if($extn=="png" || $extn=="PNG"){
		imagepng($newimage,$final);
	}
	else if($extn=="gif" || $extn=="GIF"){
		imagegif($newimage,$final,95);
	}
	chmod("$final",0777);
?>