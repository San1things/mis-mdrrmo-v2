<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function index(Request $request){
    $data = [];
    $categories = DB::table('tbl_categories');

    $data['categories'] = $categories->get()->toArray();

        return view('admin.categories', $data);
    }

}
