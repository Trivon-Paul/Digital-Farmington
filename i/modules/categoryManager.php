<?php 
	include('i/functions/categoryModuleFunctions.php');
	if(!empty($c)){
	}else{
		$categoryList = buildCategories();
	}
?>
<script type="text/javascript">
$(function() {
	$('#categoryEdit').submit(function(){
	});

});

$(function(){
	$('.groupSelector').on('click', 'li', function(){
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
    <form name="categoryEdit" action="i/process/processor.php" method="post" id="categoryEdit">
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
  </div>
</div>
