<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class KafedraController extends Controller
{
    function showNewTeacher(Request $request, $login){
    	$kafedra_name_result = DB::select('select name from kafedra where login = ?', [$login]);

        // get user type
        $user_type = $request->session()->get('user_type');

        // get kafedra login
        if ($user_type == "kitaphana"){
        	$fakultet_login = $request->session()->get("user_login");
        }else{
        	$fakultet_login = $request->session()->get("fakultet_login");
        }

    	return view('kafedra/new_teacher', ['login' => $login, 'name' => $kafedra_name_result[0]->name, 'fakultet_login' => $fakultet_login, 'user_type' => $user_type]);
    }

    //create new work form
    function createNewTeacher(Request $request, $kafedra_login){

        // get info
    	$kafedra_id_result = DB::select('select `id` from kafedra where login = ?', [$kafedra_login]);
    	$kafedra_id = $kafedra_id_result[0]->id;
    	$name = $request->name;
    	$login = $request->login;
    	$password = $request->password;

    	//checking if login unique
    	$select_result = DB::select('select * from teacher where login = ?', [$login]);
    	if (!isset($select_result[0])){
    		// inserting to database
	    	$insert_result = DB::insert('insert into teacher (name, login, password, kafedra_id) values (?, ?, ?, ?)', [$name, $login, $password, $kafedra_id]);

	    	if ($insert_result){
	    		return redirect('kafedra/'.$kafedra_login.'/new_teacher');
	    	}else{
	    		return "error";
	    	}	
    	}else{
    		return "error login already exists";
    	}
    }

    function showTeacherList(Request $request, $login){
    	$select_result = DB::select('select id, name from kafedra where login = ?', [$login]);
    	$kafedra_id = $select_result[0]->id;

    	// Filter info
    	$filter_sort = $request->input('sort_select');
    	$filter_year = $request->input('year_select');
    	$filter_month = $request->input('month_select');

    	// Get teacher name and works 
    	$teachers = DB::select('select id, login, name from teacher where kafedra_id = ?', [$kafedra_id]);
    	$teacher_works = [];
    	$i = 0;
    	foreach ($teachers as $teacher) {
    		$teacher_works[$i] = DB::select('select * from work where teacher_id = ?', [$teacher->id]);
    		$i++;
    	}

    	// Get work types
    	$work_types = DB::select('select id, name from work_type');
    	
    	// Get balls of work types
    	$i = 0;
    	$main_balls = []; 
    	$work_years = [];
    	foreach ($teachers as $teacher) {
	    	$teacher_balls = [];
    		$whole_ball = 0;
    		$i1 = 0;
	    	foreach ($work_types as $work_type) {
	    		if (($filter_year == 'Ýyly' and $filter_month == 'Aýy') or !isset($filter_year)){
	    			$select_balls = DB::select('select date, ball from work where teacher_id = ? and type_id = ?', [$teacher->id, $work_type->id]);
	    		}else if ($filter_month == 'Aýy'){
	    			$select_balls = DB::select('select date, ball from work where teacher_id = ? and type_id = ? and year(date) = ?', [$teacher->id, $work_type->id, $filter_year]);
	    		}else{
	    			$select_balls = DB::select('select date, ball from work where teacher_id = ? and type_id = ? and year(date) = ? and month(date) = ?', [$teacher->id, $work_type->id, $filter_year, $filter_month]);
	    		}
		    	$teacher_balls[$i1] = 0;
	    		foreach ($select_balls as $ball) {
	    			$teacher_balls[$i1] += $ball->ball;
	    			$year = substr($ball->date, 0 , 4);
	    			if (array_search($year, $work_years) === false)
	    				$work_years[count($work_years)] = $year;
	    		}
	    		$whole_ball += $teacher_balls[$i1];
	    		$i1++;
	    	}
	    	$main_balls[$i] = new teacherBall($teacher_balls, $whole_ball);
	    	$i++;
	    }

	    // Sorting
	    if ($filter_sort == 'asc'){
		    for ($i = 0; $i < count($main_balls); $i++) {
		    	$max = $main_balls[$i]->whole_ball;
		    	$max_index = $i;
		    	for ($j = $i + 1; $j < count($main_balls); $j++) { 
		    		if ($main_balls[$j]->whole_ball > $max){
		    			$max = $main_balls[$j]->whole_ball;
		    			$max_index = $j;
		    		}
		    	}
		    	$third = $main_balls[$i];
		    	$main_balls[$i] = $main_balls[$max_index];
		    	$main_balls[$max_index] = $third;

		    	$third = $teachers[$i];
		    	$teachers[$i] = $teachers[$max_index];
		    	$teachers[$max_index] = $third;
		    }
		}else if($filter_sort == 'desc'){
			for ($i = 0; $i < count($main_balls); $i++) {
		    	$min = $main_balls[$i]->whole_ball;
		    	$min_index = $i;
		    	for ($j = $i + 1; $j < count($main_balls); $j++) { 
		    		if ($main_balls[$j]->whole_ball < $min){
		    			$min = $main_balls[$j]->whole_ball;
		    			$min_index = $j;
		    		}
		    	}
		    	$third = $main_balls[$i];
		    	$main_balls[$i] = $main_balls[$min_index];
		    	$main_balls[$min_index] = $third;
		    	
		    	$third = $teachers[$i];
		    	$teachers[$i] = $teachers[$min_index];
		    	$teachers[$min_index] = $third;
		    }
		}

		// session for kafedra login
		$request->session()->put("kafedra_login", $login);

        // get user type
        $user_type = $request->session()->get('user_type');

        // get kafedra login
        if ($user_type == "kitaphana"){
        	$fakultet_login = $request->session()->get("user_login");
        }else{
        	$fakultet_login = $request->session()->get("fakultet_login");
        }

    	return view('kafedra/teacher_list', ['login' => $login, 'name' => $select_result[0]->name, 'teachers' => $teachers, 'teacher_works' => $teacher_works, 'work_types' => $work_types, 'main_balls' => $main_balls, 'work_years' => $work_years, 'fakultet_login' => $fakultet_login, 'user_type' => $user_type]);
    }

    function showStatistic(Request $request, $login){

        //get kafedra id
    	$kafedra_name_result = DB::select('select id, name from kafedra where login = ?', [$login]);
        $kafedra_id = $kafedra_name_result[0]->id;
        $kafedra_index = $kafedra_id - 1;

        // get rating
        $kafedra_ratings = [];
        $i = 0;
        $j = 0;
    	$kafedras = DB::select('select id from kafedra');
    	$teachers_ball_count = [];
    	$teachers_ball_index = [];
        foreach ($kafedras as $kafedra) {
        	$kafedra_teachers_id = DB::select('select id from teacher where kafedra_id = ?', [$kafedra->id]);
        	$kafedra_ratings[$i] = 0;
        	foreach ($kafedra_teachers_id as $teacher_id) {
        		$teachers_ball_count[$j] = 0;
        		$teacher_balls = DB::select('select ball from work where teacher_id = ?', [$teacher_id->id]);
        		foreach ($teacher_balls as $ball) {
        			$kafedra_ratings[$i] += $ball->ball;
        			$teachers_ball_count[$j] += $ball->ball;
        		} 
        		$teachers_ball_index[$j] = $j;
        		$j++;
        	}

            // division to teachers count
            $teacher_balls_count = count($kafedra_teachers_id);
            if ($teacher_balls_count != 0)
                $kafedra_ratings[$i] = intval($kafedra_ratings[$i] / $teacher_balls_count);

        	if ($i == $kafedra_index){
        		for ($i = 0; $i < count($teachers_ball_count); $i++){
					$max = $teachers_ball_count[$i];
					$max_index = $i;
					for ($j = $i; $j < count($teachers_ball_count); $j++){
						if ($teachers_ball_count[$j] > $max){
							$max = $teachers_ball_count[$j];
							$max_index = $j;
						}
        			}
        			$third = $teachers_ball_count[$i];
        			$teachers_ball_count[$i] = $teachers_ball_count[$max_index];
        			$teachers_ball_count[$max_index] = $third;

        			$third = $teachers_ball_index[$i];
        			$teachers_ball_index[$i] = $teachers_ball_index[$max_index];
        			$teachers_ball_index[$max_index] = $third;
        		}
        		$top_teacher_select = DB::select('select name from teacher where id = ?', [$teachers_ball_index[0] + 1]);
        		$top_teacher_name = $top_teacher_select[0]->name;
        	}
        	$i++;
        }

        $i = 0;
        foreach ($kafedra_ratings as $kafedra_rating) {
        	$kafedra_ratings_new[$i] = $kafedra_rating;
        	$i++;
        }
        $kafedra_ratings = $kafedra_ratings_new;
		for ($i = 0; $i < count($kafedra_ratings); $i++) { 
			$max = $kafedra_ratings[$i];
			$max_index = $i;
			for ($j = $i + 1; $j < count($kafedra_ratings); $j++) { 
				if ($kafedra_ratings[$j] > $max){
					$max = $kafedra_ratings[$j];
					$max_index = $j;
				}
			}
			$third = $kafedra_ratings[$i];
			$kafedra_ratings[$i] = $kafedra_ratings[$max_index];
			$kafedra_ratings[$max_index] = $third;

			if ($i == $kafedra_index)
				$kafedra_index = $max_index;
			else if ($max_index == $kafedra_index)
				$kafedra_index = $i;
		}

		// Month statistic
		$kafedra_teachers_id = DB::select('select id from teacher where kafedra_id = ?', [$kafedra_id]);
		$teacher_month_statistic = [];
		for ($i = 1; $i <= 12; $i++) { 
			$teacher_month_statistic[$i - 1] = 0;
			foreach ($kafedra_teachers_id as $kafedra_teacher_id) {
                if ($i < 10)
					$select_result = DB::select('select ball from work where teacher_id = ? and year(date) = ? and month(date) = ?', [$kafedra_teacher_id->id, date("Y"), "0" + $i]);
				else
					$select_result = DB::select('select ball from work where teacher_id = ? and year(date) = ? and month(date) = ?', [$kafedra_teacher_id->id, date("Y"), $i]);
				foreach ($select_result as $result) {
					$teacher_month_statistic[$i - 1] += $result->ball;
				}
			}
		}
		for ($i = 1; $i <= 12; $i++) { 
			$teachers_count = count($kafedra_teachers_id);
            if ($teachers_count != 0)
            	$teacher_month_statistic[$i - 1] = intval($teacher_month_statistic[$i - 1] / $teachers_count);
		}

		// Work type statistic
		$kafedra_work_statistics = [];
		$i = 0;
		$work_types = DB::select('select id, name from work_type');
		foreach ($kafedra_teachers_id as $teacher_id) {
			$i = 0;
			foreach ($work_types as $work_type) {
				if (!isset($kafedra_work_statistics[$i]))
					$kafedra_work_statistics[$i] = 0;
				$select_result = DB::select('select * from work where teacher_id = ? and type_id = ?', [$teacher_id->id, $work_type->id]);
				foreach ($select_result as $result) {
					$kafedra_work_statistics[$i]++;
				}
				$i++;
			}
		}

        // get user type
        $user_type = $request->session()->get('user_type');

        // get kafedra login
        if ($user_type == "kitaphana"){
        	$fakultet_login = $request->session()->get("user_login");
        }else{
        	$fakultet_login = $request->session()->get("fakultet_login");
        }

    	return view('kafedra/statistic', ['login' => $login, 'name' => $kafedra_name_result[0]->name, 'rating' => $kafedra_index + 1, 'ball' => $kafedra_ratings[$kafedra_index], 'top_teacher_name' => $top_teacher_name, 'teacher_month_statistic' => $teacher_month_statistic, 'kafedra_work_statistics' => $kafedra_work_statistics, 'work_types' => $work_types, 'fakultet_login' => $fakultet_login, 'user_type' => $user_type]);
    }

    function showProfile(Request $request, $login){
    	$kafedra_name_result = DB::select('select name from kafedra where login = ?', [$login]);	

    	// get kafedra info
    	$kafedra_info = DB::select('select id, fakultet_id from kafedra where login = ?', [$login]);

    	// get fakultet name
    	$fakultet_name = DB::select('select name from fakultet where id = ?', [$kafedra_info[0]->fakultet_id]);

        // get user type
        $user_type = $request->session()->get('user_type');

        // get kafedra login
        if ($user_type == "kitaphana"){
        	$fakultet_login = $request->session()->get("user_login");
        }else{
        	$fakultet_login = $request->session()->get("fakultet_login");
        }

    	return view('kafedra/profile', ['login' => $login, 'name' => $kafedra_name_result[0]->name, 'kafedra_info' => $kafedra_info, 'fakultet_login' => $fakultet_login, 'user_type' => $user_type, 'fakultet_name' => $fakultet_name[0]->name]);
    }
}

// Class for teacher balls

class teacherBall
{
	public $type_balls;
	public $whole_ball;

	function __construct($type_balls, $whole_ball)
	{
		$this->type_balls = $type_balls;
		$this->whole_ball = $whole_ball;
	}
}