<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LoginController extends Controller
{
    function LoginCheck(Request $request){

    	//get form data
    	$login = $request->input('login');
    	$password = $request->input('password');
    	$user_type = $request->input('user_type');
        $request->session()->put('user_login', $login);
        
    	//check login and password
        switch ($user_type) {
            case 'teacher':
                $user_name = DB::select('select name from teacher where login = ? and password = ?', [$login, $password]);
                if ($user_name != []){
                    $request->session()->put('user_type', $user_type);
                    return redirect('/teacher/'.$login.'/new_work');
                }else{
                    $user_name = DB::select('select name from admin where login = ? and password = ?', [$login, $password]);
                    if ($user_name != []){
                        $request->session()->put("user_type", "admin");
                        return redirect('/admin/'.$login.'/new_fakultet');
                    }else{
                        return redirect('/login?error=true');
                    }
                }
                break;
            case 'kafedra':
                $user_name = DB::select('select name from kafedra where login = ? and password = ?', [$login, $password]);
                if ($user_name != []){
                    $request->session()->put('user_type', $user_type);
                    return redirect('/kafedra/'.$login.'/new_teacher');
                }else{
                    $user_name = DB::select('select name from admin where login = ? and password = ?', [$login, $password]);
                    if ($user_name != []){
                        $request->session()->put("user_type", "admin");
                        return redirect('/admin/'.$login.'/new_fakultet');
                    }else{
                        return redirect('/login?error=true');
                    }
                }
                break;
            case 'kitaphana':
                $user_name = DB::select('select name from kitaphana where login = ? and password = ?', [$login, $password]);
                if ($user_name != []){
                    $request->session()->put('user_type', $user_type);
                    return redirect('/kitaphana/'.$login.'/teacher_list');
                }else{
                    $user_name = DB::select('select name from admin where login = ? and password = ?', [$login, $password]);
                    if ($user_name != []){
                        $request->session()->put("user_type", "admin");
                        return redirect('/admin/'.$login.'/new_fakultet');
                    }else{
                        return redirect('/login?error=true');
                    }
                }
                break;
            case 'fakultet':
                $user_name = DB::select('select name from fakultet where login = ? and password = ?', [$login, $password]);
                if ($user_name != []){
                    $request->session()->put('user_type', $user_type);
                    return redirect('/fakultet/'.$login.'/new_kafedra');
                }else{
                    $user_name = DB::select('select name from admin where login = ? and password = ?', [$login, $password]);
                    if ($user_name != []){
                        $request->session()->put("user_type", "admin");
                        return redirect('/admin/'.$login.'/new_fakultet');
                    }else{
                        return redirect('/login?error=true');
                    }
                }
                break;
        }
    }
}
