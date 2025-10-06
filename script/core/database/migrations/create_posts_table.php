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
        if(!Schema::hasTable('posts')) {
            Schema::create('posts', function (Blueprint $table) {
                $table->integer('id', true);
                $table->integer('user_id')->nullable();
                $table->integer('category_id')->nullable();
                $table->integer('sub_category_id')->nullable();
                $table->enum('status', ['pending', 'active', 'rejected', 'expire'])->default('pending');
                $table->string('slug', 150)->nullable();
                $table->string('title', 150)->nullable();
                $table->text('description')->nullable();
                $table->text('images')->nullable();
                $table->integer('price')->default(0);
                $table->enum('negotiable', ['0', '1'])->nullable();
                $table->string('phone', 50)->nullable();
                $table->enum('hide_phone', ['0', '1'])->nullable();
                $table->char('city_id', 50)->nullable();
                $table->char('state_id', 50)->nullable();
                $table->char('country_code', 50)->nullable();
                $table->text('location')->nullable();
                $table->string('latlong')->nullable();
                $table->string('tag', 225)->nullable();
                $table->enum('hide', ['0', '1'])->nullable();
                $table->enum('featured', ['0', '1'])->default('0');
                $table->enum('urgent', ['0', '1'])->default('0');
                $table->enum('highlight', ['0', '1'])->default('0');
                $table->timestamp('expire_date')->nullable();
                $table->integer('view')->default(1);
                $table->enum('emailed', ['0', '1'])->nullable();
                $table->enum('admin_seen', ['0', '1'])->nullable();
                $table->timestamps();

                $table->index(['id'], 'id');
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
        Schema::dropIfExists('posts');
    }
};
