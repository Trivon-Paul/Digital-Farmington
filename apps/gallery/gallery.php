<?php require_once('i/DB/DBConnect.php'); ?>
<?php require_once('i/functions/functions.php'); ?>
<?php require_once('i/functions/queryFunctions.php'); ?>
<?php include("i/functions/galleryModuleFunctions.php"); ?>
<?php
$gallery_id = $_GET['gallery'];
$gallery_delay = $_GET['delay'];

if(isset($_GET['embed']))
	$embed=true;

$galleryData = getGalleries($gallery_id);
$gallery = mysql_fetch_array($galleryData);

$gallery['image'] = str_replace("|","",explode("|,|",$gallery['image']));
$gallery['sizeRatio'] = str_replace("|","",explode("|,|",$gallery['sizeRatio']));
$gallery['title'] = str_replace("|","",explode("|,|",$gallery['title']));
$gallery['caption'] = str_replace("|","",explode("|,|",$gallery['caption']));
$gallery['thumb'] = str_replace("u/","thumbs/",$gallery['image']);

$slideNum = count($gallery['title']);

?>
<title><?php echo $gallery['name']; ?></title>
<script type="text/javascript">
	//Total Number of Slides
	slideNum = <?php echo $slideNum; ?>;
	slideLag = <?php echo $gallery_delay; ?>;
</script>
<script type="text/javascript" src="apps/gallery/gallery.js" language="javascript"></script>
<script type="text/javascript">
function taller(element){
	if($("#"+element).css("height") != "400px"){
		$("#"+element).animate({height:"400px"},500,"easeInOutQuad");
		$("#"+element).css("z-index","40");
	}
	else if($("#"+element).css("height") == "400px"){
		$("#"+element).animate({height:"65px"},500,"easeInOutCubic",function(){		
			$("#"+element).css("z-index","30");
		});
	}
}
function wider(){
	if($("#selector").css("width") != "400px"){
		
		$("#selector").animate({left:"-400px",width:"400px"},100,"easeInOutQuad")
		$("#sliderTag").animate({left:"0px"},100,"easeInOutQuad",function(){
			$("#selector figure").css({"width":"70px","height":"45px","margin":"5px 10px","line-height":"45px"});
			$("#selector figure img").css("width","70px");
			$("#sliderTag").animate({left:"400px"},500,"easeInOutQuad");
			$("#selector").animate({left:"0px"},500,"easeInOutQuad");
		});

	}
	else {
		$("#selector").animate({left:"-400px"},100,"easeInOutQuad")
		$("#sliderTag").animate({left:"0px"},100,"easeInOutQuad",function(){
			$("#selector").css({"width":"100px","left":"-100px"});
			$("#selector figure").css({"width":"40px","height":"30px","margin":"5px auto","line-height":"30px"});
			$("#selector figure img").css("width","40px");
			$("#sliderTag").animate({left:"100px"},500,"easeInOutQuad");
			$("#selector").animate({left:"0px"},500,"easeInOutQuad");
		});
	}
}
</script>
<style type="text/css">
body {
	background: #000;
}
.clickable {
	cursor: pointer;
}
* {
	box-sizing: border-box;
}
#selector {
	position: fixed;
	top: 0px;
	bottom: 0px;
	left: 0px;
	width: 120px;
	background: #333;
	overflow: auto;
	overflow-x: hidden;
	overflow-y: auto;
	z-index: 30;
}
#selector #playPause {
	width: 35px;
	height: 35px;
	margin: 10px auto 10px;
	background: url(apps/gallery/pause.png) no-repeat;
}
#selector #thumbs {
	overflow: auto;
	overflow-x: hidden;
	overflow-y: auto;
	padding: 8px;
}
#selector #thumbs .active {
	outline: solid 3px #ee2;
}
#sliderTag {
	position: absolute;
	z-index: 100;
	top: 5px;
	left: 120px;
	background: rgba(022,022,022,1);
	border-radius: 0px 4px 4px 0px;
	padding: 2px 6px;
	width: 22px;
	color: #fff;
}
#selector figure {
	display: inline-block;
	margin: 5px auto;
	width: 40px;
	height: 30px;
	background: #000;
	overflow: hidden;
	line-height: 30px;
}
#selector figure img {
	vertical-align: middle;
}
#selector figure figcaption {
	display: none;
}
#selector figure:hover figcaption {
	display: block;
}
#currentSlide {
	position: fixed;
	top: 0px;
	right: 0px;
	bottom: 0px;
	left: 120px;
	padding: 20px;
	text-align: center;
	background: #000;
	z-index: 0;
}
#currentSlide #display {
	position: absolute;
	top: 20px;
	left: 40px;
	right: 40px;
	bottom: 85px;
	z-index: 20;
}
#currentSlide #display img {
	vertical-align: middle;
}
#currentSlide #information {
	position: absolute;
	bottom: 0px;
	height: 65px;
	left: 0px;
	right: 0px;
	background: #000;
	border-top: solid 1px #fff;
	color: #fff;
	font-size: 14px;
	line-height: 120%;
	font-family: Arial, Helvetica, sans-serif;
	text-align: left;
	padding: 8px;
}
#currentSlide .hideBtn {
	opacity: 0.2;
	transition: opacity 0.2s;
}
#currentSlide .hideBtn:hover {
	opacity: 1;
}
#currentSlide #next {
	position: absolute;
	right: 0px;
	top: 50%;
	margin: -20px 0px;
	height: 40px;
	width: 40px;
	padding: 10px 10px;
	z-index: 30;
}
#currentSlide #prev {
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
	position: fixed;
	top: 50%;
	z-index: 123412341234;
	opacity: 1;
	border-radius: 12px;
	left: 0px;
	display:none;
}
<?php if($embed) {
?> #selector, #information, #sliderTag {
 display:none !important;
}
#currentSlide {
 left:0px;
}
#currentSlide #display {
 bottom:0px;
 top:0px;
 left:0px;
 right:0px;
}
<?php
}
?>
</style>
</head><body>
<div id="sliderTag" class="clickable" onClick="wider()"> &gt; </div>
<div id="selector">
  <div id="playPause" class="clickable" onClick="togglePlay();"></div>
  <div id="thumbs">
    <?php $imgID=0; ?>
    <?php 
            for($i=0; $i < $slideNum; $i++){
                echo "
                  <figure class='clickable' data-imgID='".$imgID."' data-imgSRC='".$gallery['image'][$i]."' data-imgRatio='".$gallery['sizeRatio'][$i]."' onClick=\"nextImageAndPause('".$imgID."')\" ><img src='".$gallery['thumb'][$i]."' style='width:40px;' />
                    <figcaption>".$gallery['title'][$i] . "<br />" . $gallery['caption'][$i]."</figcaption>
                  </figure>";
                $imgID++;
            }
        ?>
  </div>
</div>
<div id="currentSlide">
  <div id="prev" class="hideBtn clickable" onClick="prevImageAndPause()"><img src="apps/gallery/prevSlide.png"></div>
  <div id="next" class="hideBtn clickable" onClick="nextImageAndPause()"><img src="apps/gallery/nextSlide.png"></div>
  <div id="playPauseAnim"></div>
  <div id="display" <?php echo $embed ? "onClick=\"togglePlay();\"" : "" ?>><img src="" id="mainImage" /></div>
  <div id="information" onClick="taller('information');"></div>
</div>
</body>
</html>