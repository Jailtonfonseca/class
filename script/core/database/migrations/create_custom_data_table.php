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
        if(!Schema::hasTable('custom_data')) {
            Schema::create('custom_data', function (Blueprint $table) {
                $table->integer('id', true);
                $table->integer('post_id')->nullable();
                $table->integer('field_id')->nullable();
                $table->string('field_type', 20)->nullable();
                $table->text('field_data')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_data');
    }
};
