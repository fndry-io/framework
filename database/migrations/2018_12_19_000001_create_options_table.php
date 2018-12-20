<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {

            $table->increments('id');
            $table->string('label')->nullable();
            $table->string('name', 100);
	        $table->string('type', 10)->comment('Type of value: bool, int, integer, boolean, string, double, array');
            $table->string('value');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('option_overrides', function(Blueprint $table){

            $table->increments('id');
            $table->unsignedBigInteger('option_id')->index();
            $table->unsignedBigInteger('owner_id')->comment('Id of resource responsible for override');
            $table->string('owner_type')->comment('Type of resource responsible for override');

            $table->softDeletes();
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
        Schema::dropIfExists('options');
        Schema::dropIfExists('option_overrides');
    }
}
