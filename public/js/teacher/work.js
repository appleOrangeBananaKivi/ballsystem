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

$(document).ready(function(){
	// ball redact window show
	$('#ball_redact_href').click(function(){
		$('#ball_redact_window').fadeIn();
	});
	$('#ball_redact_back').click(function(){
		$('#ball_redact_window').fadeOut();
	});
});