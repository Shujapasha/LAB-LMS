<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // $table->string('patient_id',255)->unique()->after('hospital_name');
            // $table->string('EHR_No',255)->unique()->after('patient_id');
            // $table->date('reg_date')->nullable()->after('EHR_No');
            // $table->enum('patient_type',['abc','bcd','def'])->default('abc')->after('reg_date')->comment('if user type is patient then we use this');
            // $table->enum('title',['abc','bcd','def'])->default('abc')->after('patient_type')->comment('if user type is patient then we use this');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
