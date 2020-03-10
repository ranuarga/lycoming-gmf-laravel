<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobSheetOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_sheet_orders', function (Blueprint $table) {
            $table->bigIncrements('job_sheet_order_id');
            $table->unsignedBigInteger('job_order_id')->nullable();
            $table->unsignedBigInteger('job_sheet_id')->nullable();
            $table->timestamps();

            $table
                ->foreign('job_sheet_id')
                ->references('job_sheet_id')
                ->on('job_sheets')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table
                ->foreign('job_order_id')
                ->references('job_order_id')
                ->on('job_orders')
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
        Schema::dropIfExists('job_sheet_orders');
    }
}
