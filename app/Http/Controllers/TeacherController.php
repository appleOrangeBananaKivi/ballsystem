<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Storage;

class TeacherController extends Controller
{	
	function getTeacherName($login){
    	$name_result = DB::select('select name from teacher where login = ?', [$login]);
    	return $name_result[0]->name;
	}

    function showNewWork(Request $request, $login){
    	$name = $this->getTeacherName($login);

        // get kafedra login
        $kafedra_login = $request->session()->get("kafedra_login");

        // Get user type
        $user_type = $request->session()->get('user_type');

        // Get work types
        $main_work_types = DB::select('select * from work_type');
        $inner_work_types = DB::select('select * from inner_work_type');

        // get user login
        if ($request->session()->get('user_type') == "kitaphana"){
            $user_login = $request->session()->get('user_login');
        }else{
            $user_login = $request->session()->get('kafedra_login');
        }

    	return view('teacher/new_work', ['login' => $login, 'name' => $name, 'user_login' => $user_login, 'user_type' => $user_type, 'main_work_types' => $main_work_types, 'inner_work_types' => $inner_work_types]);
    }

    function showWorkList(Request $request, $login){

    	//get teacher name
    	$name = $this->getTeacherName($login);
    	
    	//get teacher id
    	$teacher_id_result = DB::select('select `id` from teacher where login = ?', [$login]);

        //get filter
        $filter_year = $request->input('year_select');
        $filter_month = $request->input('month_select');

        // Sort info
        $sort_type = $request->input("sort_type");
        $sort_num = $this->getSortNum($request, $sort_type);

        //get teacher works
        if (($filter_year == "Ýyly" and $filter_month == "Aýy") or (!isset($filter_year))){

            //sorting
            if (isset($sort_type)){
                switch ($sort_num) {
                    case 1:
                        $work_list = DB::select('select * from work where teacher_id = ? order by '.$sort_type.'_check desc', [$teacher_id_result[0]->id]);
                        break;
                    case 2:
                        $work_list = DB::select('select * from work where teacher_id = ? order by '.$sort_type.'_check asc', [$teacher_id_result[0]->id]);
                        break;
                    case 3:
                        $work_list = DB::select('select * from work where teacher_id = ?', [$teacher_id_result[0]->id]);
                        break;
                }
            }else{
                $work_list = DB::select('select * from work where teacher_id = ?', [$teacher_id_result[0]->id]);
            }
        }
    	else if ($filter_month == "Aýy"){
            if (isset($sort_type)){
                switch ($sort_num) {
                    case 1:
                        $work_list = DB::select('select * from work where teacher_id = ? and year(date) = ? order by '.$sort_type.'_check desc', [$teacher_id_result[0]->id, $filter_year]);
                        break;
                    case 2:
                        $work_list = DB::select('select * from work where teacher_id = ? and year(date) = ? order by '.$sort_type.'_check asc', [$teacher_id_result[0]->id, $filter_year]);
                        break;
                    case 3:
                        $work_list = DB::select('select * from work where teacher_id = ? and year(date) = ?', [$teacher_id_result[0]->id, $filter_year]);
                        break;
                }
            }else{
                $work_list = DB::select('select * from work where teacher_id = ? and year(date) = ?', [$teacher_id_result[0]->id, $filter_year]);
            }
        }
        else{
            if (isset($sort_type)){
                switch ($sort_num) {
                    case 1:
                        $work_list = DB::select('select * from work where teacher_id = ? and year(date) = ? and month(date) = ? order by '.$sort_type.'_check desc', [$teacher_id_result[0]->id, $filter_year, $filter_month]);
                        break;
                    case 2:
                        $work_list = DB::select('select * from work where teacher_id = ? and year(date) = ? and month(date) = ? order by '.$sort_type.'_check asc', [$teacher_id_result[0]->id, $filter_year, $filter_month]);
                        break;
                    case 3:
                        $work_list = DB::select('select * from work where teacher_id = ? and year(date) = ? and month(date) = ?', [$teacher_id_result[0]->id, $filter_year, $filter_month]);
                        break;
                }
            }else{
                $work_list = DB::select('select * from work where teacher_id = ? and year(date) = ? and month(date) = ?', [$teacher_id_result[0]->id, $filter_year, $filter_month]);
            }
        }

    	//get work types
    	$main_work_types = DB::select('select name from work_type');
        $inner_work_types = DB::select('select * from inner_work_type');

        $whole_work_list = DB::select('select * from work where teacher_id = ?', [$teacher_id_result[0]->id]);

        // get work years
        $years = [];
        $work_types = [];
        $i = 0;
        foreach ($whole_work_list as $work) {
            $year_str = substr($work->date, 0, 4);
            if (array_search($year_str, $years) === false){
                $years[count($years)] = $year_str;
            }

            /* get work typeof work */
            if ($work->inner_type_id != 0){
                $work_types[$i] = $inner_work_types[$work->inner_type_id - 1]->name;
            }else{
                $work_types[$i] = $main_work_types[$work->type_id - 1]->name;
            }
            $i++;
        }

        // get user login
        if ($request->session()->get('user_type') == "kitaphana"){
            $user_login = $request->session()->get('user_login');
        }else{
            $user_login = $request->session()->get('kafedra_login');
        }

        // Get user type
        $user_type = $request->session()->get('user_type');

    	return view('teacher/work_list', ['login' => $login, 'name' => $name, 'work_list' => $work_list, 'years' => $years, 'user_login' => $user_login, 'user_type' => $user_type, 'work_types' => $work_types]);
    }

