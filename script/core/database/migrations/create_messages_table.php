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
        if(!Schema::hasTable('messages')) {
            Schema::create('messages', function (Blueprint $table) {
                $table->integer('id', true);
                $table->integer('post_id')->nullable();
                $table->integer('from_id')->nullable();
                $table->integer('to_id')->nullable();
                $table->string('message_type', 20)->nullable();
                $table->text('message_content')->nullable();
                $table->tinyInteger('recd')->default(0);
                $table->enum('seen', ['0', '1'])->default('0');
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
        Schema::dropIfExists('messages');
    }
};
