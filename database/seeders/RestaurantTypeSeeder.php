<?php

namespace Database\Seeders;

use App\Models\RestaurantType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restaurantType1 = RestaurantType::create([
           'name' =>  'Breakfast and lunch',
            'description' => 'Breakfast and lunch'
        ]);
        $restaurantType1->addMedia(public_path('fake/logo.png'))->preservingOriginal()->toMediaCollection();

        $restaurantType2 = RestaurantType::create([
            'name' =>  'Lunch only',
            'description' => 'Lunch only'
        ]);
        $restaurantType2->addMedia(public_path('fake/logo.png'))->preservingOriginal()->toMediaCollection();

        $restaurantType3 = RestaurantType::create([
            'name' =>  'Lunch and dinner',
            'description' => 'Lunch and dinner'
        ]);
        $restaurantType3->addMedia(public_path('fake/logo.png'))->preservingOriginal()->toMediaCollection();

        $restaurantType4 = RestaurantType::create([
            'name' =>  'Dinner only',
            'description' => 'Dinner only'
        ]);
        $restaurantType4->addMedia(public_path('fake/logo.png'))->preservingOriginal()->toMediaCollection();

        $restaurantType5 = RestaurantType::create([
            'name' =>  'Cafe',
            'description' => 'Cafe'
        ]);
        $restaurantType5->addMedia(public_path('fake/logo.png'))->preservingOriginal()->toMediaCollection();

        $restaurantType6 = RestaurantType::create([
            'name' =>  'Vegetarian / Healthy',
            'description' => 'Vegetarian / Healthy'
        ]);
        $restaurantType6->addMedia(public_path('fake/logo.png'))->preservingOriginal()->toMediaCollection();

        // Fake Data
//        RestaurantType::factory(30)->create()->each(function ($restaurantType){
//            $fakeImageUrl = fake()->imageUrl();
//
//            $restaurantType->addMediaFromUrl($fakeImageUrl)->preservingOriginal()->toMediaCollection();
//        });

    }
}
