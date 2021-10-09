<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailMarketerMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_marketer_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('source');
            $table->string('subject');
            $table->string('from_name');
            $table->string('from_email');
            $table->string('to');
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('clicked_at')->nullable();
            $table->unsignedBigInteger('subscriber_id');
            $table->string('hash');
            $table->timestamps();
            $table->foreign('subscriber_id')->references('id')->on('mail_marketer_subscribers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_marketer_messages');
    }
}
