<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function generateUserPdf(Request $request)
    {
        $data = [];

        $usertype = $request->input('usertype', '');
        $searchUser = $request->input('searchUser', '');

        $users = DB::table('tbl_users');

        if (!empty($usertype)) {
            if ($usertype == 'other') {
                $users
                    ->where('usertype', '!=', 'admin')
                    ->where('usertype', '!=', 'staff');
            } else {
                $users->where('usertype', $usertype);
            }
        }

        if (!empty($searchUser)) {
            $name = $searchUser;
            if (empty($usertype)) {
                $users->where('firstname', 'like', "%$name%")
                    ->orWhere('lastname', 'like', "%$name%")
                    ->orWhere('email', 'like', "%$name%");
            } else {
                $users->where('firstname', 'like', "%$name%")
                    ->orWhere('lastname', 'like', "%$name%")
                    ->orWhere('email', 'like', "%$name%")
                    ->where('usertype', $usertype);
            }
        };

        $data['users'] = $users->orderByDesc('id')->get();

        $pdf = Pdf::loadView('admin.components.pdf.user-generate-pdf', $data);
        return $pdf->stream();
    }

    public function generateInventoryPdf(Request $request)
    {
        $data = [];

        $category = $request->input('category', '');
        $searchItem = $request->input('searchItem', '');

        $items = DB::table('tbl_items');

        if (!empty($category)) {
            if ($category == 'other') {
                $items
                    ->where('item_category', '!=', 'Personal Protective Equipment')
                    ->where('item_category', '!=', 'Disaster Supplies')
                    ->where('item_category', '!=', 'Medicines')
                    ->where('item_category', '!=', 'Vehicles');
            } else {
                $items->where('item_category', $category);
            }
        }

        if (!empty($searchItem)) {
            $name = $searchItem;
            if (empty($usertype)) {
                $items->where('item_name', 'like', "%$name%")
                    ->orWhere('item_description', 'like', "%$name%")
                    ->orWhere('item_category', 'like', "%$name%");
            } else {
                $items->where('item_name', 'like', "%$name%")
                    ->orWhere('item_description', 'like', "%$name%")
                    ->orWhere('item_category', 'like', "%$name%")
                    ->where('item_category', $usertype);
            }
        };

        $data['items'] = $items->orderByDesc('id')->get();

        $pdf = Pdf::loadView('admin.components.pdf.inventory-generate-pdf', $data);
        return $pdf->stream();
    }

    public function generateSeminarHistoryPdf(Request $request)
    {
        $data = [];
    }

    public function generateSubscriptionPdf(Request $request)
    {
        $data = [];
    }

    public function generateLogsPdf(Request $request)
    {
        $data = [];
    }
}
