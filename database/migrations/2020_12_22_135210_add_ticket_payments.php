<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTicketPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('number_of_tickets');
            $table->integer('total_cost');
            $table->boolean('claimed')->default(False);
            $table->date('claimed_date')->nullable();
            $table->string('team_name');
            $table->string('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
