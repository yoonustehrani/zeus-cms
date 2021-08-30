<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_relationships', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('data_row_id')->nullable()->default(null);
            $table->string('type');
            $table->string('local_method');
            $table->string('target_model')->nullable();
            $table->string('target_route')->nullable();
            $table->boolean('dynamic')->default(false);
            $table->foreign('data_row_id')->references('id')->on('data_rows')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_relationships');
    }
}
