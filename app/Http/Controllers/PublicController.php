<?php

namespace App\Http\Controllers;

use App\Mail\SubscriptionMailer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PublicController extends Controller
{
    public function home(Request $request)
    {
        $data = [];
        $data['alerts'] = [
            1 => ['Error subscribing, the email you input has been subscribed.', 'danger'],
            3 => ['Error subscribing, you havent put any email yet!', 'danger'],
            2 => ['You are now subscribed! You will receive all the updates from us.', 'success'],

        ];

        if (!empty(request()->input('alert'))) {
            $data['alert'] = request()->input('alert');
        }

        return view('home', $data);
    }

    public function publicHomeSubscribe(Request $request)
    {
        $input = $request->input();
        $checkEmail = DB::table('tbl_subscriptions')
            ->where('email', $input['homeemail'])->count();

        if (empty($input['homeemail'])) {
            return redirect('/?alert=3');
            die();
        }

        if ($checkEmail >= 1) {
            return redirect('/?alert=1');
            die();
        }
        $formattedNow = Carbon::now('Asia/Manila')->format('m/d/y h:ia');
        DB::table('tbl_subscriptions')
            ->insert([
                'email' => $input['homeemail'],
                'subscribed_at' => $formattedNow,
                'created_at' => Carbon::now('Asia/Manila'),
                'updated_at' => Carbon::now('Asia/Manila')
            ]);

        Mail::to($input['homeemail'])->send(new SubscriptionMailer);

        // ADDING NOTIFICATION
        $orgusers = DB::table('tbl_users')
            ->where('usertype', 'admin')
            ->orWhere('usertype', 'staff')->get();

        foreach ($orgusers as $orguser) {
            DB::table('tbl_notif')
                ->insert([
                    'user_id' => $orguser->id,
                    'user_type' => 'org',
                    'title' => 'An unknown public user subscribed to the Org.',
                    'description' => 'New person subscribed to our org known as ' . $input['homeemail'] . '.',
                    'link' => '/subscriptions',
                    'seen' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
        }

        return redirect('/?alert=2');
    }

    public function about()
    {
        return view('about');
    }

    public function services()
    {
        return view('services');
    }

    public function faqs()
    {
        $data = [];
        $data['alerts'] = [
            1 => ['Error subscribing, the email you input has been subscribed.', 'danger'],
            2 => ['You are now subscribed! You will receive all the updates from us.', 'success'],
            3 => ['Successful! your message has been saved!', 'success'],
            4 => ['Error! Please put an email in the input!', 'danger'],
            5 => ['Error! Please put the corresponding input!', 'danger'],
            6 => ['Sorry! You can only send 3 messages, Please wait for a respond to message again.', 'danger'],
        ];

        if (!empty(request()->input('alert'))) {
            $data['alert'] = request()->input('alert');
        }

        return view('faqs', $data);
    }

    public function publicFaqsSubscribe(Request $request)
    {
        $input = $request->input();

        if (empty($input['faqscollapseemail'])) {
            return redirect('/faqs?alert=4');
            die();
        }

        $checkEmail = DB::table('tbl_subscriptions')
            ->where('email', $input['faqscollapseemail'])->count();

        if ($checkEmail >= 1) {
            return redirect('/faqs?alert=1');
            die();
        }
        $formattedNow = Carbon::now('Asia/Manila')->format('m/d/y h:ia');
        DB::table('tbl_subscriptions')
            ->insert([
                'email' => $input['faqscollapseemail'],
                'subscribed_at' => $formattedNow,
                'created_at' => Carbon::now('Asia/Manila'),
                'updated_at' => Carbon::now('Asia/Manila')
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
                    'title' => 'An unknown public user subscribed to the Org.',
                    'description' => 'New person subscribed to our org known as ' . $input['faqscollapseemail'] . '.',
                    'link' => '/subscriptions',
                    'seen' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
        }
        return redirect('/faqs?alert=2');
    }

    public function publicFaqsMessage(Request $request)
    {
        $input = $request->input();

        if (empty($input['faqsquestionname']) || empty($input['faqsquestionemail']) || empty($input['faqsquestionmessage'])) {
            return redirect('/faqs?alert=5');
            die();
        }

        $messageCheck = DB::table('tbl_messages')
            ->where('email', $input['faqsquestionemail'])
            ->where('replied', 0)->count();
        if ($messageCheck >= 3) {
            return redirect('/faqs?alert=6');
            die();
        }

        DB::table('tbl_messages')
            ->insert([
                'name' => $input['faqsquestionname'],
                'email' => $input['faqsquestionemail'],
                'message' => $input['faqsquestionmessage'],
                'replied' => 0,
                'seen' => 0,
                'created_at' => Carbon::now(),
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
                    'title' => $input['faqsquestionname'] . ' sent a message.',
                    'description' => 'This public person (' . $input['faqsquestionname'] . ') sent a message/question.',
                    'link' => '/adminmessages',
                    'seen' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
        }
        return redirect('/faqs?alert=3');
    }

    public function announcements(Request $request)
    {
        $data = [];
        $announcements = DB::table('tbl_announcements');

        $data['announcements'] = $announcements->orderByDesc('id')->get()->toArray();

        return view('announcements', $data);
    }

    public function report(Request $request)
    {
        $data = [];

        $data['alerts'] = [
            1 => ['Successful! Your report has been sent. Please standby for calls and updates.', 'success'],
            2 => ['Error! Please pin point where you are so that we know where to get to you.', 'danger'],
            3 => ['Error! Please put the required input.', 'danger'],
        ];
        if (!empty($request->query('alert'))) {
            $data['alert'] = $request->query('alert');
        }

        return view('report', $data);
    }

    public function publicReportProcess(Request $request)
    {
        $input = $request->input();

        if(empty($input['name']) || empty($input['contact']) || empty($input['barangay']) || empty($input['description']) || empty($input['signeddisclaimer'])){
            return redirect('/report?alert=3');
            die();
        }

        if (empty($input['latitude']) || empty($input['longitude'])) {
            return redirect('/report?alert=2');
            die();
        }

        DB::table('tbl_reports')
            ->insert([
                'name' => $input['name'],
                'contact' => $input['contact'],
                'barangay' => $input['barangay'],
                'description' => $input['description'],
                'latitude' => $input['latitude'],
                'longitude' => $input['longitude'],
                'signed_disclaimer' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        return redirect('/report?alert=1');
    }

    // public function tryemail()
    // {
    //     return view('email.subscribeview-mail');
    // }
}
