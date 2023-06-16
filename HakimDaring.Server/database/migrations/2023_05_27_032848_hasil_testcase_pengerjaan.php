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
        Schema::create("hasil_testcase_pengerjaan", function (Blueprint $table) {
            $table->uuid("id_pengerjaan");
            $table->uuid("id_testcase");
            $table->string("status");
            $table->double("waktu");
            $table->integer("memori");
            $table->timestamps();

            $table->primary(["id_pengerjaan", "id_testcase"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hasil_testcase_pengerjaan');
    }
};
