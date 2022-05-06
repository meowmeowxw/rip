<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60);
            $table->string('description', 1024);
            $table->unsignedDouble('price');
            $table->integer('quantity');
            $table->unsignedDouble('alcohol');
            $table->unsignedInteger('cl');
            $table->string('path', 1024);
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('category_id')->index();
            $table->unsignedBigInteger('seller_id')->index();
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
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
        Schema::dropIfExists('products');
    }
}
