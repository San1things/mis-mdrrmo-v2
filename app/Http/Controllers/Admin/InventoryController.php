<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('adminhandler');
    }

    public function index(Request $request)
    {

        $data = [];
        $qstring = [];
        $items = DB::table('tbl_items');
        $categories = DB::table('tbl_categories');

        $query = request()->query();
        $qstring['category'] = '';
        $qstring['searchItem'] = '';

        if(!empty($query['category'])){
            $qstring['category'] = $query['category'];
            $items->where('item_category', $query['category']);
        }

        if(!empty($query['searchItem'])){
            $qstring['searchItem'] = $query['searchItem'];
            $name = $query['searchItem'];
            if(empty($query['category'])){
                $items->where('item_name', 'like', "%$name%");
            } else {
                $items->where('item_name', 'like', "%$name%")
                ->where('item_category', $query['category']);
            }
        }

        $data['itemsCount'] = DB::table('tbl_items')->count();
        $data['items'] = $items->get()->toArray();
        $data['categories'] = $categories->get()->toArray();
        $data['qstring'] = $qstring;

        return view('admin.inventory', $data);
    }

    public function itemAdd(Request $request)
    {
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

    public function itemUpdate(Request $request)
    {
        $input = request()->input();

        $ctgnm = DB::table('tbl_categories')->where('id', $input['itemcategory'])->first();
        DB::table('tbl_items')->where('id', $input['id'])
            ->update([
                'category_id' => $input['itemcategory'],
                'item_name' => $input['itemname'],
                'item_description' => $input['itemdescription'],
                'item_category' => $ctgnm->category_name,
                'item_quantity' => $input['itemquantity'],
                'expired_at' => $input['itemexpired']
            ]);

        return redirect('/inventory');
    }

    public function itemDelete(Request $request)
    {
        $input = request()->input();
        DB::table('tbl_items')->where('id', $input['id'])->delete();
        return redirect('/inventory');
    }
}
