<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodingLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coding_levels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('interview_id');
            $table->integer('level');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('interview_id')->references('id')->on('interviews');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coding_levels');
    }
}
