<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Svg\Tag\Rect;

class StaticPageController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('adminhandler');
    }

    public function subscriptionsIndex(Request $request)
    {
        $data = [];
        $query = $request->query();

        $subscribers = DB::table('tbl_subscriptions');
        if (!empty(request()->query('searchSubscriber'))) {
            $emailtyped = $query['searchSubscriber'];
            $subscribers->where('email', 'like', "%$emailtyped%");
        }

        $data['subCount'] = DB::table('tbl_subscriptions')->count();
        $data['subscribers'] = $subscribers->orderByDesc('id')->paginate(15)->appends($request->all());

        return view('admin.subscriptions', $data);
    }

    public function adminMessagesIndex()
    {
        return view('admin.adminmessages');
    }

    public function adminNotifIndex(Request $request)
    {
        $data = [];
        $data['alerts'] = [
            1 => ['Notification has been removed!', 'info']
        ];
        if (!empty($request->query('alert'))) {
            $data['alert'] = $request->query('alert');
        }

        $userinfo = $request->attributes->get('userinfo');
        $notifications = DB::table('tbl_notif')
            ->where('user_id', $userinfo[0])
            ->where('user_type', 'org');

        $data['notifications'] = $notifications->orderByDesc('id')->paginate(30)->appends($request->all());

        return view('admin.adminnotif', $data);
    }

    public function adminRemoveNotif(Request $request)
    {
        $input = $request->input();

        $userinfo = $request->attributes->get('userinfo');
        DB::table('tbl_notif')
            ->where('user_id', $userinfo[0])
            ->where('id', $input['id'])
            ->delete();
        return redirect('/adminnotif?alert=1');
    }

    public function logsIndex(Request $request)
    {
        $data = [];
        $logs = DB::table('tbl_logs')
            ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_logs.user_id')
            ->select('tbl_logs.created_at as log_created_at', 'tbl_users.created_at as user_created_at', 'tbl_logs.*', 'tbl_users.*');

        $nameAction = $request->input('searchLogs');
        if (!empty($request->query('searchLogs'))) {
            $logs
                ->where('tbl_users.firstname', 'like', "%$nameAction%")
                ->orWhere('tbl_users.lastname', 'like', "%$nameAction%")
                ->orWhere('tbl_logs.log_title', 'like', "%$nameAction%");
        }

        $data['logs'] = $logs->orderByDesc('tbl_logs.id')->paginate(30)->appends($request->all());

        return view('admin.logs', $data);
    }

    public function adminprofileIndex(Request $request)
    {
        $data = [];
        $userinfo = $request->attributes->get('userinfo');

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
        }

        $users = DB::table('tbl_users');
        $data['adminprofile'] = $users
            ->where('id', $userinfo[0])
            ->first();

        return view('admin.adminprofile', $data);
    }

    public function adminUpdateProfile(Request $request)
    {
        $input = $request->input();
        $userinfo = $request->attributes->get('userinfo');

        if ($input['email'] == null || $input['username'] == null || $input['usertype'] == null || $input['team'] == null || $input['firstname'] == null || $input['lastname'] == null || $input['birthday'] == null || $input['gender'] == null || $input['address'] == null || $input['contact'] == null) {
            return redirect('/adminprofile?alert=7');
            die();
        }

        $users = DB::table('tbl_users');
        $tableemail = $users
            ->where('email', $input['email'])
            ->where('id', '!=', $userinfo[0])->count();
        if ($tableemail >= 1) {
            return redirect('/adminprofile?alert=1');
            die();
        }

        if (strlen($input['contact']) != 10) {
            return redirect('/adminprofile?alert=2');
            die();
        }

        DB::table('tbl_users')->where('id', $userinfo[0])
            ->update([
                'email' => $input['email'],
                'username' => $input['username'],
                'usertype' => $input['usertype'],
                'team' => $input['team'],
                'firstname' => $input['firstname'],
                'lastname' => $input['lastname'],
                'gender' => $input['gender'],
                'address' => $input['address'],
                'bday' => $input['birthday'],
                'contact' => $input['contact'],
            ]);

        $userinfo = $request->attributes->get('userinfo');
        DB::table('tbl_logs')
            ->insert([
                'user_id' => $userinfo[0],
                'log_title' => "Updated it's profile",
                'log_description' => "This user updated it's profile.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        return redirect('/adminprofile?alert=5');
    }

    public function adminUpdatePassword(Request $request)
    {
        $input = $request->input();
        $userinfo = $request->attributes->get('userinfo');
        $users = DB::table('tbl_users');

        if (strlen($input['profilepassword1']) < 8) {
            return redirect('/adminprofile?alert=3');
            die();
        }

        if ($input['profilepassword1'] != $input['profilepassword2']) {
            return redirect('/adminprofile?alert=4');
            die();
        }

        $users->where('id', $userinfo[0])
            ->update([
                'password' => $input['profilepassword1']
            ]);

        $userinfo = $request->attributes->get('userinfo');
        DB::table('tbl_logs')
            ->insert([
                'user_id' => $userinfo[0],
                'log_title' => "Updated it's password",
                'log_description' => "This user updated it's password.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        return redirect('adminprofile?alert=6');
    }
}
