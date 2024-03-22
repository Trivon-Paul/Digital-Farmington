<?php require_once('utility.php'); ?>
<?php
/*
 * Functions.php contains several more specific functions used by application 
 */

/*
 * Performs query to receive list of categories associated with specific POI
 * NOTE: Not used anywhere in application
 */
function getPOICategory($id){
	global $DBConnect;
	$query = "SELECT category FROM catManager WHERE poiID = {$id} ORDER BY category ASC";
	// Changed $result = mysql_query($query, $DBConnect);
	$result = mysqli_query($DBConnect, $query);
	
	if($result){
	//    Changed to new sqli
		while($cat = mysqli_fetch_array($result)){
			$catList[] .= str_replace("|||"," ",$cat[0]);
		}
	}
	return $catList;
}


/*
 * Returns HTML creating the photo gallery for a given POI. If the gallery is 
 * built on the map, a slide show is made. If the gallery is built in admin 
 * tools, a list of images is made.
*/
function getGallery($poiID = 1, $frontEnd = false){
	$fileList = getApplicantFiles($poiID, $frontEnd); //Get list of images
	return buildApplicantFiles($fileList, $frontEnd); //Create HTML to display images
}

/*
 * Returns an array of paths for image files (as strings) for a given POI.
 * TODO: imageList var is not used in function. Move to function it is used in.
 * NOTE: Files besides images may be included in list if uploaded. Application 
 * may enter bad state if non-image files are included.
 */
function getApplicantFiles($poiID, $frontEnd){
	$imageList = array();
	$fileList = [];
        //Directory path depends on certain circumstances
	if($frontEnd)	$poiDir = "../u/POI_".$poiID;
	else			$poiDir = "u/POI_".$poiID;
	
		//For each non-hidden file in directory, add it to file list.
	if(is_dir($poiDir)){
		$poiDirList = scandir($poiDir);
		foreach($poiDirList as $file){
			if(stripos($file, '.') > 0){				
				$fileList[] = escapeSpecials($poiDir . "/" . $file);
			}
		}
	}
	else{
		$fileList[] = NULL;
	}
	return $fileList;

}

/*
 * Given a list of files, function creates and returns the HTML to show images 
 * within an embedded slideshow when done on map (frontend is true) or within a 
 * list when done on admin tools (frontend is false).
 * TODO: Remove blinking of images when only 1 image is provided.
 */
function buildApplicantFiles($fileList, $frontEnd){
	if($fileList)
		if($frontEnd){ //If loaded on map, slide show is created
		
			$i = 1;
		 if(count($fileList)==1){
			foreach($fileList as $file){
				$fileOutput = "<div><div>";
				$fileName = explode("/",$file);
				$fileOutput .= "<img src='" . $file ."' width = 200 height = 150 style='display: block;'>";
				$i++;
			}
		 }
		 else{
		 $fileOutput = "<div id='sub_rotator'><div class='rotator_image'>";
			foreach($fileList as $file){
				$fileName = explode("/",$file);
				$fileOutput .= "<img src='" . $file ."' class='slide".$i."' style='display: block;'>";
				$i++;
			}
		}
			$fileOutput .= "</div></div>";
		}else{    //If loaded on admin tools, list of images is created
		  if(current($fileList)!=NULL){
			$fileOutput = "<div id='imageList'><ul>";
			foreach($fileList as $file){
				$fileName = explode("/",$file);
				$fileOutput .= "<li class='image'><div class='deleteImg clickable' data-filePath=\"".$file."\">X</div>";
				$fileOutput .=  "<a href='" . $file ."' class='popup poiSlide'><img src='" . $file ."' class='poiSlideImg' /></a>";
				$fileOutput .=   "</li>";
			}
			$fileOutput .= "</ul></div>";
		  }
		}
	if(current($fileList)==NULL && $frontEnd){
		$file = "../u/default.jpg";
		$fileOutput = "<img src='" . $file ."' style='display: block;'>";
		return $fileOutput;
	}
	return $fileOutput;

}



