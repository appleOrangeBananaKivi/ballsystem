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

	<!-- New work page styles -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/teacher/new_work.css') }}">
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
				<a id="selected_sidebar_link" class="menu_link" href="new_work">
					<img src="{{ URL::asset('pic/svg/folder-open-solid.png') }}">
					Iş goşmak
				</a>
				<br/>
				<a class="menu_link" href="work_list">
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

				<!-- New work -->
				<div class="row justify-content-around">
					<div id="new_work_div" class="col-7">
						<h5>Täze iş goşmak</h5>
						<p>Maglamuat bazasyna iş goşmak</p>

						<!-- New work form -->
						<form id="new_work_form" action="new_work/create" method="post">
							@csrf
							<label>Işiň ady</label>
							<input class="new_work_name_input" type="text" name="name"/><br/>
							<label>Işiň görnüşi</label>
							<select id="main_work_type_select" name="type">
								@foreach ($main_work_types as $main_work_type)
									<option value="{{ $main_work_type->id }}">{{ $main_work_type->name }}</option>
								@endforeach
							</select><br/>
							@foreach ($main_work_types as $main_work_type)
								<div id="inner_work_type{{ $main_work_type->id }}" class="inner_work_type_container">
									<label>Işiň içki görnüşi</label>
									<select name="inner_work_type">
										@foreach ($inner_work_types as $inner_work_type)
											@if ($inner_work_type->main_work_type == $main_work_type->id)
												<option value="{{ $inner_work_type->id }}">{{ $inner_work_type->name }}</option>
											@endif
										@endforeach
									</select>
								</div>
							@endforeach
							<label>Iş hakda maglumat</label>
							<textarea class="new_work_name_input" name="info"></textarea>
							<input id="new_work_submit" type="submit" name="new_work_submit" value="Goş">
						</form>
					</div>

					<div class="col-4" id="folder_pic_div">
						<img src="{{ URL::asset('pic/folder.jpg') }}">
					</div>
				</div>
			</div>

			<!-- Right sidebar -->
			<div id="sidebar_right" class="col-3">
				<h5>Iş goşmak sahypasy</h5>
				<p>Täze iş goşmak hakda gysgaça maglumat</p>
				<hr/>
				<div class="right_sidebar_list_item">
					<div class="row">
						<div class="col-3">
							<img width="35" height="35" src="{{ URL::asset('pic/svg/folder-open-solid.png') }}">
						</div>
						<div class="col-9">
							<h5>Iş goşmak</h5>	
							<p>Siziň bukjaňyza täze iş bukjasy goşular. Onuň içine şol işe degişli faýllary ýükläp bilersiňiz.</p>
						</div>
					</div>
				</div>
				<div class="right_sidebar_list_item">
					<div class="row">
						<div class="col-3">
							<img width="50" height="30" src="{{ URL::asset('pic/svg/name.png') }}">
						</div>
						<div class="col-9">
							<h5>Işiň ady manyly bolamly</h5>	
							<p>Işiň ady iş näme hakdadygyny suratlandyrmaly.</p>
						</div>
					</div>
				</div>
				<div class="right_sidebar_list_item">
					<div class="row">
						<div class="col-3">
							<i></i>
						</div>
						<div class="col-9">
							<h5>Işiň görnüşini saýlaň</h5>	
							<p>Siziň işiňiz haýsy işleriň görnüşine degişlidigini saýlamaly.</p>
						</div>
					</div>
				</div>
				<div class="right_sidebar_list_item">
					<div class="row">
						<div class="col-3">
							<i></i>
						</div>
						<div class="col-9">
							<h5>Iş hakda maglumat</h5>	
							<p>Iş hakda maglumat özünde işi gysgaça suratlandyrmaly.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="{{ URL::asset('bootstrap/jquery-3.5.1.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/teacher/new_work.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('bootstrap/popper.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('bootstrap/bootstrap.js') }}"></script>
</body>
</html>
