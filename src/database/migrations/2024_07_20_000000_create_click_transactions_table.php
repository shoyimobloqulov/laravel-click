<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClickTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('click_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('click_trans_id')->unique();
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('click_paydoc_id')->nullable();
            $table->unsignedBigInteger('merchant_trans_id');
            $table->decimal('amount', 10, 2);
            $table->timestamp('sign_time');
            $table->string('situation');
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('click_transactions');
    }
}
