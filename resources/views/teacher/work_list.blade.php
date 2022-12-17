<!DOCTYPE html>
<html>
<head>
	<title>{{ $name }} mugallymyň sahypasy</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('bootstrap/bootstrap.css') }}">

	<!-- Main styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('main.css') }}">

	<!-- Teacher page styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/structure.css') }}">

	<!-- Work list page styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/teacher/work_list.css') }}">
</head>	
<body>

	@if ($user_type != "teacher")
		@if ($user_type == "kitaphana")
			<div id="back_button">
				<a href="http://{{ $_SERVER['SERVER_NAME'] }}/ballsystem/public/kitaphana/{{ $user_login }}/teacher_list"><img src="{{ URL::asset('pic/svg/back_arrow.png') }}"></a>
			</div>
		@else
			<div id="back_button">
				<a href="http://{{ $_SERVER['SERVER_NAME'] }}/ballsystem/public/kafedra/{{ $user_login }}/teacher_list"><img src="{{ URL::asset('pic/svg/back_arrow.png') }}"></a>
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
				<a class="menu_link" href="new_work">
					<img src="{{ URL::asset('pic/svg/folder-open-solid.png') }}">
					Iş goşmak
				</a>
				<br/>
				<a id="selected_sidebar_link" class="menu_link" href="work_list">
					<img src="{{ URL::asset('pic/svg/list-ul-solid.png') }}">
					Işleriň sanawy
				</a>
				<br/>
				<a class="menu_link" href="statistic">
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
				
				<!-- Search bar -->
				<div class="row">
					<div id="search_div" class="col">
						<span id="search_img_container"><i></i></span>
						<input id="search" type="text" name="search" onkeyup="search()" />
					</div>
				</div>

				<!-- Work list -->
				<div id="work_list_div" class="row">
					<div class="col">
						
						<!-- Header row -->
						<form action="" method="get">
							<div class="row align-items-center">
								<div class="col-4">
									<h5>Işleriň sanawy</h5>
									<p>Siziň bukjaňyzdaky ähli işler.</p>
								</div>
								<div class="col-3 offset-1">

									<!-- Hided select element -->
									<select name="year_select" class="main_select">
										<option selected value="Ýyly"></option>
										@foreach($years as $year)
										<option value="{{ $year }}"></option>
										@endforeach
									</select>

									<!-- Custom select element -->
									<div class="custom_select_selected">
										<i></i>
										<span>Ýyly</span>
										<i></i>
										<div class="custom_select_div">
											<div>Ýyly</div>
											@foreach($years as $year)
											<div>{{ $year }}</div>
											@endforeach
										</div>
									</div>
								</div>
								<div class="col-3">

									<!-- Hided select element -->
									<select name="month_select" class="main_select">
										<option selected value="Aýy"></option>
										<option value="01"></option>
										<option value="02"></option>
										<option value="03"></option>
										<option value="04"></option>
										<option value="05"></option>
										<option value="06"></option>
										<option value="07"></option>
										<option value="08"></option>
										<option value="09"></option>
										<option value="10"></option>
										<option value="11"></option>
										<option value="12"></option>
									</select>

									<!-- Custom select element -->
									<div class="custom_select_selected">
										<i></i>
										<span>Aýy</span>
										<i></i>
										<div class="custom_select_div">
											<div>Aýy</div>
											<div>Ýanwar</div>
											<div>Fewral</div>
											<div>Mart</div>
											<div>Aprel</div>
											<div>Maý</div>
											<div>Iýun</div>
											<div>Iýul</div>
											<div>Awgust</div>
											<div>Sentýabr</div>
											<div>Oktýabr</div>
											<div>Noýabr</div>
											<div>Dekabr</div>
										</div>
									</div>
								</div>
								<div class="col-1">
									<input id="filter_submit" type="submit" name="filter_submit" value="Filter" />
								</div>
							</div>
						</div>
					</form>
					<div class="w-100"></div>

					<!-- Table -->
					<div id="work_list_table" class="col">
						<table id="works_table">
							<tr>
								<th>id</th>
								<th>Işiň ady</th>
								<th>Iş hakda maglumat</th>
								<th>Görnüşi</th>
								<th>Baly</th>
								<th>Senesi</th>
								<?php
									$path = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
									$contains_get = false;
									$sort_type_pos = strpos($path, "sort_type");
									if ($sort_type_pos !== false)
										$path = substr($path, 0, $sort_type_pos - 1);
									if (strpos($path, "?") !== false)
										$contains_get = true;
								?>
								<th class="check_types">
									@if ($contains_get)
										<a href=<?php echo($path."&sort_type=kafedra"); ?>><img src="{{ URL::asset('pic/svg/building-regular-th.png') }}"/></a>
									@else
										<a href=<?php echo($path."?sort_type=kafedra"); ?>><img src="{{ URL::asset('pic/svg/building-regular-th.png') }}"/></a>
									@endif
								</th>
								<th class="check_types">
									@if ($contains_get)
										<a href=<?php echo($path."&sort_type=fakultet"); ?>><img src="{{ URL::asset('pic/svg/university-solid-th.png') }}"/></a>
									@else
										<a href=<?php echo($path."?sort_type=fakultet"); ?>><img src="{{ URL::asset('pic/svg/university-solid-th.png') }}"/></a>
									@endif
								</th>
								<th class="check_types">
									@if ($contains_get)
										<a href=<?php echo($path."&sort_type=admin"); ?>><img src="{{ URL::asset('pic/svg/user-cog-solid-th.png') }}"/></a>
									@else
										<a href=<?php echo($path."?sort_type=admin"); ?>><img src="{{ URL::asset('pic/svg/user-cog-solid-th.png') }}"/></a>
									@endif
								</th>
							</tr>
							<?php $i = 1; ?>
							@foreach($work_list as $work)
							<tr class="search_hide_element">
								<td>{{ $i }}</td>
								<td><a class="search_element" href="work_list/{{ $work->id }}">{{ $work->name }}</a></td>
								<td>{{ $work->info }}</td>
								<td><?php echo($work_types[$i - 1]); ?></td>
								<td>{{ $work->ball }}</td>
								<td>{{ $work->date }}</td>
								@if( $work->kafedra_check)
									<td class="pic_td"><img src="{{ URL::asset('pic/check.png') }}"></td>
								@else
									<td class="pic_td"><img src="{{ URL::asset('pic/unchecked.png') }}"></td>
								@endif

								@if( $work->fakultet_check)
									<td class="pic_td"><img src="{{ URL::asset('pic/check.png') }}"></td>
								@else
									<td class="pic_td"><img src="{{ URL::asset('pic/unchecked.png') }}"></td>
								@endif

								@if( $work->admin_check)
									<td class="pic_td"><img src="{{ URL::asset('pic/check.png') }}"></td>
								@else
									<td class="pic_td"><img src="{{ URL::asset('pic/unchecked.png') }}"></td>
								@endif
							</tr>
							<?php $i++; ?>
							@endforeach
						</table>
					</div>
				</div>
			</div>

			<!-- Right sidebar -->
			<div id="sidebar_right" class="col-3">
				<h5>Işleriň sanawy sahypasy</h5>
				<p>Işleriň sanawy hakda gysgaça maglumat</p>
				<hr/>
				<div class="right_sidebar_list_item">
					<div class="row">
						<div class="col-3">
							<i></i>
						</div>
						<div class="col-9">
							<h5>Işleriň sanawyny görmek</h5>	
							<p>Siz öz bukjaňyzdaky işleriň sanawyny tablisa hökmünde görüp bilersiňiz.</p>
						</div>
					</div>
				</div>
				<div class="right_sidebar_list_item">
					<div class="row">
						<div class="col-3">
							<i></i>
						</div>
						<div class="col-9">
							<h5>Işiň faýllary</h5>	
							<p>Işiň içindäki faýllary görmek, goşmak we üýtgetmek üçin şol işiň adyna basyň.</p>
						</div>
					</div>
				</div>
				<div class="right_sidebar_list_item">
					<div class="row">
						<div class="col-3">
							<i></i>
						</div>
						<div class="col-9">
							<h5>Işleri filterlemek</h5>	
							<p>Işleri senesi boýunça filterläň. Filterlemek üçin ýyly we aýy saýlaň.</p>
						</div>
					</div>
				</div>
				<div class="right_sidebar_list_item">
					<div class="row">
						<div class="col-3">
							<i></i>
						</div>
						<div class="col-9">
							<h5>Işleri gözlemek</h5>	
							<p>Işleri gözleg tekst meýdançasynyň kömegi bilen gözlediň.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="{{ URL::asset('bootstrap/jquery-3.5.1.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('main.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/teacher/work_list.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('bootstrap/popper.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('bootstrap/bootstrap.js') }}"></script>
</body>
</html>