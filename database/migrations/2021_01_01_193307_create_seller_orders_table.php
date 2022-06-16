<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_orders', function (Blueprint $table) {
            $table->id();
            // $table->unsignedDouble('profit');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('seller_id')->index();
            $table->unsignedBigInteger('order_id')->index();
            $table->timestamps();

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('status_id')
                ->references('id')
                ->on('status')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('seller_id')
                ->references('id')
                ->on('sellers')
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
        Schema::dropIfExists('seller_orders');
    }
}
