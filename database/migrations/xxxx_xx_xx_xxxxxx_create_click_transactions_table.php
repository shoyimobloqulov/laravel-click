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
            $table->bigInteger('click_trans_id')->nullable()->unique();
            $table->integer('service_id')->nullable();
            $table->bigInteger('click_paydoc_id')->nullable()->unique();
            $table->string('merchant_trans_id')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->datetime('sign_time')->nullable();
            $table->string('situation')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('click_transactions');
    }
}
