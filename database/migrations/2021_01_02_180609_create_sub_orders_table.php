<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_orders', function (Blueprint $table) {
            $table->unsignedDouble('total_price');
            $table->unsignedDouble('single_price');
            $table->unsignedInteger('ordered_quantity');
            $table->unsignedBigInteger('seller_order_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->timestamps();

            $table->primary(['seller_order_id', 'product_id']);

            $table->foreign('seller_order_id')
                ->references('id')
                ->on('seller_orders')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade')
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
        Schema::dropIfExists('sub_orders');
    }
}
