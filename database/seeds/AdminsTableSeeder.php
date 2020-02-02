<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'admin_user_name' => 'admin',
            'admin_full_name' => 'Mr. Administrator',
            'password' => Hash::make('admin'),
        ]);
    }
}
