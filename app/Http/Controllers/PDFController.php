<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

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

        $last = $request->input('last', '');
        $seminars = DB::table('tbl_seminars')
            ->whereIn('status', ['finished', 'cancelled']);
        if (!empty($last)) {
            if ($last == 'week') {
                $weekstart = Carbon::now()->subWeek();
                $weekend = Carbon::now()->subDays(30);
                $seminars
                    ->whereBetween('updated_at', [$weekend, $weekstart]);
            } else if ($last == 'month') {
                $monthstart = Carbon::now()->subMonth();
                $monthend = Carbon::now()->subMonths(6);
                $seminars
                    ->whereBetween('updated_at', [$monthend, $monthstart]);
            } else if ($last == '6months') {
                $sixmonthstart = Carbon::now()->subMonths(6);
                $sixmonthend = Carbon::now()->subYear();
                $seminars
                    ->whereBetween('updated_at', [$sixmonthend, $sixmonthstart]);
            } else if ($last == 'year') {
                $yearstart = Carbon::now()->subYear();
                $yearend = Carbon::now()->subyears(2);
                $seminars
                    ->whereBetween('updated_at', [$yearend, $yearstart]);
            }
        }

        $data['seminars'] = $seminars->orderByDesc('updated_at')->get();

        $pdf = Pdf::loadView('admin.components.pdf.seminar-generate-pdf', $data);
        return $pdf->stream();
    }

    public function generateSubscriptionPdf(Request $request)
    {
        $data = [];

        $last = $request->input('last', '');
        $searchSubscriber = $request->input('searchSubscriber', '');

        $subscribers = DB::table('tbl_subscriptions');

        if (!empty($last)) {
            if ($last == 'week') {
                $weekstart = Carbon::now()->subWeek();
                $weekend = Carbon::now()->subDays(30);
                $subscribers
                    ->whereBetween('created_at', [$weekend, $weekstart]);
            } else if ($last == 'month') {
                $monthstart = Carbon::now()->subMonth();
                $monthend = Carbon::now()->subMonths(6);
                $subscribers
                    ->whereBetween('created_at', [$monthend, $monthstart]);
            } else if ($last == '6months') {
                $sixmonthstart = Carbon::now()->subMonths(6);
                $sixmonthend = Carbon::now()->subYear();
                $subscribers
                    ->whereBetween('created_at', [$sixmonthend, $sixmonthstart]);
            } else if ($last == 'year') {
                $yearstart = Carbon::now()->subYear();
                $yearend = Carbon::now()->subyears(2);
                $subscribers
                    ->whereBetween('created_at', [$yearend, $yearstart]);
            }
        }

        if (!empty($searchSubscriber)) {
            $emailtyped = $searchSubscriber;
            $subscribers->where('email', 'like', "%$emailtyped%");
        }

        $data['subscribers'] = $subscribers->orderByDesc('id')->get();

        $pdf = Pdf::loadView('admin.components.pdf.subscriber-generate-pdf', $data);
        return $pdf->stream();
    }

    public function generateLogsPdf(Request $request)
    {
        $data = [];

        $last = $request->input('last', '');
        $searchLogs = $request->input('searchLogs', '');

        $logs = DB::table('tbl_logs')
            ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_logs.user_id')
            ->select('tbl_logs.created_at as log_created_at', 'tbl_users.created_at as user_created_at', 'tbl_logs.*', 'tbl_users.*');

        if (!empty($last)) {
            if ($last == 'week') {
                $weekstart = Carbon::now()->subWeek();
                $weekend = Carbon::now()->subDays(30);
                $logs
                    ->whereBetween('tbl_logs.created_at', [$weekend, $weekstart]);
            } else if ($last == 'month') {
                $monthstart = Carbon::now()->subMonth();
                $monthend = Carbon::now()->subMonths(6);
                $logs
                    ->whereBetween('tbl_logs.created_at', [$monthend, $monthstart]);
            } else if ($last == '6months') {
                $sixmonthstart = Carbon::now()->subMonths(6);
                $sixmonthend = Carbon::now()->subYear();
                $logs
                    ->whereBetween('tbl_logs.created_at', [$sixmonthend, $sixmonthstart]);
            } else if ($last == 'year') {
                $yearstart = Carbon::now()->subYear();
                $yearend = Carbon::now()->subyears(2);
                $logs
                    ->whereBetween('tbl_logs.created_at', [$yearend, $yearstart]);
            }
        }

        if (!empty($searchLogs)) {
            $nameAction = $request->input('searchLogs');

            $logs->where(function ($query) use ($nameAction) {
                $query->where('tbl_users.firstname', 'like', "%$nameAction%")
                    ->orWhere('tbl_users.lastname', 'like', "%$nameAction%")
                    ->orWhere('tbl_logs.log_title', 'like', "%$nameAction%");
            });
        }

        $data['logs'] = $logs->orderByDesc('tbl_logs.id')->get();

        $pdf = Pdf::loadView('admin.components.pdf.logs-generate-pdf', $data);
        return $pdf->stream();
    }
}
