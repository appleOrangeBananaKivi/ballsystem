<!DOCTYPE html>
<html>
<head>
	<title>{{ $name }} fakultetiň sahypasy</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('bootstrap/bootstrap.css') }}">

	<!-- Main styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('main.css') }}">

	<!-- Teacher page styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/structure.css') }}">

	<!-- New work page styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/kafedra/new_teacher.css') }}">
</head>
<body>
	
	@if ($user_type != "fakultet")
		@if ($user_type == "kitaphana")
			<div id="back_button">
				<a href="http://{{ $_SERVER['SERVER_NAME'] }}/ballsystem/public/kitaphana/{{ $admin_login }}/fakultet_list"><img src="{{ URL::asset('pic/svg/back_arrow.png') }}"></a>
			</div>
		@else
			<div id="back_button">
				<a href="http://{{ $_SERVER['SERVER_NAME'] }}/ballsystem/public/admin/{{ $admin_login }}/fakultet_list"><img src="{{ URL::asset('pic/svg/back_arrow.png') }}"></a>
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
				<a id="selected_sidebar_link" class="menu_link" href="new_teacher">
					<img src="{{ URL::asset('pic/svg/folder-open-solid.png') }}">
					<small>Kafedra goşmak</small>
				</a>
				<br/>
				<a class="menu_link" href="kafedra_list">
					<img src="{{ URL::asset('pic/svg/list-ul-solid.png') }}">
					<small>Kafedralaň reýtingy</small>
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

				<!-- New kafedra -->
				<div class="row justify-content-around">
					<div id="new_teacher_div" class="col-7">
						<h5>Täze kafedra goşmak</h5>
						<p>Maglumat bazasyna kafedra goşmak</p>

						<!-- New work add form -->
						<form id="new_teacher_form" action="new_kafedra/create" method="post">
							@csrf
							<label>Kafedranyň ady</label>
							<input class="new_teacher_input" type="text" name="name"/><br/>
							<label>Kafedranyň loginy</label>
							<input class="new_teacher_input" type="text" name="login"/><br/>
							<label>Kafedranyň paroly</label>
							<input class="new_teacher_input" type="text" name="password"/><br/>
							<input id="new_teacher_submit" type="submit" name="new_teacher_submit" value="Goş">
						</form>
					</div>

					<div class="col-4" id="teacher_pic_div">
						<img style="width: 40%;" src="{{ URL::asset('pic/svg/building-regular-selected.png') }}">
					</div>
				</div>
			</div>

			<!-- Right sidebar -->
			<div id="sidebar_right" class="col-3">
				<h5>Kafedra goşmak sahypasy</h5>
				<p>Täze kafedra goşmak hakda gysgaça maglumat</p>
				<hr/>
				<div class="right_sidebar_list_item">
					<div class="row">
						<div class="col-3">
							<img width="45" height="35" src="{{ URL::asset('pic/svg/chalkboard-teacher-solid.png') }}">
						</div>
						<div class="col-9">
							<h5>Kafedra goşmak</h5>	
							<p>Kafedralar bazasyna täze kafedra goşular.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="{{ URL::asset('bootstrap/jquery-3.5.1.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('bootstrap/popper.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('bootstrap/bootstrap.js') }}"></script>
</body>
</html>