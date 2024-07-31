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
        $categories = DB::table('tbl_categories');

        $data['itemsCount'] = DB::table('tbl_items')->count();
        $data['items'] = $items->get()->toArray();
        $data['categories'] = $categories->get()->toArray();

        return view('admin.inventory', $data);
    }

    public function itemAdd(Request $request){
        $input = request()->input();

        $ctgnm = DB::table('tbl_categories')->where('id', $input['itemcategory'])->first();
        DB::table('tbl_items')
        ->insert([
            'category_id' => $input['itemcategory'],
            'item_name' => $input['itemname'],
            'item_description' => $input['itemdescription'],
            'item_category' => $ctgnm->category_name,
            'item_quantity' => $input['itemquantity'],
            'expired_at' => $input['itemexpired']
        ]);

        return redirect('/inventory');
    }
}
