$(document).ready(function(){

	// changing color of pic
	var user_types = [$("#teacher_div"), $("#kafedra_div"), $("#fakultet_div"), $("#kitaphana_div")];
	
	//first selected
	$("#teacher_div").attr("class", "col-4 user_type_div user_type_div_selected");
	$("#teacher_radio").attr("checked", "");
	var pic_attr = $("#teacher_div").children("img").attr('src');
	pic_attr = pic_attr.substr(0, pic_attr.length - 4);
	$("#teacher_div").children("img").attr('src', pic_attr + '-selected.png');

	$(".user_type_div").click(function(){
		$(".user_type_div").attr("class", "col-4 user_type_div");
		$(".user_type_div:nth-child(even)").attr("class", "col-4 offset-1 user_type_div");
		if ($(this).index() + 1 == 1 || $(this).index() + 1 == 3)
			$(this).attr("class", "col-4 user_type_div user_type_div_selected");
		else
			$(this).attr("class", "col-4 offset-1 user_type_div user_type_div_selected");
		$(".user_type_radio").removeAttr("checked");
		var user_type = $(this).text().trim();
		switch (user_type){
			case "Mugallym":
				$("#teacher_radio").attr("checked", "");
				break;
			case "Kafedra":
				$("#kafedra_radio").attr("checked", "");
				break;
			case "Fakultet":
				$("#fakultet_radio").attr("checked", "");
				break;
			case "Kitaphana":
				$("#admin_radio").attr("checked", "");
				break;
		}
	});

	function divHover(id){
		var pic_attr = $(id).children("img").attr('src');
		pic_attr = pic_attr.substr(0, pic_attr.length - 4);
		$(id).children("img").attr('src', pic_attr + '-selected.png');
	}

	function divHoverExit(id){
		var pic_attr = $(id).children("img").attr('src');
		pic_attr = pic_attr.substr(0, pic_attr.length - 13);
		$(id).children("img").attr('src', pic_attr + '.png');
	}

	function uncheckEvery(){
		if (teacher_div_checked){
			teacher_div_checked = false;
			var pic_attr = $('#teacher_div img').attr('src');
			pic_attr = pic_attr.substr(0, pic_attr.length - 13);
			$('#teacher_div img').attr('src', pic_attr + '.png');
		}else if (kafedra_div_checked){
			kafedra_div_checked = false;
			var pic_attr = $('#kafedra_div img').attr('src');
			pic_attr = pic_attr.substr(0, pic_attr.length - 13);
			$('#kafedra_div img').attr('src', pic_attr + '.png');
		}else if (fakultet_div_checked){
			fakultet_div_checked = false;
			var pic_attr = $('#fakultet_div img').attr('src');
			pic_attr = pic_attr.substr(0, pic_attr.length - 13);
			$('#fakultet_div img').attr('src', pic_attr + '.png');
		}else if (kitaphana_div_checked){
			kitaphana_div_checked = false;
			var pic_attr = $('#kitaphana_div img').attr('src');
			pic_attr = pic_attr.substr(0, pic_attr.length - 13);
			$('#kitaphana_div img').attr('src', pic_attr + '.png');
		}
	}

	var teacher_div_checked = true;
	$('#teacher_div').mouseover(function(){
		if (!teacher_div_checked){
			divHover('#teacher_div');
		}
	});
	$('#teacher_div').mouseout(function(){
		if (!teacher_div_checked){
			divHoverExit('#teacher_div');
		}
	});
	$('#teacher_div').click(function(){
		if (!teacher_div_checked){
			uncheckEvery();
			teacher_div_checked = true;
		}
	});

	var kafedra_div_checked = false;
	$('#kafedra_div').mouseover(function(){
		if (!kafedra_div_checked){
			divHover('#kafedra_div');
		}
	});
	$('#kafedra_div').mouseout(function(){
		if (!kafedra_div_checked){
			divHoverExit('#kafedra_div');
		}
	});
	$('#kafedra_div').click(function(){
		if (!kafedra_div_checked){
			uncheckEvery();
			kafedra_div_checked = true;
		}
	});

	var fakultet_div_checked = false;
	$('#fakultet_div').mouseover(function(){
		if (!fakultet_div_checked){
			divHover('#fakultet_div');
		}
	});
	$('#fakultet_div').mouseout(function(){
		if (!fakultet_div_checked){
			divHoverExit('#fakultet_div');
		}
	});
	$('#fakultet_div').click(function(){
		if (!fakultet_div_checked){
			uncheckEvery();
			fakultet_div_checked = true;
		}
	});

	var kitaphana_div_checked = false;
	$('#kitaphana_div').mouseover(function(){
		if (!kitaphana_div_checked){
			divHover('#kitaphana_div');
		}
	});
	$('#kitaphana_div').mouseout(function(){
		if (!kitaphana_div_checked){
			divHoverExit('#kitaphana_div');
		}
	});
	$('#kitaphana_div').click(function(){
		if (!kitaphana_div_checked){
			uncheckEvery();
			kitaphana_div_checked = true;
		}
	});
});