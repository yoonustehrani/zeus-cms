<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailMarketerMessageFailuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mail_marketer_messages', function (Blueprint $table) {
            $table->timestamp('failed_at')->nullable()->after('hash');
        });
        Schema::create('mail_marketer_message_failures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('message_id');
            $table->timestamps();
            $table->foreign('message_id')->references('id')->on('mail_marketer_messages')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mail_marketer_messages', function (Blueprint $table) {
            $table->dropColumn(['failed_at']);
        });
        Schema::dropIfExists('mail_marketer_message_failures');
    }
}
