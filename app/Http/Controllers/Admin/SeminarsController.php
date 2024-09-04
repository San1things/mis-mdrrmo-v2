<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Svg\Tag\Rect;

use function Laravel\Prompts\select;

class SeminarsController extends Controller
{
    public function upcomingIndex(Request $request)
    {
        $data = [];
        $data['alerts'] = [
            1 => ['Successful! Seminar has been created.', 'success'],
            2 => ['Successful! Informations has been updated.', 'success'],
            3 => ['Error! Please fill out all the inputs!', 'danger'],
        ];

        if (!empty(request()->query('alert'))) {
            $data['alert'] = request()->query('alert');
        }

        $seminars = DB::table('tbl_seminars')
            ->where('status', 'upcoming');

        $data['seminars'] = $seminars->orderByDesc('id')->paginate(7)->appends($request->all());
        $data['seminarCount'] = $seminars->count();

        return view('admin.adminseminars', $data);
    }

    public function createSeminar(Request $request)
    {
        $input = $request->input();

        if ($input['seminartitle'] == null || $input['startdate'] == null || $input['seminarlocation'] == null || $input['startdate'] == null) {
            return redirect('/adminseminars?alert=3');
            die();
        }

        DB::table('tbl_seminars')
            ->insert([
                'title' => $input['seminartitle'],
                'description' => $input['seminardescription'],
                'starts_at' => $input['startdate'],
                'location' => $input['seminarlocation'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        $userinfo = $request->attributes->get('userinfo');
        DB::table('tbl_logs')
            ->insert([
                'user_id' => $userinfo[0],
                'log_title' => 'Created a seminar.',
                'log_description' => "This user created a seminar on Seminar Page.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        return redirect('/adminseminars?alert=1');
    }

    public function updateSeminar(Request $request)
    {
        $input = $request->input();

        DB::table('tbl_seminars')
            ->where('id', $input['sid'])
            ->update([
                'title' => $input['seminartitle'],
                'description' => $input['seminardescription'],
                'starts_at' => $input['startdate'],
                'location' => $input['seminarlocation'],
                'updated_at' => Carbon::now(),
            ]);

        $userinfo = $request->attributes->get('userinfo');
        DB::table('tbl_logs')
            ->insert([
                'user_id' => $userinfo[0],
                'log_title' => 'Updated a seminar.',
                'log_description' => "This user updated a seminar on Seminar Page.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        return redirect('/adminseminars?alert=2');
    }

    public function seminarCollapsedDiv(Request $request)
    {
        $data = [];
        $qstring = [];

        $data['alerts'] = [
            1 => ['Successful! An attendee has been removed.', 'primary']
        ];

        if (!empty($request->query('alert'))) {
            $data['alert'] = $request->query('alert');
        }

        $data['seminarid'] = $seminarid = $request->query('id');

        $data['seminar'] = $seminar = DB::table('tbl_seminars')
            ->where('id', $seminarid)
            ->first();


        $attendees = DB::table('tbl_attendees')
            ->where('seminar_id', $seminarid)
            ->leftjoin('tbl_users', 'tbl_users.id', '=', 'tbl_attendees.user_id');

        if ($request->query('searchAttendee')) {
            $name = $request->query('searchAttendee');
            $attendees->where('tbl_users.firstname', 'like', "%$name%")
                ->orWhere('tbl_users.lastname', 'like', "%$name%");
        }

        // Users
        $data['attendees'] = $attendees
            ->get()
            ->toArray();

        $data['attendeesCount'] = DB::table('tbl_attendees')
            ->where('seminar_id', $seminarid)->count();

        return view('admin.seminarcollapseddiv', $data);
    }

    public function adminRemoveAttendee(Request $request)
    {
        $attendeeid = $request->query('uid');
        $sid = $request->query('sid');

        // dd($request->query());
        DB::table('tbl_attendees')
            ->where('user_id', $attendeeid)
            ->where('seminar_id', $sid)
            ->delete();

        $userinfo = $request->attributes->get('userinfo');
        DB::table('tbl_logs')
            ->insert([
                'user_id' => $userinfo[0],
                'log_title' => 'Removed a seminar attendee.',
                'log_description' => "This user removed a seminar attendee on Seminar Page.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        //ADDING NOTIFICATION
        $seminarinfo = DB::table('tbl_seminars')
            ->where('id', $sid)
            ->first();
        DB::table('tbl_notif')
            ->insert([
                'user_id' => $attendeeid,
                'user_type' => 'resident',
                'title' => 'You have been removed from a seminar.',
                'description' => 'An admin removed you from our seminar(' . $seminarinfo->title . ') Maybe it was just an accident, sign with us again!',
                'link' => 'userseminars',
                'seen' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        return redirect('/seminarcollapseddiv?alert=1&id=' . $sid);
    }

    public function historyIndex(Request $request)
    {
        $data = [];

        $seminars = DB::table('tbl_seminars')
            ->where('status', 'ongoing')
            ->orWhere('status', 'finished')
            ->orWhere('status', 'cancelled');

        $data['hseminarCount'] = DB::table('tbl_seminars')
            ->where('status', 'ongoing')
            ->orWhere('status', 'finished')
            ->orWhere('status', 'cancelled')
            ->count();

        $data['historyseminars'] = $seminars->orderBy('updated_at')->paginate()->appends($request->all());

        return view('admin.adminhistory', $data);
    }

    public function historyCollapsedDiv(Request $request)
    {
        $data = [];
        $data['alerts'] = [
            1 => ['Successful! Certificate has been sent', 'success']
        ];

        if(!empty($request->query('alert'))){
            $data['alert'] = $request->query('alert');
        }

        $sid = $request->query('id');

        $data['seminar'] = $seminar = DB::table('tbl_seminars')
            ->where('id', $sid)->first();

        $attendees = DB::table('tbl_attendees')
            ->where('seminar_id', $sid)
            ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_attendees.user_id');

        if ($request->query('searchAttendee')) {
            $name = $request->query('searchAttendee');
            $attendees->where('tbl_users.firstname', 'like', "%$name%")
                ->orWhere('tbl_users.lastname', 'like', "%$name%");
        }

        $data['attendeesCount'] = DB::table('tbl_attendees')
            ->where('seminar_id', $sid)->count();

        $data['attendees'] = $attendees->orderByDesc('updated_at')->paginate(30)->appends($request->all());

        return view('admin.historycollapseddiv', $data);
    }

    public function sendCertificate(Request $request)
    {
        $sid = $request->query('sid');
        $uid = $request->query('uid');

        $user = DB::table('tbl_users')
        ->where('id', $uid)
        ->first();

        DB::table('tbl_attendees')
        ->where('seminar_id', $sid)
        ->where('user_id', $uid)
        ->update([
            'cert_request' => 'sent',
            'updated_at' => Carbon::now()
        ]);

        return redirect('/historycollapseddiv?alert=1&id=' . $sid);
    }
}
