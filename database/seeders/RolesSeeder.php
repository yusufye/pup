<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['super_admin','Client'];

        foreach ($roles as $r){
            DB::table('roles')->insert([
                'name' => $r,
                'guard_name' => 'web'
            ]);
        }
    }
}
