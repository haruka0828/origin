<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
        $table->unsignedBigInteger('company_id');// （外部キー）
        $table->string('product_name');
        $table->decimal('price', 4, 0);
        $table->integer('stock');
        $table->text('comment')->nullable();
        $table->string('img_pass')->nullable();
        $table->timestamps();
        // 外部キー制約
        $table->foreign('company_id')->references('id')->on('companies');
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
};
