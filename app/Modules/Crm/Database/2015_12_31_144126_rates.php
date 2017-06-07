<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Rates extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_service_rates', function (Blueprint $table) {
            $table->increments('id');
           
            $table->integer('customer_service_item_id');
            $table->date('created_at');
            $table->date('updated_at');
            $table->string('title',15);
           
            $table->decimal('amount', 5);
            $table->tinyInteger('status');
            $table->tinyInteger('is_default');
           
           
            
        }); 
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customer_service_rates'); 
	}
}