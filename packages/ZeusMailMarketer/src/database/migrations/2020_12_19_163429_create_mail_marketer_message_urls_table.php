<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailMarketerMessageUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_marketer_message_urls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('link');
            $table->bigInteger('click_count')->default(0);
            $table->string('hash');
            $table->morphs('source');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_marketer_message_urls');
    }
}
