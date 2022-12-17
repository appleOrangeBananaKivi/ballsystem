<!DOCTYPE html>
<html>
<head>
	<title>Içeri giriň</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('bootstrap/bootstrap.css') }}">

	<!-- Main styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('main.css') }}">

	<!-- Login page styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/about.css') }}">
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

			<!-- Features presentation -->
			<div id="features_presentation" class="row justify-content-center">
				<div class="col-6">
					<h1>Öz işiňizde ünsüňizi jemläň</h1>
				</div>
				<div class="w-100"></div>
				<div id="presentation_description" class="col-6">
					<h5>Öň siziň işiňiz köp wagty alardy, indiden beýläk işiňizi çaltlaşdyryň.</h5>
				</div>
				<div class="w-100"></div>
				<div class="col-3 feature_block">
					<div><img src="{{ URL::asset('pic/services1.svg') }}"/></div>
					<h4>Işiň awtomatizasiýasy</h4>
					<p>Awtomatlaşdyrylan proses ullanyjynyň ulgama giren badyna başlaýar.</p>
				</div>
				<div class="col-3 feature_block">
					<div><img src="{{ URL::asset('pic/services2.jpg') }}"/></div>
					<h4>Awtomatlaşdyrylan ball sistemasy</h4>
					<p>Web saýt ulanyjylaryň awtomatlaşdyrylan sistemysy hökmünde işleýär.</p>
				</div>
				<div class="col-3 feature_block">
					<div><img src="{{ URL::asset('pic/services3.svg') }}"/></div>
					<h4>Maglumatyň elýeterliligi</h4>
					<p>Web saýtdaky maglumat ulanyjy üçin elýeter.</p>
				</div>
				<div class="w-100"></div>
				<div class="col-3 feature_block">
					<div><img src="{{ URL::asset('pic/services4.svg') }}"/></div>
					<h4>Işlere amatly gözegçilik etmek</h4>
					<p>Işleriň bukjalaryny çalt we amatly gözegçilik etmek we barlamak.</p>
				</div>
				<div class="col-3 feature_block">
					<div><img src="{{ URL::asset('pic/services5.svg') }}"/></div>
					<h4>Kömekçi filtrler</h4>
					<p>Tablisadaky sanawlary çalt filtrlemek.</p>
				</div>
				<div class="col-3 feature_block">
					<div><img src="{{ URL::asset('pic/services6.svg') }}"/></div>
					<h4>Işleriň arhiwda saklanmagy</h4>
					<p>Işler serwerda bukjalarda saklanýar. Uly göwrümli arhiwleri döretmek mümkinçiligi.</p>
				</div>
			</div>
		</div>

		<div id="contact" class="row">
			<div class="col">
				Habarlaşmak üçin şu emaila ýazyp bilersiňiz: someemail@gmail.com
			</div>
		</div>
	</div>

	<script type="text/javascript" src="{{ URL::asset('bootstrap/jquery-3.5.1.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/login.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('bootstrap/popper.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('bootstrap/bootstrap.js') }}"></script>
</body>
</html>
