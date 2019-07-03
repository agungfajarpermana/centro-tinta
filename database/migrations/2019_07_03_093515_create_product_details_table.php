<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_details', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
                  
            $table->integer('harga');
            $table->integer('stok_awal');
            $table->integer('stok_masuk');
            $table->integer('stok_keluar');
            $table->integer('penjualan');
            $table->integer('stok_akhir');
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
        Schema::dropIfExists('product_details');
    }
}
