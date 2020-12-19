<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailMarketerCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_marketer_campaign_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('mail_marketer_campaigns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('subject');
            $table->string('from_name');
            $table->string('from_email');
            $table->unsignedInteger('status_id');
            $table->unsignedBigInteger('template_id');
            $table->mediumText('content');
            $table->boolean('track_opens');
            $table->boolean('track_clicks');
            $table->integer('click_count');
            $table->integer('open_count');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
            $table->foreign('status_id')->references('id')->on('mail_marketer_campaign_statuses')->onUpdate('cascade');
            $table->foreign('template_id')->references('id')->on('mail_marketer_templates')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_marketer_campaign_statuses');
        Schema::dropIfExists('mail_marketer_campaigns');
    }
}
