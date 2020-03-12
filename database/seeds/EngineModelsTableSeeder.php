<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EngineModelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [];
        $lines = file(public_path() . '/engine_models.csv');
        foreach ($lines as $line) {
            array_push($arr, [
                'engine_model_name' => $line,
                'engine_model_reference' => 'OHM 60294-7-14',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }

        DB::table('engine_models')->insert($arr);
    }
}
