<?php require_once('../../i/DB/DBConnect.php'); ?>
<?php $admin = true; ?>
<?php require_once('../../i/functions/functions.php'); ?>
<?php require_once('../../i/functions/queryFunctions.php'); ?>
<?php require_once('../../i/DB/session.php'); ?>
<?php


//------------------------------------------------------
//-------------POI MODULE------------------------------
//------------------------------------------------------
if(isset($_POST['poiForm'])){
	//create News Post
	if($_POST['newPOI'] == '1')
		include('POICreate.php');
	//update News Post
	if($_POST['newPOI'] == ""){
	    //echo "Update";
		include('POIUpdate.php');
		//error_reporting(E_ALL);
	}
	//Delete Post
	if(isset($_POST['deletePOI'])){
		$_SESSION['deletePOI'] = $_POST['poiID'];
		redirect('POIDelete.php');
	}
	//echo '../../admin.php?poi='.$_POST['poiForm'];
	redirect('../../admin.php?poi='.$_POST['poiForm']);
}




if(isset($_POST['adminUserForm'])){
	include('../../adminModule/functions/adminManagerFunctions.php');

	//create Admin User
	if(isset($_POST['adminCreate']))
		include('adminUserCreate.php');
	//update Admin User
	if(isset($_POST['adminEdit']))
		include('adminUserUpdate.php');
	//remove Admin User
	if(isset($_POST['adminDelete'])){
		$_SESSION['deleteAdminUser'] = $_POST['adminDelete'];
		redirect('adminUserDelete.php');
	}
	redirect('../../admin.php?u='.$_POST['adminUserForm']);
}
//------------------------------------------------------
//-------------GALLERY MODULE------------------------------
//------------------------------------------------------

if(isset($_POST['poiGalleryForm'])){
	//upload File
	if(isset($_POST['uploadFile']))
		include('poiGalleryUpload.php');
	//update Gallery Order
	if(isset($_POST['sortOrder']))
		include('updateOrder.php');
	//remove Gallery
	if(isset($_POST['deletePOIImage'])){
		$_SESSION['deleteImage'] = $_POST['deletePOIImage'];
		unlink("../../".$_SESSION['deleteImage']);
	}
	redirect('../../admin.php?poi='.$_POST['poiGalleryForm']);
}


//------------------------------------------------------
//-------------POI MODULE------------------------------
//------------------------------------------------------
if(isset($_POST['newCategory'])){
	include('categoryCreate.php');
	redirect('../../admin.php?c');
}
if(isset($_POST['updateCategories'])){
	//create News Post
	if(isset($_POST['updateCategories']))
		include('categoryUpdate.php');
	redirect('../../admin.php?c');
}

?>