<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EngineersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('engineers')->insert([
            'engineer_user_name' => 'engineer',
            'engineer_full_name' => 'Mr. Engineer',
            'password' => Hash::make('engineer'),
        ]);
    }
}
