<script type="text/javascript" src="/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">

//PAGE CONTENT CODE
	tinymce.init({
		selector: "div.editable",
		plugins: [
			"advlist autolink link image lists charmap hr anchor",
			"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
			"table contextmenu textcolor paste textcolor"
        ],

        toolbar1: "undo redo | cut copy paste | searchreplace | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | removeformat",
        toolbar2: "bullist numlist | outdent indent | forecolor | fontsizeselect | link unlink ",
		
		external_filemanager_path:"/js/filemanager/",
		filemanager_title:"Responsive Filemanager" ,
		external_plugins: { "filemanager" : "/js/filemanager/plugin.min.js"},

        menubar: false,
        toolbar_items_size: 'small',
		image_advtab: true,
	    forced_root_block : "", 
    	force_br_newlines : true,
    	force_p_newlines : true,
		target_list: false,
		default_link_target: "_blank",
	    contextmenu: "link image media" ,

	});
	
	
	
</script>
