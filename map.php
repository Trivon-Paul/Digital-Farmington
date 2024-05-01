<?php require_once('i/DB/DBConnect.php'); ?>
<?php require_once('i/functions/functions.php'); ?>
<?php require_once('i/functions/queryFunctions.php'); ?>
<?php require_once('poiModule/functions/poiModuleFunctions.php'); ?>
<?php require("i/layout/header.php"); ?>
<script type="text/javascript" src="/js/mapReset.js"></script>
<script type="text/javascript" src="/js/search.js"></script>
<style>
    #resultList li span{
        margin:auto;
        width: 225px;
        padding: 4px 4px 4px 4px;
        margin-bottom: -1px;
        border: 1px solid #000;   
        color: black;
        background-color: white; 
        display: block;
        text-decoration: none;
        cursor: pointer;
    }
    
    #resultList li span:hover{
        background-color: lightblue;
    }
    
    #searchInput{
        display: block;
        margin:auto;
        width: 225px;
        border-radius: 1px;
        font-size: 16px;
        padding: 6px;
        margin-top: 5px;
    }
    
    ::-webkit-scrollbar{
        width: 13px;
    }
    
    ::-webkit-scrollbar-track{
        box-shadow: inset 0 0 6px black;
    }
    
    ::-webkit-scrollbar-thumb{
        background: #0076b5;
        border-radius: 30px;
        border: solid;
        border-width: 1px;
    }
    
    /* Buttons */
    ::-webkit-scrollbar-button
    {
      height: 13px;
      width: 13px;
      background-size: 13px 13px;
      background-color: white;
    }

    ::-webkit-scrollbar-button:vertical:decrement
    {
       background-image: url(/img/scrollUp.png);
    }

    ::-webkit-scrollbar-button:vertical:increment
    {
        background-image: url(/img/scrollDown.png);
    }

    ::-webkit-scrollbar-button:hover{
        background-color: lightgrey;
    }

    div.gm-style-mtc {
        display: none;
    }

    
</style>
</head>
<body>
<div id="resetMap" class="clickable">Reset Map</div>
<div id="pip-pano"></div>
<div id="map-canvas" <?php echo $admin ? "style='top:46px;'" : ""; ?>></div>
<div id="rightBanner" <?php echo $admin ? "style='top:46px;'" : ""; ?>>
  <div id="categories">
    <h2>Categories</h2>
    <?php echo buildCategoryList(array(),$frontEnd = true); ?> 
  </div>
  <div id="search">
      <div id="searchBar">
          <form>
              <input type="text" name="search" id="searchInput" placeholder="Enter Keyword to Search">
                     <!-- padding: 12px 12px 12px 12px; margin: 16px 12px 12px 12px" -->
          </form>
      </div>
      <div id="searchResults">
          <ul id="resultList">
              
          </ul>
      </div>
  </div>
</div>
<div id="bottomBanner">
<div id="btmBannerHide" class="clickable">Close</div>
<?php if($admin) { ?>
<div id="adminBtns">
<a href="admin.php?poi" id="editPOI">Edit This POI</a>
<form name="deletePOI" action="/i/process/processor.php" method="post" style="display:inline-block">
<input type="hidden" name="poiForm" value="">
<input type="hidden" id="poiIDDeleter" name="poiID" value="">
<input type="submit" name="poiDelete" id="deletePOI" value="Delete" class="clickable" />
</form>
</div>
<?php }?>
<div id="thumbnails"> </div>
<div id="descArea"></div>
</div>
<div id="timeline">
  <div id="slider"></div>
</div>


 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzEuoJaOcio4btLm3g681cowFWsZF6WkQ"></script>
<!-- Below script was previous map api --Chelsea !--> 
<!-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script> !-->
<script src="js/dataFunctions.js"></script> 
<script src="js/markerCluster.js"></script> 
<script src="js/List.js"></script> 
<script src="js/Mapster.js"></script> 
<script src="js/map_option.js"></script> 
<script src="js/jqueryui.mapster.js"></script>
<script src="js/app.js"></script>
</body>
</html>
