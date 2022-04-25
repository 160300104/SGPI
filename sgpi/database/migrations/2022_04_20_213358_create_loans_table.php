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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->date('loan_date');
            $table->date('delivery_date')->nullable();
            $table->string('observations', 100)->nullable();

            $table->unsignedBigInteger('id_lab')->nullable();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->unsignedBigInteger('id_status')->nullable();

            $table->foreign('id_lab')
                    ->references('id')->on('labs')
                    ->onDelete('set null');

            $table->foreign('id_user')
                    ->references('id')->on('users')
                    ->onDelete('set null');
            $table->timestamps();

            $table->foreign('id_status')
                    ->references('id')->on('statuses')
                    ->onDelete('set null'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
};
