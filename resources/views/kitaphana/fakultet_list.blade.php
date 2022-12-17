<!DOCTYPE html>
<html>
<head>
	<title>{{ $name }} kitaphananyň sahypasy</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('bootstrap/bootstrap.css') }}">

	<!-- Main styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('main.css') }}">

	<!-- Teacher page styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/structure.css') }}">

	<!-- New work page styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/kafedra/teacher_list.css') }}">
</head>
<body>
	<div class="containe-fluid">
		<div class="row">

			<!-- Left sidebar -->
			<div id="sidebar_left" class="col-2">

				<!-- Logo -->
				<a id="logo" href="/ballsystem/public/">
					<img src="{{ URL::asset('pic/logo.png') }}">
				</a><br/>

				<!-- Links -->
				<a class="menu_link" href="teacher_list">
					<img src="{{ URL::asset('pic/svg/list-ul-solid.png') }}">
					<small>Mugallymlar reýtingy</small>
				</a>
				<a class="menu_link" href="kafedra_list">
					<img src="{{ URL::asset('pic/svg/list-ul-solid.png') }}">
					<small>Kafedralar reýtingy</small>
				</a>
				<a id="selected_sidebar_link" class="menu_link" href="fakultet_list">
					<img src="{{ URL::asset('pic/svg/list-ul-solid.png') }}">
					<small>Fakultetler reýtingy</small>
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
				<div id="work_list_div" class="row content_div">
					<div class="col">
						
						<!-- Header row -->
						<form action="" method="get">
							<div class="row align-items-center">
								<div class="col-8">
									<h5>Mugallymlaryň reýtingy</h5>
									<p>{{ $name }} kitaphananyň mugallymlaryň reýtingy</p>
								</div>
								<div class="w-100"></div>
								<div class="col-4">
									<!-- Hided select element -->
									<select name="sort_select" class="main_select">
										<option selected value="id"></option>
										<option value="asc"></option>
										<option value="desc"></option>
									</select>
									<!-- Custom select element -->
									<div style="width: 210px" class="custom_select_selected">
										<i></i>
										<span>Id-lar boýunça</span>
										<i></i>
										<div style="width: 210px" class="custom_select_div">
											<div>Id-lar boýunça</div>
											<div>Başda köp bally</div>
											<div>Başda az bally</div>
										</div>
									</div>
								</div>
								<div class="col-3">
									<!-- Hided select element -->
									<select name="year_select" class="main_select">
										<option selected value="Ýyly"></option>
										@foreach($work_years as $work_year)
										<option value="{{ $work_year }}"></option>
										@endforeach
									</select>
									<!-- Custom select element -->
									<div class="custom_select_selected">
										<i></i>
										<span>Ýyly</span>
										<i></i>
										<div class="custom_select_div">
											<div>Ýyly</div>
											@foreach($work_years as $work_year)
											<div>{{ $work_year }}</div>
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
						</form>
					</div>
					<div class="w-100"></div>

					<!-- Table -->
					<div id="work_list_table" class="col">
						<table id="works_table">
							<tr>
								<th>Id</th>
								<th>Mugallym</th>
								@foreach($work_types as $work_type)
								<th>{{ $work_type->name }}</th>
								@endforeach
								<th>Netije</th>
							</tr>
							<?php $i1 = 1; ?>
							@foreach($teachers as $teacher)
							<?php $i2 = 0; ?>
							<tr class="search_hide_element">
							<td>{{ $i1 }}</td>
							<td><a class="search_element" href="/ballsystem/public/fakultet/{{ $teacher->login }}/kafedra_list">{{ $teacher->name }}</a></td>
							@foreach($work_types as $work_type)
							<td>
								<?php 
									if (!isset($main_balls[$i1 - 1]->type_balls[$i2])){
										echo ("0");
									}else{
								?>
									{{ $main_balls[$i1 - 1]->type_balls[$i2] }}
								<?php }?>
							</td>
							<?php $i2++; ?>
							@endforeach
							<td>{{ $main_balls[$i1 - 1]->whole_ball }}</td>
							<?php $i1++; ?>
							</tr>
							@endforeach
						</table>
					</div>
				</div>
			</div>

			<!-- Right sidebar -->
			<div id="sidebar_right" class="col-3">
				<h5>Mugallymlaryň reýtingy sahypasy</h5>
				<p>Tablisa görnüşindäki mugallymlaryň reýtingy</p>
				<hr/>
				<div class="right_sidebar_list_item">
					<div class="row">
						<div class="col-3">
							<img width="45" height="35" src="{{ URL::asset('pic/svg/chalkboard-teacher-solid.png') }}">
						</div>
						<div class="col-9">
							<h5>Mugallymlaryň reýtingy</h5>	
							<p>Mugallymlaryň reýtingy tablisa görnüşinde berilen.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="{{ URL::asset('bootstrap/jquery-3.5.1.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/kafedra/teacher_list.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('bootstrap/popper.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('bootstrap/bootstrap.js') }}"></script>
</body>
</html>