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
        Schema::create('organizations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('owner_id');
            $table->string('organization_name');
            $table->string('organization_legal_name');
            $table->json('organization_logo');
            $table->longText('organization_address');
            $table->string('organization_phone');
            $table->longText('organization_description');
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
        Schema::drop('organizations');
    }
};
