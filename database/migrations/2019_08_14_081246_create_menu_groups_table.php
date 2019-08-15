<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // menu_groups {id, admin_group_id, menu_id, mgroup_status, mgroup_r, mgroup_c, mgroup_u, mgroup_d, mgroup_a}
        Schema::create('menu_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('admin_group_id');
            $table->bigInteger('menu_id');
            $table->boolean('mgroup_status');
            $table->boolean('mgroup_r');
            $table->boolean('mgroup_c');
            $table->boolean('mgroup_u');
            $table->boolean('mgroup_d');
            $table->boolean('mgroup_a');
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
        Schema::dropIfExists('menu_groups');
    }
}
