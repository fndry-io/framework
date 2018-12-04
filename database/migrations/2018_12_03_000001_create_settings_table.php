<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {

            $table->increments('id');
            $table->string('domain', 100)->comment('Plugin domain');
            $table->string('name', 100)->comment('Setting name');
            $table->enum('type', ['bool', 'int', 'integer', 'boolean', 'string', 'double', 'array'])->comment('Type of value');
            $table->string('default')->comment('Setting default value');
            $table->string('value')->comment('Changed Setting value')->nullable();

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
        Schema::dropIfExists('settings');
    }
}
