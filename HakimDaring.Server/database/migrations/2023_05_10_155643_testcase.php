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
            $table->longText('testcase');
            $table->longText('jawaban');
            $table->integer('urutan');
            $table->boolean('publik');
            $table->integer("versi_soal");
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
        Schema::dropIfExists('testcase');
    }
};
