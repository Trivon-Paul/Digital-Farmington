<?php
function getAdminUserID($userID){
	global $DBConnect;

	$query = "SELECT * FROM admin WHERE id='".$userID."' LIMIT 1";
	// $result = mysql_query($query, $DBConnect);
	$result = mysqli_query($DBConnect, $query);
	confirmQuery($result);
	
	//if no rows are returned, fetch_array will return false
	// Updated to sqli
	if ($user = mysqli_fetch_array($result)){
		return $user;
	} else {
		return NULL;
	}
}

function getAdminUsers(){
	global $DBConnect;

	$query = "SELECT * ";
	$query .="FROM admin ";
	$query .= "ORDER BY name ASC";
	// $userSet = mysql_query($query, $DBConnect);
	$userSet = mysqli_query($DBConnect, $query);
	confirmQuery($userSet);
	
	return $userSet;
}

function buildAdminUsers(){
	global $DBConnect;
	
	$adminUsers = getAdminUsers();
	

	$output = "<div>";
	// Updated to sqli
	//MAY NEED TO UPDATE strtotime
	while ($user = mysqli_fetch_array($adminUsers)){
		
		if($user['id'] != 1){
		
		  if($user["lastLogin"] != "0000-00-00"){
			  $lastTime = strtotime($user["lastLogin"]);
			  $lastTime = strftime("%m/%d/%Y", $lastTime);
		  }else{
			  $lastTime = "<em>User has never logged in</em>";
		  }
		  
		  $output .=  "<a href='admin.php?u=".$user['id']."' class='name'>".$user["name"] . "</a>";
		}
	}
	$output .= "</div>";
	
	return $output;
}

?>
