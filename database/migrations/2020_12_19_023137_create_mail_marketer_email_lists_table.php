<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailMarketerEmailListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_marketer_email_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
        Schema::create('mail_marketer_unsubscribe_events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
        Schema::create('mail_marketer_email_list_subscriber', function (Blueprint $table) {
            $table->unsignedInteger('email_list_id');
            $table->unsignedBigInteger('subscriber_id');
            $table->unsignedInteger('unsubscribe_event_id')->nullable();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->text('complaint')->nullable();
            $table->foreign('email_list_id')->references('id')->on('mail_marketer_email_lists')->onUpdate('cascade');
            $table->foreign('subscriber_id')->references('id')->on('mail_marketer_subscribers')->onUpdate('cascade');
            $table->foreign('unsubscribe_event_id')->references('id')->on('mail_marketer_unsubscribe_events')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_marketer_email_lists');
        Schema::dropIfExists('mail_marketer_unsubscribe_events');
        Schema::dropIfExists('mail_marketer_email_list_subscriber');
    }
}
