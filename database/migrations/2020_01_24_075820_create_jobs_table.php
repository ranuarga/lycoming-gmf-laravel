<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('job_id');
            $table->unsignedBigInteger('engine_model_id');
            $table->unsignedBigInteger('job_order_id');
            $table->timestamps();

            $table
                ->foreign('engine_model_id')
                ->references('engine_model_id')
                ->on('engine_models')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table
                ->foreign('job_order_id')
                ->references('job_order_id')
                ->on('job_orders')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
