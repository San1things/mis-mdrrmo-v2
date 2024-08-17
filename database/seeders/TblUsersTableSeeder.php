<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TblUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('tbl_users')->delete();

        \DB::table('tbl_users')->insert(array (
            0 =>
            array (
                'id' => 1,
                'firstname' => 'Main',
                'lastname' => 'Admin',
                'email' => 'masteradmin@mdrrmo.org',
                'usertype' => 'admin',
                'username' => 'mainadmin11',
                'password' => 'password',
                'status' => 'active',
                'otp' => NULL,
                'otp_added_at' => NULL,
                'otp_token' => NULL,
                'verified' => 0,
                'gender' => 'Male',
                'address' => 'Morong Rizal',
                'bday' => '2002-07-11',
                'contact' => '9876543219',
                'team' => 'undefined',
                'created_at' => '2024-08-17 11:45:54',
                'updated_at' => '2024-08-17 03:48:37',
            ),
            1 =>
            array (
                'id' => 2,
                'firstname' => 'Bertong',
                'lastname' => 'Bayawak',
                'email' => 'testuser@mdrrmo.org',
                'usertype' => 'resident',
                'username' => 'testresident',
                'password' => 'password',
                'status' => 'active',
                'otp' => NULL,
                'otp_added_at' => NULL,
                'otp_token' => NULL,
                'verified' => 0,
                'gender' => 'Male',
                'address' => 'Morong Rizal',
                'bday' => '2024-08-01',
                'contact' => '99999999999',
                'team' => 'undefined',
                'created_at' => '2024-08-17 04:07:29',
                'updated_at' => '2024-08-17 04:07:29',
            ),
        ));

    
    }
}
