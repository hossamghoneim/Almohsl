<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => 123123123,
            'phone' => '01000000000',
        ]);

        Admin::create([
            'name' => 'admin',
            'email' => 'support@test.com',
            'password' => 123123123,
            'phone' => '01000000001',
        ]);

    }
}
