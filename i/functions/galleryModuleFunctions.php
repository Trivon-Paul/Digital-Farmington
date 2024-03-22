<?php
function getGalleries($galleryID = ""){
	global $DBConnect;
	if($galleryID == "") unset($galleryID);
	else $galID = $galleryID;
	
	$query = "SELECT * FROM gallery "; 
	if(isset($galID)){
		$query .= "WHERE id = ".$galID." ";
	}
	$query .= "ORDER BY name ASC";
	
	$result = mysql_query($query, $DBConnect);
	confirmQuery($result);
	
	return $result;
}

function buildGalleryList(){
	$output = "";
	$galleryData = getGalleries();
	
	while ($g = mysql_fetch_array($galleryData)){
		$titles = str_replace("|","",explode("|,|",$g['title']));
		$images = str_replace("|","",explode("|,|",$g['image']));
		$captions = str_replace("|","",explode("|,|",$g['caption']));
		
		$output .= "<a class='dash_gallerySelect' href='admin.php?g=".$g['id']."'>
						<div id='gallery".$g['id']."' class='galleryListing'>
							<div class='galleryName'>
								<h3>".$g['name']."</h3>
							</div>
							<div class='row' style='line-height:0px;'>
								<div class='col description'>".$g['description']."</div>
							</div>
							<div class='row imageThumb'>";
								for($i=0; $i < min(count($titles),8); $i++){
													$cIMG = str_replace("/app/u/","/app/thumbs/",$images[$i]);

									$output .= "<div class='col'><div class='image'><img src='".$cIMG."' /></div></div>";
								}
			if((count($titles) - 8) > 0){
				$output .= "<div class='col'><div class='more'>+".(count($titles) - 8)."<br />More</div></div>";
			}
		$output .="</div></div></a>";
	}
	return $output;
}

function getGalleryList(){
	global $DBConnect;
	
	$query = "SELECT name,id FROM gallery ORDER BY name ASC";
	
	$result = mysql_query($query, $DBConnect);
	confirmQuery($result);
	
	return $result;
}


?>