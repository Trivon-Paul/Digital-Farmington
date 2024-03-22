<?php
    //This needs to be modified to provide better feedback for upload issues
	$fileUploaded = array();
	if(isset($_FILES['fileUpload'])){
		//File Save Location		
		$rootDir = "../../u/POI_". $_POST['poiGalleryForm'];
		
		if(!is_dir($rootDir)) mkdir($rootDir);
		
		$fileName = $_FILES['fileUpload']['tmp_name'];
		$targetFile = escapeSpecials($_FILES['fileUpload']['name']);
		$targetLocation = $rootDir;
		if(move_uploaded_file($fileName,$rootDir."/".$targetFile)){
            $_SESSION['message']= "File Uploaded Successfully<br/>";
			// $message .= "File Uploaded Successfully<br />";
		} else {
			$error .= $_FILES['fileUpload']['error'];
			$_SESSION['message'] = "Upload Failed. Please Try Again <br/>";
			//$_SESSION['message'] .= $upload_errors[$error];
		}
	}

?>
