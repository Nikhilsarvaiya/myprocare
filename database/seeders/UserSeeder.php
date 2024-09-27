<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('asdfasdf')
        ]);
        $user->markEmailAsVerified();

        $user->assignRole('user');
        $user->assignRole('admin');

        $user = User::create([
            'name' => 'Abc',
            'email' => 'abc@gmail.com',
            'password' => Hash::make('asdfasdf')
        ]);
        $user->markEmailAsVerified();
        $user->assignRole('user');

        $user = User::create([
            'name' => 'Xyz',
            'email' => 'xyz@gmail.com',
            'password' => Hash::make('asdfasdf')
        ]);
        $user->markEmailAsVerified();
        $user->assignRole('user');

        if (App::isLocal()){
            User::factory(200)->create()->each(function ($user){
                $user->assignRole('user');
            });
        }
    }
}
