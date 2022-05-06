<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedDouble('price');
            $table->string('credit_card', 24);
            $table->string('street', 128);
            $table->string('city', 128);
            $table->unsignedBigInteger('customer_id')->index();
            $table->timestamps();

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
