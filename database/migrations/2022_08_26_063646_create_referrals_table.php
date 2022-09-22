<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',191);
            $table->string('email',191);
            $table->string('phone',191);
            $table->text('location');
            $table->enum('category',['internal','shared'])->default('internal')->comment('category for refrence');
            $table->enum('shared_in_type',['no','percentage','amount'])->default('no')->comment('When category shared selected');
            $table->double('shared_in_amount_or_percentage', 15, 2);
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
        Schema::dropIfExists('referrals');
    }
}
