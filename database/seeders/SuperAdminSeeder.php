<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'email.yusufye@gmail.com',
            'password' => bcrypt('test1234'),
            'email_verified_at' => date('Y-m-d h:i:s'),
        ]);
        $superAdmin->assignRole('super_admin');
    }
}
