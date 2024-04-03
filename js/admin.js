$(document).ready(function(){
	updateSortOrder();
	shwayTime = 1000;

	
//------------------------------------------------------
//----------------Page Submit Functions-----------------
//------------------------------------------------------
	$("#pageEditor").submit(function(event){
		if($('#topBannerType').val() == 1){
			var imagePath = $('#topBannerImg').attr('src');
			$('#topBannerContent').val(imagePath);
		}
	});
	
//------------------------------------------------------
//-------------Location & Attribute Functions-----------
//------------------------------------------------------
	redirectVal = $('#redirectURL').val();
	$('#redirectPage').click(function (){
		if($('#redirectPage').prop('checked')==true){
			$('#redirectField').show();
			$('#redirectURL').val(redirectVal);
		}else{
			redirectVal = $('#redirectURL').val();
			$('#redirectURL').val("");
			$('#redirectField').hide();
		}
	});
	
	
//------------------------------------------------------
//-------------Page Structure Functions-----------------
//------------------------------------------------------
	$('#row1Standard').click(function(){
		changePageLayout(0);
	});
	$('#row1TwoCols img').click(function(){
		changePageLayout(1);
	});
	$('#row2Add img').click(function(){
		toggle('r2secondColAdd');
		toggle('r3RowAdd');
		changePageLayout(2);
	});
	$('#row2TwoCols img').click(function(){
		changePageLayout(3)
	});
	$('#row3Add img').click(function(){
		toggle('r3secondColAdd');
		changePageLayout(4);
	});
	$('#row3TwoCols img').click(function(){
		changePageLayout(5)
	});


	//-----Controls for Page Banner-------
	$('#noBanner').click(function(){
		$('#bannerToggler').val("");
		$('#mainContent').removeClass('bannerRight bannerLeft');
		$('#noBanner').addClass('active');
		$('#leftBannerAdd').removeClass('active');
		$('#rightBannerAdd').removeClass('active');
	});
	$('#leftBannerAdd').click(function(){
		$('#bannerToggler').val("bannerLeft");
		$('#mainContent').removeClass('bannerRight').addClass('bannerLeft');
		$('#noBanner').removeClass('active');
		$('#leftBannerAdd').addClass('active');
		$('#rightBannerAdd').removeClass('active');
	});
	$('#rightBannerAdd').click(function(){
		$('#bannerToggler').val("bannerRight");
		$('#mainContent').removeClass('bannerLeft').addClass('bannerRight');
		$('#noBanner').removeClass('active');
		$('#leftBannerAdd').removeClass('active');
		$('#rightBannerAdd').addClass('active');
	});
	
	
//------------------------------------------------------
//-------------Top Image Functions----------------------
//------------------------------------------------------
	
	$('#removeBanner').click(function(){
		$('#removeBanner').hide();
		$('#noBannerImg').show();
		$('#topImageSet').hide();
		$('#topImageSelector').hide();
		$('#topSlideshowSet').hide();
		$('#topBannerType').val('0');
		$('#bannerImgPath').val('');
		$('#topBannerImg').attr('src','').hide();
	});
	$('#useImage').click(function(){
		$('#removeBanner').show();
		$('#noBannerImg').hide();
		$('#topImageSet').show();
		$('#topImageSelector').show();
		$('#topSlideshowSet').hide();
		$('#topBannerImg').show();
		$('#topBannerType').val('1');
	});
	$('#useSlideshow').click(function(){
		$('#removeBanner').show();
		$('#topImageSet').hide();
		$('#noBannerImg').hide();
		$('#topSlideshowSet').show();
		$('#topBannerImg').attr('src','img/null.gif').hide();
		$('#topBannerType').val('2');
		$('#useSlideshowSet').show().delay(600).fadeOut(400);
				
		var $slideID = $("#slideshowSelector").val();
		var $slideDelay = $("#slideshowDuration").val();
		var $slideHeight = $("#slideshowHeight").val();
		var $embedData = "/apps/?gallery="+$slideID+"&type=2&delay="+$slideDelay+"&height="+$slideHeight;
		$('#topSlideshowSet').load($embedData, function(){
							galleryTarget = $embedData;
							slideDelay = galleryTarget.split('&');
							slideDelay = slideDelay[2].split('=');
							slideDelay = parseInt(slideDelay[1]);
							slideDelay = $slideDelay * 1000;
							
							$('#topSlideshowSet #currentSlide').children('img').hide();
							$('#rotator1').show();
							
							slides = $('#topSlideshowSet #currentSlide').children('img').length;
							active = 2;
							
							clearInterval(rotate);
							rotate = window.setInterval(function(){
								$('#topSlideshowSet #currentSlide').children('img').hide();
								$('#rotator'+active).show();
								active = active + 1;
								if(active > slides){
									active = 1;
								}
							},slideDelay);
						

		});
		
		$('#topBannerContent').val($embedData);

	});

//--------------------------------------------------------------------------------------------------------------------------------------------------
//-------------Media Element Dropper Functions------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------

//------------------------------------------------------
//-------------Gallery Insert Functions-----------------
//------------------------------------------------------

	$('input[name=displayType]').click(function(){
		if($(this).val() == 0){
			$('#slide_vars').show();
			$('#list_vars').hide();
		}else{
			$('#slide_vars').hide();
			$('#list_vars').show();
		}
	});
	$('#createMedia_Gallery').click(function(){
		$('#galleryDropper').removeClass('hidden');
		$('#galleryTip').removeClass('hidden');
		
		var $galleryID = $('#gallerySelector').val();
		var $galleryType = $('input[name=displayType]:checked').val();


		$('#leftPanel .galleryObject').attr("data-id",$galleryID);
		$('#leftPanel .galleryObject').attr("data-type",$galleryType);
		
		//Slideshow
		if($galleryType == 0){
			var $slideDelay = ($('#slideDelay').val() * 1000);
			$('#leftPanel .galleryObject').attr("data-delay",$slideDelay);
		}
		//Gallery List
		if($galleryType == 1){
			var $slideWidth = $('#imageSize').val();
			$('#leftPanel .galleryObject').attr("data-imageWidth",$slideWidth);
			var $imgAlign = $('input[name=imageAlign]:checked').val();
			$('#leftPanel .galleryObject').attr("data-imageAlignment",$imgAlign);
		}
	}); 
	
//------------------------------------------------------
//-------------Form Insert Functions--------------------
//------------------------------------------------------
	
	$('#createMedia_Form').click(function(){
		$('#formDropper').removeClass('hidden');
		$('#formTip').removeClass('hidden');
		
		var $formID = $('#formSelector').val();

		$('#leftPanel .formObject').attr("data-id",$formID);
	});

//------------------------------------------------------
//-------------News Feed Insert Functions---------------
//------------------------------------------------------
	
	$('#createMedia_News').click(function(){
		$('#newsDropper').removeClass('hidden');
		$('#newsTip').removeClass('hidden');
		
		var $newsID = $('#newsSelector').val();

		$('#leftPanel .newsObject').attr("data-id",$newsID);
	});


//------------------------------------------------------
//-------------Misc Insert Functions--------------------
//------------------------------------------------------
 	$( ".draggable" ).draggable({ 
		revert: "invalid",
		revertDuration: 100,
		containment: 'body',
		scroll:false,
		helper: "clone",
		appendTo: 'body'
		
	});

    $( ".mediaDropZone" ).droppable({
		activeClass: "ui-state-default",
		hoverClass: "ui-state-hover",
		drop: function( event, ui ) {
			$('#galleryDropper').addClass('hidden');
			$('#galleryTip').addClass('hidden');

			var $dropLocation = $(this);
			$dropLocation.addClass( "hasElement" );

			
			//------------------------Gallery-----------------------------
			if(ui.draggable.children().hasClass("galleryObject")){
				var $objID = ui.draggable.find(".galleryObject").attr("data-id");
				var $objType = ui.draggable.find(".galleryObject").attr("data-type");
				//Slideshow
				if($objType == 0){
					var $objDelay = ui.draggable.find(".galleryObject").attr("data-delay");
					var $embedData = "/apps/?gallery="+$objID+"&type="+$objType+"&delay="+$objDelay+"&embed";
					
					$dropID = $dropLocation.attr('id');
					tinymce.get($dropID).setContent("<iframe src='"+$embedData+"' frameborder='0' seamless='seamless' align='middle' ></iframe>");
				}
				//Gallery List
				else if($objType == 1){
					var $imgWidth = ui.draggable.find(".galleryObject").attr("data-imageWidth");
					var $imgAlign = ui.draggable.find(".galleryObject").attr("data-imageAlignment");
					var $embedData = "/apps/?gallery="+$objID+"&type="+$objType+"&w="+$imgWidth+"&a="+$imgAlign+"&embed";
					$dropLocation.load($embedData);
				}
	
			}
			//------------------------FORMS-----------------------------
			if(ui.draggable.children().hasClass("formObject")){
				var $objID = ui.draggable.find(".formObject").attr("data-id");
				var $embedData = "/apps/?form="+$objID+"&embed";
					
				$dropID = $dropLocation.attr('id');
				tinymce.get($dropID).setContent("<iframe src='"+$embedData+"' frameborder='0' seamless='seamless' align='middle' ></iframe>");
			}
			//------------------------FORMS-----------------------------
			if(ui.draggable.children().hasClass("newsObject")){
				var $objID = ui.draggable.find(".newsObject").attr("data-id");				
				var $embedData = "/apps/?news="+$objID+"&type="+$objType+"&w="+$imgWidth+"&a="+$imgAlign+"&embed";
				$dropLocation.load($embedData);	
			}

		}
	});
//--------------------------------------------------------------------------------------------------------------------------------------------------
//---END-------Media Element Dropper Functions END-------END------------------END-----------------END------------END----------END--------------END--
//--------------------------------------------------------------------------------------------------------------------------------------------------
	$('.editable').click(function(){
		$('.colorPicker').removeClass('show');
		var target = $(this).attr('id');
		$('#'+target +'ColorPicker').addClass('show');
		
	});
	
	$('#deletePOI').click(function(){
		var poiID = $(this).attr('data-id');
		$.post("/i/process/processor.php", { poiDelete: poiID , poiDelete: "true" }, function(){});
	});
	
	
		
	
});



