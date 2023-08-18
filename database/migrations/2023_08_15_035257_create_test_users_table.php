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
        Schema::create('test_users', function (Blueprint $table) {				
            $table->id();
            $table->string('user_name');
            $table->string('email')->unique();
            $table->string('password')->collation('utf8_bin'); //collationを追記	
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
        Schema::dropIfExists('test_users');
    }
};
