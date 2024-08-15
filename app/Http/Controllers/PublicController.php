<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    public function home()
    {
        return view('home');
    }
    public function about()
    {
        return view('about');
    }
    public function services()
    {
        return view('services');
    }
    public function faqs()
    {
        return view('faqs');
    }
    public function announcements(Request $request)
    {
        $data = [];
        $announcements = DB::table('tbl_announcements');

        $data['announcements'] = $announcements->get()->toArray();

        return view('announcements', $data);
    }
}
