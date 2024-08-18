<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TblAnnouncementsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tbl_announcements')->delete();
        
        \DB::table('tbl_announcements')->insert(array (
            0 => 
            array (
                'id' => 1,
                'announcement_name' => '1st Seminar Sample',
                'announcement_description' => 'It will be held at Morong Town Plaza and the date is December 25, 2024. Log in on our page to join!!',
                'announcement_link' => NULL,
                'announcement_type' => 'Seminar',
                'announcement_image' => '2024-08-18announcementFxtz0ELV.jpg',
                'created_at' => '2024-08-18 22:21:24',
                'updated_at' => '2024-08-18 22:21:24',
            ),
            1 => 
            array (
                'id' => 2,
                'announcement_name' => 'Facebook  Page of MDRRMO',
                'announcement_description' => 'Please like or add our official facebook page.',
                'announcement_link' => 'https://www.facebook.com/mdrrmo.morong.3',
                'announcement_type' => 'Other',
                'announcement_image' => '2024-08-18announcementf92qsOoU.png',
                'created_at' => '2024-08-18 22:22:11',
                'updated_at' => '2024-08-18 22:22:11',
            ),
        ));
        
        
    }
}