    //get balls
    function get_ball($id){
        $balls = DB::select('select ball from work where teacher_id = ?', [$id]);
        $ball_sum = 0;
        foreach ($balls as $ball) {
            $ball_sum += $ball->ball;
        }
        return $ball_sum;
    }

    function showStatistic(Request $request, $login){

        //get teacher id
        $teacher_id_result = DB::select('select `id` from teacher where login = ?', [$login]);
        $teacher_id = $teacher_id_result[0]->id;

        // get rating
        $work_infos = DB::select('select ball, teacher_id from work');
        
        // get teacher ids
        $teacher_ids = [];
        $teacher_id_index = 0;
        $i = 0;
        foreach ($work_infos as $info) {
            if (array_search($info->teacher_id, $teacher_ids) === false){
                $teacher_ids[$i] = $info->teacher_id;
                if ($teacher_id == $teacher_ids[$i])
                    $teacher_id_index = $i;
                $i++;
            }
        }

        //get teacher balls
        $teacher_balls = [];
        $i = 0;
        foreach ($teacher_ids as $id) {
            $teacher_balls[$i] = $this->get_ball($id);
            $i++;
        }

        // get teacher summary ball
        $teacher_sum_ball = $teacher_balls[$teacher_id_index];

        // sorting and finding rating
        rsort($teacher_balls);
        $teacher_rating = array_search($teacher_sum_ball, $teacher_balls) + 1;

        // finding top work
        $top_work_select = DB::select('select name from work where teacher_id = ? order by ball desc', [$teacher_id]);
        $top_work = $top_work_select[0]->name;

        // month balls
        for ($i = 1; $i <= 12; $i++){
            if ($i < 10)
                $month_select = DB::select('select ball from work where teacher_id = ? and month(date) = ? and year(date) = ?', [$teacher_id, '0' + $i, date("Y")]);
            else
                $month_select = DB::select('select ball from work where teacher_id = ? and month(date) = ? and year(date) = ?', [$teacher_id, $i, date("Y")]);
            $month_ball = 0;
            foreach ($month_select as $month) {
                $month_ball += $month->ball;
            }
            $months[$i] = $month_ball;
        }

        // get work types
        $select_work_types = DB::select('select type_id from work where teacher_id = ?', [$teacher_id]);

        // work types
        $work_types = [];
        $i = 0;
        foreach ($select_work_types as $select_work_type) {
            if (array_search($select_work_type->type_id, $work_types) === false){
                $work_types[$i] = $select_work_type->type_id;
                $i++;
            }
        }

        //get work types sum
        $work_types_sum = [];
        $i = 0;
        foreach ($work_types as $work_type) {
            $select_result = DB::select('select * from work where teacher_id = ? and type_id = ?', [$teacher_id, $work_type]);
            $work_types_sum[$i] = count($select_result);
            $i++;
        }

        //get work types names
        $work_types_names = [];
        $i = 0;
        foreach ($work_types as $work_type) {
            $select_result = DB::select('select name from work_type where id = ?', [$work_type]);
            $work_types_names[$i] = $select_result[0]->name;
            $i++;
        }

        // get user login
        if ($request->session()->get('user_type') == "kitaphana"){
            $user_login = $request->session()->get('user_login');
        }else{
            $user_login = $request->session()->get('kafedra_login');
        }

        // Get user type
        $user_type = $request->session()->get('user_type');

    	$name = $this->getTeacherName($login);
    	return view('teacher/statistic', [
            'login' => $login, 
            'name' => $name, 
            'rating' => $teacher_rating, 
            'ball' => $teacher_sum_ball, 
            'top_work' => $top_work, 
            'months' => $months, 
            'work_types_names' => $work_types_names,
            'work_types_sum' => $work_types_sum, 
            'user_login' => $user_login, 
            'user_type' => $user_type
        ]);
    }

