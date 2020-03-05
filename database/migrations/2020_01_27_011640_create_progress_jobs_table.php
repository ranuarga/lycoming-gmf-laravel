<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgressJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress_jobs', function (Blueprint $table) {
            $table->bigIncrements('progress_job_id');
            $table->unsignedBigInteger('job_id')->nullable();
            $table->unsignedBigInteger('job_sheet_id')->nullable();
            $table->unsignedBigInteger('engineer_id')->nullable();
            $table->unsignedBigInteger('management_id')->nullable();
            $table->unsignedBigInteger('progress_status_id')->nullable();
            $table->datetime('progress_job_date_start')->nullable();
            $table->datetime('progress_job_date_completion')->nullable();
            $table->text('progress_job_remark')->nullable();
            $table->text('progress_job_note')->nullable();
            $table->timestamps();

            $table
                ->foreign('job_id')
                ->references('job_id')
                ->on('jobs')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table
                ->foreign('job_sheet_id')
                ->references('job_sheet_id')
                ->on('job_sheets')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table
                ->foreign('engineer_id')
                ->references('engineer_id')
                ->on('engineers')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table
                ->foreign('management_id')
                ->references('management_id')
                ->on('managements')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table
                ->foreign('progress_status_id')
                ->references('progress_status_id')
                ->on('progress_statuses')
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
        Schema::dropIfExists('progress_jobs');
    }
}
