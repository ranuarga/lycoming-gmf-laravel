<?php

use Illuminate\Database\Seeder;

class JobSheetOrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [];
        for($i = 1 ; $i <= 3 ; $i++) {
            for($j = 1; $j <= 10; $j++) {
                if($i == 2 && $j == 6) {
                    continue;
                }
                if($i == 3) {
                    if($j == 3 || $j == 4 || $j == 5 || $j == 6 || $j == 7 || $j == 8 || $j == 9)
                        continue;
                }
                array_push($arr, [
                    'job_order_id' => $i,
                    'job_sheet_id' => $j,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                    ]);
            }
        }

        DB::table('job_sheet_orders')->insert($arr);
    }
}
