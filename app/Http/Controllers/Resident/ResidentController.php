<?php

namespace App\Http\Controllers\Resident;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Attribute;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ResidentController extends Controller
{
    public function __construct()
    {
        $this->middleware('residenthandler');
    }

    public function userhome(Request $request)
    {
        $data = [];
        $userinfo = $request->attributes->get('userinfo');
        $data['user'] = DB::table('tbl_users')
            ->where('id', $userinfo[0])->first();

        return view('user.userhome', $data);
    }

    public function userabout()
    {
        return view('user.userabout');
    }

    public function userservices()
    {
        return view('user.userservices');
    }

    public function userfaqs(Request $request)
    {
        $data = [];

        $data['alerts'] = [
            1 => ['Your message has been sent!', 'success'],
            2 => ['Error! Please fill all the required input.', 'danger'],
            3 => ['Sorry! You can only send 3 messages, Please wait for a respond to message again.', 'danger'],
        ];

        if(!empty($request->query('alert'))){
            $data['alert'] = $request->query('alert');
        }

        $userinfo = $request->attributes->get('userinfo');
        $data['user'] = DB::table('tbl_users')
            ->where('id', $userinfo[0])->first();

        return view('user.userfaqs', $data);
    }

    public function userFaqsMessage(Request $request)
    {
        $input = $request->input();

        if (empty($input['faqsquestionname']) || empty($input['faqsquestionemail']) || empty($input['faqsquestionmessage'])) {
            return redirect('/userfaqs?alert=2');
            die();
        }

        $messageCheck = DB::table('tbl_messages')
            ->where('email', $input['faqsquestionemail'])
            ->where('replied', 0)->count();
        if ($messageCheck >= 3) {
            return redirect('/userfaqs?alert=3');
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

        return redirect('/userfaqs?alert=1');
    }

    public function userannouncements(Request $request)
    {
        $data = [];
        $announcements = DB::table('tbl_announcements');

        $data['announcements'] = $announcements
            ->orderByDesc('id')
            ->get()
            ->toArray();

        return view('user.userannouncements', $data);
    }

    public function userseminars(Request $request)
    {
        $data = [];

        $data['alerts'] = [
            1 => ['Good job! You are now registered. Please bring yourself in the given place that is posted. Thank you!', 'success'],
            2 => ['Unregistered succesfully! If you change your mind, you can join us anytime!', 'primary'],
            3 => ['Certificate has been requested! We will proccess it right away!', 'success'],
        ];

        if (!empty($request->query('alert'))) {
            $data['alert'] = $request->query('alert');
        }

        $data['seminars'] = DB::table('tbl_seminars')
            ->orderByDesc('id')
            ->get()
            ->toArray();
        $data['attendeeCount'] = DB::table('tbl_attendees')->count();
        return view('user.userseminars', $data);
    }

    public function userJoinSeminar(Request $request)
    {
        $seminarid = $request->query('sid');
        $userinfo = $request->attributes->get('userinfo');

        DB::table('tbl_attendees')
            ->insert([
                'user_id' => $userinfo[0],
                'seminar_id' => $seminarid,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        //ADDING NOTIFICATION
        $seminarinfo = DB::table('tbl_seminars')
            ->where('id', $seminarid)
            ->first();
        DB::table('tbl_notif')
            ->insert([
                'user_id' => $userinfo[0],
                'user_type' => 'resident',
                'title' => 'You have joined a seminar.',
                'description' => 'Thanks for joining our seminar(' . $seminarinfo->title . '). This will be held at ' . $seminarinfo->location . ' and will start at exactly ' . Carbon::create($seminarinfo->starts_at)->format('h:m a  M, d Y') . '. Please be ready and join us to be prepared and ready in time of emergency!',
                'link' => '/userseminars',
                'seen' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        $orgusers = DB::table('tbl_users')
            ->where('usertype', 'admin')
            ->orWhere('usertype', 'staff')->get();

        foreach ($orgusers as $orguser) {
            DB::table('tbl_notif')
                ->insert([
                    'user_id' => $orguser->id,
                    'user_type' => 'org',
                    'title' => 'A resident joined our seminar.',
                    'description' => $userinfo[1] . ' ' . $userinfo[2] . ' joined our seminar(' . $seminarinfo->title . ') that will be held at ' . $seminarinfo->location . '.',
                    'link' => '/adminseminars',
                    'seen' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
        }
        return redirect('/userseminars?alert=1');
    }

    public function userUnregisterSeminar(Request $request)
    {
        $seminarid = $request->query('sid');
        $userinfo = $request->attributes->get('userinfo');

        DB::table('tbl_attendees')
            ->where('user_id', $userinfo[0])
            ->where('seminar_id', $seminarid)
            ->delete();

        //ADDING NOTIFICATION
        $seminarinfo = DB::table('tbl_seminars')
            ->where('id', $seminarid)
            ->first();
        DB::table('tbl_notif')
            ->insert([
                'user_id' => $userinfo[0],
                'user_type' => 'resident',
                'title' => 'You unregistered to our seminar!',
                'description' => 'You remove your registration to our seminar(' . $seminarinfo->title . ') that will be held at ' . $seminarinfo->location . '. We hope that you reconsider your decision. Have a good life ahead!',
                'link' => '/userseminars',
                'seen' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        $orgusers = DB::table('tbl_users')
            ->where('usertype', 'admin')
            ->orWhere('usertype', 'staff')->get();

        foreach ($orgusers as $orguser) {
            DB::table('tbl_notif')
                ->insert([
                    'user_id' => $orguser->id,
                    'user_type' => 'org',
                    'title' => 'A resident cancel its registration to our seminar.',
                    'description' => $userinfo[1] . ' ' . $userinfo[2] . ' unregistered to our seminar(' . $seminarinfo->title . ').',
                    'link' => '/adminseminars',
                    'seen' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
        }
        return redirect('/userseminars?alert=2');
    }

    public function userprofile(Request $request)
    {
        $data = [];
        $data['userinfo'] = $userinfo = $request->attributes->get('userinfo');

        $data['alerts'] = [
            1 => ['Update failed, the email you input has been used.', 'danger'],
            2 => ['Update failed, mobile number must be 10 digits long, please remove the starting 0 if you have one.', 'danger'],
            3 => ['Error! Password must be 8 character long.', 'danger'],
            4 => ['Error! Password does not match.', 'danger'],
            5 => ['Nice! Your profile details was updated succesfully.', 'primary'],
            6 => ['Succesful! Password has been changed.', 'primary'],
            7 => ['Error! Please fill out all the requirements, dont make empty inputs.', 'danger'],
        ];

        if (!empty($request->input('alert'))) {
            $data['alert'] = $request->input('alert');
        };

        $users = DB::table('tbl_users');
        $data['userprofile'] = $users
            ->where('id', $userinfo[0])->first();

        return view('user.userprofile', $data);
    }

    public function userUpdateProfile(Request $request)
    {
        $input = $request->input();
        $userinfo = $request->attributes->get('userinfo');

        if ($input['email'] == null || $input['username'] == null || $input['firstname'] == null || $input['lastname'] == null || $input['birthday'] == null || $input['gender'] == null || $input['address'] == null || $input['contact'] == null) {
            return redirect('/userprofile?alert=7');
            die();
        }

        $users = DB::table('tbl_users');
        $tableemail = $users
            ->where('email', $input['email'])
            ->where('id', '!=', $userinfo[0])->count();
        if ($tableemail >= 1) {
            return redirect('/userprofile?alert=1');
            die();
        }

        if (strlen($input['contact']) != 10) {
            return redirect('/userprofile?alert=2');
            die();
        }

        DB::table('tbl_users')->where('id', $userinfo[0])
            ->update([
                'email' => $input['email'],
                'username' => $input['username'],
                'firstname' => $input['firstname'],
                'lastname' => $input['lastname'],
                'gender' => $input['gender'],
                'address' => $input['address'],
                'bday' => $input['birthday'],
                'contact' => $input['contact'],
            ]);

        return redirect('/userprofile?alert=5');
    }

    public function userUpdatePassword(Request $request)
    {
        $input = $request->input();
        $userinfo = $request->attributes->get('userinfo');
        $users = DB::table('tbl_users');

        if (strlen($input['profilepassword1']) < 8) {
            return redirect('/userprofile?alert=3');
            die();
        }

        if ($input['profilepassword1'] != $input['profilepassword2']) {
            return redirect('/userprofile?alert=4');
            die();
        }

        $users->where('id', $userinfo[0])
            ->update([
                'password' => $input['profilepassword1']
            ]);

        return redirect('userprofile?alert=6');
    }

    public function usernotif(Request $request)
    {
        $data = [];
        $data['alerts'] = [
            1 => ['Notification has been removed!', 'info']
        ];
        if (!empty($request->query('alert'))) {
            $data['alert'] = $request->query('alert');
        }

        $userinfo = $request->attributes->get('userinfo');
        $notifications = DB::table('tbl_notif')
            ->where('user_id', $userinfo[0])
            ->where('user_type', 'resident');

        $data['notifications'] = $notifications->orderByDesc('id')->paginate(30)->appends($request->all());

        return view('user.usernotif', $data);
    }

    public function userRemoveNotif(Request $request)
    {
        $input = $request->input();

        $userinfo = $request->attributes->get('userinfo');
        DB::table('tbl_notif')
            ->where('id', $input['id'])
            ->where('user_id', $userinfo[0])
            ->delete();

        return redirect('/usernotif?alert=1');
    }
}
