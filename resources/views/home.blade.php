<?php 
	$server_name = "localhost/ballsystem/public/";
?>
<html>
<head>
	<title><?php print env('APP_NAME'); ?></title>

	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('bootstrap/bootstrap.css') }}">

	<!-- Main styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('main.css') }}">

	<!-- Home page styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/home.css') }}">
</head>
<body>

	<div class="container-fluid px-0">

		<!-- Header -->
		<div id="header">

			<!-- Navbar -->
			<div id="navbar" class="row">

				<!-- Logo -->
				<div id="logo" class="col-2">
					<a href="">
						<img src="{{ URL::asset('pic/logo.png') }}">
					</a>
				</div>

				<!-- Nav -->
				<div id="nav" class="col-4 offset-4">
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

			<!-- Welcome header -->
			<div id="welcome_div" class="row justify-content-center">
				<div class="col-6">
					<h1>Institutyň ball sistemasyny web saýtyň kömegi bilen dolarandyrmak</h1>
				</div>
				<div class="w-100"></div>
				<div id="welcome_description" class="col-6">
					<h5>Institutyň ball sistemasyny web saýtyň kömegi bilen dolarandyrma</h5>
				</div>
				<div class="w-100"></div>
				<div class="col-6">
					<a id="start_now" href="login">Häziriň özünde başla</a>
				</div>
				<div class="w-100"></div>
				<div id="welcome_screen_div" class="col-8">
					<img src="{{ URL::asset('pic/screen.png') }}"/>
				</div>
			</div>
		</div>

		<!-- Features presentation -->
		<div class="row justify-content-center">
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

		<!-- Footer -->
		<div id="footer" class="row justify-content-center">
			<div id="footer_contact" class="col-4">
				<img src="{{ URL::asset('pic/logo.png') }}">
				<h6>Awtomatlaşdyrylan proses ullanyjynyň ulgama giren badyna başlaýar.</h6>
				<a href=""><img src="{{ URL::asset('pic/svg/twitter-brands.png') }}"/></a>
				<a href=""><img src="{{ URL::asset('pic/svg/facebook-f-brands.png') }}"/></a>
				<a href=""><img src="{{ URL::asset('pic/svg/phone-alt-solid.png') }}"/></a>
			</div>
			<div class="col-2">
				<h4>Sanly çözgüt</h4>
				<a href="">Sistema hakda</a><br/>
				<a href="">Ullanmak tertibi</a>
			</div>
			<div class="col-2">
				<h4>Sanly çözgüt</h4>
				<a href="">Sistema hakda</a><br/>
				<a href="">Ullanmak tertibi</a>
			</div>
			<div class="col-2">
				<h4>Sanly çözgüt</h4>
				<a href="">Sistema hakda</a><br/>
				<a href="">Ullanmak tertibi</a>
			</div>
		</div>
		<div id="footer_copyright" class="col">
			Copyright ©2021 Ähli hukuklary goralgy
		</div>
	</div>

	<script type="text/javascript" src="{{ URL::asset('bootstrap/jquery-3.5.1.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('bootstrap/popper.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('bootstrap/bootstrap.js') }}"></script>
</body>
</html>