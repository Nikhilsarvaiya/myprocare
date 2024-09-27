<?php

namespace Database\Seeders;

use App\Models\FoodType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foodType1 = FoodType::create([
           'name' => 'Mexican',
           'description' => 'Mexican',
        ]);
        $foodType1->addMedia(public_path('fake/logo.png'))->preservingOriginal()->toMediaCollection();

        $foodType2 = FoodType::create([
            'name' => 'Italian',
            'description' => 'Italian',
        ]);
        $foodType2->addMedia(public_path('fake/logo.png'))->preservingOriginal()->toMediaCollection();

        $foodType3 = FoodType::create([
            'name' => 'Japanese',
            'description' => 'Japanese',
        ]);
        $foodType3->addMedia(public_path('fake/logo.png'))->preservingOriginal()->toMediaCollection();

        $foodType4 = FoodType::create([
            'name' => 'Chinese',
            'description' => 'Chinese',
        ]);
        $foodType4->addMedia(public_path('fake/logo.png'))->preservingOriginal()->toMediaCollection();

        $foodType5 = FoodType::create([
            'name' => 'French',
            'description' => 'French',
        ]);
        $foodType5->addMedia(public_path('fake/logo.png'))->preservingOriginal()->toMediaCollection();

        $foodType6 = FoodType::create([
            'name' => 'Basque',
            'description' => 'Basque',
        ]);
        $foodType6->addMedia(public_path('fake/logo.png'))->preservingOriginal()->toMediaCollection();

        $foodType1 = FoodType::create([
            'name' => 'NA',
            'description' => 'NA',
        ]);
        $foodType1->addMedia(public_path('fake/logo.png'))->preservingOriginal()->toMediaCollection();

        // Fake Data
//        FoodType::factory(30)->create()->each(function ($foodType){
//            $fakeImageUrl = fake()->imageUrl();
//
//            $foodType->addMediaFromUrl($fakeImageUrl)->preservingOriginal()->toMediaCollection();
//        });
    }
}
