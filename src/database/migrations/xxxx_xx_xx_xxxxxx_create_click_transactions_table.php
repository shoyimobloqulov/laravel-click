<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClickTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('click_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('click_trans_id')->unique();
            $table->string('service_id');
            $table->string('click_paydoc_id');
            $table->string('merchant_trans_id')->unique();
            $table->decimal('amount', 10, 2);
            $table->integer('action');
            $table->integer('error')->nullable();
            $table->string('error_note')->nullable();
            $table->string('sign_time');
            $table->string('sign_string');
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('click_transactions');
    }
}
