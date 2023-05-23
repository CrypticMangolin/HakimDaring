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
        Schema::table('data_user', function (Blueprint $table) {
            $table->foreign('id_user')->references('id_user')->on('user'); 
        });

        Schema::table("soal", function (Blueprint $table) {
            $table->foreign('id_user_pembuat')->references("id_user")->on("user");
            $table->foreign('id_ruangan_diskusi')->references("id")->on("ruangan_comment");
        });

        Schema::table("testcase", function (Blueprint $table) {
            $table->foreign('id_soal')->references("id")->on("soal");
        });

        Schema::table("ruangan_comment", function (Blueprint $table) {
            $table->foreign('id_pembuat')->references("id_user")->on("user");
        });

        Schema::table("comment", function (Blueprint $table) {
            $table->foreign('id_ruangan')->references("id")->on("ruangan_comment");
            $table->foreign('id_penulis')->references("id_user")->on("user");
            $table->foreign('reply')->references("id")->on("comment");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
