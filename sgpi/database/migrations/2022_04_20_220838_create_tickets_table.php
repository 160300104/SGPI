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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->unsignedBigInteger('id_material')->nullable();
            $table->unsignedBigInteger('id_loan')->nullable();

            $table->foreign('id_material')
                    ->references('id')->on('materials')
                    ->onDelete('set null');

            $table->foreign('id_loan')
                    ->references('id')->on('loans')
                    ->onDelete('set null');

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
        Schema::dropIfExists('tickets');
    }
};
