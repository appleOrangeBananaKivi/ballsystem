<!DOCTYPE html>
<html>
<head>
	<title>Içeri giriň</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('bootstrap/bootstrap.css') }}">

	<!-- Main styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('main.css') }}">

	<!-- Login page styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/news.css') }}">
</head>
<body>

	<div class="container-fluid px-0">

		<!-- Navbar -->
		<div id="navbar" class="row">

			<!-- Logo -->
			<div id="logo" class="col-2">
				<a href="">
					<img src="{{ URL::asset('pic/logo.png') }}">
				</a>
			</div>

			<!-- Nav -->
			<div id="nav" class="col- offset-4">
				<ul>
					<li style="padding-left: 15px;"><a class="draw" href="../public/">Baş</a></li>
					<li style="padding-left: 15px;"><a class="draw" href="news">Täzelikler</a></li>
					<!-- <li style="padding-left: 15px;"><a class="draw" href="">Statistika</a></li> -->
					<li style="padding-left: 15px;"><a class="draw" href="about">Barada</a></li>
				</ul>
			</div>

			<!-- Log in link -->
			<div id="logInLink" class="col-2">
				<a href="login">Log in</a>
			</div>
		</div>

		<div class="row">
			<div class="col-10">

				<!-- News header -->
				<h2 class="header">Täzelikler</h2>

				<!-- News blocks -->
				<div id="news_blocks_container" class="row justify-content-center">
					<div class="col-4">
						<div>
							<img src="{{ URL::asset('pic/bgcolor.jpg') }}">
						</div>
						<h5><a href="#">Täzelik</a></h5>
						<p>Täzelik hakda goşmaça maglumat</p>
					</div>
					<div class="col-4 offset-1">
						<div>
							<img src="{{ URL::asset('pic/bgcolor.jpg') }}">
						</div>
						<h5><a href="#">Täzelik</a></h5>
						<p>Täzelik hakda goşmaça maglumat</p>
					</div>

					<div class="col-4">
						<div>
							<img src="{{ URL::asset('pic/bgcolor.jpg') }}">
						</div>
						<h5><a href="#">Täzelik</a></h5>
						<p>Täzelik hakda goşmaça maglumat</p>
					</div>
					<div class="col-4 offset-1">
						<div>
							<img src="{{ URL::asset('pic/bgcolor.jpg') }}">
						</div>
						<h5><a href="#">Täzelik</a></h5>
						<p>Täzelik hakda goşmaça maglumat</p>
					</div>

					<div class="col-4">
						<div>
							<img src="{{ URL::asset('pic/bgcolor.jpg') }}">
						</div>
						<h5><a href="#">Täzelik</a></h5>
						<p>Täzelik hakda goşmaça maglumat</p>
					</div>
					<div class="col-4 offset-1">
						<div>
							<img src="{{ URL::asset('pic/bgcolor.jpg') }}">
						</div>
						<h5><a href="#">Täzelik</a></h5>
						<p>Täzelik hakda goşmaça maglumat</p>
					</div>
				</div>
			</div>
			<div id="sidebar_menu" class="col-2">

				<!-- Sidebar menu -->
				<h3 class="header">Kategoriýalar</h3>

				<div>
					<a href="#">Bilim</a><br/>
					<a href="#">Ball sistema</a><br/>
					<a href="#">Institut</a><br/>
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
