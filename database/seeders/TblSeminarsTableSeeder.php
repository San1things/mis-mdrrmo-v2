<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TblSeminarsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tbl_seminars')->delete();
        
        \DB::table('tbl_seminars')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => '1st Sample Seminar',
                'description' => 'Donec nunc risus, vulputate non sem id, eleifend sodales elit. Praesent pulvinar mi id bibendum cursus. Nunc tellus felis, dapibus at imperdiet eu, imperdiet at libero. In ac pharetra est, sit amet ultrices neque. Nam in vestibulum arcu, ac facilisis orci. Nullam justo nisl, hendrerit id euismod quis, sagittis eu nibh. Curabitur ac lacus finibus, cursus ipsum vel, rhoncus libero. Pellentesque at fringilla dolor. Fusce at enim commodo lorem blandit facilisis. Ut feugiat orci eu nibh faucibus fringilla. Praesent venenatis dui vel nibh ultricies, aliquet congue arcu dictum. Aliquam viverra aliquam velit ut molestie. Donec suscipit volutpat massa a hendrerit. Ut urna erat, tempus ac tempus eu, pretium nec ex.',
                'location' => 'Morong Town Plaza',
                'starts_at' => '2024-12-25 08:00:00',
                'status' => 'upcoming',
                'created_at' => '2024-08-18 22:22:40',
                'updated_at' => '2024-08-18 22:22:40',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => '2nd Sample Seminar',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed accumsan posuere lobortis. Aenean malesuada vestibulum ante, eget iaculis sem finibus at. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec aliquam quis augue non rutrum. Integer malesuada congue libero ut ultricies. Donec vulputate sit amet neque in porta. Nullam vestibulum risus at dictum faucibus.',
                'location' => 'Morong Public Market',
                'starts_at' => '2024-08-31 08:00:00',
                'status' => 'upcoming',
                'created_at' => '2024-08-18 22:23:05',
                'updated_at' => '2024-08-18 22:23:05',
            ),
        ));
        
        
    }
}