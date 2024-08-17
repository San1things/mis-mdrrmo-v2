<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TblCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('tbl_categories')->delete();

        \DB::table('tbl_categories')->insert(array(
            0 =>
            array(
                'id' => 1,
                'category_name' => 'Personal Protective Equipment',
                'category_description' => 'PPE',
                'created_at' => '2024-08-17 19:03:39',
                'updated_at' => '2024-08-17 19:03:39',
            ),
            1 =>
            array(
                'id' => 2,
                'category_name' => 'Disaster Supplies',
                'category_description' => 'supplies',
                'created_at' => '2024-08-17 19:04:41',
                'updated_at' => '2024-08-17 19:04:41',
            ),
            2 =>
            array(
                'id' => 3,
                'category_name' => 'Vehicles',
                'category_description' => 'vehicles used for emergency',
                'created_at' => '2024-08-17 19:04:41',
                'updated_at' => '2024-08-17 19:04:41',
            ),
            3 =>
            array(
                'id' => 4,
                'category_name' => 'Medicines',
                'category_description' => 'medicines used for rescue',
                'created_at' => '2024-08-17 19:04:41',
                'updated_at' => '2024-08-17 19:04:41',
            ),
        ));
    }
}
