<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    public function home(Request $request)
    {
        $data = [];
        $data['alerts'] = [
            1 => ['Error subscribing, the email you input has been subscribed.', 'danger'],
            2 => ['You are now subscribed! You will receive all the updates from us.', 'success']
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
            2 => ['You are now subscribed! You will receive all the updates from us.', 'success']
        ];

        if (!empty(request()->input('alert'))) {
            $data['alert'] = request()->input('alert');
        }

        return view('faqs', $data);
    }
    public function publicFaqsSubscribe(Request $request)
    {
        $input = $request->input();
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

        return redirect('/faqs?alert=2');
    }
    public function announcements(Request $request)
    {
        $data = [];
        $announcements = DB::table('tbl_announcements');

        $data['announcements'] = $announcements->orderByDesc('id')->get()->toArray();

        return view('announcements', $data);
    }
}
