<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        if(!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->integer('id', true);
                $table->string('name', 300);
                $table->string('slug', 150)->nullable();
                $table->integer('order')->nullable();
                $table->string('picture', 300)->nullable();
                $table->string('icon', 300)->default('fa-usd');
            });

            $categories = array(
                array('id' => '1','name' => 'Cars & Bikes','slug' => 'cars-bikes','order' => '0','picture' => 'https://img.icons8.com/dusk/64/000000/traffic-jam.png','icon' => 'pe-7s-car'),
                array('id' => '2','name' => 'Mobiles & Tablets','slug' => 'mobiles-tablets','order' => '1','picture' => 'https://img.icons8.com/dusk/64/000000/two-smartphones.png','icon' => 'pe-7s-phone'),
                array('id' => '3','name' => 'Electronics & Appliances','slug' => 'electronics-appliances','order' => '2','picture' => 'https://img.icons8.com/dusk/64/000000/tv.png','icon' => 'pe-7s-monitor'),
                array('id' => '5','name' => 'Home & Lifestyle','slug' => 'home-lifestyle','order' => '4','picture' => 'https://img.icons8.com/dusk/64/000000/home-page.png','icon' => 'pe-7s-drawer'),
                array('id' => '6','name' => 'Jobs','slug' => 'jobs','order' => '5','picture' => 'https://img.icons8.com/dusk/64/000000/find-matching-job.png','icon' => 'pe-7s-portfolio'),
                array('id' => '7','name' => 'Services','slug' => 'services','order' => '6','picture' => 'https://img.icons8.com/dusk/64/000000/services.png','icon' => 'pe-7s-tools'),
                array('id' => '8','name' => 'Entertainment','slug' => 'entertainment','order' => '7','picture' => 'https://img.icons8.com/dusk/64/000000/dancing.png','icon' => 'pe-7s-film'),
                array('id' => '4','name' => 'Real Estate','slug' => 'real-estate','order' => '3','picture' => 'https://img.icons8.com/dusk/64/000000/real-estate.png','icon' => 'pe-7s-home')
            );
            DB::table('categories')->insert($categories);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
