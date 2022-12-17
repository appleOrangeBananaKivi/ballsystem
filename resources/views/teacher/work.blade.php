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
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/teacher/work.css') }}">
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
				<a class="menu_link" href="/ballsystem/public/teacher/{{ $login }}/new_work">
					<img src="{{ URL::asset('pic/svg/folder-open-solid.png') }}">
					Iş goşmak
				</a>
				<br/>
				<a id="selected_sidebar_link" class="menu_link" href="/ballsystem/public/teacher/{{ $login }}/work_list">
					<img src="{{ URL::asset('pic/svg/list-ul-solid.png') }}">
					Işleriň sanawy
				</a>
				<br/>
				<a class="menu_link" href="/ballsystem/public/teacher/{{ $login }}/statistic">
					<img src="{{ URL::asset('pic/svg/chart-line-solid.png') }}">
					Statistika
				</a>
				<br/>
				<a class="menu_link" href="/ballsystem/public/teacher/{{ $login }}/profile">
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
						<input id="search" onkeyup="search()" type="text" name="search"/>
					</div>
				</div>

				<!-- Info divs -->
				<div id="info_divs_container" class="row">
					<div class="col info_div">
						<div>
							<h4>Iş</h4>
						</div>
						<div>
							<span>{{ $work->name }}</span>
						</div>
					</div>
					<div class="col info_div">
						<div>
							<h4>Bal</h4>
						</div>
						<div>
							<span>
								@if ($work->ball == 0) 
									Barlagda
							 	@else
							 		{{ $work->ball }}
							 	@endif
							</span>
						</div>
					</div>
					<div class="col info_div">
						<div>
							<h4>Id</h4>
						</div>
						<div>
							<span>{{ $work->id }}</span>
						</div>
					</div>
					<div id="check_img_div" class="col info_div">
						<?php 
							if ($user_type != 'teacher'){
								switch ($user_type) {
									case 'kafedra':
										$checked = $work->kafedra_check;
										break;
									case 'fakultet':
										$checked = $work->fakultet_check;
										break;
									case 'admin':
										$checked = $work->admin_check;
										break;
									case 'kitaphana':
										$checked = $work->admin_check;
										break;
								}
								if ($checked){
									echo("<img src=".URL::asset('pic/check.png').">");
								}else{
									echo("<a href='".$work->id."/check'>
											<img src=".URL::asset('pic/unchecked.png').">
										</a>");
								}
							}else{
								if ($work->admin_check)
									echo("<img src='".URL::asset('pic/check.png')."'>");
								else
									echo("<img src='".URL::asset('pic/unchecked.png')."'>");
							}
						?>
					</div>
				</div>

				<!-- Work info and work date -->
				<div class="row">
					<div id="work_info" class="col-7 content_div">
						<h5>Iş hakda maglumat</h5>
						<p>Işi suratlandyrýan gysgaça maglumat</p>
						<p>{{ $work->info }}</p>
					</div>
					<div id="work_date" class="col">
						<h5>Işiň senesi</h5>
						<p>Işiň bukja goşulan senesi</p>
						<h3>{{ $work->date }}</h3>
					</div>
				</div>

				<!-- Work files list -->
				<div id="work_files" class="row content_div">
					<div class="col">
						<div class="col-4">
							<h5>Işleriň sanawy</h5>
							<p>Siziň bukjaňyzdaky ähli işler.</p>
						</div>
					</div>

					<div class="w-100"></div>

					<div id="work_files_table_div" class="col">
						<table>
							<tr>
								<th>id</th>
								<th>Faýlyň ady</th>
								<th>Göwrümi</th>
								<th>Senesi</th>
							</tr>
							<?php $counter = 1;?>
							@if (isset($files))
								@foreach($files as $file)
								<tr class="search_hide_element">
									<td>{{ $counter }}</td>
									<td><a class="search_element" href="{{ $work_id }}/download/{{ $counter }}">{{ $file->name }}</a></td>
									<td>{{ $file->size }} {{ $file->size_type }}</td>
									<td>{{ $file->time }}</td>
								</tr>
								<?php $counter += 1; ?>
								@endforeach
							@endif
						</table>
					</div>
				</div>

				<!-- Upload new file -->
				<div id="upload_file" class="row content_div">
					<div class="col">
						<h5>Faýl ýüklemek</h5>
						<p>Işiň bukjasyna faýllary ýükläň.</p>
					</div>
					<div class="w-100"></div>
					<div class="col">
						<form action="{{ $work_id }}/upload" method="post" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="col-10">
							  		<input type="file" class="custom-file-input" id="customFile" name="upload_file">
							  		<label class="custom-file-label" for="customFile">Faýly saýlaň</label>
								</div>
								<div class="col-2">
							 		<input class="btn btn-outline-primary" type="submit" name="upload_file_submit" id="upload_file_submit" value="Ýüklemek">
								</div>
							</div>
						</form>
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
							<i></i>
						</div>
						<div class="col-9">
							<h5>Işiň sahypasy</h5>	
							<p>Iş hakda maglumat berilen. Işiň içindäki faýllary görüp bilersiňiz.</p>
						</div>
					</div>
				</div>
				<div class="right_sidebar_list_item">
					<div class="row">
						<div class="col-3">
							<i></i>
						</div>
						<div class="col-9">
							<h5>Işiň baly</h5>	
							<p>Işiň barlanandan soň goýulan baly.</p>
						</div>
					</div>
				</div>
				<div class="right_sidebar_list_item">
					<div class="row">
						<div class="col-3">
							<i></i>
						</div>
						<div class="col-9">
							<h5>Işiň senesi</h5>	
							<p>Işiň goşulan senesi.</p>
						</div>
					</div>
				</div>
				<div class="right_sidebar_list_item">
					<div class="row">
						<div class="col-3">
							<i></i>
						</div>
						<div class="col-9">
							<h5>Işiň bukjasyndaky faýllar</h5>	
							<p>Işiň bukjasyndaky faýllararyň sanawy. Faýlyň üstüne basyp geçirip bilersiňiz</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="{{ URL::asset('bootstrap/jquery-3.5.1.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('main.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/teacher/work.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('bootstrap/popper.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('bootstrap/bootstrap.js') }}"></script>
</body>
</html>