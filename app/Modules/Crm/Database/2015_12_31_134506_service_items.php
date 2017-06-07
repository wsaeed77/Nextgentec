<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ServiceItems extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_service_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->date('created_at');
            $table->date('updated_at');
            $table->integer('service_type_id');
            $table->string('title',15);
            $table->integer('billing_period_id');
            $table->integer('default_rate_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->tinyInteger('is_active');
            $table->tinyInteger('is_default');
            $table->text('comments');

            $table->decimal('unit_price', 5);
            $table->integer('quantity');

            $table->decimal('estimate', 5);
            $table->integer('estimated_hours');

            $table->enum('bill_for',['actual_hours','project_estimate']);


        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customer_service_items');
	}
}