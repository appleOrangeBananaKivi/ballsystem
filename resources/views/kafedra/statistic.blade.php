<!DOCTYPE html>
<html>
<head>
	<title>{{ $name }} kafedranyň sahypasy</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('bootstrap/bootstrap.css') }}">

	<!-- Main styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('main.css') }}">

	<!-- Teacher page styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/structure.css') }}">

	<!-- Statistic page styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/teacher/statistic.css') }}">

	<!-- Google charts -->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
	
	@if ($user_type != "kafedra")
		@if ($user_type == "kitaphana")
			<div id="back_button">
				<a href="http://{{ $_SERVER['SERVER_NAME'] }}/ballsystem/public/kitaphana/{{ $fakultet_login }}/kafedra_list"><img src="{{ URL::asset('pic/svg/back_arrow.png') }}"></a>
			</div>
		@else
			<div id="back_button">
				<a href="http://{{ $_SERVER['SERVER_NAME'] }}/ballsystem/public/fakultet/{{ $fakultet_login }}/kafedra_list"><img src="{{ URL::asset('pic/svg/back_arrow.png') }}"></a>
			</div>
		@endif
	@endif
	
	<div class="containe-fluid">
		<div class="row">

			<!-- Left sidebar -->
			<div id="sidebar_left" class="col-2">

				<!-- Logo -->
				<a id="logo" href="/ballsystem/public/">
					<img src="{{ URL::asset('pic/logo.png') }}">
				</a><br/>

				<!-- Links -->
				<a class="menu_link" href="new_teacher">
					<img src="{{ URL::asset('pic/svg/folder-open-solid.png') }}">
					<small>Mugallym goşmak</small>
				</a>
				<br/>
				<a class="menu_link" href="teacher_list">
					<img src="{{ URL::asset('pic/svg/list-ul-solid.png') }}">
					<small>Mugallymlar reýtingy</small>
				</a>
				<br/>
				<a id="selected_sidebar_link" class="menu_link" href="statistic">
					<img src="{{ URL::asset('pic/svg/chart-line-solid.png') }}">
					Statistika
				</a>
				<br/>
				<a class="menu_link" href="profile">
					<img src="{{ URL::asset('pic/svg/user-circle-solid.png') }}">
					Meniň profilim
				</a>
				<br/>
			</div>

			<!-- Main content -->
			<div id="main" class="col-7">

				<!-- Rating and ball sum -->
				<div id="info_divs_container" class="row">
					<div class="col info_div">
						<div>
							<h6>Reýting</h6>
							<p>Ball boýunça orun</p>
						</div>
						<div>
							<span>{{ $rating }}</span>
						</div>
					</div>
					<div class="col info_div">
						<div>
							<h6>Ball</h6>
							<p>Ballaryň jemi</p>
						</div>
						<div>
							<span>{{ $ball }}</span>
						</div>
					</div>
					<div class="col info_div">
						<div>
							<h6 style="font-size: 14px;">Top mugallym</h6>
							<p>Iň köp bally mugallym</p>
						</div>
						<div>
							<span style="line-height: 18px; padding-top: 21px; font-size: 10px;">{{ $top_teacher_name }}</span>
						</div>
					</div>
				</div>

				<!-- Activity and work types statistic -->
				<div class="row justify-content-around">
					<div class="col-7 content_div">
						<h5>Mugallymlaryň statistikasy</h5>
						<p>{{ date("Y") }} ýylyň mugallymlaryň statistikasy</p>
						<canvas id="activity">
							
						</canvas>
					</div>
					<div id="piechart_div" class="col-4 content_div">
						<div id="piechart"></div>
					</div>
				</div>
			</div>

			<!-- Right sidebar -->
			<div id="sidebar_right" class="col-3">
				<h5>Statistika sahypasy</h5>
				<p>Statistika hakda gysgaça maglumat</p>
				<hr/>
				<div class="right_sidebar_list_item">
					<div class="row">
						<div class="col-3">
							<i></i>
						</div>
						<div class="col-9">
							<h5>Statistika</h5>	
							<p>Statistika sahypasynda mugallymlaryň statistikasyny görüp bilersiňiz.</p>
						</div>
					</div>
				</div>
				<div class="right_sidebar_list_item">
					<div class="row">
						<div class="col-3">
							<i></i>
						</div>
						<div class="col-9">
							<h5>Reýting</h5>	
							<p>Reýting - kafedranyň ähli kafedralaryň içinde ball boýunça durýan ýeri.</p>
						</div>
					</div>
				</div>
				<div class="right_sidebar_list_item">
					<div class="row">
						<div class="col-3">
							<i></i>
						</div>
						<div class="col-9">
							<h5>Ball</h5>	
							<p>Ball - kafedranyň ähli mugallymlarynyň ballarynyň jemi.</p>
						</div>
					</div>
				</div>
				<div class="right_sidebar_list_item">
					<div class="row">
						<div class="col-3">
							<i></i>
						</div>
						<div class="col-9">
							<h5>Top mugallym</h5>	
							<p>Top mugallym - kafedranyň iň köp ball gazanan mugallymy.</p>
						</div>
					</div>
				</div>
				<div class="right_sidebar_list_item">
					<div class="row">
						<div class="col-3">
							<i></i>
						</div>
						<div class="col-9">
							<h5>Mugallymyň statistikasy</h5>	
							<p>Kafedranyň soňky ýylyň aýlarynda gazanan ballarynyň we işleriniň görnüşleriniň shemalary.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="{{ URL::asset('bootstrap/jquery-3.5.1.min.js') }}"></script>
	<script type="text/javascript">
		var canvas = document.getElementById('activity');
		var ctx = canvas.getContext('2d');

		var width = canvas.width;
		var height = canvas.height;

		ctx.beginPath();
		ctx.moveTo(25, 15);
		ctx.lineTo(25, height - 15);
		ctx.lineTo(width - 15, height - 15);
		ctx.stroke();

		var column_width = (width - 83) / 12;
		var month_balls = [];

		<?php 
			for($i = 1; $i <= 12; $i++){
				echo('month_balls['.($i - 1).'] = '.($teacher_month_statistic[$i - 1] / 5).';');
			}
		?>
		var pos_x = 25;

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
			ctx.fillText((5 - i) * 100, 5, i * 20 + 38);
		}

		// Chart
		// Load google charts
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawChart);

		// Draw the chart and set the chart values
		function drawChart() {
			<?php 
				echo("var data = google.visualization.arrayToDataTable([
						['Task', 'Hours per Day'],
					");
				$i = 0;
				foreach ($kafedra_work_statistics as $work_statistics) {
					if (strlen($work_types[$i]->name) > 50){
						echo("['".substr($work_types[$i]->name, 0, 50)."', ".$work_statistics."],");
					}else{
						echo("['".$work_types[$i]->name."', ".$work_statistics."],");
					}
					$i++;
				}
				echo("]);");
			?>

		  var piechart_div_width = document.getElementById('piechart_div').clientWidth - 50;
		  var piechart_div_height = document.getElementById('piechart_div').clientHeight - 25;

		  // Optional; add a title and set the width and height of the chart
		  var options = {'title':'Işlerim', titleTextStyle: {fontSize: 18}, 'width':piechart_div_width, 'height':piechart_div_height, is3D: true, fontSize: 12, legend: {position: 'top', maxLines: 3}};

		  // Display the chart inside the <div> element with id="piechart"
		  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
		  chart.draw(data, options);
		}
	</script>
	<script type="text/javascript" src="{{ URL::asset('bootstrap/popper.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('bootstrap/bootstrap.js') }}"></script>
</body>
</html>