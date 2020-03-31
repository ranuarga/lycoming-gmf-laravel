<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_days', function (Blueprint $table) {
            $table->bigIncrements('pending_day_id');
            $table->unsignedBigInteger('progress_job_id')->nullable();
            $table->date('pending_day_date_start')->nullable();
            $table->date('pending_day_date_end')->nullable();
            $table->timestamps();

            $table
                ->foreign('progress_job_id')
                ->references('progress_job_id')
                ->on('progress_jobs')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pending_days');
    }
}
