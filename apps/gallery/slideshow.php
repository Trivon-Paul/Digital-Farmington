<?php require_once('../i/DB/DBConnect.php'); ?>
<?php require_once('../i/functions/functions.php'); ?>
<?php require_once('../i/functions/queryFunctions.php'); ?>
<?php include("../i/functions/galleryModuleFunctions.php"); ?>
<?php
$gallery_id = $_GET['gallery'];
$gallery_delay = $_GET['delay'];
$gallery_height = $_GET['height'];

$galleryData = getGalleries($gallery_id);
$gallery = mysql_fetch_array($galleryData);

$gallery['image'] = str_replace("|","",explode("|,|",$gallery['image']));
$gallery['sizeRatio'] = str_replace("|","",explode("|,|",$gallery['sizeRatio']));

$slideNum = count($gallery['image']);

?>
<script type="text/javascript">
        //Total Number of Slides
        slideNum = <?php echo $slideNum; ?>;
        slideLag = <?php echo $gallery_delay; ?>;
    </script>
<script type="text/javascript" src="apps/gallery/gallery.js" language="javascript"></script>
<style type="text/css">
#slideshowContainer {
	background:#000;
	position:relative;
	padding:0px;
	margin:0px;
	width:960px;
	height:<?php echo $gallery_height ?>px;
}
#currentSlide {
	position: absolute;
	top: 0px;
	right: 0px;
	bottom: 0px;
	left: 0px;
	text-align: center;
	background: #000;
	z-index: 0;
}
#currentSlide #display img {
	vertical-align: middle;
}
#slideshowContainer .hideBtn {
	opacity: 0.2;
	transition: opacity 0.2s;
}
#slideshowContainer .hideBtn:hover {
	opacity: 1;
}
#slideshowContainer #next {
	position: absolute;
	right: 0px;
	top: 50%;
	margin: -20px 0px;
	height: 40px;
	width: 40px;
	padding: 10px 10px;
	z-index: 30;
}
#slideshowContainer #prev {
	position: absolute;
	left: 0px;
	top: 50%;
	margin: -20px 0px;
	height: 40px;
	width: 40px;
	padding: 10px 10px;
	z-index: 30;
}
#playPauseAnim {
	right: 0px;
	background: URL(apps/gallery/pause.png) center center no-repeat rgba(0, 0, 0, 0.5);
	width: 70px;
	height: 80px;
	margin: -40px auto;
	position: absolute;
	top: 50%;
	z-index: 123412341234;
	opacity: 1;
	border-radius: 12px;
	left: 0px;
	display:none;
}
</style>
<div id="slideshowContainer" class="slides<?php echo $slideNum ?>">
  <div id="prev" class="hideBtn clickable" onClick="prevImageAndPause()"><img src="apps/gallery/prevSlide.png"></div>
  <div id="next" class="hideBtn clickable" onClick="nextImageAndPause()"><img src="apps/gallery/nextSlide.png"></div>
  <div id="playPauseAnim"></div>
  <div id="currentSlide" onClick="togglePlay();">
    <?php $imgID=1; ?>
    <?php 
		for($i=1; $i < $slideNum; $i++){
			echo "<img src='".$gallery['image'][$i]."' data-imgRatio='".$gallery['sizeRatio'][$i]."' id='rotator".$i."' />";
			$imgID++;
		}
	?>
  </div>
</div>
