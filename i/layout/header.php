<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Language" content="EN">

<base href="https://digitalfarmingtonmap.org">
<?php error_reporting(0); ?>



<title>Stanley-Whitman House<?php echo $admin ? " - Admin" : ""; ?></title>
<!-- <script type="text/javascript" src="js/html5iePatch.js"></script> -->

<link rel="icon" type="image/x-icon" href="/favicon.ico?"/>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script src="lib/angular/angular.min.js"> </script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

<link rel="stylesheet" href="css/style.css" />
<link href="css/reset.css" rel="stylesheet" type="text/css" />
<link href="css/default.css" rel="stylesheet" type="text/css" />
<link href="css/utility.css" rel="stylesheet" type="text/css" />
<script src="js/default.js"></script>
<script src="js/utility.js"></script>
<script src="js/rotator.js"></script>
<link href="css/rotator.css" rel="stylesheet" type="text/css" />
<?php 
//VARIABLES ARE USED BUT WHEN NEED TO FIND WHERE THEY ARE DEFINED!!!
if($login){
	echo "<link href='a_css/login.css' rel='stylesheet' type='text/css' />";
	echo "<link href='//fonts.googleapis.com/css?family=Lato:100,300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>";}
if($admin){
	echo "<link href='a_css/admin.css' rel='stylesheet' type='text/css' />";
	echo "<script src='js/admin.js'></script>";
	echo "<link href='a_css/sortItems.css' rel='stylesheet' type='text/css' />";
	require_once("i/layout/tinyMCE.php");}
if($adminManager){
	echo "<link href='a_css/adminManager.css' rel='stylesheet' type='text/css' />";
	echo "<script src='js/adminManager.js'></script>";}
if($poiModule){
	echo "<link href='a_css/poiModule.css' rel='stylesheet' type='text/css' />";
	echo "<script src='js/galleryModule.js'></script>";
	echo "";
	}
if($poiList)
	echo "<link href='a_css/poiList.css' rel='stylesheet' type='text/css' />";
if($categoryModule){
	echo "<link href='a_css/categoryManager.css' rel='stylesheet' type='text/css' />";
	}
?>
<?php  ?>	
