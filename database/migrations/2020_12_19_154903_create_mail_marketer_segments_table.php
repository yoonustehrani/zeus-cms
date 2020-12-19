<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailMarketerSegmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_marketer_segments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
        Schema::create('mail_marketer_segment_subscriber', function (Blueprint $table) {
            $table->unsignedBigInteger('segment_id');
            $table->unsignedBigInteger('subscriber_id');
            $table->foreign('segment_id')->references('id')->on('mail_marketer_segments')->onUpdate('cascade');
            $table->foreign('subscriber_id')->references('id')->on('mail_marketer_subscribers')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_marketer_segments');
        Schema::dropIfExists('mail_marketer_segment_subscriber');
    }
}
