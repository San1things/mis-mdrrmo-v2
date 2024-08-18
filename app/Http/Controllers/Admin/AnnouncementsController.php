<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AnnouncementsController extends Controller
{

    public function __construct(Request $request)
    {
        $this->middleware('adminhandler');
    }

    public function index(Request $request)
    {
        $data = [];
        $announcements = DB::table('tbl_announcements');
        $query = $request->query();
        $qstring['type'] = '';
        $qstring['searchAnnouncement'] = '';

        $data['alerts'] = [
            1 => ['Error! Please put an image haeder!', 'danger'],
            2 => ['Successful! Announcement has beeen updated', 'success'],
            3 => ['Well Done! Announcement has beeen posted publicly!', 'success'],
        ];

        if(!empty($request->query('alert'))){
            $data['alert'] = request()->query('alert');
        }


        if (!empty($query['type'])) {
            $qstring['type'] = $query['type'];
            if ($query['type'] == 'other') {
                $announcements->whereNotIn('announcement_type', ['Seminar', 'Event']);
            } else {
                $announcements->where('announcement_type', $query['type']);
            }
        }

        if (!empty($query['searchAnnouncement'])) {
            $qstring['searchAnnouncement'] = $query['searchAnnouncement'];
            $anntitle = $query['searchAnnouncement'];
            if (empty($query['type'])) {
                $announcements->where('announcement_name', 'like', "%$anntitle%");
            } else {
                $announcements
                    ->where('announcement_name', 'like', "%$anntitle%")
                    ->where('announcement_type', $query['type']);
            }
        }

        $data['annCount'] = DB::table('tbl_announcements')->count();
        $data['announcements'] = $announcements->orderByDesc('id')->paginate(15)->appends($request->all());
        $data['qstring'] = $qstring;

        return view('admin.adminannouncements', $data);
    }

    public function announcementAdd(Request $request)
    {
        $input = $request->input();

        if (!empty($request->file())) {
            $time = Carbon::now()->toDateString();
            $randomtext = Str::random(8);
            $image = $request->file('announcementimage');
            $imagename = $time . 'announcement' . $randomtext . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/uploadedpics'), $imagename);
        } else {
            return redirect('adminannouncements?alert=1');
        }


        DB::table('tbl_announcements')
            ->insert([
                'announcement_name' => $input['announcementname'],
                'announcement_description' => $input['announcementdescription'],
                'announcement_link' => $input['announcementlink'],
                'announcement_type' => $input['announcementtype'],
                'announcement_image' => $imagename,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        return redirect('/adminannouncements?alert=3');
    }

    public function announcementUpdate(Request $request)
    {
        $input = $request->input();

        DB::table('tbl_announcements')
            ->where('id', $input['id'])
            ->update([
                'announcement_name' => $input['announcementname'],
                'announcement_description' => $input['announcementdescription'],
                'announcement_link' => $input['announcementlink'],
                'announcement_type' => $input['announcementtype'],
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        return redirect('/adminannouncements?alert=2');
    }
}
