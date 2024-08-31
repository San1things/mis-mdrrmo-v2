<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
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

        $data['alerts'] = [
            1 => ['Error! Please input all the needed information.', 'danger'],
            2 => ['Succesful! An item has been added.', 'success'],
            3 => ['Updated succesfully! Item has been updated.', 'primary'],
            4 => ['Deleted succesfully! Item has been deleted.', 'danger'],
            5 => ['Error! This item is in the inventory, search it and just update the item.', 'danger'],
        ];

        if (!empty($request->query('alert'))) {
            $data['alert'] = $request->query('alert');
        }

        $query = request()->query();
        $qstring['category'] = '';
        $qstring['searchItem'] = '';

        if (!empty($query['category'])) {
            $qstring['category'] = $query['category'];
            if ($query['category'] == 'other') {
                $items->whereNotIn('item_category', ['Personal Protective Equipment', 'Vehicles', 'Disaster Supplies', 'Medicines']);
            } else {
                $items->where('item_category', $query['category']);
            }
        }

        if (!empty($query['searchItem'])) {
            $qstring['searchItem'] = $query['searchItem'];
            $name = $query['searchItem'];
            if (empty($query['category'])) {
                $items->where('item_name', 'like', "%$name%");
            } else {
                $items->where('item_name', 'like', "%$name%")
                    ->where('item_category', $query['category']);
            }
        }

        $data['itemsCount'] = DB::table('tbl_items')->count();
        $data['items'] = $items->orderByDesc('id')->paginate(15)->appends($request->all());
        $data['categories'] = $categories->get()->toArray();
        $data['qstring'] = $qstring;

        return view('admin.inventory', $data);
    }

    public function itemAdd(Request $request)
    {
        $input = request()->input();

        if (empty($input['itemname']) || empty($input['itemdescription']) || empty($input['itemcategory']) || empty($input['itemquantity'])) {
            return redirect('/inventory?alert=1');
            die();
        }

        $itemcheck = DB::table('tbl_items')
            ->where('item_name', $input['itemname'])
            ->where('item_description', $input['itemdescription'])
            ->count();

        if ($itemcheck >= 1) {
            return redirect('/inventory?alert=5');
            die();
        }

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

        $userinfo = $request->attributes->get('userinfo');
        DB::table('tbl_logs')
            ->insert([
                'user_id' => $userinfo[0],
                'log_title' => 'Added an item.',
                'log_description' => "This user added an item on Inventory Page.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        return redirect('/inventory?alert=2');
    }

    public function itemUpdate(Request $request)
    {
        $input = request()->input();

        if (empty($input['itemname']) || empty($input['itemdescription']) || empty($input['itemcategory']) || empty($input['itemquantity'])) {
            return redirect('/inventory?alert=1');
            die();
        }

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

        $userinfo = $request->attributes->get('userinfo');
        DB::table('tbl_logs')
            ->insert([
                'user_id' => $userinfo[0],
                'log_title' => 'Updated an item.',
                'log_description' => "This user updated an item on Inventory Page.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        return redirect('/inventory?alert=3');
    }

    public function itemDelete(Request $request)
    {
        $input = request()->input();
        DB::table('tbl_items')->where('id', $input['id'])->delete();

        $userinfo = $request->attributes->get('userinfo');
        DB::table('tbl_logs')
            ->insert([
                'user_id' => $userinfo[0],
                'log_title' => 'Deleted an item.',
                'log_description' => "This user deleted an item on Inventory Page.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        return redirect('/inventory?alert=4');
    }

    public function categoriesIndex(Request $request)
    {
        $data = [];

        $data['alerts'] = [
            1 => ['Successful! Category has beeen added.', 'success'],
            2 => ['Successful! A category has been updated!', 'primary'],
            3 => ['Category has been deleted.', 'danger'],
        ];

        if(!empty($request->query('alert'))){
            $data['alert'] = $request->query('alert');
        }

        $categories = DB::table('tbl_categories')
            ->leftJoin('tbl_items', 'tbl_categories.id', '=', 'tbl_items.category_id')
            ->select('tbl_categories.*', DB::raw('COUNT(tbl_items.id) as item_count'))
            ->groupBy('tbl_categories.id')
            ->get()->toArray();

        $data['categories'] = $categories;

        return view('admin.categories', $data);
    }

    public function createCategory(Request $request)
    {
        $input = $request->input();

        DB::table('tbl_categories')
            ->insert([
                'category_name' => $input['categoryname'],
                'category_description' => $input['categorydescription'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        return redirect('/categories?alert=1');
    }

    public function updateCategory(Request $request)
    {
        $input = $request->input();

        DB::table('tbl_categories')
            ->where('id', $input['id'])
            ->update([
                'category_name' => $input['categoryname'],
                'category_description' => $input['categorydescription'],
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        return redirect('/categories?alert=2');
    }

    public function deleteCategory(Request $request)
    {
        $input = $request->input();

        DB::table('tbl_categories')
            ->where('id', $input['id'])
            ->delete();

        return redirect('/categories?alert=3');
    }
}
