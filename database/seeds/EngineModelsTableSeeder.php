<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EngineModelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('engine_models')->insert([
            ['engine_model_name' => 'Lycoming IO-320',],
            ['engine_model_name' => 'Lycoming IO-360',]
        ]);
    }
}
