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
        Schema::create("testcase", function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_soal");
            $table->string('testcase');
            $table->string('jawaban');
            $table->integer('urutan');
            $table->boolean('publik');
            $table->integer("versi_soal");
            $table->timestamps();

            $table->foreign('id_soal')->references("id")->on("soal");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('testcase');
    }
};
