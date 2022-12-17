var canvas = document.getElementById('activity');
var ctx = canvas.getContext('2d');

var width = canvas.width;
var height = canvas.height;

ctx.beginPath();
ctx.moveTo(15, 15);
ctx.lineTo(15, height - 15);
ctx.lineTo(width - 15, height - 15);
ctx.stroke();

var column_width = (width - 83) / 12;
var month_balls = [];

<?php 
	for($i = 0; $i < 12; $i++){
		echo('month_balls['.$i.'] = '.$months[$i]);
	}
?>

for (var i = 0; i < 12; i++) {
	month_balls[i] = Math.round(Math.random() * (50)) * 2;
}
var pos_x = 15;

// Months
var months = ['Ýan', 'Few', 'Mart', 'Apr', 'Maý', 'Iýun', 'Iýul', 'Awg', 'Sen', 'Okt', 'Noý', 'Dek'];

for (var i = 0; i < 12; i++) {
	pos_x += 4;

	// creating gradient
	gradient = ctx.createLinearGradient(width / 2, 1, width / 2, height);
	gradient.addColorStop(0, 'rgb(188, 61, 202)');
	gradient.addColorStop(1, 'rgb(22, 119, 247)');
	ctx.fillStyle = gradient;

	// drawing rectangles
	ctx.fillRect(pos_x, height - 16 - month_balls[i], column_width, month_balls[i]);
	
	// filling text
	ctx.font = '10px serif'
	ctx.fillText(months[i], pos_x, height - 3);

	pos_x += column_width;
}

for (var i = 0; i < 6; i++) {
	// filling text
	ctx.font = '10px serif'
	ctx.fillText((5 - i) * 10, 1, i * 20 + 38);
}

// Chart
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Task', 'Hours per Day'],
  ['Work', 888],
  ['Eat', 2],
  ['TV', 4],
  ['Gym', 2],
  ['Sleep', 8]
]);

  var piechart_div_width = document.getElementById('piechart_div').clientWidth - 25;
  var piechart_div_height = document.getElementById('piechart_div').clientHeight - 25;

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'Işlerim', 'width':piechart_div_width, 'height':piechart_div_height};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
