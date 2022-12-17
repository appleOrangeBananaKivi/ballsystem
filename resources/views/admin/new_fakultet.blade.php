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
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/kafedra/new_teacher.css') }}">
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
				<a id="selected_sidebar_link" class="menu_link" href="new_fakultet">
					<img src="{{ URL::asset('pic/svg/folder-open-solid.png') }}">
					<small>Fakultet goşmak</small>
				</a>
				<br/>
				<a class="menu_link" href="fakultet_list">
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

				<!-- New fakultet -->
				<div class="row justify-content-around">
					<div id="new_teacher_div" class="col-7">
						<h5>Täze fakultet goşmak</h5>
						<p>Maglumat bazasyna fakultet goşmak</p>

						<!-- New fakultet form -->
						<form id="new_teacher_form" action="new_fakultet/create" method="post">
							@csrf
							<label>Fakultetiň ady</label>
							<input class="new_teacher_input" type="text" name="name"/><br/>
							<label>Fakultetiň loginy</label>
							<input class="new_teacher_input" type="text" name="login"/><br/>
							<label>Fakultetiň paroly</label>
							<input class="new_teacher_input" type="text" name="password"/><br/>
							<input id="new_teacher_submit" type="submit" name="new_teacher_submit" value="Goş">
						</form>
					</div>

					<div class="col-4" id="teacher_pic_div">
						<img style="width: 40%;" src="{{ URL::asset('pic/svg/university-solid-selected.png') }}">
					</div>
				</div>
			</div>

			<!-- Right sidebar -->
			<div id="sidebar_right" class="col-3">
				<h5>Fakultet goşmak sahypasy</h5>
				<p>Täze fakultet goşmak hakda gysgaça maglumat</p>
				<hr/>
				<div class="right_sidebar_list_item">
					<div class="row">
						<div class="col-3">
							<img width="45" height="35" src="{{ URL::asset('pic/svg/chalkboard-teacher-solid.png') }}">
						</div>
						<div class="col-9">
							<h5>Fakultet goşmak</h5>	
							<p>Fakultetler bazasyna täze kafedra goşular.</p>
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