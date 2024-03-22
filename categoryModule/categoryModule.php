<?php 
	include('functions/categoryModuleFunctions.php');
	if(!empty($c)){
	}else{
		$categoryList = buildCategories();
	}
?>
<style>
    html, body{
        overflow: auto;
    }
    </style>

<script type="text/javascript">
$(function() {
	$('#categoryEdit').submit(function(){
	});

});

$(function(){
	$(document).on("click", '.groupSelector li', function(){
		$this = $(this);
		$id = $this.data('id');
		$dotID = $this.data('name');

		$('#dot'+$dotID).val($id);
		$this.parent().siblings('.poiDot').attr('src','/img/poiIcon'+$id+'.png');
		
	});	
	
	
});
</script>
<style type="text/css"></style>
<div id="moduleContainer">
  <p class="message"><?php echo $message; ?></p>
  <div id="poiForm">
    <h2>POI Category List</h2>
    <form name="categoryEdit" action="/i/process/processor.php" method="post" id="categoryEdit">
      <ul style="margin-top:10px">
        <li class='category head'>
          <div class="dotColor"><span>&bull;</span></div>
          <p class='categoryName'>Current Name</p>
          <p class="changeTo">Change To</p>
        </li>
        <?php echo $categoryList ?>
      </ul>
      <br />
      <input type="submit" name="updateCategories" value="Save Changes" class="button bluebutton" />
    </form>
    <br />
    <br />
    <br />
    <a id="addCategory" onclick="toggle('addCategory')" class="clickable button accept">New Category</a>
    <form name="newCategory" action="/i/process/processor.php" method="post" id="addCategory" class="addCategory hidden">
      <div class='dotColor'>
        <input type='hidden' id='addDot' name='addDot' value='1'>
        <div onclick="toggle('groupSelector')"> <img src='/img/poiIcon1.png' class='poiDot'>
          <ul id='groupSelector' class='groupSelector4 groupSelector hidden' style='position:absolute;'>
            <li data-id='0' data-name='4' class=''><img src='/img/poiIcon0.png' class='poiDot'></li>
            <li data-id='1' data-name='4' class='selected'><img src='/img/poiIcon1.png' class='poiDot'></li>
            <li data-id='2' data-name='4' class=''><img src='/img/poiIcon2.png' class='poiDot'></li>
            <li data-id='3' data-name='4' class=''><img src='/img/poiIcon3.png' class='poiDot'></li>
            <li data-id='4' data-name='4' class=''><img src='/img/poiIcon4.png' class='poiDot'></li>
            <li data-id='5' data-name='4' class=''><img src='/img/poiIcon5.png' class='poiDot'></li>
            <li data-id='6' data-name='4' class=''><img src='/img/poiIcon6.png' class='poiDot'></li>
            <li data-id='7' data-name='4' class=''><img src='/img/poiIcon7.png' class='poiDot'></li>
            <li data-id='8' data-name='4' class=''><img src='/img/poiIcon8.png' class='poiDot'></li>
            <li data-id='9' data-name='4' class=''><img src='/img/poiIcon9.png' class='poiDot'></li>
            <li data-id='10' data-name='4' class=''><img src='/img/poiIcon10.png' class='poiDot'></li>
            <li data-id='11' data-name='4' class=''><img src='/img/poiIcon11.png' class='poiDot'></li>
            <li data-id='12' data-name='4' class=''><img src='/img/poiIcon12.png' class='poiDot'></li>
            <li data-id='13' data-name='4' class=''><img src='/img/poiIcon13.png' class='poiDot'></li>
            <li data-id='14' data-name='4' class=''><img src='/img/poiIcon14.png' class='poiDot'></li>
            <li data-id='15' data-name='4' class=''><img src='/img/poiIcon15.png' class='poiDot'></li>
          </ul>
        </div>
      </div>
      <span class='categoryName'>New Category:</span>
      <input class='changeTo' type='text' name='addCategory' value='New Category'>
      <input type="submit" name="newCategory" value="Add Category" class="button bluebutton" />
    </form>
  </div>
</div>
