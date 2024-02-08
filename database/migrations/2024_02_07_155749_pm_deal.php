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
        Schema::create('pm_deals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id');
            $table->integer('pm_type_id');
            $table->longText('deal_title');
            $table->longText('deal_description');
            $table->longText('deal_owner');
            $table->float('deal_value');
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
        Schema::dropIfExists('pm_deals');
    }
};
