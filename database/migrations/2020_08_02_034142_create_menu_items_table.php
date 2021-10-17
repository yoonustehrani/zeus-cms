<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('menu_id');
            $table->string('title');
            $table->string('url')->default('');
            $table->string('target')->default('_self');
            $table->string('icon_class')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('order');
            $table->string('route')->nullable()->default(null);
            $table->json('parameters')->default(json_encode(json_decode('[]')));
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_items');
    }
}
