<?php error_reporting(0); ?>
<?php require_once('i/DB/DBConnect.php'); ?>
<?php require_once('i/functions/functions.php'); ?>
<?php require_once('i/functions/queryFunctions.php'); ?>
<?php require("i/layout/header.php"); ?>

<style>
#container {
	width: 98%;
	margin: 0px auto;
	min-width: 960px;
        top: 30px
}
div#topBanner {
}
div#topBanner {
	height: 80px;
        margin-top: 15px;
	padding: 20px;
	background: #2C53A8;
	border-bottom: solid 1px #000;
}
h1 {
	font-size: 30px;
	color: #FFF;
}
body {
	background: #BA3737;
}
div#mainContent {
	position: absolute;
	width: 98%;
	min-width: 960px;
	bottom: 15px;
	top: 80px;
}
iframe {
	width:100%;
	height:100%;
}
</style>

</head>
<body>
    
<div id="container">
  <div id="topBanner">
    <h1><a href="https://digitalfarmington.org" style="color: white; text-decoration:none;">Digital Farmington</a></h1>
  </div>
  <div id="mainContent">
      <iframe src="/map.php" width="100%" height="600"> 
  </div>
</div>
</body>
</html>
