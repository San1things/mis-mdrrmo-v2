<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('adminhandler');
    }

    public function index(Request $request)
    {
        $data = [];
        $reports = DB::table('tbl_reports');

        $data['reportsCount'] = DB::table('tbl_reports')->count();

        $data['reports'] = $reports->orderByDesc('id')->paginate(20)->appends($request->all());
        return view('admin.adminreports', $data);
    }
}
