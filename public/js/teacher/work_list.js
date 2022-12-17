$(document).ready(function(){
	$(".custom_select_div div").click(function(){	
		$(this).parent().parent().children("span").text($(this).text());
		var index = $(this).index();
		$($(this).parent().parent().parent().children("select").children("option")).each(function(){
			$(this).removeAttr('selected');
		});
		$(this).parent().parent().parent().children("select").children("option:nth-child(" + (index + 1) + ")").attr('selected', '');
	});
});

function search() {
	// Declare variables
	var input, filter, ul, li, a, i, txtValue;
	input = document.getElementById('search');
	filter = input.value.toUpperCase();
	elements = document.getElementsByClassName('search_element');
	hide_elements = document.getElementsByClassName('search_hide_element')

	// Loop through all list items, and hide those who don't match the search query
	for (i = 0; i < elements.length; i++) {
		txtValue = elements[i].innerText;
		if (txtValue.toUpperCase().indexOf(filter) > -1) {
			hide_elements[i].style.display = "";
		} else {
			hide_elements[i].style.display = "none";
		}
	}
}