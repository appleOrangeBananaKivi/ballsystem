<!DOCTYPE html>
<html>
<head>
	<title>{{ $name }} adminyň sahypasy</title>

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
				<a class="menu_link" href="new_fakultet">
					<img src="{{ URL::asset('pic/svg/folder-open-solid.png') }}">
					<small>Fakultet goşmak</small>
				</a>
				<br/>
				<a id="selected_sidebar_link" class="menu_link" href="fakultet_list">
					<img src="{{ URL::asset('pic/svg/list-ul-solid.png') }}">
					<small>Fakultetler reýtingy</small>
				</a>
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
									<h5>Fakultetlar reýtingy</h5>
									<p>Maglumat bazasyndaky fakultetlaryň reýtingy</p>
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
								<th>Kafedra</th>
								@foreach($work_types as $work_type)
								<th><p>{{ $work_type->name }}</p></th>
								@endforeach
								<th><p>Netije</p></th>
							</tr>
							<?php $i = 1; ?>
							@foreach($fakultets as $fakultet)
							<?php $i1 = 0; ?>
							<tr class="search_hide_element">
							<td>{{ $i }}</td>
							<td><a class="search_element" href="/ballsystem/public/fakultet/{{ $fakultet->login }}/kafedra_list">{{ $fakultet->name }}</a></td>
							@foreach($work_types as $work_type)
							<td>
								<?php 
									if(isset($fakultet_ratings[$i - 1]->type_balls[$i1]))
										echo($fakultet_ratings[$i - 1]->type_balls[$i1]);
									else
										echo(0);
								?>
							</td>
							<?php $i1++; ?>
							@endforeach
							<td>{{ $fakultet_ratings[$i - 1]->whole_ball }}</td>
							<?php $i++; ?>
							</tr>
							@endforeach
						</table>
					</div>
				</div>
			</div>

			<!-- Right sidebar -->
			<div id="sidebar_right" class="col-3">
				<h5>Fakultetler reýtingy sahypasy</h5>
				<p>Tablisa görnüşindäki fakultetleriň reýtingy</p>
				<hr/>
				<div class="right_sidebar_list_item">
					<div class="row">
						<div class="col-3">
							<img width="35" height="35" src="{{ URL::asset('pic/svg/university-solid.png') }}">
						</div>
						<div class="col-9">
							<h5>Fakultetler reýtingy sahypasy</h5>
							<p>Tablisa görnüşindäki fakultetleriň reýtingyy</p>
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