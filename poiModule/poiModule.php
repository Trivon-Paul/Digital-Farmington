<?php 
	include('functions/poiModuleFunctions.php');
	
	if(empty($poi) && !isset($_GET['new']))
		$poiList = true;
	else if(!empty($poi))
		$poiData = mysqli_fetch_array(getPoiID($poi));
	
	if(isset($_GET['new'])){
		$newPOI = true;
		$poiData['startDate'] = 1900;
		$poiData['endDate'] = 2000;
	}
	?>
<style>
    html, body{
        overflow: auto;
    }
    </style>
<script type="text/javascript">
$(function() {
	$('#poiFormShell').on("submit",function(){updateCategories()});
	$('#address').change(function(){
		toggle("locationFinder");
	});
	
	
	$( "#slider-range" ).slider({
	  range: true,
	  min: 1610,
	  max: 2025,
	  values: [ <?php echo $poiData['startDate'] ?>, <?php echo $poiData['endDate'] ?> ],
	  step: 1,
	  slide: function( event, ui ) {
		  var startLeft = "<div id='startDateDisplay' class='sliderDisplay'>"+ui.values[ 0 ]+"</div>";
		  var endLeft = "<div id='endDateDisplay' class='sliderDisplay'>"+ui.values[ 1 ]+"</div>";
		  
		  $('#slider-range span:first-of-type').html(startLeft);
		  $('#slider-range span:last-of-type').html(endLeft);
	  },
	  change: function(event, ui) {
		  // when the user change the slider
		  $( "#startDate" ).val( $( "#slider-range" ).slider( "values", 0 ) ); 
		  $( "#endDate" ).val( $( "#slider-range" ).slider( "values", 1 ) );
		  sliderHeaderSet();
	  },
	});
	sliderHeaderSet();

});

function sliderHeaderSet(){
	var startLeft = "<div id='startDateDisplay' class='sliderDisplay'>"+$( "#slider-range" ).slider( "values", 0 )+"</div>";
	var endLeft = "<div id='endDateDisplay' class='sliderDisplay'>"+$( "#slider-range" ).slider( "values", 1 )+"</div>";

		$('#slider-range span:first-of-type').html(startLeft);
		$('#slider-range span:last-of-type').html(endLeft);

}
  


  </script>
<div id="moduleContainer">
  <?php 
