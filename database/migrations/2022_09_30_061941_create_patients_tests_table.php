<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients_tests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('radiology_tests_id');
            $table->foreign('radiology_tests_id')->references('id')->on('radiology_tests')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->bigInteger('referral_id')->unsigned();
            $table->foreign('referral_id')
                ->references('id')
                ->on('referrals')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('fee')->default(0);
            $table->integer('discount_by')->default(0)->comment('Default value is 0. 0 means Gilani Altrasound and 1 means Referral');
            $table->integer('discount')->default(0);
            $table->integer('net_amount')->default(0);
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
        Schema::dropIfExists('patients_tests');
    }
}
