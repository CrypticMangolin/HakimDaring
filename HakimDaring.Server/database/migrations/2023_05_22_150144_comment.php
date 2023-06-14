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
        Schema::create("comment", function (Blueprint $table) {
            $table->uuid("id_comment");
            $table->uuid("id_ruangan");
            $table->uuid("id_penulis");
            $table->longText("pesan");
            $table->dateTime("tanggal_penulisan");
            $table->uuid("reply")->nullable();
            $table->string("status");
            $table->integer("jumlah_report");
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
        Schema::dropIfExists('comment');
    }
};
