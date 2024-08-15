<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $data = [];
        $data['alerts'] = [
            1 => ['Wrong email or pasword or the account is inactive, try again.', 'danger', 'Error!'],
            2 => ['Session expired.', 'warning', 'Error!'],
            3 => ['You have no permission to access.', 'danger', 'Error!'],
        ];
        if (!empty(request()->input('alert'))) {
            $data['alert'] = request()->input('alert');
        }

        if (session()->has('sessionkey')) {
            return redirect()->route('adminhomepage');
        }

        return view('login', $data);
    }

    public function loginProcess(Request $request)
    {
        $input = request()->input();
        $user = DB::table('tbl_users')
            ->where('email', $input['email'])
            ->where('password', $input['password'])
            ->where('status', 'active')
            ->first();
        if (empty($user)) {
            return redirect('/login?alert=1');
            die();
        }

        $userkey = [
            $user->id, //0
            $user->firstname, //1
            $user->lastname, //2
            $user->email, //3
            $user->usertype, //4
            $user->username, //5
            $user->gender, //6
            $user->address, //7
            $user->bday, //8
            $user->contact, //9
            $user->team, //10
            date('ymdHis')
        ];

        $userid = encrypt(implode(',', $userkey));
        $request->session()->put('sessionkey', $userid);
        session(['sessionkey' => $userid]);

        if ($user->usertype == 'admin' || $user->usertype == 'staff') {
            return  redirect('/users');
        } else if ($user->usertype == 'resident') {
            return redirect('/userhome');
        }
    }

    public function register(Request $request)
    {
        $data = [];

        $data['alerts'] = [
            1 => ['Email has been used, please put diferent email.', 'danger', 'Error!'],
            2 => ['Password must be 8 characters long.', 'danger', 'Error!'],
            3 => ['Password not match, try again.', 'danger', 'Error!'],
            4 => ['Please fill out all the requirements!', 'danger', 'Error!'],
            5 => ['Contact number must be 11 digits long.', 'danger', 'Error!'],
        ];
        if (!empty(request()->input('alert'))) {
            $data['alert'] = request()->input('alert');
        }

        return view('register', $data);
    }

    public function registerProcess(Request $request)
    {
        $input = $request->input();

        // ERROR TRAPPING
        if ($input['email'] == null || $input['username'] == null || $input['password'] == null || $input['confirmpassword'] == null || $input['fname'] == null || $input['lname'] == null || $input['bday'] == null || $input['gender'] == null || $input['address'] == null || $input['contact'] == null) {
            return redirect('/register?alert=4');
            die();
        }
        if (strlen($input['password']) < 8) {
            return redirect('/register?alert=2');
            die();
        }
        if ($input['password'] != $input['confirmpassword']) {
            return redirect('/register?alert=3');
            die();
        }
        $tableemail = DB::table('tbl_users')
            ->where('email', $input['email'])->get();
        if ($tableemail != null) {
            return redirect('/register?alert=1');
            die();
        }
        if (strlen($input['contact']) != 11) {
            return redirect('/register?alert=5');
            die();
        }
    }


    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
}
