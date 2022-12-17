<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class FakultetController extends Controller
{
    function showNewKafedra(Request $request, $login){
    	$fakultet_name_result = DB::select('select name from fakultet where login = ?', [$login]);

        // get user type
        $user_type = $request->session()->get('user_type');

        // get admin login
        $admin_login = $request->session()->get("admin_login");

    	return view('fakultet/new_kafedra', ['login' => $login, 'name' => $fakultet_name_result[0]->name, 'admin_login' => $admin_login, 'user_type' => $user_type]);
    }

    function createNewKafedra(Request $request, $fakultet_login){

        // get info
    	$fakultet_id_result = DB::select('select `id` from fakultet where login = ?', [$fakultet_login]);
    	$fakultet_id = $fakultet_id_result[0]->id;
    	$name = $request->name;
    	$login = $request->login;
    	$password = $request->password;

    	//checking if login unique
    	$select_result = DB::select('select * from kafedra where login = ?', [$login]);
    	if (!isset($select_result[0])){
    		// inserting to database
	    	$insert_result = DB::insert('insert into kafedra (name, login, password, fakultet_id) values (?, ?, ?, ?)', [$name, $login, $password, $fakultet_id]);

	    	if ($insert_result){
	    		return redirect('fakultet/'.$fakultet_login.'/new_kafedra');
	    	}else{
	    		return "error";
	    	}	
    	}else{
    		return "error login already exists";
    	}
    }

    // show kafedra list
    function showKafedraList(Request $request, $login){

        // Filter info
        $filter_sort = $request->input('sort_select');
        $filter_year = $request->input('year_select');
        $filter_month = $request->input('month_select');

        // get fakultet id
        $fakultet_id_result = DB::select('select `id`, name from fakultet where login = ?', [$login]);
        $fakultet_id = $fakultet_id_result[0]->id;

        // get fakultet kafedras id
        $kafedras = DB::select('select id, login, name from kafedra where fakultet_id = ?', [$fakultet_id]);

        //for each kafedra get balls
        $kafedra_ratings = [];
        $kafedra_index = 0; 
        $work_years = [];
    
        // Get work types
        $work_types = DB::select('select id, name from work_type');
        foreach ($kafedras as $kafedra) {
            
            $kafedra_balls = [];
            $kafedra_whole_ball = 0;

            // Get teacher name and works 
            $teachers = DB::select('select id, login, name from teacher where kafedra_id = ?', [$kafedra->id]);
            $teacher_works = [];
            $i = 0;
            foreach ($teachers as $teacher) {
                $teacher_works[$i] = DB::select('select * from work where teacher_id = ?', [$teacher->id]);
                $i++;
            }
            
            // Get balls of work types
            $i = 0;
            $main_balls = [];
            foreach ($teachers as $teacher) {
                $teacher_balls = [];
                $whole_ball = 0;
                $i1 = 0;
                foreach ($work_types as $work_type) {
                    if (!isset($filter_year) or ($filter_year == 'Ýyly' and $filter_month == 'Aýy'))
                        $select_balls = DB::select('select date, ball from work where teacher_id = ? and type_id = ?', [$teacher->id, $work_type->id]);
                    else if ($filter_month == 'Aýy')
                        $select_balls = DB::select('select date, ball from work where teacher_id = ? and type_id = ? and year(date) = ?', [$teacher->id, $work_type->id, $filter_year]);
                    else
                        $select_balls = DB::select('select date, ball from work where teacher_id = ? and type_id = ? and year(date) = ? and month(date) = ?', [$teacher->id, $work_type->id, $filter_year, $filter_month]);
                    $teacher_balls[$i1] = 0;
                    foreach ($select_balls as $ball) {
                        $teacher_balls[$i1] += $ball->ball;
                        $year = substr($ball->date, 0 , 4);
                        if (array_search($year, $work_years) === false)
                            $work_years[count($work_years)] = $year;
                    }
                    $teachers_count = count($teachers);
                    if ($teachers_count != 0)
                        $teacher_balls[$i1] = intval($teacher_balls[$i1] / $teachers_count);
                    $whole_ball += $teacher_balls[$i1];
                    $i1++;
                }
                $main_balls[$i] = new teacherBall($teacher_balls, $whole_ball);
                $i++;
            }

            foreach ($main_balls as $main_ball) {
                $i = 0;
                foreach ($main_ball->type_balls as $teacher_ball) {
                    if (!isset($kafedra_balls[$i]))
                        $kafedra_balls[$i] = 0;
                    $kafedra_balls[$i] += $teacher_ball;
                    $i++;
                }
                $kafedra_whole_ball += $main_ball->whole_ball;
            }

            $kafedra_ratings[$kafedra_index] = new teacherBall($kafedra_balls, $kafedra_whole_ball);
            $kafedra_index++;
        }

        // Sorting
        if ($filter_sort == 'asc'){
            for ($i = 0; $i < count($kafedra_ratings); $i++) {
                $max = $kafedra_ratings[$i]->whole_ball;
                $max_index = $i;
                for ($j = $i + 1; $j < count($kafedra_ratings); $j++) { 
                    if ($kafedra_ratings[$j]->whole_ball > $max){
                        $max = $kafedra_ratings[$j]->whole_ball;
                        $max_index = $j;
                    }
                }
                $third = $kafedra_ratings[$i];
                $kafedra_ratings[$i] = $kafedra_ratings[$max_index];
                $kafedra_ratings[$max_index] = $third;
    
                $third = $kafedras[$i];
                $kafedras[$i] = $kafedras[$max_index];
                $kafedras[$max_index] = $third;
            }
        }else if($filter_sort == 'desc'){
            for ($i = 0; $i < count($kafedra_ratings); $i++) {
                $min = $kafedra_ratings[$i]->whole_ball;
                $min_index = $i;
                for ($j = $i + 1; $j < count($kafedra_ratings); $j++) { 
                    if ($kafedra_ratings[$j]->whole_ball < $min){
                        $min = $kafedra_ratings[$j]->whole_ball;
                        $min_index = $j;
                    }
                }
                $third = $kafedra_ratings[$i];
                $kafedra_ratings[$i] = $kafedra_ratings[$min_index];
                $kafedra_ratings[$min_index] = $third;
                
                $third = $kafedras[$i];
                $kafedras[$i] = $kafedras[$min_index];
                $kafedras[$min_index] = $third;
            }
        }

        // session for kafedra login
        $request->session()->put("fakultet_login", $login);

        // get user type
        $user_type = $request->session()->get('user_type');

        // get admin login
        $admin_login = $request->session()->get("admin_login");

        return view('fakultet/kafedra_list', ['login' => $login, 'name' => $fakultet_id_result[0]->name, 'kafedra_ratings' => $kafedra_ratings, 'work_years' => $work_years, 'work_types' => $work_types, 'kafedras' => $kafedras, 'admin_login' => $admin_login, 'user_type' => $user_type]);

    }

    // show statistic
    function showStatistic(Request $request, $login){

        // get fakultet id
        $fakultet_name_result = DB::select('select id, name from fakultet where login = ?', [$login]);
        $fakultet_id = $fakultet_name_result[0]->id;
        $fakultet_index = $fakultet_id - 1;

        // get fakultet's kafedras to check if fakultet has kafedra
        $kafedras = DB::select('select * from kafedra where fakultet_id = ?', [$fakultet_id]);

        if ($kafedras !== []){
        
            // get rating
            $fakultet_ratings = [];
            $l = 0;
            $n = 0;
            $fakultets = DB::select('select id from fakultet');

            foreach ($fakultets as $fakultet) {
                $kafedra_ratings = [];
                $i = 0;
                $j = 0;
                $kafedras = DB::select('select id from kafedra where fakultet_id = ?', [$fakultet->id]);
                $kafedras_ball_index = [];

                foreach ($kafedras as $kafedra) {
                    $kafedra_teachers_id = DB::select('select id from teacher where kafedra_id = ?', [$kafedra->id]);
                    $kafedra_ratings[$i] = 0;
                    foreach ($kafedra_teachers_id as $teacher_id) {
                        $teacher_balls = DB::select('select ball from work where teacher_id = ?', [$teacher_id->id]);
                        foreach ($teacher_balls as $ball) {
                            $kafedra_ratings[$i] += $ball->ball;
                        } 
                        $j++;
                    }

                    // division to teachers count
                    $teacher_balls_count = count($kafedra_teachers_id);
                    if ($teacher_balls_count != 0)
                        $kafedra_ratings[$i] = intval($kafedra_ratings[$i] / $teacher_balls_count);

                    $kafedras_ball_index[$i] = $i;
                    $i++;
                }
                $fakultet_ratings[$l] = 0;
                foreach ($kafedra_ratings as $kafedra_rating) {
                    $fakultet_ratings[$l] += $kafedra_rating;
                }

                // division to kafedras count
                $kafedra_ratings_count = count($kafedra_ratings);
                if ($kafedra_ratings_count != 0)
                    $fakultet_ratings[$l] = intval($fakultet_ratings[$l] / $kafedra_ratings_count);

                if ($l == $fakultet_index){
                    for ($i = 0; $i < count($kafedra_ratings); $i++){
                        $max = $kafedra_ratings[$i];
                        $max_index = $i;
                        for ($j = $i; $j < count($kafedra_ratings); $j++){
                            if ($kafedra_ratings[$j] > $max){
                                $max = $kafedra_ratings[$j];
                                $max_index = $j;
                            }
                        }
                        $third = $kafedra_ratings[$i];
                        $kafedra_ratings[$i] = $kafedra_ratings[$max_index];
                        $kafedra_ratings[$max_index] = $third;

                        $third = $kafedras_ball_index[$i];
                        $kafedras_ball_index[$i] = $kafedras_ball_index[$max_index];
                        $kafedras_ball_index[$max_index] = $third;
                    }
                    $top_kafedra_select = DB::select('select name from kafedra where fakultet_id = ?', [$fakultet_id]);
                    $top_kafedra_name = $top_kafedra_select[0]->name;
                }
                $l++;
            }

            $i = 0;
            foreach ($fakultet_ratings as $fakultet_rating) {
                $fakultet_ratings_new[$i] = $fakultet_rating;
                $i++;
            }
            $fakultet_ratings = $fakultet_ratings_new;
            for ($i = 0; $i < count($fakultet_ratings); $i++) { 
                $max = $fakultet_ratings[$i];
                $max_index = $i;
                for ($j = $i + 1; $j < count($fakultet_ratings); $j++) { 
                    if ($fakultet_ratings[$j] > $max){
                        $max = $fakultet_ratings[$j];
                        $max_index = $j;
                    }
                }
                $third = $fakultet_ratings[$i];
                $fakultet_ratings[$i] = $fakultet_ratings[$max_index];
                $fakultet_ratings[$max_index] = $third;

                if ($i == $fakultet_index)
                    $fakultet_index = $max_index;
                else if ($max_index == $fakultet_index)
                    $fakultet_index = $i;
            }

            // Month statistic
            $kafedras = DB::select("select * from kafedra where fakultet_id = ?", [$fakultet_id]);
            $teacher_month_statistic = [];
            foreach ($kafedras as $kafedra) {
                $kafedra_teachers_id = DB::select('select id from teacher where kafedra_id = ?', [$kafedra->id]);
                for ($i = 1; $i <= 12; $i++) { 
                    if (!isset($teacher_month_statistic[$i - 1]))
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
            }
            $i = 1;
            foreach ($kafedras as $kafedra) {
                $kafedras_count = count($kafedras);
                if ($kafedras_count != 0)
                    $teacher_month_statistic[$i - 1] = intval($teacher_month_statistic[$i - 1] / $kafedras_count);
                $i++;
            }

            // get user type
            $user_type = $request->session()->get('user_type');

            // get admin login
            $admin_login = $request->session()->get("admin_login");

            return view('fakultet/statistic', ['login' => $login, 'name' => $fakultet_name_result[0]->name, 'rating' => $fakultet_index + 1, 'ball' => $fakultet_ratings[$fakultet_index], 'top_teacher_name' => $top_kafedra_name, 'teacher_month_statistic' => $teacher_month_statistic, 'kafedra_work_statistics' => $kafedra_work_statistics, 'work_types' => $work_types, 'admin_login' => $admin_login, 'user_type' => $user_type]);
        }else{
            return "Fakultetde kafedralar bolmany sebäpli statistikalar elýeter däl";
        }
    }

    function showProfile(Request $request, $login){
        $fakultet_name_result = DB::select('select name from fakultet where login = ?', [$login]);    

        // get kafedra info
        $fakultet_info = DB::select('select id from fakultet where login = ?', [$login]);

        // get user type
        $user_type = $request->session()->get('user_type');

        // get admin login
        $admin_login = $request->session()->get("admin_login");

        return view('fakultet/profile', ['login' => $login, 'name' => $fakultet_name_result[0]->name, 'fakultet_info' => $fakultet_info, 'admin_login' => $admin_login, 'user_type' => $user_type]);
    }
}

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
