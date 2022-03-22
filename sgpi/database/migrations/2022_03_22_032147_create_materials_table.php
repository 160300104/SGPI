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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);

            $table->string('image',100);

            $table->integer('quantity');

            $table->date('register_date');

            $table->unsignedBigInteger('id_lab')->nullable();
            $table->unsignedBigInteger('id_category')->nullable();

            $table->foreign('id_lab')
                    ->references('id')->on('labs')
                    ->onDelete('set null');

            $table->foreign('id_category')
                    ->references('id')->on('categories')
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
        Schema::dropIfExists('materials');
    }
};
