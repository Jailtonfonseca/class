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
        if(!Schema::hasTable('category_translation')) {
            Schema::create('category_translation', function (Blueprint $table) {
                $table->integer('id', true);
                $table->integer('translation_id');
                $table->string('lang_code', 10);
                $table->string('title');
                $table->string('slug', 150)->nullable();
                $table->string('category_type', 22)->nullable();
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
        Schema::dropIfExists('category_translation');
    }
};