    function showProfile(Request $request, $login){
        $teacher_info = DB::select('select id, kafedra_id from teacher where login = ?', [$login]);
    	$name = $this->getTeacherName($login);
        $kafedra_select = DB::select('select name from kafedra where id = ?', [$teacher_info[0]->kafedra_id]);

        // get user type
        $user_type = $request->session()->get('user_type');

        // get user login
        if ($request->session()->get('user_type') == "kitaphana"){
            $user_login = $request->session()->get('user_login');
        }else{
            $user_login = $request->session()->get('kafedra_login');
        }

    	return view('teacher/profile', ['login' => $login, 'name' => $name, 'teacher_info' => $teacher_info, 'kafedra' => $kafedra_select[0]->name, 'user_login' => $user_login, 'user_type' => $user_type]);
    }

    //create new work form
    function createNewWork(Request $request, $teacher_login){

        // get info
    	$teacher_id_result = DB::select('select `id` from teacher where login = ?', [$teacher_login]);
    	$name = $request->name;
        if ($request->inner_work_type != ''){
            $inner_work_type = $request->inner_work_type;
        }else{
            $inner_work_type = 0;
        }
        $type = $request->type;
    	$info = $request->info;
    	$teacher_id = $teacher_id_result[0]->id;
    	$today = getdate();
    	$date = $today['year'].'-'.$today['mon'].'-'.$today['mday'];

        // inserting to database
    	$insert_result = DB::insert('insert into work (name, info, type_id, inner_type_id, ball, teacher_id, date, kafedra_check, fakultet_check, admin_check) values (?, ?, ?, ?, 0, ?, ?, false, false, false)', [$name, $info, $type, $inner_work_type, $teacher_id, $date]);

        // get work id
        $select_result = DB::select('select * from work');
        $work_id = $select_result[count($select_result) - 1]->id;

        // creating folder of work
        $mkdir_result = Storage::disk('local')->makeDirectory('teacher_works/'.$teacher_id.'/'.$work_id );

    	if ($insert_result and $mkdir_result){
    		return redirect('teacher/'.$teacher_login.'/new_work');
    	}else{
    		return "error";
    	}
    }

