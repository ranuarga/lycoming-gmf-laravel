<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManagementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('managements')->insert([
            'management_user_name' => 'management',
            'management_full_name' => 'Mr. Management',
            'password' => Hash::make('management'),
        ]);
    }
}
