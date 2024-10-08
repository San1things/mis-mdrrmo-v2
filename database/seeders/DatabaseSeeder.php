<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(TblUsersTableSeeder::class);
        $this->call(TblCategoriesTableSeeder::class);
        $this->call(TblSubscriptionsTableSeeder::class);
        $this->call(TblItemsTableSeeder::class);
        $this->call(TblAnnouncementsTableSeeder::class);
        $this->call(TblSeminarsTableSeeder::class);
        $this->call(TblMessagesTableSeeder::class);
    }
}
