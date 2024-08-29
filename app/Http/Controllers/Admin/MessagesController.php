<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\MessageReplyMailer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Console\Input\Input;

class MessagesController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        $query = $request->query();
        $qstring = [];
        $messages = DB::table('tbl_messages');

        $data['alerts'] = [
            1 => ['Successful! Reply has been sent!', 'success'],
            2 => ['Error! Please put the corresponding input before replying!', 'danger'],
        ];

        if (!empty($request->query('alert'))) {
            $data['alert'] = $request->query('alert');
        }

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

    public function adminMessageReply(Request $request)
    {
        $input = $request->input();
        if (empty($input['messagereply'])) {
            return redirect('/adminmessages?alert=2');
            die();
        }

        $userinfo = $request->attributes->get('userinfo');

        $messageinfo = DB::table('tbl_messages')
            ->where('id', $input['id'])
            ->first();

        $usermessage = $messageinfo->message;
        $reply = $input['messagereply'];

        Mail::to($messageinfo->email)->send(new MessageReplyMailer($reply, $usermessage));

        db::table('tbl_messages')
        ->where('id', $input['id'])
        ->update([
            'replied' => 1,
            'updated_at' => Carbon::now(),
        ]);

        // ADDING NOTIFICATION
        $orgusers = DB::table('tbl_users')
            ->where('usertype', 'admin')
            ->orWhere('usertype', 'staff')->get();

        foreach ($orgusers as $orguser) {
            DB::table('tbl_notif')
                ->insert([
                    'user_id' => $orguser->id,
                    'user_type' => 'org',
                    'title' => $userinfo[1] . ' ' . $userinfo[2] . ' replied to a message.',
                    'description' => $userinfo[1] . " replied to " . $messageinfo->name . "'s message",
                    'link' => '/adminmessages',
                    'seen' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
        }

        DB::table('tbl_notif')
            ->insert([
                'user_id' => $messageinfo->user_id,
                'user_type' => 'resident',
                'title' => 'An admin replied to your message.',
                'description' => "An admin replied to your question/message, you can check your email now.",
                'link' => 'https://mail.google.com/',
                'seen' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            // ADDING LOGS
        $userinfo = $request->attributes->get('userinfo');
        DB::table('tbl_logs')
            ->insert([
                'user_id' => $userinfo[0],
                'log_title' => 'Replied to a message.',
                'log_description' => "This user replied to " . $messageinfo->name . " on the Messages Page.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        return redirect('/adminmessages?alert=1');
    }
}
