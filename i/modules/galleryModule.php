<?php 
	include('i/functions/galleryModuleFunctions.php');
	if($g)
		$gallery = mysql_fetch_array(getGalleries($g));
	if(isset($_GET['new'])){
		$newGallery = true;
		$g = true;
	}
?>

<div id="galleryModule">
  <?php if(!$g)	echo"<h1>Dashboard</h1>";?>
  <p class="message"><?php echo $message; ?></p>
  <div id="galleryList">
    <h1><a href="admin.php?g">Gallery List</a></h1>
    <div class="scrollList"> <a class="button accept" href="admin.php?g&new">New Gallery</a>
      <?php 
		$galleryList = getGalleryList();
		while($title = mysql_fetch_array($galleryList)){
			echo "<a href='admin.php?g=".$title['id']."'>".$title['name']."</a>";
		}
	?>
    </div>
  </div>
  <div id="galleryInformation">
    <?php 
		if(!$g){
			echo buildGalleryList(); 
		}else{
			$titles = str_replace("|","",explode("|,|",$gallery['title']));
			$images = str_replace("|","",explode("|,|",$gallery['image']));
			$captions = str_replace("|","",explode("|,|",$gallery['caption']));
			
			echo "<form name='galleryModule' id='galleryUpdate' action='i/process/processor.php' method='post'>
			<input type='hidden' name='galleryModuleForm' value='".$gallery['id']."'>
			
			<input type='hidden' name='image' value='' class='image'>
			<input type='hidden' name='sizeRatio' value='' class='sizeRatio'>
			<input type='hidden' name='title' value='' class='title'>
			<input type='hidden' name='caption' value='' class='caption'>
			<h3>Gallery Name</h3>
			<input type='text' name='name' value='";
				echo $newGallery ? "New Gallery" : $gallery['name'];
			echo "' style='width: 540px;' class='h2' >";
			
			//Submit Changes
			echo "<input type='submit' name='";
				echo $newGallery ? "galleryCreate" : "galleryUpdate" ;
				echo "' value='";
				echo $newGallery ? "Create Gallery" : "Save Gallery" ;
			echo "' class='accept button' style='position: absolute; right: 20px; top:30px; font-size:16px;' />";
			
			//Delete Gallery
			if(!$newGallery){
				echo "<input type='submit' name='galleryDelete' value='Delete Gallery'
						onclick=\"return confirm('Are you sure? This operation cannot be undone.')\"
						class='reject button' style='position: absolute; right: 20px; top:65px; font-size:16px;' />";
			}


			echo "
			<div class='gallery_desc'>
					<h3>Gallery Description</h3>
					<input name='description' type='text' value='".$gallery['description']."' style='width:100%;' />
				</div>
				<h3>Link:</h3
			<p><a href='app/?gallery=".$gallery['id']."&delay=4000' target='_blank'>http://app/?gallery=".$gallery['id']."&delay=4000</a></p>
				<h3>Embed Code:</h3>
			<input type='text' style='width:100%' value=\"<iframe src='app/?gallery=".$gallery['id']."&amp;delay=4000&amp;embed' seamless='seamless' width='80%' height='330' frameborder='0'></iframe>\" />
				<h3>Gallery Images</h3>
				<ol class='sortField gallerySorter'>";
			for($i=0; $i < count($titles); $i++){
				$cIMG = str_replace("/app/u/","/app/thumbs/",$images[$i]);
				echo "<li class='galleryObject' id='galleryObject".$i."'>
						<div class='anchor col'></div>
							<a href='js/filemanager/dialog.php?type=1&amp;attr=src&amp;field_id=image".$i."&amp;popup=1' class='popup obj_imgCont col'>
								<img src='".$cIMG."' class='obj_img' id='image".$i."' />
							</a>
						<div class='col'>
							<input type='text' class='obj_title fake_editable' name='title".$i."' value='".$titles[$i]."' /><br />
							<textarea class='obj_caption fake_editable' name='caption".$i."'>".$captions[$i]."</textarea>
						</div>
						<div class='remove col clickable'>X</div>

					</li>";				
			}
			
			echo "
				</ol><p class='accept button' id='addSlide'>Add Slide</p>
			</form>
			";
		}
	?>
  </div>
</div>
