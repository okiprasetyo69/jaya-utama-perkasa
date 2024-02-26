<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name'=>'Super Admin',
                'phone_number' => '081312345678',
                'email'=>'superadmin@test.com',
                'role'=>'superadmin',
                'password'=> bcrypt('12345678'),
            ],
            [
                'name'=>'Consumer',
                'phone_number' => '088912345678',
                'email'=>'consumer@test.com',
                'role'=>'consumer',
                'password'=> bcrypt('12345678'),
            ], 
        ];
  
        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
