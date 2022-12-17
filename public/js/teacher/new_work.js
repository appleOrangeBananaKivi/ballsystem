$(document).ready(function(){
	$("#main_work_type_select").on('change', function(){
		$(".inner_work_type_container").css("display", "none");
		if($("#inner_work_type" + $(this).val() + " select").children().length > 0){
			$("#inner_work_type" + $(this).val()).css("display", "block");
		}
	});
});
