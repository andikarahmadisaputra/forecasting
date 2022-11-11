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
        Schema::create('peramalan_headers', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->integer('kategori_id');
            $table->decimal('hasil', 14, 2)->unsigned();
            $table->decimal('alpha', 2, 1);
            $table->decimal('beta', 2, 1);
            $table->decimal('mse', 14, 2);
            $table->decimal('mad', 14, 2);
            $table->decimal('mape', 4, 2);
            $table->decimal('rmse', 14, 2);
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
        Schema::dropIfExists('peramalan_headers');
    }
};
