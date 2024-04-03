$(function(){
	//var resetMap = window.setTimeout(backHome,240000);
		
	function backHome(){
		window.location = 'map.php';
	}
	window.onclick = function(){
		window.clearTimeout(resetMap);
		resetMap = setTimeout(backHome,240000);
	}
	
	$('#resetMap').click(function() {
    location.reload();
});
});

