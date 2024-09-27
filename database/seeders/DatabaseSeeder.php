<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\RestaurantType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(UserSeeder::class);

        File::deleteDirectory(public_path('media'));
        File::makeDirectory(public_path('media'), 0775);

        //$this->call(BusinessTypeSeeder::class);
        //$this->call(EventSeeder::class);

        $this->call(RestaurantTypeSeeder::class);
        $this->call(FoodTypeSeeder::class);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
