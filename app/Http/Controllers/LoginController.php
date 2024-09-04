<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

        // dd(session()->has('sessionkey'));
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

        //OTP
        $otpcode = Str::upper(Str::random(6));
        $otptoken = Str::random(12);

        DB::table('tbl_users')
            ->insert([
                'firstname' => $input['firstname'],
                'lastname' => $input['lastname'],
                'email' => $input['email'],
                'usertype' => $input['usertype'],
                'username' => $input['username'],
                'password' => md5($input['password']),
                'gender' => $input['gender'],
                'address' => $input['address'],
                'bday' => $input['bday'],
                'contact' => $input['contact'],
                'team' => $input['team'],
                'otp' => $otpcode,
                'otp_token' => $otptoken,
                'otp_added_at' => Carbon::now()->toDateTimeString(),
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        return redirect('/verification?otp_token=' . $otptoken);
    }

    public function verification(Request $request)
    {
        $data = [];
        $query = $request->query();

        // if (empty($query)) {
        //     return redirect('/login?alert=3');
        //     die();
        // }

        $checktoken = DB::table('tbl_users')
            ->where('otp_token', $query['otp_token'])
            ->count();

        if ($checktoken == 0) {
            return redirect('/login?alert=3');
            die();
        }

        $checkverified = DB::table('tbl_users')
        ->where('otp_token', $query['otp_token'])
        ->first();

        if ($checkverified->verified == 1){
            return redirect('/login');
        }

        if(!$query['alert']){
            $newotp = Str::upper(Str::random(6));

            DB::table('tbl_users')
            ->where('otp_token', $query['otp_token'])
            ->update([
                'otp' => $newotp,
                'otp_added_at' => Carbon::now(),
            ]);

            $user = DB::table('tbl_users')
            ->where('id', $checkverified->id)
            ->first();

            $otpcode = $newotp;
            $fullname = $user->firstname . ' ' . $user->lastname;
            // MAIL HERE
        }

        return view('verification', $data);
    }


    public function logout(Request $request)
    {
        $userinfo = $request->attributes->get('userinfo');
        if ($userinfo[4] == 'admin' || $userinfo[4] == 'staff') {
            DB::table('tbl_logs')
                ->insert([
                    'user_id' => $userinfo[0],
                    'log_title' => "Logged out.",
                    'log_description' => "This user logged out from the system.",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
        }

        $request->session()->flush();
        return redirect('/');
    }
}
