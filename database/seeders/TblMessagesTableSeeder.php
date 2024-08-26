<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TblMessagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tbl_messages')->delete();
        
        \DB::table('tbl_messages')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => NULL,
                'name' => 'Test Message',
                'email' => 'testmailersan1@gmail.com',
                'message' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam vestibulum arcu ac turpis aliquet ullamcorper. Sed rutrum iaculis ante a condimentum. Ut eu metus gravida, faucibus ipsum vel, tincidunt turpis. Praesent eget ex purus. In lobortis tincidunt aliquam. Sed tristique ex nibh, id viverra nulla accumsan tempus. Morbi vel orci ut mauris placerat elementum. Integer mollis finibus eleifend. Suspendisse est diam, semper sed est et, interdum facilisis purus. Integer quis dui purus.',
                'replied' => 0,
                'seen' => 1,
                'created_at' => '2024-08-26 11:29:22',
                'updated_at' => '2024-08-26 11:29:22',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => NULL,
                'name' => 'Another One Name',
                'email' => 'testmailersan1@gmail.com',
                'message' => 'Praesent vel facilisis mi. Maecenas mauris nulla, auctor ut quam ut, hendrerit iaculis urna. Etiam sed pulvinar justo. Integer ultrices porta metus sit amet laoreet. Mauris sollicitudin hendrerit est. Cras in sapien quis mauris semper iaculis. Ut finibus lobortis tempus. Donec dapibus risus interdum tortor aliquam sodales. Quisque rhoncus orci vitae ipsum egestas placerat.',
                'replied' => 0,
                'seen' => 1,
                'created_at' => '2024-08-26 16:26:14',
                'updated_at' => '2024-08-26 16:26:14',
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => NULL,
                'name' => 'Bertong Bayawak',
                'email' => 'testuser@mdrrmo.org',
                'message' => 'Maecenas vitae ante eu libero condimentum ultrices nec non erat. Nam luctus odio nec ultricies viverra. Proin eget odio eget nisi iaculis vulputate vestibulum dictum nulla. Nunc pellentesque, mi sit amet fringilla vulputate, massa ipsum sodales quam, ut auctor lorem lorem eget orci. Cras vitae leo ut eros vulputate pharetra vel ut purus. In aliquet, eros et vulputate suscipit, est augue placerat felis, sed volutpat mauris magna id est. Suspendisse lacus enim, iaculis in quam ut, feugiat facilisis mi.',
                'replied' => 0,
                'seen' => 1,
                'created_at' => '2024-08-26 17:19:37',
                'updated_at' => '2024-08-26 17:19:37',
            ),
        ));
        
        
    }
}