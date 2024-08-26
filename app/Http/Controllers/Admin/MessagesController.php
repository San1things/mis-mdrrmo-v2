<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MessagesController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        $query = $request->query();
        $qstring = [];
        $messages = DB::table('tbl_messages');

        $qstring['sender'] = '';
        $qstring['searchMessage'] = '';

        if (!empty($request->query('sender'))) {
            $qstring['sender'] = $request->query('sender');
            if ($query['sender'] == 'user') {
                $messages->whereNotNull('user_id');
            } elseif ($query['sender'] == 'unknown') {
                $messages->whereNull('user_id');
            }
        }

        if (!empty($request->query('searchMessage'))) {
            $qstring['searchMessage'] = $request->query('searchMessage');
            $senderName = $query['searchMessage'];
            if (empty($query['sender'])) {
                $messages->where('name', 'like', "%$senderName%")
                    ->orWhere('email', 'like', "%$senderName%");
            } else {
                if ($query['sender'] == 'user') {
                    $messages->whereNotNull('user_id')
                        ->where('name', 'like', "%$senderName%")
                        ->orWhere('email', 'like', "%$senderName%");
                } elseif ($query['sender'] == 'unknown') {
                    $messages->whereNull('user_id')
                        ->where('name', 'like', "%$senderName%")
                        ->orWhere('email', 'like', "%$senderName%");
                }
            }
        }

        $data['qstring'] = $qstring;
        $data['messageCount'] = DB::table('tbl_messages')->count();
        $data['messages'] = $messages->orderByDesc('id')->paginate(30)->appends($request->all());

        return view('admin.adminmessages', $data);
    }
}
