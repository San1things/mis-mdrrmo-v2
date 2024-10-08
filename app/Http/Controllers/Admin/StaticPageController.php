<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\UnsubscribeMailer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
        $qstring = [];

        $data['alerts'] = [
            1 => ['Succesful! You unsubscribe a subscriber.', 'success']
        ];

        if (!empty($request->query('alert'))) {
            $data['alert'] = $request->query('alert');
        }

        $qstring['searchSubscriber'] = '';
        $subscribers = DB::table('tbl_subscriptions');
        if (!empty(request()->query('searchSubscriber'))) {
            $qstring['searchSubscriber'] = $query['searchSubscriber'];
            $emailtyped = $query['searchSubscriber'];
            $subscribers->where('email', 'like', "%$emailtyped%");
        }

        $qstring['last'] = '';
        if (!empty($query['last'])) {
            $qstring['last'] = $query['last'];
            if ($query['last'] == 'week') {
                $weekstart = Carbon::now()->subWeek();
                $weekend = Carbon::now()->subDays(30);
                $subscribers
                    ->whereBetween('created_at', [$weekend, $weekstart]);
            } else if ($query['last'] == 'month') {
                $monthstart = Carbon::now()->subMonth();
                $monthend = Carbon::now()->subMonths(6);
                $subscribers
                    ->whereBetween('created_at', [$monthend, $monthstart]);
            } else if ($query['last'] == '6months') {
                $sixmonthstart = Carbon::now()->subMonths(6);
                $sixmonthend = Carbon::now()->subYear();
                $subscribers
                    ->whereBetween('created_at', [$sixmonthend, $sixmonthstart]);
            } else if ($query['last'] == 'year') {
                $yearstart = Carbon::now()->subYear();
                $yearend = Carbon::now()->subyears(2);
                $subscribers
                    ->whereBetween('created_at', [$yearend, $yearstart]);
            }
        }

        $data['qstring'] = $qstring;
        $data['subCount'] = DB::table('tbl_subscriptions')->count();
        $data['subscribers'] = $subscribers->orderByDesc('id')->paginate(15)->appends($request->all());

        return view('admin.subscriptions', $data);
    }

    public function adminUnsubscribe(Request $request)
    {
        $input = $request->input();

        $userinfo = $request->attributes->get('userinfo');
        DB::table('tbl_logs')
            ->insert([
                'user_id' => $userinfo[0],
                'log_title' => "Unsubscribed a subscriber",
                'log_description' => "This user unsubscribed a subscriber at the Subscriptions Page.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        $getEmail = DB::table('tbl_subscriptions')
            ->where('id', $input['id'])
            ->first();

        Mail::to($getEmail->email)->send(new UnsubscribeMailer);

        DB::table('tbl_subscriptions')
            ->where('id', $input['id'])
            ->delete();

        return redirect('/subscriptions?alert=1');
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

    public function adminReportsIndex()
    {
        $data = [];

        return view('admin.adminreports', $data);
    }

    public function logsIndex(Request $request)
    {
        $data = [];
        $qstring = [];
        $query = $request->query();

        $logs = DB::table('tbl_logs')
            ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_logs.user_id')
            ->select('tbl_logs.created_at as log_created_at', 'tbl_users.created_at as user_created_at', 'tbl_logs.*', 'tbl_users.*');

        $qstring['searchLogs'] = '';
        if (!empty($request->query('searchLogs'))) {
            $qstring['searchLogs'] = $query['searchLogs'];
            $nameAction = $request->input('searchLogs');

            $logs->where(function ($query) use ($nameAction) {
                $query->where('tbl_users.firstname', 'like', "%$nameAction%")
                    ->orWhere('tbl_users.lastname', 'like', "%$nameAction%")
                    ->orWhere('tbl_logs.log_title', 'like', "%$nameAction%");
            });
        }

        $qstring['last'] = '';
        if (!empty($query['last'])) {
            $qstring['last'] = $query['last'];
            if ($query['last'] == 'week') {
                $weekstart = Carbon::now()->subWeek();
                $weekend = Carbon::now()->subDays(30);
                $logs
                    ->whereBetween('tbl_logs.created_at', [$weekend, $weekstart]);
            } else if ($query['last'] == 'month') {
                $monthstart = Carbon::now()->subMonth();
                $monthend = Carbon::now()->subMonths(6);
                $logs
                    ->whereBetween('tbl_logs.created_at', [$monthend, $monthstart]);
            } else if ($query['last'] == '6months') {
                $sixmonthstart = Carbon::now()->subMonths(6);
                $sixmonthend = Carbon::now()->subYear();
                $logs
                    ->whereBetween('tbl_logs.created_at', [$sixmonthend, $sixmonthstart]);
            } else if ($query['last'] == 'year') {
                $yearstart = Carbon::now()->subYear();
                $yearend = Carbon::now()->subyears(2);
                $logs
                    ->whereBetween('tbl_logs.created_at', [$yearend, $yearstart]);
            }
        }

        $data['qstring'] = $qstring;
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
                'password' => md5($input['profilepassword1'])
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
