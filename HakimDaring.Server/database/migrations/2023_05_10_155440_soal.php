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
        Schema::create("soal", function (Blueprint $table) {
            $table->id();
            $table->uuid("id_user_pembuat");
            $table->string('judul');
            $table->string('soal');
            $table->integer("versi");
            $table->integer('jumlah_submit');
            $table->integer('jumlah_berhasil');
            $table->string('status');
            $table->timestamps();

            $table->foreign('id_user_pembuat')->references("id_user")->on("user");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soal');
    }
};
