<?php

namespace App\Http\Controllers\Resident;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        return view('user.userprofile', $data);
    }
    public function usernotif()
    {
        return view('user.usernotif');
    }
}
