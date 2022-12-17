<!DOCTYPE html>
<html>
<head>
	<title>Içeri giriň</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('bootstrap/bootstrap.css') }}">

	<!-- Main styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('main.css') }}">

	<!-- Login page styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/login.css') }}">
</head>
<body>
	<div class="container_fluid px-0">

		<!-- Login container -->
		<div id="login_container_row" class="row justify-content-center align-items-center">
			<div id="login_container" class="col-8">
				<div class="row">
					<div id="login_div" class="col-4">

						<!-- Login welcome -->
						<h3>Hoş geldiňiz</h3>
						<h6>Dowam etmek üçin içeri giriň</h6>

						<!-- Login form -->
						<form id="login_form" action="auth" method="post">
							@csrf

							<!-- Error message -->
							<?php
								if (isset($_GET['error'])){
									echo('<p id="error_message">Loginyňyz ýa-da passwordyňyz ýalňyş</p>');
								}
							?>
							<img src="{{ URL::asset('pic/svg/user-solid.png') }}">
							<input id="login_input" type="text" name="login" placeholder="login" required />
							<hr/>
							<img src="{{ URL::asset('pic/svg/key-solid.png') }}">
							<input type="password" name="password" placeholder="password" required />
							<hr/>	
							<div id="remember_div" class="remember_password_div">
								<input type="checkbox" name="remember">
								<label>Remember me</label>
							</div>
							<div id="password_div" class="remember_password_div">
								<a href="">Forgot password?</a>
							</div>
							<div id="login_submit_div">
								<input id="login_submit" type="submit" name="login_submit" value="Gir">
							</div>
							<input id="teacher_radio" class="user_type_radio" type="radio" name="user_type" value="teacher" checked />
							<input id="kafedra_radio" class="user_type_radio" type="radio" name="user_type" value="kafedra" />
							<input id="fakultet_radio" class="user_type_radio" type="radio" name="user_type" value="fakultet" />
							<input id="admin_radio" class="user_type_radio" type="radio" name="user_type" value="kitaphana" />
						</form>
					</div>
					<div id="user_type_div" class="col-8">
						<div id="user_type_first_row" class="row justify-content-center">
							<div id="teacher_div" id="user_type_div_selected" class="col-4 user_type_div">
								<img id="teacher_pic" src="{{ URL::asset('pic/svg/chalkboard-teacher-solid.png') }}">
								<br/>
								Mugallym
							</div>
							<div id="kafedra_div" class="col-4 offset-1 user_type_div">
								<img src="{{ URL::asset('pic/svg/building-regular.png') }}">
								<br/>
								Kafedra
							</div>
						</div>
						<div class="row justify-content-center">
							<div id="fakultet_div" class="col-4 user_type_div">
								<img src="{{ URL::asset('pic/svg/university-solid.png') }}">
								<br/>
								Fakultet
							</div>
							<div id="kitaphana_div" class="col-4 offset-1 user_type_div">
								<img id="admin_pic" src="{{ URL::asset('pic/svg/book-reader-solid.png') }}">
								<br/>
								Kitaphana
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="{{ URL::asset('bootstrap/jquery-3.5.1.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/login.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('bootstrap/popper.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('bootstrap/bootstrap.js') }}"></script>
</body>
</html>