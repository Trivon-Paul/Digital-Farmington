<?php require_once('i/DB/DBConnect.php'); ?>
<?php require_once('i/functions/functions.php'); ?>
<?php require_once('i/functions/queryFunctions.php'); ?>
<?php require_once('i/DB/session.php'); ?>
<?php


require("i/layout/header.php");
?>
<link href="css/default.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.container .imgContainer {
	width:270px;
	height:420px;
	background:#f00;
	margin:6px 24px;
}
.container .text1 {
	width:580px;
	margin:18px;
}
</style>
</head>
<body>
<?php include('i/layout/topBanner.php'); ?>
<div class="mainContainer">
  <div id="mainContent">
    <div id="pageContent">
      <h1>Oops...<br>
404 - Page Not Found</h1>
      <p><a href="home">Click here to return to the Home Page</a></p>
    </div>
  </div>
</div>
<?php include('i/layout/footer.php'); ?>
</body>
</html>