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
        if(!Schema::hasTable('post_resubmit')) {
            Schema::create('post_resubmit', function (Blueprint $table) {
                $table->integer('id', true);
                $table->integer('product_id')->nullable()->unique('product_id');
                $table->integer('user_id')->nullable();
                $table->enum('featured', ['0', '1'])->default('0');
                $table->enum('urgent', ['0', '1'])->default('0');
                $table->enum('highlight', ['0', '1'])->default('0');
                $table->string('product_name', 100)->nullable();
                $table->text('description')->nullable();
                $table->integer('category')->nullable();
                $table->integer('sub_category')->nullable();
                $table->integer('price')->nullable();
                $table->enum('negotiable', ['0', '1'])->default('0');
                $table->string('phone', 50)->nullable();
                $table->enum('hide_phone', ['0', '1'])->nullable();
                $table->text('location')->nullable();
                $table->char('city', 50)->nullable();
                $table->char('state', 50)->nullable();
                $table->char('country', 50)->nullable();
                $table->string('latlong')->nullable();
                $table->text('screen_shot')->nullable();
                $table->string('tag', 225)->nullable();
                $table->enum('status', ['pending', 'active', 'rejected', 'softreject'])->default('pending');
                $table->integer('view')->default(1);
                $table->longText('custom_fields')->nullable();
                $table->longText('custom_types')->nullable();
                $table->longText('custom_values')->nullable();
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->integer('featured_exp_date')->nullable();
                $table->integer('urgent_exp_date')->nullable();
                $table->integer('highlight_exp_date')->nullable();
                $table->enum('contact_phone', ['0', '1'])->default('0');
                $table->enum('contact_email', ['0', '1'])->default('0');
                $table->enum('contact_chat', ['0', '1'])->default('0');
                $table->text('comments')->nullable();
                $table->enum('admin_seen', ['0', '1'])->default('0');

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
        Schema::dropIfExists('post_resubmit');
    }
};
