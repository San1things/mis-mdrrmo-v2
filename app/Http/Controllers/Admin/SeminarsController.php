<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class SeminarsController extends Controller
{
    public function index()
    {
        $data = [];
        $seminars = DB::table('tbl_seminars');

        $data['seminars'] = $seminars->get()->toArray();
        $data['seminarCount'] = $seminars->count();

        return view('admin.adminseminars', $data);
    }

    public function createSeminar(Request $request)
    {
        $input = $request->input();

        DB::table('tbl_seminars')
            ->insert([
                'title' => $input['seminartitle'],
                'description' => $input['seminardescription'],
                'starts_at' => $input['startdate'],
                'location' => $input['seminarlocation'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        return redirect('/adminseminars');
    }

    public function collapsedDiv(Request $request)
    {
        $data = [];
        $data['seminarid'] = $seminarid = $request->query('id');

        $data['seminar'] = $seminar = DB::table('tbl_seminars')
            ->where('id', $seminarid)
            ->first();

        // Users
        $data['attendees'] = $attendees = DB::table('tbl_attendees')
            ->where('seminar_id', $seminarid)
            ->leftjoin('tbl_users', 'tbl_users.id', '=', 'tbl_attendees.user_id')
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

        return redirect('/seminarcollapseddiv?id=' . $sid);
    }
}
