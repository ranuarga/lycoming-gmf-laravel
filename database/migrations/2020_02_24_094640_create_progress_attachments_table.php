<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgressAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress_attachments', function (Blueprint $table) {
            $table->bigIncrements('progress_attachment_id');
            $table->unsignedBigInteger('progress_job_id')->nullable();
            $table->string('cloudinary_public_id')->nullable();
            $table->text('cloudinary_secure_url')->nullable();
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
        Schema::dropIfExists('progress_attachments');
    }
}
