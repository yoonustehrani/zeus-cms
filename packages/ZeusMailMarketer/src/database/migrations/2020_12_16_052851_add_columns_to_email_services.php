<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToEmailServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mail_marketer_email_services', function (Blueprint $table) {
            $table->integer('daily_emails')->after('name')->default(0);
            $table->integer('daily_emails_left')->after('daily_emails')->default(0);
            $table->integer('hourly_emails')->after('daily_emails_left')->default(0);
            $table->integer('hourly_emails_left')->after('hourly_emails')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_services', function (Blueprint $table) {
            //
        });
    }
}
