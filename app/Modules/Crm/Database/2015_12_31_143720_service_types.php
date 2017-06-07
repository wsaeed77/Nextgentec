<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ServiceTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_service_types', function (Blueprint $table) {
            $table->increments('id');
           
            $table->date('created_at');
            $table->date('updated_at');
            $table->string('title', 15);
            $table->string('description', 15);
            $table->tinyInteger('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('customer_service_types');
    }
}
