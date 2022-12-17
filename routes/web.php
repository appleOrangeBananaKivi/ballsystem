<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//redirect to home
Route::get('/', function () {
    return view('home');
});

//redirect to login page
Route::get('/login', function(Request $request){

	//check if prev query return error
	if (isset($request->error)){
		$error = $request->error;
		return view('login', ['error' => $error]);
	}else{
		return view('login');
	}
});

//redirect to news page
Route::get('/news', 'NewsController@showNews');

// redirect to about page
Route::get('/about', function(){
	return view('about');
});


//check login
Route::post('/auth', 'LoginController@loginCheck');

//redirect to teacher new work page
Route::get('/teacher/{login}/new_work', 'TeacherController@showNewWork');

//redirect to teacher work list page
Route::get('/teacher/{login}/work_list', 'TeacherController@showWorkList');

//redirect to teacher work list page
Route::get('/teacher/{login}/statistic', 'TeacherController@showStatistic');

//redirect to teacher work list page
Route::get('/teacher/{login}/profile', 'TeacherController@showProfile');

//create new work
Route::post('/teacher/{login}/new_work/create', 'TeacherController@createNewWork');

//show work page
Route::get('/teacher/{login}/work_list/{work_id}', 'TeacherController@showWork');

//download work file
Route::get('/teacher/{login}/work_list/{work_id}/download/{file_id}', 'TeacherController@downloadWorkFile');

//upload work file
Route::post('/teacher/{login}/work_list/{work_id}/upload', 'TeacherController@uploadWorkFile');

//check work
Route::get('/teacher/{login}/work_list/{work_id}/check', 'TeacherController@checkWork');


//redirect to teacher new work page
Route::get('/kafedra/{login}/new_teacher', 'KafedraController@showNewTeacher');

//create new teacher
Route::post('/kafedra/{login}/new_teacher/create', 'KafedraController@createNewTeacher');

//redirect to teacher list page
Route::get('/kafedra/{login}/teacher_list', 'KafedraController@showTeacherList');

//redirect to statistic page
Route::get('/kafedra/{login}/statistic', 'KafedraController@showStatistic');

//redirect to profile page
Route::get('/kafedra/{login}/profile', 'KafedraController@showProfile');

//redirect to teacher list page
Route::get('/kitaphana/{login}/teacher_list', 'KitaphanaController@showTeacherList');

//redirect to kafedra list page
Route::get('/kitaphana/{login}/kafedra_list', 'KitaphanaController@showKafedraList');

//redirect to fakultet list page
Route::get('/kitaphana/{login}/fakultet_list', 'KitaphanaController@showFakultetList');

//redirect to profile page
Route::get('/kitaphana/{login}/profile', 'KitaphanaController@showProfile');


// Fakultet
// redirect to new kafedra
Route::get('/fakultet/{login}/new_kafedra', 'FakultetController@showNewKafedra');

// create new kafedra
Route::post('/fakultet/{login}/new_kafedra/create', 'FakultetController@createNewKafedra');

// redirect kafedra list
Route::get('/fakultet/{login}/kafedra_list', 'FakultetController@showKafedraList');

//redirect to statistic page
Route::get('/fakultet/{login}/statistic', 'FakultetController@showStatistic');

//redirect to profile page
Route::get('/fakultet/{login}/profile', 'FakultetController@showProfile');


// Admin
// redirect to new fakultet
Route::get('/admin/{login}/new_fakultet', 'AdminController@showNewFakultet');

// create new fakultet
Route::post('/admin/{login}/new_fakultet/create', 'AdminController@createNewFakultet');

// redirect to fakultet list
Route::get('/admin/{login}/fakultet_list', 'AdminController@showFakultetList');

//redirect to profile page
Route::get('/admin/{login}/profile', 'AdminController@showProfile');
