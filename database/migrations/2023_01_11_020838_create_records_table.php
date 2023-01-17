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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->string('old_address',32)->nullable();
            $table->string('address',32);
            $table->string('product_code',64);
            $table->string('product_description',128);
            $table->string('process',32);
            $table->string('batch',32);
            $table->double('net_weight',10,3,true);
            $table->string('expedition',32)->default('');
            $table->unique(['address','product_code','process','batch','net_weight'],'UNQ_REGISTER');
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
        Schema::dropIfExists('records');
    }
};
