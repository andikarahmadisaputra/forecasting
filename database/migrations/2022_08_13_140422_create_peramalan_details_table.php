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
        Schema::create('peramalan_details', function (Blueprint $table) {
            $table->id();
            $table->integer('peramalan_header_id');
            $table->date('tanggal');
            $table->decimal('aktual', 14, 2)->unsigned();
            $table->decimal('level', 14, 2)->nullable();
            $table->decimal('trend', 14, 2)->nullable();
            $table->decimal('peramalan', 14, 2)->nullable()->unsigned();
            $table->decimal('se', 14, 2)->nullable();
            $table->decimal('ad', 14, 2)->nullable();
            $table->decimal('ape', 4, 2)->nullable();
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
        Schema::dropIfExists('peramalan_details');
    }
};
