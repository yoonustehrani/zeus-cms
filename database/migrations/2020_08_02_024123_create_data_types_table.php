<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('display_name_singular');
            $table->string('display_name_plural');
            $table->string('icon')->nullable();
            $table->string('model_name');
            $table->string('policy_name')->nullable();
            $table->string('controller')->nullable();
            $table->string('api_controller')->nullable();
            $table->boolean('pagination')->nullable();
            // $table->string('description', 400)->nullable();
            // $table->boolean('generate_permission')->default(false);
            // $table->boolean('server_side')->default(true);
            $table->json('details')->default(json_encode(json_decode('[]')));
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
        Schema::dropIfExists('data_types');
    }
}
