<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Countries;
use App\Models\CustomData;
use App\Models\CustomField;
use App\Models\MobileNumber;
use App\Models\Option;
use App\Models\Post;
use App\Models\PostOption;
use App\Models\PostType;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class FakeController extends Controller
{
    /**
     * Display listings of the resource.
     */
    public function index(Request $request)
    {
        if(Auth::user() && Auth::user()->isAdmin() && Auth::user()->id == 1) {

            $countries = Countries::where('active','1')->paginate(2);
            foreach ($countries as $country) {
                echo $country->code.'<br>';
                $country_code = strtoupper($country->code);
                $country_name = $country->name;

                for ($j = 1; $j <= 10; $j++) {

                    /*Create fake User*/
                    $faker = Faker::create();
                    $username = $faker->unique()->userName();
                    $email = $faker->unique()->safeEmail();
                    $is_username_exist = User::where('username',$username)->count();
                    $is_email_exist = User::where('email',$email)->count();
                    if($is_username_exist > 0 || $is_email_exist > 0){
                        continue;
                    }

                    $file = public_path('storage/demo_images/user/'.$j.'.jpg');
                    $avatarname = uniqid() . time() . '.png';
                    File::copy($file, public_path('storage/profile/') . $avatarname);

                    $user = User::create([
                        'name' => $faker->name(),
                        'username' => $username,
                        'email' => $email,
                        'password' => Hash::make("bylancer"),
                        'group_id' => config('settings.default_user_plan'),
                        'country' => $country_name,
                        'country_code' => $country_code,
                        'image' => $avatarname,
                    ]);

                    MobileNumber::create([
                        'user_id' => $user->id,
                        'mobile_number' => $faker->unique()->e164PhoneNumber(),
                        'verification_code' => "123456",
                        'verified' => '1'
                    ]);

                    $user->markEmailAsVerified();

                    for ($k = 0; $k < 5; $k++) {
                        $images = array_filter(glob(public_path('storage/demo_images/realestate/') . '*'), 'is_file');

                        $image_names = [];

                        for ($i = 0; $i < 5; $i++) {
                            $file = $images[array_rand($images)];
                            $name = uniqid() . time() . '.png';
                            File::copy($file, public_path('storage/products/') . $name);

                            $size = '400x250';
                            $image = Image::make($file);
                            if ($size) {
                                $size = explode('x', strtolower($size));
                                if (isset($size[1])) {
                                    $image->resize($size[0], $size[1]);
                                } else {
                                    $image->resize($size[0], null, function ($constraint) {
                                        $constraint->aspectRatio();
                                    });
                                }

                            }
                            $image->save(public_path('storage/products/thumb/') . $name);

                            $image_names[] = $name;
                        }
                        $image_names = implode(',', $image_names);


                        $city = Cities::query()->where('country_code', $country_code)
                            ->with(['district', 'region', 'country'])
                            ->inRandomOrder()->first();
                        $city_id = $city->id;
                        $state_id = $city->subadmin1_code;
                        $admin2Code = $city->subadmin2_code;

                        $location = $city->name;
                        if (!empty($admin2Code) && isset($city->district->name) && !empty($city->district->name)) {
                            $location = $location . ", " . $city->district->name;
                        }
                        if (!empty($state_id) && isset($city->region->name) && !empty($city->region->name)) {
                            $location = $location . ", " . $city->region->name;
                        }

                        $nearBy = $this->generateNearbyLatLong($city->latitude, $city->longitude, 50);
                        $latitude = $nearBy['latitude'];
                        $longitude = $nearBy['longitude'];

                        $title = $faker->sentence(5);
                        $looking_for = $faker->randomElement(['buy', 'rent']);
                        $category = $faker->randomElement(['residential', 'commercial']);
                        $tags = implode(',', $faker->words(5));
                        $post_type_id = PostType::query()->where('category', $category)
                            ->inRandomOrder()->first()->id;


                        $create = Post::create([
                            'user_id' => $user->id,
                            'status' => "active",
                            'looking_for' => $looking_for,
                            'category' => $category,
                            'post_type_id' => $post_type_id,
                            'property_size' => $faker->randomNumber(5, true),
                            'title' => $title,
                            'slug' => SlugService::createSlug(Post::class, 'slug', $title),
                            'description' => $faker->sentence(200),
                            'images' => $image_names,
                            'city_id' => $city_id,
                            'state_id' => $state_id,
                            'country_code' => $country_code,
                            'location' => $location,
                            'latitude' => $latitude,
                            'longitude' => $longitude,
                            'price' => $faker->randomFloat(2, 9999, 999999),
                            'tag' => $tags,
                            'urgent' => ($k % 4 == 0 ? 1 : 0),
                            'highlight' => ($k % 5 == 0 ? 1 : 0),
                            'featured' => ($k % 2 == 0 ? 1 : 0),
                            'expire_date' => Carbon::now()->addDays(365)
                        ]);

                        if ($create) {
                            $post_id = $create->id;
                            $price_period = ($looking_for == "buy") ? 'fixed' : $faker->randomElement(['day', 'month', 'week', 'year']);

                            PostOption::updatePostOption($create->id, 'price_period', $price_period);

                            $custom_fields = CustomField::whereRaw("find_in_set($post_type_id , post_type_id)")
                                ->orderBy('order')->get();

                            if (count($custom_fields) > 0) {
                                foreach ($custom_fields as $row) {

                                    $id = $row->id;
                                    $type = $row->type;
                                    $default = $row->default;
                                    $required = $row->required;
                                    $name = $row->title;

                                    $value = null;

                                    if ($type == "radio-buttons") {
                                        $options = explode(',', $row['options']);
                                        $key = array_rand($options);
                                        $value = $options[$key];
                                    } elseif ($type == "checkboxes") {
                                        $options = explode(',', $row['options']);
                                        $optionKey = array_rand($options, 5);
                                        $value = [];
                                        foreach ($optionKey as $key) {
                                            $value[] = $options[$key];
                                        }
                                    }

                                    if ($value) {
                                        if (is_array($value)) {
                                            $field_data = implode(',', $value);
                                        } else {
                                            $field_data = $value;
                                        }
                                        CustomData::create([
                                            'post_id' => $post_id,
                                            'field_id' => $id,
                                            'field_data' => $field_data
                                        ]);
                                    }
                                }
                            }

                            $users = User::query()
                                ->where('id', '!=', $user->id)
                                ->inRandomOrder()
                                ->limit(3)
                                ->get();

                            foreach ($users as $u) {
                                Review::create([
                                    'post_id' => $post_id,
                                    'user_id' => $u->id,
                                    'comments' => $faker->sentence(20),
                                    'rating' => $faker->randomElement([3, 4, 5]),
                                    'publish' => '1'
                                ]);
                            }
                        }
                    }
                }
            }

            echo "done";
        }
        else{
            abort(404);
        }

    }

    function generateNearbyLatLong($latitude, $longitude, $radiusInKm = 10)
    {
        $earthRadius = 6371; // Earth radius in kilometers
        $nearbyLocations = [];

        // Convert radius from kilometers to radians
        $radiusInRadians = $radiusInKm / $earthRadius;

        // Random bearing in radians
        $randomBearing = deg2rad(rand(0, 360));

        // Random distance in radians within the radius
        $randomDistance = $radiusInRadians * sqrt(rand(0, 100) / 100);

        // Calculate new latitude
        $newLatitude = asin(sin(deg2rad($latitude)) * cos($randomDistance) +
            cos(deg2rad($latitude)) * sin($randomDistance) * cos($randomBearing));

        // Calculate new longitude
        $newLongitude = deg2rad($longitude) +
            atan2(
                sin($randomBearing) * sin($randomDistance) * cos(deg2rad($latitude)),
                cos($randomDistance) - sin(deg2rad($latitude)) * sin($newLatitude)
            );

        // Convert latitude and longitude back to degrees
        $newLatitude = rad2deg($newLatitude);
        $newLongitude = rad2deg($newLongitude);

        $nearbyLocations = [
            'latitude' => $newLatitude,
            'longitude' => $newLongitude,
        ];

        return $nearbyLocations;
    }
}
