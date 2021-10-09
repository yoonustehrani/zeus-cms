<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToMailMarketerMessageFailures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mail_marketer_message_failures', function (Blueprint $table) {
            $table->string('severity')->after('message_id')->default('unknown');
            $table->mediumText('description')->nullable()->after('severity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mail_marketer_message_failures', function (Blueprint $table) {
            $table->dropColumn(['severity', 'description']);
        });
    }
}
