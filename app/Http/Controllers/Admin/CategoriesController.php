<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function index(Request $request){
    $data = [];
    $categories = DB::table('tbl_categories')->leftJoin('tbl_items', 'tbl_categories.id', '=', 'tbl_items.category_id')
    ->select('tbl_categories.*', DB::raw('COUNT(tbl_items.id) as item_count'))
    ->groupBy('tbl_categories.id')
    ->get()->toArray();

    $data['categories'] = $categories;

        return view('admin.categories', $data);
    }

}
