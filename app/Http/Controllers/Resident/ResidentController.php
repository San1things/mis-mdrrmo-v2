<?php

namespace App\Http\Controllers\Resident;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ResidentController extends Controller
{
    public function __construct()
    {
        $this->middleware('residenthandler');
    }

    public function userhome(Request $request)
    {
        $data = [];
        $data['userinfo'] = $userinfo = $request->attributes->get('userinfo');

        return view('user.userhome', $data);
    }
    public function userabout()
    {
        return view('user.userabout');
    }
    public function userservices()
    {
        return view('user.userservices');
    }
    public function userfaqs(Request $request)
    {
        $data = [];
        $userinfo = $request->attributes->get('userinfo');
        $data['name'] = $userinfo[1] . " " . $userinfo[2];
        $data['email'] = $userinfo[3];

        return view('user.userfaqs', $data);
    }
    public function userannouncements()
    {
        return view('user.userannouncements');
    }
    public function userseminars()
    {
        return view('user.userseminars');
    }
    public function userprofile(Request $request)
    {
        $data = [];
        $data['userinfo'] = $userinfo = $request->attributes->get('userinfo');

        $data['alerts'] = [
            1 => ['Update failed, the email you input has been used.', 'danger'],
            2 => ['Update failed, mobile number must be 10 digits long, please remove the starting 0 if you have one.', 'danger'],
            3 => ['Error! Password must be 8 character long.', 'danger'],
            4 => ['Error! Password does not match.', 'danger'],
            5 => ['Nice! Your profile details was updated succesfully.', 'primary'],
            6 => ['Succesful! Password has been changed.', 'primary'],
            7 => ['Error! Please fill out all the requirements, dont make empty inputs.', 'danger'],
        ];

        if (!empty($request->input('alert'))) {
            $data['alert'] = $request->input('alert');
        };

        $users = DB::table('tbl_users');
        $data['userprofile'] = $users
            ->where('id', $userinfo[0])->first();

        return view('user.userprofile', $data);
    }

    public function userUpdateProfile(Request $request)
    {
        $input = $request->input();
        $userinfo = $request->attributes->get('userinfo');
        $users = DB::table('tbl_users');

        if ($input['email'] == null || $input['username'] == null || $input['firstname'] == null || $input['lastname'] == null || $input['birthday'] == null || $input['gender'] == null || $input['address'] == null || $input['contact'] == null) {
            return redirect('/userprofile?alert=7');
            die();
        }

        $tableemail = $users
            ->where('email', $input['email'])
            ->where('id', '!=', $userinfo[0])->count();
        if ($tableemail >= 1) {
            return redirect('/userprofile?alert=1');
            die();
        }

        if (strlen($input['contact']) != 10) {
            return redirect('/userprofile?alert=2');
            die();
        }

        DB::table('tbl_users')->where('id', $userinfo[0])
            ->update([
                'email' => $input['email'],
                'username' => $input['username'],
                'firstname' => $input['firstname'],
                'lastname' => $input['lastname'],
                'gender' => $input['gender'],
                'address' => $input['address'],
                'bday' => $input['birthday'],
                'contact' => $input['contact'],
            ]);

            return redirect('/userprofile?alert=5');
    }
    public function userUpdatePassword(Request $request)
    {
        $input = $request->input();
        $userinfo = $request->attributes->get('userinfo');
        $users = DB::table('tbl_users');

        if (strlen($input['profilepassword1']) < 8) {
            return redirect('/userprofile?alert=3');
            die();
        }

        if ($input['profilepassword1'] != $input['profilepassword2']) {
            return redirect('/userprofile?alert=4');
            die();
        }

        $users->where('id', $userinfo[0])
            ->update([
                'password' => $input['profilepassword1']
            ]);

            return redirect('userprofile?alert=6');
    }

    public function usernotif()
    {
        return view('user.usernotif');
    }
}
