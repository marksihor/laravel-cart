<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id()->index();
            $table->foreignId('cart_id')->constrained();
            $table->json('attributes')->nullable();
            $table->json('data')->nullable();
            $table->float('price', 10, 2)->default(0)->index();
            $table->float('discount', 10, 2)->default(0)->index();
            $table->float('total', 10, 2)->default(0)->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->unsignedBigInteger('seller_id')->nullable()->index();
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
        Schema::dropIfExists('cart_items');
    }
}
