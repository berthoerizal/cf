<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('admin_id');
            $table->string('project_name');
            $table->string('project_desc');
            $table->string('project_short_desc');
            $table->integer('project_min_modal'); 
            $table->string('project_sharingp');
            $table->integer('project_total');
            $table->date('project_date'); 
            $table->date('project_duration');
            $table->date('project_start_date'); 
            $table->string('project_status');
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
        Schema::dropIfExists('projects');
    }
}
