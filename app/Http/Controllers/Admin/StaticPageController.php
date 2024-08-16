<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StaticPageController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('adminhandler');
    }

    public function subscriptionsIndex(){
        $data = [];
        $subscribers = DB::table('tbl_subscriptions');

        $data['subCount'] = $subscribers->count();
        $data['subscribers'] = $subscribers->get()->toArray();

        return view('admin.subscriptions', $data);
    }

    public function logsIndex()
    {
        return view('admin.logs');
    }
}
