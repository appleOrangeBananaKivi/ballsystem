<!DOCTYPE html>
<html>
<head>
	<title>{{ $admin_info->name }} adminyň sahypasy</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('bootstrap/bootstrap.css') }}">

	<!-- Main styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('main.css') }}">

	<!-- Teacher page styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/structure.css') }}">

	<!-- Teacher page styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/teacher.css') }}">
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
				<a class="menu_link" href="fakultet_list">
					<img src="{{ URL::asset('pic/svg/list-ul-solid.png') }}">
					<small>Fakultetler reýtingy</small>
				</a>
				<br/>
				<a id="selected_sidebar_link" class="menu_link" href="profile">
					<img src="{{ URL::asset('pic/svg/user-circle-solid.png') }}">
					Meniň profilim
				</a>
				<br/>
			</div>

			<!-- Main content -->
			<div id="main" class="col-7">
				<div class="content_div">
					<h5>Admin hakda maglumat</h5>
					<p>Admin hakda maglumat bazasyndaky maglumatlar</p>
					<p><b>Id</b> - {{ $admin_info->id }}</p>
					<p><b>Ady</b> - {{ $admin_info->name }}</p>
					<p><b>Loginy</b> - {{ $login }}</p>
				</div>
			</div>

			<!-- Right sidebar -->
			<div id="sidebar_right" class="col-3">
				<h5>Meniň profilim sahypasy</h5>
				<p>Adminyň profili hakda gysgaça maglumat</p>
				<hr/>
				<div class="right_sidebar_list_item">
					<div class="row">
						<div class="col-3">
							<img width="35" height="35" src="{{ URL::asset('pic/svg/folder-open-solid.png') }}">
						</div>
						<div class="col-9">
							<h5>Meniň profilim</h5>	
							<p>Meniň profilim sahypada admin hakda maglumat berlen.</p>
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