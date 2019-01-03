<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePickListItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pick_list_items', function (Blueprint $table) {

            $table->increments('id');
            $table->string('label', 100);
	        $table->string('identifier', 50)->unique();
	        $table->string('description', 500)->nullable();

	        $table->integer('pick_list_id')->unsigned()->index();

	        $table->foreign('pick_list_id', 'pick_list_items_pick_list_id_foreign')->references('id')->on('pick_lists');

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
	    Schema::table('pick_list_items', function(Blueprint $table)
	    {
		    $table->dropForeign('pick_list_items_pick_list_id_foreign');
	    });
        Schema::dropIfExists('pick_list_items');
    }
}
