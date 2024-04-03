$(document).ready(function(){
	$('#btmBannerHide').on('click',function(){
		infoHide();
	});
	
	
	
	
});

function infoAppear(){
	$('div#bottomBanner').css('bottom','0px');
}
function infoHide(){
	$('div#bottomBanner').css('bottom','-250px');
}