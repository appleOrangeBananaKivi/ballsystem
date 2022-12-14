<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class KitaphanaController extends Controller
{

    function showTeacherList(Request $request, $login){
    	$select_result = DB::select('select id, name from kitaphana where login = ?', [$login]);
    	$kafedra_id = $select_result[0]->id;

    	// Filter info
    	$filter_sort = $request->input('sort_select');
    	$filter_year = $request->input('year_select');
    	$filter_month = $request->input('month_select');

    	// Get teacher name and works 
    	$teachers = DB::select('select id, login, name from teacher');
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
	    		if (($filter_year == 'Ýyly' and $filter_month == 'Aýy') or !isset($filter_year))
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

    	return view('kitaphana/teacher_list', ['login' => $login, 'name' => $select_result[0]->name, 'teachers' => $teachers, 'teacher_works' => $teacher_works, 'work_types' => $work_types, 'main_balls' => $main_balls, 'work_years' => $work_years]);
    }

    function showKafedraList(Request $request, $login){
    	$select_result = DB::select('select id, name from kitaphana where login = ?', [$login]);
    	$kafedra_id = $select_result[0]->id;

    	// Filter info
        $filter_sort = $request->input('sort_select');
        $filter_year = $request->input('year_select');
        $filter_month = $request->input('month_select');

        // get fakultet kafedras id
        $kafedras = DB::select('select id, login, name from kafedra');

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

    	return view('kitaphana/kafedra_list', ['login' => $login, 'name' => $select_result[0]->name, 'teachers' => $kafedras, 'teacher_works' => $teacher_works, 'work_types' => $work_types, 'main_balls' => $kafedra_ratings, 'work_years' => $work_years]);
    }

    function showFakultetList(Request $request, $login){
    	$select_result = DB::select('select id, name from kitaphana where login = ?', [$login]);
    	$kafedra_id = $select_result[0]->id;

    	        // Filter info
        $filter_sort = $request->input('sort_select');
        $filter_year = $request->input('year_select');
        $filter_month = $request->input('month_select');

        // variables for fakultet
        $fakultets = DB::select("select * from fakultet");
        $fakultet_ratings = [];
	    $fakultet_index = 0;
	    $work_years = [];

        foreach ($fakultets as $fakultet) {
        	
        	// variables for fakultet
	    	$fakultet_balls = [];
	    	$fakultet_whole_ball = 0;

	        // get fakultet kafedras id
	        $kafedras = DB::select('select id, login, name from kafedra where fakultet_id = ?', [$fakultet->id]);

	        //for each kafedra get balls
	        $kafedra_ratings = [];
	        $kafedra_index = 0; 
	    
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

	            // get kafedra ratings
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

	        // get fakultet ratings
	        foreach ($kafedra_ratings as $kafedra_rating) {
	            $i = 0;
	            foreach ($kafedra_rating->type_balls as $kafedra_ball) {
	                if (!isset($fakultet_balls[$i]))
	                    $fakultet_balls[$i] = 0;
	                $fakultet_balls[$i] += $kafedra_ball;
	                $i++;
	            }
	            
	            $fakultet_whole_ball += $kafedra_rating->whole_ball;
	        }
 
	        // divising fakultet balls to kafedra count
	        $kafedras_count = count($kafedras);
	        if ($kafedras_count != 0){
		        for ($i = 0; $i < count($fakultet_balls); $i++) {
		        	$fakultet_balls[$i] = intval($fakultet_balls[$i] / $kafedras_count);
		        }

	        	// divising fakultet whole ball to kafedra count
	        	$fakultet_whole_ball = intval($fakultet_whole_ball / $kafedras_count);
	    	}

	        $fakultet_ratings[$fakultet_index] = new teacherBall($fakultet_balls, $fakultet_whole_ball);
	        $fakultet_index++;

	        // Sorting
	        if ($filter_sort == 'asc'){
	            for ($i = 0; $i < count($fakultet_ratings); $i++) {
	                $max = $fakultet_ratings[$i]->whole_ball;
	                $max_index = $i;
	                for ($j = $i + 1; $j < count($fakultet_ratings); $j++) { 
	                    if ($fakultet_ratings[$j]->whole_ball > $max){
	                        $max = $fakultet_ratings[$j]->whole_ball;
	                        $max_index = $j;
	                    }
	                }
	                $third = $fakultet_ratings[$i];
	                $fakultet_ratings[$i] = $fakultet_ratings[$max_index];
	                $fakultet_ratings[$max_index] = $third;
	    
	                $third = $fakultets[$i];
	                $fakultets[$i] = $fakultets[$max_index];
	                $fakultets[$max_index] = $third;
	            }
	        }else if($filter_sort == 'desc'){
	            for ($i = 0; $i < count($fakultet_ratings); $i++) {
	                $min = $fakultet_ratings[$i]->whole_ball;
	                $min_index = $i;
	                for ($j = $i + 1; $j < count($fakultet_ratings); $j++) { 
	                    if ($fakultet_ratings[$j]->whole_ball < $min){
	                        $min = $fakultet_ratings[$j]->whole_ball;
	                        $min_index = $j;
	                    }
	                }
	                $third = $fakultet_ratings[$i];
	                $fakultet_ratings[$i] = $fakultet_ratings[$min_index];
	                $fakultet_ratings[$min_index] = $third;
	                
	                $third = $fakultets[$i];
	                $fakultets[$i] = $fakultets[$min_index];
	                $fakultets[$min_index] = $third;
	            }
	        }
	    }

        // session for kafedra login
        $request->session()->put("admin_login", $login);

    	return view('kitaphana/fakultet_list', ['login' => $login, 'name' => $select_result[0]->name, 'teachers' => $fakultets, 'teacher_works' => $teacher_works, 'work_types' => $work_types, 'main_balls' => $fakultet_ratings, 'work_years' => $work_years]);
    }

    function showProfile($login){
    	$kafedra_name_result = DB::select('select id, name from kitaphana where login = ?', [$login]);	

    	return view('kitaphana/profile', ['login' => $login, 'name' => $kafedra_name_result[0]->name, 'kitaphana_id' => $kafedra_name_result[0]->id]);
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
