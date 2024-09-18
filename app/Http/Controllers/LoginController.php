<?php

namespace App\Http\Controllers;

use App\Mail\OTPMailer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
            4 => ['You are now verified.', 'success', 'Succesful!'],
            5 => ['Please dont leave all blanks empty.', 'error', 'Error!'],
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

        if(empty($input['email']) || empty($input['password'])){
            return redirect('/login?alert=5');
            die();
        }

        $user = DB::table('tbl_users')
            ->where('email', $input['email'])
            ->where('password', md5($input['password']))
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
            DB::table('tbl_logs')
                ->insert([
                    'user_id' => $user->id,
                    'log_title' => "Logged in.",
                    'log_description' => $user->firstname . ' ' . $user->lastname . ' logged in the system.',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
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
            5 => ['Contact number must be 10 digits long. Please remove the extra 0 on the front', 'danger', 'Error!'],
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
        if ($input['email'] == null || $input['username'] == null || $input['password'] == null || $input['confirmpassword'] == null || $input['firstname'] == null || $input['lastname'] == null || $input['bday'] == null || $input['gender'] == null || $input['address'] == null || $input['contact'] == null) {
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
            ->where('email', $input['email'])->count();
        if ($tableemail >= 1) {
            return redirect('/register?alert=1');
            die();
        }
        if (strlen($input['contact']) != 10) {
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
                'usertype' => 'resident',
                'username' => $input['username'],
                'password' => md5($input['password']),
                'gender' => $input['gender'],
                'address' => $input['address'],
                'bday' => $input['bday'],
                'contact' => $input['contact'],
                'team' => 'undefined',
                'otp' => $otpcode,
                'otp_token' => $otptoken,
                'otp_added_at' => Carbon::now()->toDateTimeString(),
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        return redirect('/verification?otp_token=' . $otptoken);
    }

    public function verificationIndex(Request $request)
    {
        $data = [];
        $query = $request->query();

        $data['alerts'] = [
            1 => ['Please input an OTP Code.', 'danger', 'Error!'],
            2 => ['OTP is incorrect', 'danger', 'Error!'],
            3 => ['OTP has been expired, please request again.', 'danger', 'Error!'],
        ];

        if (!empty($request->query('alert'))) {
            $data['alert'] = $request->query('alert');
        }

        if (empty($query)) {
            return redirect('/login?alert=3');
            die();
        }

        if ($query['otp_token'] == null) {
            return redirect('/login?alert=3');
            die();
        }

        $checktoken = DB::table('tbl_users')
            ->where('otp_token', $query['otp_token'])
            ->count();

        if ($checktoken == 0) {
            return redirect('/login?alert=3');
            die();
        }

        $account = DB::table('tbl_users')
            ->where('otp_token', $query['otp_token'])
            ->first();

        if ($account->verified == 1) {
            return redirect('/login');
        }

        if (!$request->query('alert')) {
            $newotp = Str::upper(Str::random(6));

            DB::table('tbl_users')
                ->where('otp_token', $query['otp_token'])
                ->update([
                    'otp' => $newotp,
                    'otp_added_at' => Carbon::now(),
                ]);

            $user = DB::table('tbl_users')
                ->where('id', $account->id)
                ->first();

            $otpcode = $newotp;
            $fullname = $user->firstname . ' ' . $user->lastname;
            Mail::to($account->email)->send(new OTPMailer($otpcode, $fullname));
        }
        $data['otptoken'] = $query['otp_token'];

        return view('verification', $data);
    }

    public function verificationProcess(Request $request)
    {
        $input = $request->input();

        if (empty($input['otp'])) {
            return redirect('/verification?otp_token=' . $input['otp_token'] . '&alert=1');
            die();
        }

        $checkOTP = DB::table('tbl_users')
            ->where('otp_token', $input['otp_token'])
            ->first();

        if ($input['otp'] != $checkOTP->otp) {
            return redirect('/verification?otp_token=' . $input['otp_token'] . '&alert=2');
            die();
        }

        $otp_created = Carbon::parse($checkOTP->otp_added_at);
        $now = Carbon::now();
        $minutesPassed = $otp_created->diffInMinutes($now);

        if ($minutesPassed >= 3) {
            return redirect('/verification?otp_token=' . $input['otp_token'] . '&alert=3');
            die();
        }

        if ($input['otp'] == $checkOTP->otp) {
            DB::table('tbl_users')
                ->where('otp_token', $input['otp_token'])
                ->update([
                    'verified' => 1,
                ]);

            return redirect('/login?alert=4');
        }
    }

    public function requestOTP(Request $request)
    {
        $query = $request->query();
        $newrequestedOTP = Str::upper(Str::random(6));

        DB::table('tbl_users')
        ->where('otp_token', $query['otp_token'])
        ->update([
            'otp' => $newrequestedOTP,
            'otp_added_at' => Carbon::now()
        ]);

        $user = DB::table('tbl_users')
        ->where('otp_token', $query['otp_token'])
        ->first();

        $otpcode = $newrequestedOTP;
        $fullname = $user->firstname . ' ' . $user->lastname;
        Mail::to($user->email)->send(new OTPMailer($otpcode, $fullname));
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