    //show work page
    function showWork(Request $request, $login, $work_id){

        // get info
        $name = $this->getTeacherName($login);
        $teacher_id_result = DB::select('select `id` from teacher where login = ?', [$login]);
        $teacher_id = $teacher_id_result[0]->id;
        $work = DB::select('select * from work where id = ?', [$work_id]);

        // get work files
        $path = 'teacher_works/'.$teacher_id.'/'.$work_id.'/';
        $file_names = Storage::files($path);
        for ($i = 0; $i < count($file_names); $i++) {
            $time = date('Y-m-d', Storage::lastModified($file_names[$i]));
            $size = Storage::size($file_names[$i]);

            // file size
            for ($i1 = 0; $i1 < 4; $i1++) { 
                if ($size > 1024){
                    $size /= 1024;
                }else{
                    break;
                }
            }
            $size_types = ['B', 'KB', 'MB', 'GB', 'TB'];
            $size_type = $size_types[$i1];

            $file_name = str_replace($path, '', $file_names[$i]);
            $files[$i] = new File($file_name, $time, $size, $size_type);
        }

        // Get user type
        $user_type = $request->session()->get('user_type');

        // get user login
        if ($request->session()->get('user_type') == "kitaphana"){
            $user_login = $request->session()->get('user_login');
        }else{
            $user_login = $request->session()->get('kafedra_login');
        }

        if (isset($files))
            return view('teacher/work', ['login' => $login, 'name' => $name, 'work_id' => $work_id, 'work' => $work[0], 'user_type' => $user_type, 'user_login' => $user_login, 'files' => $files]);
        else
            return view('teacher/work', ['login' => $login, 'name' => $name, 'work_id' => $work_id, 'work' => $work[0], 'user_type' => $user_type, 'user_login' => $user_login]);
    }

    // check work
    function checkWork(Request $request, $login, $work_id){
        $user_type = $request->session()->get("user_type");
        switch ($user_type) {
            case 'kafedra':
                $update_result = DB::update('update work set kafedra_check = true where id = ?', [$work_id]);
                break;
            case 'fakultet':
                $update_result = DB::update('update work set fakultet_check = true where id = ?', [$work_id]);
                break;
            case 'admin':
                $work_type_id = DB::select("select type_id, inner_type_id from work where id = ?", [$work_id]);
                if ($work_type_id[0]->inner_type_id != 0){
                    $work_type_ball_select = DB::select("select ball from inner_work_type where id = ?", [$work_type_id[0]->inner_type_id]);
                }else{
                    $work_type_ball_select = DB::select("select ball from work_type where id = ?", [$work_type_id[0]->type_id]);
                }
                $work_type_ball = $work_type_ball_select[0]->ball;
                $update_result = DB::update('update work set admin_check = true, ball = ? where id = ?', [$work_type_ball, $work_id]);
                break;
        }
        if ($update_result)
            return redirect('/teacher/'.$login.'/work_list/'.$work_id);
        else
            return 'error';
    }

    //download work file
    function downloadWorkFile($login, $work_id, $file_id){
        $teacher_id_result = DB::select('select `id` from teacher where login = ?', [$login]);
        $teacher_id = $teacher_id_result[0]->id;
        $files = Storage::files('teacher_works/'.$teacher_id.'/'.$work_id.'/');
        return Storage::download($files[$file_id - 1]);
    }

    //upload work file
    function uploadWorkFile(Request $request, $login, $work_id){
        $teacher_id_result = DB::select('select `id` from teacher where login = ?', [$login]);
        $teacher_id = $teacher_id_result[0]->id;
        $target_dir = 'C:/xampp/htdocs/ballsystem/storage/app/teacher_works/'.$teacher_id.'/'.$work_id.'/';
        $target_file = $target_dir . basename($_FILES["upload_file"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        move_uploaded_file($_FILES["upload_file"]["tmp_name"], $target_file);
        return redirect('/teacher/'.$login.'/work_list/'.$work_id);
    }

    // custom functions
    function getSortNum($request, $sort_type){
        $sorting_types = ["kafedra", "fakultet", "admin"];
        if ($request->session()->get($sort_type."_sort") !== null){
            $sort_num = $request->session()->get($sort_type."_sort");
            if ($sort_num == 3)
                $sort_num = 1;
            else
                $sort_num++;
            foreach ($sorting_types as $sorting_type) {
                $request->session()->put($sorting_type."_sort", 3); 
            }
            $request->session()->put($sort_type."_sort", $sort_num); 
        }else{
            foreach ($sorting_types as $sorting_type) {
                $request->session()->put($sorting_type."_sort", 3); 
            }
            $request->session()->put($sort_type."_sort", 1);
            $sort_num = 1;
        }
        return $sort_num;
    }
}

class File{
    public $name;
    public $time;
    public $size;
    public $size_type;
    function __construct($name, $time, $size, $size_type){
        $this->name = $name;
        $this->time = $time;
        $this->size = $size;
        $this->size_type = $size_type;
    }
}
