<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnnouncementsController extends Controller
{
    public function index(){
        $data = [];
        $announcements = DB::table('tbl_announcements');

        $data['announcements'] = $announcements->get()->toArray();
        $data['annCount'] = $announcements->count();

        return view('admin.adminannouncements', $data);
    }

    public function announcementAdd(){
        
    }
}
