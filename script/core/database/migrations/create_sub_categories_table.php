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
        if(!Schema::hasTable('sub_categories')) {
            Schema::create('sub_categories', function (Blueprint $table) {
                $table->integer('id', true);
                $table->integer('category_id');
                $table->string('name');
                $table->string('slug', 150)->nullable();
                $table->mediumInteger('order');
                $table->text('picture')->nullable();
                $table->enum('photo_show', ['0', '1'])->default('1');
                $table->enum('price_show', ['0', '1'])->default('1');

                $table->unique(['id'], 'id');
            });

            $sub_categories = array(
                array('id' => '1','category_id' => '1','name' => 'Bikes & Scooters','slug' => 'bikes-scooters2','order' => '1','picture' => 'https://img.icons8.com/color/64/000000/cycling-mountain-bike--v2.png','photo_show' => '1','price_show' => '0'),
                array('id' => '2','category_id' => '1','name' => 'Cars','slug' => 'bikes-scooters','order' => '0','picture' => 'https://img.icons8.com/bubbles/64/000000/car.png','photo_show' => '1','price_show' => '1'),
                array('id' => '3','category_id' => '1','name' => 'Commercial Vehicles','slug' => 'commercial-vehicles','order' => '4','picture' => 'https://img.icons8.com/color/64/000000/bus.png','photo_show' => '1','price_show' => '1'),
                array('id' => '4','category_id' => '1','name' => 'Spare Parts Accessories','slug' => 'spare-parts-accessories','order' => '3','picture' => 'https://img.icons8.com/officel/64/000000/car-theft.png','photo_show' => '1','price_show' => '1'),
                array('id' => '5','category_id' => '1','name' => 'Other Vehicles','slug' => 'other-vehicles','order' => '2','picture' => 'https://img.icons8.com/dusk/64/000000/truck.png','photo_show' => '1','price_show' => '1'),
                array('id' => '6','category_id' => '2','name' => 'Mobile Phones','slug' => 'mobile-phones','order' => '5','picture' => 'https://img.icons8.com/dusk/64/000000/two-smartphones.png','photo_show' => '1','price_show' => '1'),
                array('id' => '7','category_id' => '2','name' => 'Accessories','slug' => 'accessories','order' => '6','picture' => 'https://img.icons8.com/cotton/64/000000/mobile-order.png','photo_show' => '1','price_show' => '1'),
                array('id' => '8','category_id' => '2','name' => 'Tablets','slug' => 'tablets','order' => '7','picture' => 'https://img.icons8.com/dusk/64/000000/windows8-tablet.png','photo_show' => '1','price_show' => '1'),
                array('id' => '9','category_id' => '2','name' => 'Wearables','slug' => 'wearables','order' => '8','picture' => 'https://img.icons8.com/dusk/64/000000/two-smartphones.png','photo_show' => '1','price_show' => '1'),
                array('id' => '10','category_id' => '3','name' => 'Camera Accessories','slug' => 'camera-accessories','order' => '9','picture' => 'https://img.icons8.com/plasticine/64/000000/camera.png','photo_show' => '1','price_show' => '1'),
                array('id' => '11','category_id' => '3','name' => 'Computer Peripherals','slug' => 'computer-peripherals','order' => '10','picture' => 'https://img.icons8.com/nolan/64/000000/computer.png','photo_show' => '1','price_show' => '1'),
                array('id' => '12','category_id' => '3','name' => 'Home Kitchen Appliances','slug' => 'home-kitchen-appliances','order' => '11','picture' => 'https://img.icons8.com/dusk/64/000000/fridge.png','photo_show' => '1','price_show' => '1'),
                array('id' => '13','category_id' => '3','name' => 'Laptops Computers','slug' => 'laptops-computers','order' => '12','picture' => 'https://img.icons8.com/nolan/64/000000/computer.png','photo_show' => '1','price_show' => '1'),
                array('id' => '14','category_id' => '3','name' => 'Music Systems - Home Theatre','slug' => 'music-systems-home-theatre','order' => '13','picture' => 'https://img.icons8.com/bubbles/64/000000/music.png','photo_show' => '1','price_show' => '1'),
                array('id' => '15','category_id' => '3','name' => 'Video Games - Consoles','slug' => 'video-games-consoles','order' => '14','picture' => 'https://img.icons8.com/color/64/000000/dreamcast.png','photo_show' => '1','price_show' => '1'),
                array('id' => '16','category_id' => '4','name' => 'Commercial Property for Rent','slug' => 'commercial-property-for-rent','order' => '15','picture' => 'https://img.icons8.com/officel/64/000000/sell-property.png','photo_show' => '1','price_show' => '1'),
                array('id' => '17','category_id' => '4','name' => 'Commercial Property for Sale','slug' => 'commercial-property-for-sale','order' => '16','picture' => 'https://img.icons8.com/officel/64/000000/sell-property.png','photo_show' => '1','price_show' => '1'),
                array('id' => '18','category_id' => '4','name' => 'Houses - Apartments for Rent','slug' => 'houses-apartments-for-rent','order' => '17','picture' => 'https://img.icons8.com/officel/64/000000/sell-property.png','photo_show' => '1','price_show' => '1'),
                array('id' => '19','category_id' => '4','name' => 'Houses - Apartments for Sale','slug' => 'houses-apartments-for-sale','order' => '18','picture' => 'https://img.icons8.com/officel/64/000000/sell-property.png','photo_show' => '1','price_show' => '1'),
                array('id' => '20','category_id' => '4','name' => 'Land - Plot For Sale','slug' => 'land-plot-for-sale','order' => '19','picture' => 'https://img.icons8.com/ios/64/000000/land-sales.png','photo_show' => '1','price_show' => '1'),
                array('id' => '21','category_id' => '4','name' => 'Paying Guest - Hostel','slug' => 'paying-guest-hostel','order' => '20','picture' => 'https://img.icons8.com/officel/64/000000/5-star-hotel.png','photo_show' => '1','price_show' => '1'),
                array('id' => '22','category_id' => '4','name' => 'Service Apartments','slug' => 'service-apartments','order' => '21','picture' => 'https://img.icons8.com/officel/64/000000/5-star-hotel.png','photo_show' => '1','price_show' => '1'),
                array('id' => '23','category_id' => '5','name' => 'Furniture & Decor','slug' => 'furniture-decor','order' => '22','picture' => 'https://img.icons8.com/dusk/64/000000/dining-table-light.png','photo_show' => '1','price_show' => '1'),
                array('id' => '24','category_id' => '5','name' => 'Sports, Books & Hobbies','slug' => 'sports-books-hobbies','order' => '24','picture' => 'https://img.icons8.com/cute-clipart/64/000000/book.png','photo_show' => '1','price_show' => '1'),
                array('id' => '25','category_id' => '5','name' => 'Kids & Toys','slug' => 'kids-toys','order' => '25','picture' => 'https://img.icons8.com/color/64/000000/plush.png','photo_show' => '1','price_show' => '1'),
                array('id' => '26','category_id' => '5','name' => 'Fashion','slug' => 'fashion','order' => '26','picture' => 'https://img.icons8.com/officel/64/000000/purse-back-view.png','photo_show' => '1','price_show' => '1'),
                array('id' => '27','category_id' => '5','name' => 'Health - Beauty Products','slug' => 'health-beauty-products','order' => '27','picture' => 'https://img.icons8.com/officel/64/000000/purse-back-view.png','photo_show' => '1','price_show' => '1'),
                array('id' => '28','category_id' => '6','name' => 'Full Time Jobs','slug' => 'full-time-jobs','order' => '28','picture' => 'https://img.icons8.com/dusk/64/000000/find-matching-job.png','photo_show' => '0','price_show' => '0'),
                array('id' => '29','category_id' => '6','name' => 'Internships','slug' => 'internships','order' => '29','picture' => 'https://img.icons8.com/dusk/64/000000/find-matching-job.png','photo_show' => '0','price_show' => '0'),
                array('id' => '30','category_id' => '6','name' => 'Part Time Jobs','slug' => 'part-time-jobs','order' => '30','picture' => 'https://img.icons8.com/dusk/64/000000/find-matching-job.png','photo_show' => '0','price_show' => '0'),
                array('id' => '31','category_id' => '6','name' => 'Work Abroad','slug' => 'work-abroad','order' => '31','picture' => 'https://img.icons8.com/dusk/64/000000/work-light.png','photo_show' => '0','price_show' => '0'),
                array('id' => '32','category_id' => '6','name' => 'Work From Home','slug' => 'work-from-home','order' => '32','picture' => 'https://img.icons8.com/dusk/64/000000/work-light.png','photo_show' => '0','price_show' => '0'),
                array('id' => '33','category_id' => '7','name' => 'Advertising - Design','slug' => 'advertising-design','order' => '33','picture' => 'https://img.icons8.com/color/64/000000/remove-ads.png','photo_show' => '1','price_show' => '1'),
                array('id' => '34','category_id' => '7','name' => 'Catering -Tiffin Services','slug' => 'catering-tiffin-services','order' => '34','picture' => 'https://img.icons8.com/color/64/000000/remove-ads.png','photo_show' => '1','price_show' => '1'),
                array('id' => '35','category_id' => '7','name' => 'Computer Repair and Service','slug' => 'computer-repair-and-service','order' => '35','picture' => 'https://img.icons8.com/color/64/000000/computer-support.png','photo_show' => '1','price_show' => '1'),
                array('id' => '36','category_id' => '7','name' => 'Dance Classes','slug' => 'dance-classes','order' => '36','picture' => 'https://img.icons8.com/color/64/000000/tango.png','photo_show' => '1','price_show' => '1'),
                array('id' => '37','category_id' => '7','name' => 'Electronics - Appliances Repair','slug' => 'electronics-appliances-repair','order' => '37','picture' => 'https://img.icons8.com/officel/16/000000/design.png','photo_show' => '1','price_show' => '1'),
                array('id' => '38','category_id' => '7','name' => 'Legal Services','slug' => 'legal-services','order' => '38','picture' => 'https://img.icons8.com/office/64/000000/courthouse.png','photo_show' => '1','price_show' => '1'),
                array('id' => '39','category_id' => '7','name' => 'Mobile & Tablet repair','slug' => 'mobile-tablet-repair','order' => '39','picture' => 'https://img.icons8.com/color/64/000000/computer-support.png','photo_show' => '1','price_show' => '1'),
                array('id' => '40','category_id' => '7','name' => 'Movers & Packers','slug' => 'movers-packers','order' => '40','picture' => 'https://img.icons8.com/officel/16/000000/design.png','photo_show' => '1','price_show' => '1'),
                array('id' => '41','category_id' => '8','name' => 'Acting - Modeling Roles','slug' => 'acting-modeling-roles','order' => '41','picture' => 'https://img.icons8.com/office/64/000000/theatre-mask.png','photo_show' => '1','price_show' => '1'),
                array('id' => '42','category_id' => '8','name' => 'Fashion Designers - Stylists','slug' => 'fashion-designers-stylists','order' => '42','picture' => 'https://img.icons8.com/clouds/64/000000/fashion-portal.png','photo_show' => '1','price_show' => '1'),
                array('id' => '43','category_id' => '8','name' => 'Make Up - Hair - Films & TV','slug' => 'make-up-hair','order' => '43','picture' => 'https://img.icons8.com/clouds/64/000000/fashion-portal.png','photo_show' => '1','price_show' => '1'),
                array('id' => '44','category_id' => '8','name' => 'Modeling Agencies','slug' => 'modeling-agencies','order' => '44','picture' => 'https://img.icons8.com/clouds/64/000000/fashion-portal.png','photo_show' => '1','price_show' => '1'),
                array('id' => '45','category_id' => '8','name' => 'Photographers - Cameraman','slug' => 'photographers-cameraman','order' => '45','picture' => 'https://img.icons8.com/cute-clipart/64/000000/camera.png','photo_show' => '1','price_show' => '1'),
                array('id' => '46','category_id' => '8','name' => 'Studios - Locations for hire','slug' => 'studios-locations','order' => '46','picture' => 'https://img.icons8.com/officel/64/000000/point-objects.png','photo_show' => '1','price_show' => '1'),
                array('id' => '50','category_id' => '7','name' => 'Secret Services','slug' => 'secret-services','order' => '47','picture' => 'https://img.icons8.com/ios/64/000000/18-plus.png','photo_show' => '1','price_show' => '1'),
                array('id' => '53','category_id' => '5','name' => 'Sofa','slug' => 'sofa','order' => '23','picture' => NULL,'photo_show' => '1','price_show' => '1')
            );
            DB::table('sub_categories')->insert($sub_categories);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_categories');
    }
};
