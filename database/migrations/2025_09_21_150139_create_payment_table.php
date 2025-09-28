<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->nullable();
            $table->integer('invoice_id')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->dateTime('payment_datetime')->nullable()->comment('Payment Date & Time');
            $table->longText('remarks')->nullable();
            $table->string('payment_method')->default('Cash')->comment('Cash,Online,Cheque,Due,Other');
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
        Schema::dropIfExists('payment');
    }
}
