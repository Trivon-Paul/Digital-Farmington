$(window).load(function(){
	imgID = 0;
	nextImage(0);
	setGalleryInterval();
	play = true;
});
$(window).resize(function(){
	resizeImage();
});
function setGalleryInterval(){
	rotateInterval = window.setInterval(function(){
		nextImage();
	},slideLag);
}

function pause(){
	if(play == false){
		var paused = true;
	}
	clearInterval(rotateInterval);
	play = false;
	$('#playPause').css("background","url(apps/gallery/play.png) no-repeat");
	if(!paused)
		$('#playPauseAnim').stop(true, true).show().css("background-image","url(apps/gallery/pause.png)").delay(120).fadeOut(600);
}
function playSlides(){
	setGalleryInterval();

	play = true;
	$('#playPause').css("background","url(apps/gallery/pause.png) no-repeat");
	$('#playPauseAnim').stop(true, true).show().css("background-image","url(apps/gallery/play.png)").delay(120).fadeOut(600);
}
function togglePlay(){
	if(play == true){
		pause();
	}else if(play == false){
		playSlides();
		setTimeout(function(){nextImage()},(slideLag/3));
	}
}

function resizeImage(){
	var imgRatio = $('[data-imgid=' + imgID + ']').attr("data-imgRatio");
	var mainWidth = $('#display').width();
	var mainHeight = $('#display').height();
	var mainSizeRatio = mainWidth/mainHeight;
	
	$("#display").css("line-height",mainHeight+"px");
	
	if(mainSizeRatio > imgRatio){
		$('#mainImg').css({'height':'100%','width':'auto'});
//		$('#mainImg').css({'margin-top':'0px'});
		
	}else {
		$('#mainImg').css({'height':'auto','width':'100%'});
//		var vertCenter = ((mainHeight-$('#mainImg').height())/2);
//		$('#mainImg').css({'margin-top':vertCenter});
	}
}
function prevImageAndPause(){
	pause();
	prevImage();
}
function prevImage(){
	imgID = imgID-1;
	if(imgID == -1){
		nextImage(slideNum-1);
	}else{
		nextImage(imgID);
	}
}
function nextImageAndPause(gotoImage){
	pause();
	nextImage(gotoImage);
}
function nextImage(gotoImage){
	if(gotoImage !== undefined){
		imgID = gotoImage;
	}else{
		imgID ++;
	}
	if(imgID >= slideNum){
		imgID = 0;	
	}

	$('figure.active').removeClass('active');
	$('[data-imgid=' + imgID + ']').addClass("active");

	var imgPath = $('[data-imgid=' + imgID + ']').attr("data-imgSRC");
	$('#display').html("<img src='"+imgPath+"' id='mainImg' />");
	
	var imgCaption = $('[data-imgid=' + imgID + '] figcaption').text();
	$('#information').text(imgCaption);

	resizeImage();

}
