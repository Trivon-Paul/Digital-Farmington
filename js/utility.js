function toggle(display){
	$('.'+display).each(function(){
		if($(this).hasClass('hidden')){
			$(this).removeClass('hidden');
		}else{
			$(this).addClass('hidden');
		}
	});
}
function activate(target){
	if(target.hasClass('active')){
		target.removeClass('active');
	}else{
		target.addClass('active');
	}
}


$(document).ready(function(){
	$(document).on("click", ".popup", function(e){
		var left = (screen.width/2)-(850/2);
 		var top = (screen.height/2)-(500/2);
		var url = $(this).attr('href');
		var newWindow = window.open(url, "popupWindow", "width=850,height=500,top="+top+",left="+left+",scrollbars=yes");
		newWindow.focus();
		return false;
	});
	
	$('.chooseOne').children().click(function(e){
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
	});
});

function popup(target){
	event.preventDefault();
		var left = (screen.width/2)-(850/2);
 		var top = (screen.height/2)-(500/2);
		var url = target;
		var newWindow = window.open(url, "popupWindow", "width=850,height=500,top="+top+",left="+left+",scrollbars=yes");
		newWindow.focus();
	return false;
}

//Math Functions
function round_to_decimal(num,decimals){
    var sign = num >= 0 ? 1 : -1;
    return (Math.round((num*Math.pow(10,decimals))+(sign*0.001))/Math.pow(10,decimals)).toFixed(decimals);
}
