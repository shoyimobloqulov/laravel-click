<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('click_trans_id')->unique();
            $table->string('merchant_trans_id');
            $table->bigInteger('click_paydoc_id');
            $table->float('amount');
            $table->integer('service_id');
            $table->integer('merchant_prepare_id')->nullable();
            $table->integer('merchant_confirm_id')->nullable();
            $table->integer('error')->default(0);
            $table->string('error_note')->nullable();
            $table->timestamp('sign_time');
            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
