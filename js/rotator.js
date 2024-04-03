
//------------------------------------------------------------------------------------------
//----------------------------------Rotator Functions----------------------------------------
//------------------------------------------------------------------------------------------	
function runGallery(){
	if(typeof rotate != 'undefined')
			clearInterval(rotate);

	$('#sub_rotator .rotator_image .slide1').addClass('active');
	
	slides = $('#sub_rotator .rotator_image').children('img').length;

//	$('#rotator_buttons').append("<div class='slide_button slide1 clickable active' data_target='1'></div>");
//	for(var i=2; i <= slides; i++){
//		$('#rotator_buttons').append("<div class='slide_button slide"+i+" clickable' data_target='"+i+"'></div>");
//	}
	
	active = 1;
	allowRotate = true;
	
	function changeSlides(target){
		if(allowRotate){
			allowRotate = false;
			$('#sub_rotator .rotator_image .active').removeClass('active').addClass('lastSlide');
			$('#sub_rotator .rotator_image .slide'+target).addClass('active').hide();
			
//			$('#rotator_buttons > .slide_button').removeClass("active");
//			$('#rotator_buttons > .slide_button.slide'+target).addClass('active');
			
			$('#sub_rotator .rotator_image .active').fadeIn(550,function(){
				$('#sub_rotator .rotator_image .lastSlide').removeClass('lastSlide');
				allowRotate = true;
			});
			resizeImage();
			
		}
	}
	
	rotate = window.setInterval(function(){
		active = active + 1;
		if(active > slides){
			active = 1;
		}
		changeSlides(active);

	},4000);
	
//	$('#rotator_buttons > .slide_button').click(function(){
//		if(allowRotate){
//			var goto = $(this).attr('data_target');
//			if(goto != active){
//				clearInterval(rotate);
//				changeSlides(goto);
//				active = goto;
//			}
//		}
//	});
	$('#rotator_next').click(function(){
		if(allowRotate){
			active = active + 1;
			if(active > slides){
				active = 1;
			}
			clearInterval(rotate);
			changeSlides(active);
		}
	});
	$('#rotator_prev').click(function(){
		if(allowRotate){
			active = active - 1;
			if(active <= 0){
				active = slides;
			}
			clearInterval(rotate);
			changeSlides(active);
		}
	});
}


	function resizeImage(){
		$("#sub_rotator img").each(function(){
			$this = $(this);
			
			var width = $this.width();
			var height =  $this.height();
			var imgRatio = width/height;
			
			var mainWidth = $('#sub_rotator').width();
			var mainHeight = $('#sub_rotator').height();
			var mainSizeRatio = mainWidth/mainHeight;
			
			$("#display").css("line-height",mainHeight+"px");
			
			if(mainSizeRatio > imgRatio){
				$this.css({'height':'100%','width':'auto'});
		//		$('#mainImg').css({'margin-top':'0px'});
				
			}else {
				$this.css({'height':'auto','width':'100%'});
		//		var vertCenter = ((mainHeight-$('#mainImg').height())/2);
		//		$('#mainImg').css({'margin-top':vertCenter});
			}
		});
	}


