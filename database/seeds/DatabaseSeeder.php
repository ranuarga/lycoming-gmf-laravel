<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminsTableSeeder::class,
            EngineersTableSeeder::class,
            EngineModelsTableSeeder::class,
            JobOrdersTableSeeder::class,
            JobSheetsTableSeeder::class,
            JobsTableSeeder::class,
            ManagementsTableSeeder::class,
            ProgressStatusesTableSeeder::class,
        ]);

    }
}
