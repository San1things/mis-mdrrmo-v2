<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TblSubscriptionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tbl_subscriptions')->delete();
        
        \DB::table('tbl_subscriptions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'email' => 'samplesubscriber_1@mdrrmo.org',
                'subscribed_at' => '08/18/24 08:09pm',
                'created_at' => '2024-08-18 20:09:43',
                'updated_at' => '2024-08-18 20:09:43',
            ),
            1 => 
            array (
                'id' => 2,
                'email' => 'samplesubscriber_2@mdrrmo.org',
                'subscribed_at' => '08/18/24 08:09pm',
                'created_at' => '2024-08-18 20:09:52',
                'updated_at' => '2024-08-18 20:09:52',
            ),
            2 => 
            array (
                'id' => 3,
                'email' => 'samplesubscriber_3@mdrrmo.org',
                'subscribed_at' => '08/18/24 08:09pm',
                'created_at' => '2024-08-18 20:09:56',
                'updated_at' => '2024-08-18 20:09:56',
            ),
            3 => 
            array (
                'id' => 4,
                'email' => 'samplesubscriber_4@mdrrmo.org',
                'subscribed_at' => '08/18/24 08:10pm',
                'created_at' => '2024-08-18 20:10:01',
                'updated_at' => '2024-08-18 20:10:01',
            ),
            4 => 
            array (
                'id' => 5,
                'email' => 'samplesubscriber_5@mdrrmo.org',
                'subscribed_at' => '08/18/24 08:10pm',
                'created_at' => '2024-08-18 20:10:06',
                'updated_at' => '2024-08-18 20:10:06',
            ),
            5 => 
            array (
                'id' => 6,
                'email' => 'testsubscriber_1@mdrrmo.org',
                'subscribed_at' => '08/18/24 08:10pm',
                'created_at' => '2024-08-18 20:10:14',
                'updated_at' => '2024-08-18 20:10:14',
            ),
            6 => 
            array (
                'id' => 7,
                'email' => 'testsubscriber_2@mdrrmo.org',
                'subscribed_at' => '08/18/24 08:10pm',
                'created_at' => '2024-08-18 20:10:19',
                'updated_at' => '2024-08-18 20:10:19',
            ),
            7 => 
            array (
                'id' => 8,
                'email' => 'testsubscriber_3@mdrrmo.org',
                'subscribed_at' => '08/18/24 08:10pm',
                'created_at' => '2024-08-18 20:10:24',
                'updated_at' => '2024-08-18 20:10:24',
            ),
            8 => 
            array (
                'id' => 9,
                'email' => 'testsubscriber_4@mdrrmo.org',
                'subscribed_at' => '08/18/24 08:10pm',
                'created_at' => '2024-08-18 20:10:30',
                'updated_at' => '2024-08-18 20:10:30',
            ),
            9 => 
            array (
                'id' => 10,
                'email' => 'testsubscriber_5@mdrrmo.org',
                'subscribed_at' => '08/18/24 08:10pm',
                'created_at' => '2024-08-18 20:10:35',
                'updated_at' => '2024-08-18 20:10:35',
            ),
            10 => 
            array (
                'id' => 11,
                'email' => 'trysubscriber1@mdrrmo.org',
                'subscribed_at' => '08/18/24 09:16pm',
                'created_at' => '2024-08-18 21:16:54',
                'updated_at' => '2024-08-18 21:16:54',
            ),
            11 => 
            array (
                'id' => 12,
                'email' => 'trysubscribe2@mdrrmo.org',
                'subscribed_at' => '08/18/24 09:16pm',
                'created_at' => '2024-08-18 21:16:58',
                'updated_at' => '2024-08-18 21:16:58',
            ),
            12 => 
            array (
                'id' => 13,
                'email' => 'trysubscriber3@mdrrmo.org',
                'subscribed_at' => '08/18/24 09:17pm',
                'created_at' => '2024-08-18 21:17:03',
                'updated_at' => '2024-08-18 21:17:03',
            ),
            13 => 
            array (
                'id' => 14,
                'email' => 'trysubscriber4@mdrrmo.org',
                'subscribed_at' => '08/18/24 09:17pm',
                'created_at' => '2024-08-18 21:17:08',
                'updated_at' => '2024-08-18 21:17:08',
            ),
            14 => 
            array (
                'id' => 15,
                'email' => 'trysubscriber5@mdrrmo.org',
                'subscribed_at' => '08/18/24 09:17pm',
                'created_at' => '2024-08-18 21:17:12',
                'updated_at' => '2024-08-18 21:17:12',
            ),
            15 => 
            array (
                'id' => 16,
                'email' => 'testingsubs1@gmail.com',
                'subscribed_at' => '08/18/24 09:17pm',
                'created_at' => '2024-08-18 21:17:43',
                'updated_at' => '2024-08-18 21:17:43',
            ),
            16 => 
            array (
                'id' => 17,
                'email' => 'testingsubs2@gmail.com',
                'subscribed_at' => '08/18/24 09:17pm',
                'created_at' => '2024-08-18 21:17:47',
                'updated_at' => '2024-08-18 21:17:47',
            ),
            17 => 
            array (
                'id' => 18,
                'email' => 'testingsubs3@gmail.com',
                'subscribed_at' => '08/18/24 09:17pm',
                'created_at' => '2024-08-18 21:17:51',
                'updated_at' => '2024-08-18 21:17:51',
            ),
            18 => 
            array (
                'id' => 19,
                'email' => 'testingsubs4@gmail.com',
                'subscribed_at' => '08/18/24 09:17pm',
                'created_at' => '2024-08-18 21:17:55',
                'updated_at' => '2024-08-18 21:17:55',
            ),
            19 => 
            array (
                'id' => 20,
                'email' => 'testingsubs5@gmail.com',
                'subscribed_at' => '08/18/24 09:17pm',
                'created_at' => '2024-08-18 21:17:59',
                'updated_at' => '2024-08-18 21:17:59',
            ),
        ));
        
        
    }
}