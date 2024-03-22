<?php require_once('../i/DB/DBConnect.php'); ?>
<?php require_once('../i/functions/functions.php'); ?>
<?php require_once('../i/functions/queryFunctions.php'); ?>
<?php include("../i/functions/galleryModuleFunctions.php"); ?>
<?php
$gallery_id = $_GET['gallery'];
$gallery_type = $_GET['type'];
$gallery_imgWidth = ($_GET['w'] > 0) ? $_GET['w'] : "30";
$imgAlign = empty($_GET['a']) ? "left" : "right";

if(isset($_GET['embed']))
	$embed=true;

$galleryData = getGalleries($gallery_id);

?>
<?php if(!$embed) { ?> 
	<title><?php echo $gallery['name']; ?></title>
<?php } ?>
<?php if(!$embed) { ?> 
<style type="text/css">
.gallery_OutputList{
	width:100%;
}
.gallery_OutputList div.g_imageObject{
	display:table;
	padding:10px;
	margin-bottom:10px;
}
.gallery_OutputList div.g_imageObject .image{
	display:table-cell;
	width:<?php echo $gallery_imgWidth ?>;
}
.gallery_OutputList div.g_imageObject .image img{
	width:100%;
	height:auto;
}
.gallery_OutputList div.g_imageObject .caption{
	display:table-cell;
	vertical-align:top;
	width:<?php echo (100-$gallery_imgWidth) ?>;
}
<?php } ?>
<?php if($embed) { ?> 
<?php } ?>
</style>
<?php if(!isset($_GET['embed'])){ ?>
	</head><body>
<?php } ?>
<?php 
	while ($g = mysql_fetch_array($galleryData)){
		$titles = str_replace("|","",explode("|,|",$g['title']));
		$images = str_replace("|","",explode("|,|",$g['image']));
		$captions = str_replace("|","",explode("|,|",$g['caption']));
		
		$output .= "<div id='gallery".$g['id']."' class='gallery_OutputList' style='width:100%;'>
						<div class='galleryInfo'>
							<h2>".$g['name']."</h2>
							<p>".$g['description']."</p>
						</div>";
			for($i=0; $i < count($titles); $i++){
				$output .= "<div class='g_imageObject' style='width:100%; padding:10px 0px; margin-bottom:10px; clear:both;'>
								<h4>".$titles[$i]."</h4>
									<img src='".$images[$i]."' class='image' width='".$gallery_imgWidth."%' style=' width:".$gallery_imgWidth."%; display:block; padding-right:8px; float:".$imgAlign.";' />
								<div class='caption' style='display:block; overflow:hidden; padding-left:10px;'>".
									$captions[$i]."
								</div>
							</div>";
			}
		$output .="</div></div>";
	}
	echo $output;
?>
<?php if(!isset($_GET['embed'])){ ?>
    </body>
    </html>
<?php } ?>


