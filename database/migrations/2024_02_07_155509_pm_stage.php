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
        Schema::create('pm_stages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pipeline_id');
            $table->integer('pm_type_id');
            $table->integer('pipeline_index');
            $table->string('stage_title');
            $table->timestamps();
            $table->softDeletesTz('deleted_at');        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pm_stages');
    }
};