if ($poiList) { include("poiList.php"); }else{
    echo '<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcUUU8sL2VxqUe_-F7d2VKMobgVoYYsxE"></script>
<script  src="poiModule/functions/mapHelper.js" type="text/javascript"></script>';
?>
    
  <!--action="/i/process/processor.php" -->
  <form name="poiForm" id="poiForm" action="/i/process/processor.php" method="post">
    <input type="hidden" name="formName" value="poiForm" />
    <input type="hidden" name="poiForm" value="<?php echo $poiData['id'] ?>" />
    <input type="hidden" name="poiID" value="<?php echo $poiData['id'] ?>" />
    <input type="hidden" name="newPOI" value="<?php echo $newPOI; ?>" />
    <input type="hidden" id="noname" value="" />
    <div id="moduleNav">
      <div class="col"><a href="/admin.php?poi" class="button bluebutton">POI List</a></div>
      <?php if(!$newPOI) {  ?>
      <div class="col"><a href="/admin.php?poi&new" class="button bluebutton">New POI</a></div>
      <?php } ?>
    </div>
    <p class="message"><?php echo $message; ?></p>
    <div id="poiFormShell">
      <div style="float:left;width: 200px;">
        <?php if(!$newPOI) {  ?>
        <input type="button" name="savePOI" value="Save Changes" id="updateButton" class="button accept" style="width: 100%; font-size: 14px;">
        <input type="button" name="deletePOI" value="Delete POI" id="deleteButton" class="button reject" style="width: 100%;">
        <?php } ?>
        <?php if($newPOI) {  ?>
        <input type="button" name="savePOI" value="Publish POI" id="publishButton" class="button accept" style="width: 100%; font-size: 14px;" />
        <?php } ?>
      </div>
      <h2>POI Manager</h2>
      <div style="float:right;">
        <h3>
          <input type="checkbox" name="hidden" value="1" class="bigbox" <?php if($poiData['hidden']==1){echo "checked='checked'";} ?> />
          Hide this POI</h3>
      </div>
      <div id="leftBanner">
        <h3>Categories</h3>
        <div id='categoryList'> <?php echo buildCategoryListAdmin(explode("|},{|",$poiData['category'])); ?> </div>
      </div>
      <div style="width:500px; float:right;">
        <h3>POI Title: (Max 200 Characters)</h3>
        <input type="text" name="title" id="title" value="<?php echo htmlentities($poiData['title']) ?>" style="width:500px;" />
        <h3>Location</h3> <h4>Insert latitude-longitude coordinates or an address. </br> Only one of the two is necessary. </br> Providing one will automatically create the other.</h4>
        <!--<h4 class="col">
          <label class="clickable button bluebutton" id="address" style="padding: 4px 5px;font-size: 12px;">
            <input type="checkbox" name="useAddress" value="1" <?php echo $poiData['useAddress'] ? "checked" : ""; ?> />
            Use Address </label>
          <p class="col" style="font-size:9px; vertical-align:bottom;">(not recommended)</p>
        </h4>-->
        <div class="row locationFinder <?php //echo $poiData['useAddress'] ? "hidden" : ""; ?>">
          <p class="col"> Latitude<br />
            <input type="text" class="col" name="lat" id="latField" value="<?php echo htmlentities($poiData['latPos']) ?>"/>
          </p>
          <p class="col"> Longitude<br />
            <input type="text" class="col" name="long" id="longField" value="<?php echo htmlentities($poiData['longPos']) ?>"/>
          </p>
        </div>
        <div class="row locationFinder <?php //echo $poiData['useAddress'] ? "" : "hidden"; ?>">
          <p class="col">Address<br />
            <input type="text" name="address" id="addressField" value="<?php echo htmlentities($poiData['address']) ?>" style="width:500px" />
          </p>
        </div>
        <div class="row">
          <h3>Date Range:</h3>
          <div id="slider-range"></div>
          <input type="hidden" id="startDate" name="startDate" value="<?php echo htmlentities($poiData['startDate']) ?>" />
          <input type="hidden" id="endDate" name="endDate" value="<?php echo htmlentities($poiData['endDate']) ?>" />
        </div>
      </div>
      <hr class="clearer" />
      <h3>POI Description:</h3><h5>Warning: do not insert website links directly. Please use the tools below to set hyperlinks (the buttons to the right of "Font Sizes").</h5>
      <div id="content" class="editable"><?php echo html_entity_decode($poiData['content']) ?></div>
    </div>
  </form>
  <div id="rightBanner">
    <?php if(!$newPOI) { ?>
    <h2 style="font-size:18px; margin-bottom:0px">Gallery</h2>
    <form name="poiImage" id="poiImageForm" action="/i/process/processor.php" method="post">
      <input type="hidden" name="poiGalleryForm" value="<?php echo $poiData['id'] ?>" />
      <input type="hidden" name="deletePOIImage" id="deleteTarget" value="" />
      <?php 
                echo getGallery($poiData['id']); 
            ?>
    </form>
    <form name="poiImageUpload" id="poiIDImage" action="/i/process/processor.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="poiGalleryForm" value="<?php echo $poiData['id'] ?>" />
      <input name="fileUpload" type="file" id="fileUpload" />
      <input type="submit" name="uploadFile" value="Upload" class="button bluebutton" style="margin:0px 10px 0px; width:150px" />
    </form>
    <?php } ?>
  </div>
  <form name="deletePOIForm" id="deletePOIForm" action="/i/process/processor.php" method="post">
    <input type="hidden" name="formName" value="poiForm" />
    <input type="hidden" name="deletePOI" value="<?php echo $poiData['id'] ?>" />
    <input type="hidden" name="poiID" value="<?php echo $poiData['id'] ?>" />
  </form>
    <?php } ?>
</div>
  