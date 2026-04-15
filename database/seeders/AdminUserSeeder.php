<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Webkul\User\Models\Admin;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => config('app.root_name'),
            'email' => config('app.root_email'),
            'password' => Hash::make(config('app.root_password')),
            'status' => 1,
            'role_id' => 1,
        ]);
    }
}
