<?php
	include "init.php";
	include "config_db.php";
	include "config.php";
//	include "include/functions.php";
	
	//for page content
	$sql_exec = select_query_without_status('content', '', '', "id='2'");
	$fetch_abt = mysql_fetch_assoc($sql_exec);
	
	//for sildeshow
	$sql_sld = select_query('slideshow', '', 'sort ASC', "");
	

	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Wooden Timber Pens and Stylus | Kevs Handcrafted Pens</title>

<?php include "include/head.php"; ?>
<link href="css/slider.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script> 
<!-- use jssor.slider.mini.js (39KB) or jssor.sliderc.mini.js (31KB, with caption, no slideshow) or jssor.sliders.mini.js (26KB, no caption, no slideshow) instead for release --> 
<!-- jssor.slider.mini.js = jssor.sliderc.mini.js = jssor.sliders.mini.js = (jssor.core.js + jssor.utils.js + jssor.slider.js) --> 
<script type="text/javascript" src="js/jssor.core.js"></script> 
<script type="text/javascript" src="js/jssor.utils.js"></script> 
<script type="text/javascript" src="js/jssor.slider.js"></script> 
<script>
        jQuery(document).ready(function ($) {
            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $ThumbnailNavigatorOptions: {
                    $Class: $JssorThumbnailNavigator$,              //[Required] Class to create thumbnail navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always

                    $Loop: 2,                                       //[Optional] Enable loop(circular) of carousel or not, 0: stop, 1: loop, 2 rewind, default value is 1
                    $SpacingX: 3,                                   //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
                    $SpacingY: 3,                                   //[Optional] Vertical space between each thumbnail in pixel, default value is 0
                    $DisplayPieces: 6,                              //[Optional] Number of pieces to display, default value is 1
                    $ParkingPosition: 204,                          //[Optional] The offset position to park thumbnail,

                    $ArrowNavigatorOptions: {
                        $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                        $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                        $AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                        $Steps: 6                                       //[Optional] Steps to go for each navigation request, default value is 1
                    }
                }
            };

            var jssor_slider1 = new $JssorSlider$("slider1_container", options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth)
                    jssor_slider1.$SetScaleWidth(Math.min(parentWidth, 1000));
                else
                    window.setTimeout(ScaleSlider, 30);
            }

            ScaleSlider();

            if (!navigator.userAgent.match(/(iPhone|iPod|iPad|BlackBerry|IEMobile)/)) {
                $(window).bind('resize', ScaleSlider);
            }


            //if (navigator.userAgent.match(/(iPhone|iPod|iPad)/)) {
            //    $(window).bind("orientationchange", ScaleSlider);
            //}
            //responsive code end
        });
    </script> 
<!-- Jssor Slider Begin --> 

</head>
<body>
<!--header start-->
<?php $arr['home'] = 'class="active"'; include "include/header.php"; ?>
<!--header end--> 
<!--section start-->

<section class="slide_vidoes">
  <div class="wrapper">
    <div class="banner_row">
    <div id="slider1_container" style="position: relative; width: 720px; height: 300px; overflow: hidden;"> 
  
  <!-- Loading Screen -->
  <div u="loading" style="position: absolute; top: 0px; left: 0px;">
    <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                background-color: #000; top: 0px; left: 0px;width: 100%;height:100%;"> </div>
    <div style="position: absolute; display: block; background: url(img/loading.gif) no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%;"> </div>
  </div>
  
  <!-- Slides Container -->
  <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 720px; height: 480px; overflow: hidden;">
  <?php while($fetch_sld = mysql_fetch_assoc($sql_sld)){ ?>
    <div> <img u="image" src="pics/<?php echo $fetch_sld['image']; ?>" /> <img u="thumb" src="thumb/<?php echo $fetch_sld['image']; ?>" /> </div>
    <?php } ?>
  </div>
  
  <!-- Thumbnail Navigator Skin Begin -->
  <div u="thumbnavigator" class="jssort07" style="position: absolute; width: 720px; height: 100px; left: 0px; bottom: 0px; overflow: hidden; margin-bottom:-17px;">
    <div style=" <?php /*?>background-color: #000;<?php */?> filter:alpha(opacity=30); opacity:.3; width: 100%; height:100%;"></div>
    <!-- Thumbnail Item Skin Begin -->
    <div u="slides" style="cursor: move;">
      <div u="prototype" class="p" style="POSITION: absolute; WIDTH: 99px; HEIGHT: 66px; TOP: 0; LEFT: 0;">
        <thumbnailtemplate class="i" style="position:absolute;"></thumbnailtemplate>
        <div class="o"> </div>
      </div>
    </div>
    <!-- Thumbnail Item Skin End --> 
    <!-- Arrow Navigator Skin Begin -->
        <!-- Arrow Left --> 
    <span u="arrowleft" class="jssora11l" style="width: 37px; height: 37px; top: 123px; left: 8px;"> </span> 
    <!-- Arrow Right --> 
    <span u="arrowright" class="jssora11r" style="width: 37px; height: 37px; top: 123px; right: 8px"> </span> 
    <!-- Arrow Navigator Skin End --> 
  </div>
  <!-- ThumbnailNavigator Skin End --> 
  <!-- Trigger --> 
</div>
              <!--<iframe src="slider.js-master/demos-jquery/image-gallery-with-vertical-thumbnail.source.php" style="width:100%; height:480px; border:none;"></iframe>
      <div class="clear"></div>-->
    </div>
  </div>
</section>
<!--section end--> 

<!--section about-->
<section class="about">
  <div class="wrapper">
    <h1 class="heading_pens"><?php echo $fetch_abt['name']; ?> </h1>
    <p class="description"> <?php echo $fetch_abt['content']; ?> </p>
    <a href="about.php" class="read_butt">Read More</a> 
    
    <!-- PayPal Logo --><a href="https://www.paypal.com/au/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/au/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, width=600, height=500'); return false;"><img src="https://www.paypalobjects.com/webstatic/en_AU/mktg/logo/Solutions-graphics-1-184x80.jpg" border="0" alt="PayPal Logo"></a><!-- PayPal Logo -->
    
    </div>
</section>
<!--section about--> 
<!--footer start-->
<?php include "include/footer.php"; ?> 
<!--footer end-->
</body>
</html>