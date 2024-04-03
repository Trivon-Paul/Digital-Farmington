$(document).ready(function(){
	updateGalleryData();
	
	$( '#imageList ul' ).sortable({
			placeholder: "sorterPlaceHolder",
	});
    $( "#imageList ul" ).disableSelection();
	$( "#imageList ul" ).on( 'sortstop', function( event, ui ) {
		updateGalleryData();
		$('.message').load("/live/updateOrder.php");
	});

	
	
	$galleryAddID=0;
	$('#addSlide').click(function(){
		var $insert = "<li class='galleryObject' id='addedSlide"+$galleryAddID+"'><div class='anchor col'></div><a href='js/filemanager/dialog.php?type=1&amp;attr=src&amp;field_id=addImage"+$galleryAddID+"&amp;popup=1' class='popup obj_imgCont col'> <img src='' class='obj_img' id='addImage"+$galleryAddID+"' /> </a><div class='col'><input type='text' class='obj_title fake_editable' name='title"+$galleryAddID+"' value='' /><br /><textarea class='obj_caption fake_editable' name='caption"+$galleryAddID+"'></textarea></div><div class='remove col clickable' onclick=\"removeSlide($('#addedSlide"+$galleryAddID+"'))\">X</div></li>";
		$('.gallerySorter').append($insert);
		$galleryAddID = $galleryAddID+1;
	});
	
	$('#galleryUpdate').submit(function(){
		updateGalleryData();
		$('#galleryUpdate').submit();
	});
	
	
	$(document).on("click", ".deleteImg", function(e){
		var target = $(this).parent('.image');
		$("#deleteTarget").val($(this).attr('data-filepath'));
		removeSlide(target);
		$("#poiImageForm").submit();
	});
	
	
	
});

function removeSlide(element){
	
	element.fadeOut(500 , function(){ element.remove(); updateGalleryData(); });
	
}

function updateGalleryData(){
	var imageArray = Array();
	var sizeRatioArray = Array();
	var captionArray = Array();
	
	$('#rightBanner .poiSlideImg').each(function(){
		var addVal = $(this).attr('src');
		imageArray.push('|'+addVal+'|');
	});
	$('.image .poiSlideImg').each(function(){
		//Get Width and Height
		var w = $(this).width();
		var h = $(this).height();
		var ratio = (w/h);
		var value = round_to_decimal(ratio,2);
		var addVal = value.toString();
		sizeRatioArray.push('|'+addVal+'|');
	});
	$('.image .poiSlideCaption').each(function(){
		var addVal = $(this).val();
		captionArray.push('|'+addVal+'|');
	});
	
	imageArray = imageArray + "";
	$('input#poiImage').val(imageArray);
	
	sizeRatioArray = sizeRatioArray + "";
	$('input#poiSizeRatio').val(sizeRatioArray);
	
	captionArray = captionArray + "";
	$('input#poiCaption').val(captionArray);

}




