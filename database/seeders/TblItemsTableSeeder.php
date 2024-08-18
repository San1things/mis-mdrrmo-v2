<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TblItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tbl_items')->delete();
        
        \DB::table('tbl_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'category_id' => 1,
                'item_name' => 'Safety Hat',
                'item_description' => 'Hats used for emergency',
                'item_category' => 'Personal Protective Equipment',
                'item_quantity' => 10,
                'expired_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'category_id' => 3,
                'item_name' => 'Ambulance',
                'item_description' => 'vehicle for rescue',
                'item_category' => 'Vehicles',
                'item_quantity' => 3,
                'expired_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'category_id' => 1,
                'item_name' => 'Gloves',
                'item_description' => NULL,
                'item_category' => 'Personal Protective Equipment',
                'item_quantity' => 5,
                'expired_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'category_id' => 1,
                'item_name' => 'Life Vest',
                'item_description' => NULL,
                'item_category' => 'Personal Protective Equipment',
                'item_quantity' => 50,
                'expired_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'category_id' => 3,
                'item_name' => 'Pick-up Trucks',
                'item_description' => 'vehicle for rescue',
                'item_category' => 'Vehicles',
                'item_quantity' => 2,
                'expired_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'category_id' => 1,
                'item_name' => 'Rubber Boots',
                'item_description' => NULL,
                'item_category' => 'Personal Protective Equipment',
                'item_quantity' => 10,
                'expired_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'category_id' => 1,
                'item_name' => 'Safety Boots',
                'item_description' => NULL,
                'item_category' => 'Personal Protective Equipment',
                'item_quantity' => 15,
                'expired_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'category_id' => 2,
                'item_name' => 'Rope',
                'item_description' => NULL,
                'item_category' => 'Disaster Supplies',
                'item_quantity' => 10,
                'expired_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'category_id' => 3,
                'item_name' => 'Boats',
                'item_description' => 'vehicle for rescue',
                'item_category' => 'Vehicles',
                'item_quantity' => 5,
                'expired_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'category_id' => 1,
                'item_name' => 'Goggles',
                'item_description' => NULL,
                'item_category' => 'Personal Protective Equipment',
                'item_quantity' => 50,
                'expired_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'category_id' => 2,
                'item_name' => 'Battery',
                'item_description' => 'batteries triple A',
                'item_category' => 'Disaster Supplies',
                'item_quantity' => 10,
                'expired_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'category_id' => 4,
                'item_name' => 'Mefenamic',
                'item_description' => '500g',
                'item_category' => 'Medicines',
                'item_quantity' => 500,
                'expired_at' => '2025-11-13',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'category_id' => 4,
                'item_name' => 'Biogesic',
                'item_description' => '500g',
                'item_category' => 'Medicines',
                'item_quantity' => 200,
                'expired_at' => '2027-07-16',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'category_id' => 3,
                'item_name' => 'Truck',
                'item_description' => 'vehicle for rescue',
                'item_category' => 'Vehicles',
                'item_quantity' => 1,
                'expired_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'category_id' => 2,
                'item_name' => 'Flashlight',
                'item_description' => NULL,
                'item_category' => 'Disaster Supplies',
                'item_quantity' => 50,
                'expired_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'category_id' => 2,
                'item_name' => 'First Aid Kits',
                'item_description' => NULL,
                'item_category' => 'Disaster Supplies',
                'item_quantity' => 50,
                'expired_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'category_id' => 2,
                'item_name' => 'Sample Item',
                'item_description' => NULL,
                'item_category' => 'Disaster Supplies',
                'item_quantity' => 100,
                'expired_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}