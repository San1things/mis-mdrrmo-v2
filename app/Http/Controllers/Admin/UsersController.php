<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class UsersController extends Controller
{
    // public $default_lpp = 2;
    // public $default_sp = 1;

    public function index(Request $request)
    {
        $data = [];
        $qstring = [];
        $users = DB::table('tbl_users');
        $query = $request->query();
        $qstring['usertype'] = '';
        $qstring['searchUser'] = '';

        if (!empty($query['usertype'])) {
            $qstring['usertype'] = $query['usertype'];
            if ($query['usertype'] == 'other') {
                $users->whereNotIn('usertype', ['admin', 'staff']);
            } else {
                $users->where('usertype', $query['usertype']);
            }
        }


        if (!empty($query['searchUser'])) {
            $qstring['searchUser'] = $query['searchUser'];
            $name = $query['searchUser'];
            if (empty($query['usertype'])) {
                $users->where('firstname', 'like', "%$name%")
                    ->orWhere('lastname', 'like', "%$name%");
            } else {
                $users->where('firstname', 'like', "%$name%")
                    ->orWhere('lastname', 'like', "%$name%")
                    ->where('usertype', $query['usertype']);
            }
        };

        // $page = $this->default_sp;
        // if (!empty($query['page'])) {
        //     $qstring['page'] = $query['page'];
        //     $page = $query['page'];
        // }

        $data['adminCount'] = DB::table('tbl_users')
            ->where('usertype', 'admin')->count();
        $data['staffCount'] = DB::table('tbl_users')
            ->where('usertype', 'staff')->count();
        $data['otherCount'] = DB::table('tbl_users')
            ->where('usertype', 'not like', 'admin%')
            ->where('usertype', 'not like', 'staff%')
            ->count();
        $data['allCount'] = DB::table('tbl_users')
            ->count();

        // $countdata = $users->count();
        // $totalpages = ceil($countdata / $this->default_lpp);
        // $dataoffset = ($page * $this->default_lpp) - $this->default_lpp;
        // $users->offset($dataoffset)->limit($this->default_lpp);

        $data['users'] = $users->orderBy('updated_at', 'desc')->paginate(5)->appends($request->all());
        $data['qstring'] = $qstring;
        return view('admin.users', $data);
    }

    public function userAdd(Request $request)
    {
        $input = $request->input();
        DB::table('tbl_users')
            ->insert([
                'firstname' => $input['firstname'],
                'lastname' => $input['lastname'],
                'email' => $input['email'],
                'usertype' => $input['usertype'],
                'username' => $input['username'],
                'password' => $input['password'],
                'gender' => $input['gender'],
                'bday' => $input['birthday'],
                'contact' => $input['contact'],
                'team' => $input['team'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);
        return redirect('/users');
    }

    public function userUpdate(Request $request)
    {
        $input = $request->input();
        DB::table('tbl_users')->where('id', $input['id'])
            ->update([
                'firstname' => $input['firstname'],
                'lastname' => $input['lastname'],
                'email' => $input['email'],
                'usertype' => $input['usertype'],
                'username' => $input['username'],
                'password' => $input['password'],
                'gender' => $input['gender'],
                'bday' => $input['birthday'],
                'contact' => $input['contact'],
                'team' => $input['team'],
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);
        return redirect('/users');
    }

    public function userDelete(Request $request)
    {
        $input = $request->input();
        DB::table('tbl_users')->where('id', $input['id'])->delete();
        return redirect('/users');
    }
}
