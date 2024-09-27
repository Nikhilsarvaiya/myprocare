<?php

namespace Database\Seeders;

use App\Models\BusinessType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BusinessType::factory(30)->create()->each(function ($category){
            $fakeImageUrl = fake()->imageUrl();

            $category->addMediaFromUrl($fakeImageUrl)->preservingOriginal()->toMediaCollection();
        });
    }
}
