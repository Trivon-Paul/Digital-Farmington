<?php require_once('i/DB/DBConnect.php'); ?>
<?php $admin = true; ?>
<?php require_once('i/functions/functions.php'); ?>
<?php require_once('i/functions/queryFunctions.php'); ?>
<?php require_once('i/DB/session.php'); confirmLogIn()  ?>
<?php

if(isset($_SESSION['message'])){
	$message = $_SESSION['message'];
	unset($_SESSION['message']);
}

//Admin Users Manager
if(isset($_GET['u'])){
	$adminManager = true;
	if(!empty($_GET['u'])){
		$userID = $_GET['u'];
	}
	$newUser = !isset($userID);
}
//Gallery Module
else if(isset($_GET['c'])){
	$categoryModule = true;
	$c = $_GET['c'];
}
//Calendar Module
else if(isset($_GET['poi'])){
	$poiModule = true;
	$poi = $_GET['poi'];
}

require("i/layout/header.php");
?>
</head>
<body>
<?php include('i/layout/adminTopNavBar.php'); ?>
<?php 
//Admin Users Manager
  if($adminManager) 		include('adminModule/adminModule.php');
  else if($categoryModule)	include('categoryModule/categoryModule.php');
  else if($poiModule)		include('poiModule/poiModule.php');

  
  else { include('index.php');} ?>
</body>
</html>