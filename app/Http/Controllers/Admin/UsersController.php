<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class UsersController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('adminhandler');
    }

    public function index(Request $request)
    {
        $data = [];
        $qstring = [];
        $users = DB::table('tbl_users');
        $query = $request->query();
        $qstring['usertype'] = '';
        $qstring['searchUser'] = '';

        $data['alerts'] = [
            1 => ['Successful! User has been added succesfully.', 'success'],
            2 => ['Successful! User details has been updated succesfully.', 'primary'],
            3 => ['Successful! User password has been updated succesfully.', 'primary'],
            4 => ['Failed! User password must be 8 characters long!', 'danger'],
            5 => ['Failed! User password not matched!', 'danger'],
            6 => ['Succesful! The user has been locked and the account is now inactive.', 'warning'],
            7 => ['Succesful! The user has been unlocked and the account is ready to use again.', 'success'],
            8 => ['Failed! Email is taken please put another one.', 'danger'],
            9 => ['Failed! Contact number must be 10 digits. Please remove the first 0 because there is an integrated +63 input.', 'danger'],
        ];

        if (!empty(request()->input('alert'))) {
            $data['alert'] = request()->input('alert');
        }

        if (!empty($query['usertype'])) {
            $qstring['usertype'] = $query['usertype'];
            if ($query['usertype'] == 'other') {
                $users->whereNotIn('usertype', ['admin', 'staff']);
            } else {
                $users->where('usertype', $query['usertype']);
            }
        }

        if (!empty($query['searchUser'])) {
            $qstring['searchUser'] = $query['searchUser'];
            $name = $query['searchUser'];
            if (empty($query['usertype'])) {
                $users->where('firstname', 'like', "%$name%")
                    ->orWhere('lastname', 'like', "%$name%");
            } else {
                $users->where('firstname', 'like', "%$name%")
                    ->orWhere('lastname', 'like', "%$name%")
                    ->where('usertype', $query['usertype']);
            }
        };

        $data['OrgUserCount'] = DB::table('tbl_users')
            ->whereIn('usertype', ['admin', 'staff'])
            ->count();
        $data['subscriberCount'] = DB::table('tbl_subscriptions')
            ->count();
        $data['otherCount'] = DB::table('tbl_users')
            ->where('usertype', 'not like', 'admin%')
            ->where('usertype', 'not like', 'staff%')
            ->count();
        $data['allCount'] = DB::table('tbl_users')
            ->count();

        // public $default_lpp = 2;
        // public $default_sp = 1;
        // $page = $this->default_sp;
        // $countdata = $users->count();
        // $totalpages = ceil($countdata / $this->default_lpp);
        // $dataoffset = ($page * $this->default_lpp) - $this->default_lpp;
        // $users->offset($dataoffset)->limit($this->default_lpp);

        $data['users'] = $users->orderBy('updated_at', 'desc')->paginate(5)->appends($request->all());
        $data['qstring'] = $qstring;
        return view('admin.users', $data);
    }

    public function userAdd(Request $request)
    {
        $input = $request->input();

        if (strlen($input['addpassword1']) < 8) {
            return redirect('/users?alert=4');
            die();
        }

        if ($input['addpassword1'] != $input['addpassword2']) {
            return redirect('/users?alert=5');
            die();
        }

        $tableemail = DB::table('tbl_users')
            ->where('email', $input['email'])->count();
        if ($tableemail >= 1) {
            return redirect('/users?alert=8');
            die();
        }

        if (strlen($input['contact']) != 10) {
            return redirect('/users?alert=9');
            die();
        }

        DB::table('tbl_users')
            ->insert([
                'firstname' => $input['firstname'],
                'lastname' => $input['lastname'],
                'email' => $input['email'],
                'usertype' => $input['usertype'],
                'username' => $input['username'],
                'password' => md5($input['addpassword1']),
                'gender' => $input['gender'],
                'address' => $input['address'],
                'bday' => $input['birthday'],
                'contact' => $input['contact'],
                'team' => $input['team'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        $userinfo = $request->attributes->get('userinfo');
        DB::table('tbl_logs')
            ->insert([
                'user_id' => $userinfo[0],
                'log_title' => 'Added a user.',
                'log_description' => "This user created a user on the Users Page.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        return redirect('/users?alert=1');
    }

    public function userUpdateDetails(Request $request)
    {
        $input = $request->input();
        DB::table('tbl_users')->where('id', $input['id'])
            ->update([
                'firstname' => $input['firstname'],
                'lastname' => $input['lastname'],
                'email' => $input['email'],
                'usertype' => $input['usertype'],
                'username' => $input['username'],
                'gender' => $input['gender'],
                'address' => $input['address'],
                'bday' => $input['birthday'],
                'contact' => $input['contact'],
                'team' => $input['team'],
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        $userinfo = $request->attributes->get('userinfo');
        DB::table('tbl_logs')
            ->insert([
                'user_id' => $userinfo[0],
                'log_title' => 'Updated a user.',
                'log_description' => "This user updated a user's info on the Users Page.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        return redirect('/users?alert=2');
    }

    public function userUpdatePassword(Request $request)
    {
        $input = $request->input();

        if (strlen($input['updatepassword1']) < 8) {
            return redirect('/users?alert=4');
            die();
        }

        if ($input['updatepassword1'] != $input['updatepassword2']) {
            return redirect('/users?alert=5');
            die();
        }

        DB::table('tbl_users')->where('id', $input['id'])
            ->update([
                'password' => $input['updatepassword1'],
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        $userinfo = $request->attributes->get('userinfo');
        DB::table('tbl_logs')
            ->insert([
                'user_id' => $userinfo[0],
                'log_title' => 'Updated a user.',
                'log_description' => "This user updated a user's password on the Users Page.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        return redirect('/users?alert=3');
    }

    public function userLock(Request $request)
    {
        $input = $request->input();
        DB::table('tbl_users')->where('id', $input['id'])
            ->update([
                'status' => "inactive",
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        $userinfo = $request->attributes->get('userinfo');
        DB::table('tbl_logs')
            ->insert([
                'user_id' => $userinfo[0],
                'log_title' => 'Locked a user.',
                'log_description' => "This user locked a user's account on the Users Page.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        return redirect('/users?alert=6');
    }

    public function userUnlock(Request $request)
    {
        $input = $request->input();
        DB::table('tbl_users')->where('id', $input['id'])
            ->update([
                'status' => "active",
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        $userinfo = $request->attributes->get('userinfo');
        DB::table('tbl_logs')
            ->insert([
                'user_id' => $userinfo[0],
                'log_title' => 'Unlocked a user.',
                'log_description' => "This user unlocked a user's account on the Users Page.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        return redirect('/users?alert=7');
    }
}
