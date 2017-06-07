<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->integer('created_by');
            $table->date('created_at');
            $table->date('updated_at');
            $table->integer('location_id');
            $table->integer('service_item_id');
            $table->string('title', 15);
            $table->text('body');
            $table->enum('status', ['new','open','closed','pending']);
            $table->enum('priority', ['low','normal','high']);
            $table->enum('type', ['email','ticket']);
            $table->string('email', 100);
            $table->string('sender_name', 250);
        });

        Schema::create('attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_id');
            $table->date('created_at');
            $table->date('updated_at');
           
            $table->string('name', 256);
            $table->string('type', 100);
        });

        Schema::create('responses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_id');
            $table->dateTime('created_at');
            $table->date('updated_at');
            $table->integer('responder_id');
            $table->text('body');
        });

        Schema::create('ticket_user', function (Blueprint $table) {
            
            $table->integer('ticket_id');
             $table->integer('user_id');
            $table->dateTime('created_at');
            $table->date('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::drop('tickets');
		Schema::drop('responses');
		Schema::drop('ticket_user');
        Schema::drop('attachments');*/
    }
}
