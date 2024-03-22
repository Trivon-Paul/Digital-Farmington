<?php require_once('../DB/DBConnect.php'); ?>
<?php require_once('../functions/functions.php'); ?>
<?php require_once('../functions/queryFunctions.php'); ?>
<?php require_once('../DB/session.php'); ?>
<?php 
if(isset($_SESSION['deletePOI']) && isset($_SESSION['deletePOI'])){
	global $DBConnect;
	$id = $_SESSION['deletePOI'];
	unset($_SESSION['deletePOI']);
	
		
	$query1 = "DELETE FROM poi WHERE id = ? LIMIT 1";
	$query2 = "DELETE FROM z_poi_cat WHERE poiID = ? ";
	
	$result1;
	$result2;
	$stmt = mysqli_stmt_init($DBConnect);
	if(mysqli_stmt_prepare($stmt, $query1)){
		mysqli_stmt_bind_param($stmt, "i", $id );
		$result1 = mysqli_stmt_execute($stmt);

	}

	if(mysqli_stmt_prepare($stmt, $query2)){
		mysqli_stmt_bind_param($stmt, "i", $id );
		$result2 = mysqli_stmt_execute($stmt);
	}
	if ($result1 && $result2){
		$_SESSION['message'] = "Deleted Successfully";
		$directory = '../../u/POI_'.$id;
		recursiveRemoveDirectory($directory);
		redirect('../../admin.php?poi');
	} else {
		// DELETE Failed
		$_SESSION['message'] =  "Deletion Failed.<br />";
		$_SESSION['message'] .=  mysqli_error($DBConnect) ;
		redirect('../../admin.php?poi');

	}
} else{
	unset($_SESSION['deletePOI']);
	redirect('../../admin.php');
  }

		function recursiveRemoveDirectory($directory){
			foreach(glob($directory."/*") as $file){
				if(is_dir($file)) { 
					recursiveRemoveDirectory($file);
				} else {
					unlink($file);
				}
			}
			if(is_dir($directory)) rmdir($directory);
		}
		mysqli_stmt_close($stmt);
?>