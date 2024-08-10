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

        // Get filter parameters from the request
        $usertype = $request->input('usertype', ''); // Default to empty string if not provided
        $searchUser = $request->input('searchUser', ''); // Default to empty string if not provided

        // Build the query with filters
        $query = DB::table('tbl_users');

        if (!empty($usertype)) {
            $query->where('usertype', $usertype);
        }

        if (!empty($searchUser)) {
            $query->where('firstname', 'like', "%$searchUser%")
                    ->orWhere('lastname', 'like', "%$searchUser%");
            }

        // Get the filtered users
        $users = $query->get();
        $data['tbl_users'] = $users;

        $pdf = Pdf::loadView('admin.components.pdf.user-generate-pdf', $data);
        return $pdf->stream();
    }
}
