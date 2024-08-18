<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class SeminarsController extends Controller
{
    public function index(Request $request)
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

        $seminars = DB::table('tbl_seminars');

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

        return redirect('/adminseminars?alert=2');
    }

    public function collapsedDiv(Request $request)
    {
        $data = [];
        $qstring = [];

        $data['alerts'] = [
            1 => ['Successful! An attendee has been removed.', 'primary']
        ];

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

        $attendeeid = $request->query('id');
        $sid = $request->query('sid');

        // dd($request->query());

        DB::table('tbl_attendees')
            ->where('user_id', $attendeeid)
            ->where('seminar_id', $sid)
            ->delete();

        return redirect('/seminarcollapseddiv?alert=1&id=' . $sid);
    }
}
