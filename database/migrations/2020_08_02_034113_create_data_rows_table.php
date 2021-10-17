<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataRowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_rows', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('data_type_id');
            $table->string('field');
            $table->string('type');
            $table->string('display_name');
            $table->boolean('required');
            $table->boolean('browse');
            $table->boolean('read');
            $table->boolean('edit');
            $table->boolean('add');
            $table->boolean('delete');
            $table->json('details')->default(json_encode(json_decode('[]')));
            $table->integer('order');
            $table->foreign('data_type_id')->references('id')->on('data_types')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_rows');
    }
}