function updateSortOrder(){
	var sortArray = Array();
	$('.sortField li').each(function(){
		var addVal = $(this).attr('data-orderid');
		sortArray.push(addVal);
	});
	sortArray = sortArray + "";
	$('input.sortOrder').val(sortArray);

}

function changePageLayout(change){
	var current = $('#layoutSelector').val();
	var r1c2 = current.charAt(0);
	var r2c1 = current.charAt(1);
	var r2c2 = current.charAt(2);
	var r3c1 = current.charAt(3);
	var r3c2 = current.charAt(4);
	
	switch (change){
		case 0:
			r1c2 = '0';
			$('#row1TwoCols').removeClass('active');
			r2c1 = '0';
			$('#row2Add').removeClass('active');
			r2c2 = '0';
			$('#row2TwoCols').removeClass('active hidden').addClass('hidden');
			r3c1 = '0';
			$('.r3RowAdd').addClass('hidden');
			$('#row3Add').removeClass('active');
			r3c2 = '0';
			$('#row3TwoCols').removeClass('active hidden').addClass('hidden');
			break;
		
		case 1:
			r1c2++
			if(r1c2 > 1){
				r1c2 = 0;
				$('#row1TwoCols').removeClass('active');
			}else $('#row1TwoCols').addClass('active');
			break;
		
		case 2:
			r2c1++
			if(r2c1 > 1){
				r2c1 = 0;
				$('#row2Add').removeClass('active');
				r3c1 = 0;
				r3c2 = 0;
				$('.r3RowAdd').addClass('hidden');
				$('#row3Add').removeClass('active');
				$('#row3TwoCols').removeClass('active hidden').addClass('hidden');
				
				
			}else $('#row2Add').addClass('active');
			if(r2c2 == 1){
				r2c2 = 0;
				$('#row2TwoCols').removeClass('active');
			}
			

			break;
		
		case 3:
			r2c2++
			if(r2c2 > 1){
				r2c2 = 0;
				$('#row2TwoCols').removeClass('active');
			}else $('#row2TwoCols').addClass('active');
			break;
		
		case 4:
			r3c1++
			if(r3c1 > 1){
				r3c1 = 0;
				$('#row3Add').removeClass('active');
			}else $('#row3Add').addClass('active');
			if(r3c2 == 1){
				r3c2 = 0;
				$('#row3TwoCols').removeClass('active');
			}
			break;
		
		case 5:
			r3c2++
			if(r3c2 > 1){
				r3c2 = 0;
				$('#row3TwoCols').removeClass('active');
			}else $('#row3TwoCols').addClass('active');
			break;
	}
	
	$('#layoutSelector').val(r1c2 + r2c1 + r2c2 + r3c1 + r3c2);
	$('#mainContent').removeClass().addClass('layout'+r1c2 + r2c1 + r2c2 + r3c1 + r3c2);
}



function submitForm(formID){
	$("#"+formID).submit();
}

function deleteCategory(categoryID){
	$.get("/i/process/categoryDelete.php?catID="+categoryID, function(result){
		if(result == "Success"){
			$('li.category.'+categoryID).addClass("fadeAway");
		}else{
			alert(result);
		}
		window.setTimeout(ShwayAway,200);
	});	
}
function ShwayAway(){
	$('.fadeAway').fadeOut(500, function(){
		$(this).remove();
	});
}












