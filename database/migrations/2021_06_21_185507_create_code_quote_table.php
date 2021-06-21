<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodeQuoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('code_quote', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('code_id');
            $table->unsignedBigInteger('quote_id');
            $table->foreign('code_id')->references('id')->on('codes');
            $table->foreign('quote_id')->references('id')->on('quotes');
            $table->timestamps();
        });

        Schema::table('codes', function (Blueprint $table) {
            $table->dropForeign('codes_quote_id_foreign');
            $table->dropColumn('quote_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('codes', function (Blueprint $table) {
            $table->unsignedBigInteger('quote_id');
            $table->foreign('quote_id')->references('id')->on('quotes');
        });

        Schema::dropIfExists('code_quote');
    }
}
