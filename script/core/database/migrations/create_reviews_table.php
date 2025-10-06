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
        if(!Schema::hasTable('reviews')) {
            Schema::create('reviews', function (Blueprint $table) {
                $table->integer('id', true);
                $table->integer('post_id');
                $table->integer('user_id');
                $table->double('rating');
                $table->mediumText('comments');
                $table->integer('publish')->default(1);
                $table->timestamps();
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
        Schema::dropIfExists('reviews');
    }
};
