<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableObservationsRemoveAgreementFk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('observations', function (Blueprint $table) {
            $table->dropForeign('observations_agreement_id_foreign');
            $table->dropColumn('agreement_id');
            $table->unsignedBigInteger('code_id');
            $table->foreign('code_id')->references('id')->on('codes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('observations', function (Blueprint $table) {
            $table->dropForeign('observations_code_id_foreign');
            $table->dropColumn('code_id');
            $table->unsignedBigInteger('agreement_id');
            $table->foreign('agreement_id')->references('id')->on('agreements');
        });
    }
}
