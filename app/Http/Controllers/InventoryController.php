<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index(Request $request){

        $data = [];
        $qstring = [];
        $items = DB::table('tbl_items');

        $data['itemsCount'] = DB::table('tbl_items')->count();
        $data['tbl_items'] = $items->get()->toArray();

        return view('inventory', $data);
    }
}
