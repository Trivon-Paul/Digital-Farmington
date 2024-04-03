$(document).ready(function(){

	$('.deleteAdmin').click(function(e){
		if(confirm('Are you sure? This opperation cannot be undone.')){
			var adminID = $(this).attr('data_id');
			$('#submit').attr('name','adminDelete');
			$('#adminUserFormID').val(adminID);
			submitForm("adminUserRemove");
	
		}else{
	
		}
	});
	
});
