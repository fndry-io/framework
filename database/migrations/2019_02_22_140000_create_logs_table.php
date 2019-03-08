<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
	        $table->bigIncrements('id');
	        $table->enum('type', ['log', 'store', 'change', 'delete']);
	        $table->enum('result', ['success', 'neutral', 'failure']);
	        $table->enum('level', ['emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug'])->index();
	        $table->text('description')->nullable();
	        $table->text('url')->nullable();
	        $table->string('origin', 200)->nullable();
	        $table->integer('user_id')->nullable()->index();
	        $table->ipAddress('ip')->nullable();
	        $table->string('user_agent', 200)->nullable();
	        $table->string('session', 100)->nullable();
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
        Schema::dropIfExists('logs');
    }
}
