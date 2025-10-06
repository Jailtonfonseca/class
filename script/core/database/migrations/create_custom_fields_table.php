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
        if(!Schema::hasTable('custom_fields')) {
            Schema::create('custom_fields', function (Blueprint $table) {
                $table->increments('id');
                $table->longText('translation_lang')->nullable();
                $table->text('translation_name')->nullable();
                $table->string('title', 100)->nullable();
                $table->string('type', 40)->nullable();
                $table->text('icon')->nullable();
                $table->string('anycat')->nullable();
                $table->string('category_id')->nullable();
                $table->text('sub_category_id');
                $table->longText('options')->nullable();
                $table->boolean('required')->unsigned()->default(false);
                $table->boolean('use_as_filter')->default(false);
                $table->boolean('show_in_view')->default(false);
                $table->boolean('active')->default(true);
                $table->integer('order')->nullable()->index('custom_order');
                $table->string('name', 40)->nullable();
                $table->string('default', 200)->nullable();
                $table->unsignedInteger('min')->default(0);
                $table->unsignedInteger('max')->default(0);
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
        Schema::dropIfExists('custom_fields');
    }
};
