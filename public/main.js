$(document).ready(function(){
	var main_height = parseInt($("#main").css("height"));
	if (main_height > parseInt($("#sidebar_left").css("height"))){
		$("#sidebar_left").css("height", main_height + "px");
		$("#sidebar_right").css("height", main_height + "px");	
	}
});