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
        Schema::create("pengerjaan", function (Blueprint $table) {
            $table->uuid("id_pengerjaan");
            $table->uuid("id_user");
            $table->uuid("id_soal");
            $table->integer("versi_soal");
            $table->string("source_code");
            $table->string("bahasa");
            $table->string("hasil");
            $table->double("total_waktu");
            $table->integer("total_memori");
            $table->dateTime("tanggal_submit");
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
        Schema::dropIfExists('pengerjaan');
    }
};
