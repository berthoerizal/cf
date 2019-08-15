<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('invest_id');
            $table->string('i_no');
            $table->string('i_principal');
            $table->string('i_sprofit');
            $table->integer('i_total');
            $table->string('i_remaining');
            $table->date('i_date');
            $table->date('i_date_pay');
            $table->string('i_status');
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
        Schema::dropIfExists('installments');
    }
}
