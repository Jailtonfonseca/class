<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\Countries;
use App\Models\Option;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class InstallController extends Controller
{
    /**
     * Display the index page - Step 1
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('install.welcome');
    }

    /**
     * Display the requirements page - Step 2
     *
     * @return \Illuminate\View\View
     */
    public function requirements()
    {
        $array = config('install.extensions');

        $results = [];

        foreach ($array as $type => $value) {
            if ($type == 'php') {
                foreach ($value as $extensions) {
                    if (!extension_loaded($extensions)) {
                        $results['extensions'][$type][$extensions] = false;
                        $results['errors'] = true;
                    } else {
                        $results['extensions'][$type][$extensions] = true;
                    }
                }
            } elseif ($type == 'apache') {
                foreach ($value as $modules) {
                    if (function_exists('apache_get_modules')) {
                        if (!in_array($modules, apache_get_modules())) {
                            $results['extensions'][$type][$modules] = false;
                            $results['errors'] = true;
                        } else {
                            $results['extensions'][$type][$modules] = true;
                        }
                    }
                }
            }
        }

        if (version_compare(PHP_VERSION, config('install.php_version')) == -1) {
            $results['errors'] = true;
        }

        return view('install.requirements', ['results' => $results]);
    }

    /**
     * Display the Permissions page. - Step 3
     *
     * @return \Illuminate\View\View
     */
    public function permissions()
    {
        $array = config('install.permissions');

        $results = [];
        foreach ($array as $type => $files) {
            foreach ($files as $file) {
                if (is_writable(base_path('../'.$file))) {
                    $results['permissions'][$type][$file] = true;
                } else {
                    $results['permissions'][$type][$file] = false;
                    $results['errors'] = true;
                }
            }
        }

        return view('install.permissions', ['results' => $results]);
    }

    /**
     * Display the Database details page. - Step 4
     *
     * @return \Illuminate\View\View
     */
    public function database()
    {
        return view('install.database');
    }

    /**
     * Display old database update notice - Step 4 (1)
     *
     * @return \Illuminate\View\View
     */
    public function updateDatabase()
    {
        return view('install.update-database');
    }

    /**
     * Display the Admin details page. - Step 5
     *
     * @return \Illuminate\View\View
     */
    public function admin()
    {
        return view('install.admin', ['db_empty' => $this->isDBEmpty()]);
    }

    /**
     * Display the Complete page. - Step 6
     *
     * @return \Illuminate\View\View
     */
    public function complete()
    {
        return view('install.complete');
    }

    /**
     * Check the database details and update the .env file.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateEnv(Request $request)
    {
        $request->validate(
            [
                'database_hostname' => ['required', 'string', 'max:50'],
                'database_port' => ['required', 'numeric'],
                'database_name' => ['required', 'string', 'max:50'],
                'database_prefix' => ['nullable', 'string', 'max:20'],
                'database_username' => ['required', 'string', 'max:50'],
                'database_password' => ['nullable', 'string', 'max:50'],
            ]
        );

        $response = $this->validateDatabaseDetails($request);
        if ($response !== true) {
            return back()->with('error', ___('Database details invalid').' '.$response)->withInput();
        }

        $response = $this->updateEnvFile($request);
        if ($response !== true) {
            return back()->with('error',
                ___('.env file is not writable, check file permissions.').' '.$response)->withInput();
        }

        /* Check database is empty or not */
        if (!$this->isDBEmpty()) {
            return redirect()->route('install.update_database');
        }

        return redirect()->route('install.admin');
    }

    /**
     * Migrate the database and create the admin user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createAdmin(Request $request)
    {
        $rules = [
            'purchase_code' => ['required', 'string', 'max:50']
        ];

        $db_empty = $this->isDBEmpty();

        if ($db_empty) {
            $rules = array_merge($rules, [
                'name' => ['required', 'string', 'max:50'],
                'username' => ['required', 'string', 'min:2', 'max:50'],
                'email' => ['required', 'string', 'email', 'max:100'],
                'password' => ['required', 'string', 'min:6', 'max:128', 'confirmed'],
            ]);
        }

        $request->validate($rules);

        $response = $this->updateOldDatabase();
        if ($response !== true) {
            return back()->with('error', ___('Database update failed').' '.$response)->withInput();
        }

        $response = $this->migrateDatabase();
        if ($response !== true) {
            return back()->with('error', ___('Database migration failed.').' '.$response)->withInput();
        }

        Option::updateOptions('purchase_code', $request->input('purchase_code'));

        $response = $this->createAdminUser($request, $db_empty);
        if ($response !== true) {
            return back()->with('error', ___('Admin user creation failed.').' '.$response)->withInput();
        }

        $response = $this->installed();
        if ($response !== true) {
            return back()->with('error', ___('.env file update failed.').' '.$response)->withInput();
        }

        $admin_username = null;
        if (!$db_empty) {
            /* Show admin details if the DB was not empty */
            $admin_username = User::where('user_type', 'admin')->first()->username;
        }

        return redirect()->route('install.complete', ['admin_username' => $admin_username]);
    }

    /**
     * Validate the database details.
     *
     * @return bool|string
     */
    private function validateDatabaseDetails(Request $request)
    {
        $settings = config("database.connections.mysql");

        config([
            'database' => [
                'default' => 'mysql',
                'connections' => [
                    'mysql' => array_merge($settings, [
                        'driver' => 'mysql',
                        'host' => $request->input('database_hostname'),
                        'port' => $request->input('database_port'),
                        'database' => $request->input('database_name'),
                        'username' => $request->input('database_username'),
                        'password' => $request->input('database_password'),
                        'prefix' => $request->input('database_prefix')
                    ]),
                ],
            ],
        ]);

        DB::purge();

        try {
            DB::connection()->getPdo();

            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the .env file.
     *
     * @return bool|string
     */
    private function updateEnvFile(Request $request)
    {
        try {
            set_env('APP_KEY', 'base64:'.base64_encode(Str::random(32)));
            set_env('APP_URL', route('home'));
            set_env('APP_DEBUG', 'false');
            set_env('DEMO_MODE', 'false');
            set_env('APP_VERSION', config('appinfo.version'));
            set_env('DB_HOST', $request->input('database_hostname'));
            set_env('DB_PORT', $request->input('database_port'));
            set_env('DB_DATABASE', $request->input('database_name'));
            set_env('DB_PREFIX', $request->input('database_prefix'));
            set_env('DB_USERNAME', $request->input('database_username'));
            set_env('DB_PASSWORD', $request->input('database_password'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return true;
    }

    /**
     * Check DB is empty or not
     *
     * @return bool
     */
    private function isDBEmpty()
    {
        return !Schema::hasTable('user');
    }

    /**
     * Migrate the database.
     * @return bool|string
     */
    private function migrateDatabase()
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Artisan::call('migrate', ['--force' => true]);
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } catch (\Exception $e){
            return $e->getMessage();
        }

        return true;
    }

    /**
     * Create the admin user.
     *
     * @param  Request  $request
     * @param  bool  $db_empty
     * @return bool|string
     */
    private function createAdminUser(Request $request, $db_empty)
    {
        try {
            $ipInfo = user_ip_info();

            if ($db_empty) {
                /* Create admin user if the DB was empty */
                $user = User::create([
                    'user_type' => 'admin',
                    'name' => $request->input('name'),
                    'username' => $request->input('username'),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                    'country' => $ipInfo->location->country_code,
                    'country_code' => $ipInfo->location->country,
                ]);
                $user->markEmailAsVerified();

                /* Installing Default Country by IP */
                $country_code = $ipInfo->location->country_code;
                if($ipInfo->location->country_code == "Other")
                    $country_code = "us";
                // Default Country SQL File
                $filePath = storage_path('database/geonames/countries/' . strtolower($country_code) . '.sql');
                if (!File::exists($filePath)) {
                    return false;
                }
                // Import the SQL file
                importSqlFile(DB::connection()->getPdo(), $filePath, DB::getTablePrefix());

                $country = Countries::where('code',$country_code)->first();
                $update = $country->update(['active' => '1',]);
                if($update)
                    Option::updateOptions('specific_country', $country_code);
            } else {

                $prefix = DB::getTablePrefix();

                /* Get all the admins from the old DB */
                $admins = DB::select("SELECT * FROM `{$prefix}admins`");
                foreach ($admins as $admin) {

                    if ($user = User::where('email', $admin->email)->first()) {
                        /* if a user exits with the same email then change the user type to 'admin' */
                        $user->update(['user_type' => 'admin']);
                    } elseif (User::where('username', $admin->username)->exists()) {

                        $username = $admin->username.'_admin';
                        $user = User::create([
                            'user_type' => 'admin',
                            'name' => $admin->name,
                            'username' => $username,
                            'email' => $admin->email,
                            'password' => $admin->password_hash,
                            'image' => $admin->image,
                            'country' => $ipInfo->location->country_code,
                            'country_code' => $ipInfo->location->country,
                        ]);
                    } else {
                        $user = User::create([
                            'user_type' => 'admin',
                            'name' => $admin->name,
                            'username' => $admin->username,
                            'email' => $admin->email,
                            'password' => $admin->password_hash,
                            'image' => $admin->image,
                            'country' => $ipInfo->location->country_code,
                            'country_code' => $ipInfo->location->country,
                        ]);
                    }

                    $user->markEmailAsVerified();

                    /* Update the admin id in blog table */
                    Blog::where('author', $admin->id)->update(['author' => $user->id]);

                    /* Update the admin id in blog_comments table */
                    BlogComment::where('user_id', $admin->id)
                        ->where('is_admin', '1')->update(['user_id' => $user->id]);
                }
            }
        } catch (\Exception $e){
            return $e->getMessage();
        }

        return true;
    }

    /**
     * Write the installed status to the .env file.
     *
     * @return bool|string
     */
    private function installed()
    {
        try {
            set_env('APP_INSTALLED', 'true');
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return true;
    }

    /**
     * Update old database if exists
     * @return bool|string
     */
    private function updateOldDatabase()
    {
        /* Check database is empty or not */
        if (!$this->isDBEmpty()) {

            try {

                DB::statement('SET FOREIGN_KEY_CHECKS=0;');

                $prefix = DB::getTablePrefix();

                DB::unprepared("DROP TABLE `{$prefix}adsense`");

                if(!Schema::hasColumn('blog', 'slug')) {
                    DB::unprepared(
                        "ALTER TABLE `{$prefix}blog`
                                    ADD `slug` VARCHAR(255) NULL DEFAULT NULL AFTER `title`;"
                    );
                }

                DB::unprepared(
                    "ALTER TABLE `{$prefix}blog_categories`
                                ADD `created_at` TIMESTAMP NULL DEFAULT NULL AFTER `active`,
                                ADD `updated_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;"
                );

                DB::unprepared(
                    "ALTER TABLE `{$prefix}blog_comment`
                                CHANGE `created_at` `created_at` TIMESTAMP NULL DEFAULT NULL;
                            ALTER TABLE `{$prefix}blog_comment`
                                ADD `updated_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;"
                );

                DB::unprepared(
                    "ALTER TABLE `{$prefix}catagory_main`
                                CHANGE `cat_id` `id` INT(11) NOT NULL AUTO_INCREMENT,
                                CHANGE `cat_name` `name` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                CHANGE `cat_order` `order` INT(10) NULL DEFAULT NULL;
                                RENAME TABLE `{$prefix}catagory_main` TO `{$prefix}categories`;"
                );

                DB::unprepared(
                    "ALTER TABLE `{$prefix}catagory_sub`
                                CHANGE `sub_cat_id` `id` INT(11) NOT NULL AUTO_INCREMENT,
                                CHANGE `main_cat_id` `category_id` INT(11) NOT NULL,
                                CHANGE `sub_cat_name` `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                CHANGE `cat_order` `order` MEDIUMINT(8) NOT NULL;
                                RENAME TABLE `{$prefix}catagory_sub` TO `{$prefix}sub_categories`;"
                );

                DB::unprepared(
                    "ALTER TABLE `{$prefix}custom_data`
                                CHANGE `product_id` `post_id` INT(11) NULL DEFAULT NULL;"
                );

                DB::unprepared(
                    "ALTER TABLE `{$prefix}custom_fields`
                                CHANGE `custom_id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                                CHANGE `custom_order` `order` INT(10) NULL DEFAULT NULL,
                                CHANGE `custom_anycat` `anycat` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                                CHANGE `custom_catid` `category_id` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                                CHANGE `custom_subcatid` `sub_category_id` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                CHANGE `custom_title` `title` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                                CHANGE `custom_type` `type` VARCHAR(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                                CHANGE `custom_options` `options` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                                CHANGE `custom_required` `required` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
                                CHANGE `custom_name` `name` VARCHAR(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                                CHANGE `custom_default` `default` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                                CHANGE `custom_min` `min` INT(11) UNSIGNED NOT NULL DEFAULT '0',
                                CHANGE `custom_max` `max` INT(11) UNSIGNED NOT NULL DEFAULT '0';"
                );

                DB::unprepared(
                    "ALTER TABLE `{$prefix}custom_options`
                                ADD `translations` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `title`;"
                );

                DB::unprepared(
                    "ALTER TABLE `{$prefix}faq_entries`
                                   CHANGE `faq_id` `id` MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT;"
                );

                DB::unprepared(
                    "ALTER TABLE `{$prefix}favads`
                                CHANGE `product_id` `post_id` INT(11) NULL DEFAULT NULL;
                                RENAME TABLE `{$prefix}favads` TO `{$prefix}post_favorites`;"
                );

                //DB::unprepared("DROP TABLE `{$prefix}countries`");

                DB::unprepared(
                    "ALTER TABLE `{$prefix}languages`
                                DROP `file_name`,
                                DROP `default`;
                             ALTER TABLE `{$prefix}languages`
                                ADD `position` INT(11) NOT NULL DEFAULT '999' AFTER `active`;"
                );

                DB::unprepared(
                    "ALTER TABLE `{$prefix}messages`
                                CHANGE `message_id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                                CHANGE `message_date` `created_at` TIMESTAMP NULL DEFAULT NULL;"
                );
                DB::unprepared(
                    "ALTER TABLE `{$prefix}messages`
                                ADD `updated_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;"
                );

                DB::unprepared(
                    "RENAME TABLE `{$prefix}payments` TO `{$prefix}payment_gateways`;
                            ALTER TABLE `{$prefix}payment_gateways`
                               CHANGE `payment_id` `id` MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT;
                            UPDATE `{$prefix}payment_gateways`
                                SET `payment_folder` = 'two_checkout'
                                WHERE `payment_folder` = '2checkout';"
                );

                DB::unprepared(
                    "ALTER TABLE `{$prefix}plans`
                                CHANGE `monthly_price` `monthly_price` DOUBLE NULL DEFAULT NULL,
                                CHANGE `annual_price` `annual_price` DOUBLE NULL DEFAULT NULL,
                                CHANGE `lifetime_price` `lifetime_price` DOUBLE NULL DEFAULT NULL,
                                CHANGE `status` `status` TINYINT(4) NOT NULL DEFAULT '1',
                                CHANGE `date` `created_at` TIMESTAMP NULL DEFAULT NULL;
                            ALTER TABLE `{$prefix}plans`
                                ADD `updated_at`   TIMESTAMP NULL DEFAULT NULL AFTER `created_at`,
                                ADD `description`  TEXT      NULL DEFAULT NULL AFTER `name`,
                                ADD `translations` LONGTEXT  NULL DEFAULT NULL AFTER `description`,
                                ADD `position`     INT(11)   NULL DEFAULT NULL AFTER `taxes_ids`;"
                );

                DB::unprepared(
                    "ALTER TABLE `{$prefix}plan_options`
                                ADD `translations` LONGTEXT  NULL DEFAULT NULL AFTER `title`,
                                ADD `created_at`   TIMESTAMP NULL DEFAULT NULL AFTER `active`,
                                ADD `updated_at`   TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;"
                );

                DB::unprepared(
                    "ALTER TABLE `{$prefix}taxes`
                                CHANGE `datetime` `created_at` TIMESTAMP NULL DEFAULT NULL;
                            ALTER TABLE `{$prefix}taxes`
                                ADD `updated_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;"
                );

                DB::unprepared(
                    "ALTER TABLE `{$prefix}testimonials`
                                ADD `translations` LONGTEXT  NULL DEFAULT NULL AFTER `image`,
                                ADD `created_at`   TIMESTAMP NULL DEFAULT NULL AFTER `translations`,
                                ADD `updated_at`   TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;"
                );

                if (!Schema::hasColumn('transaction', 'details')) {
                    DB::unprepared(
                        "ALTER TABLE `{$prefix}transaction`
                                    ADD `details` TEXT NULL DEFAULT NULL AFTER `taxes_ids`;"
                    );
                }
                if (!Schema::hasColumn('transaction', 'currency_code')) {
                    DB::unprepared(
                        "ALTER TABLE `{$prefix}transaction`
                                    ADD `currency_code` VARCHAR(3) NULL DEFAULT NULL AFTER `base_amount`;"
                    );
                }

                DB::unprepared(
                    "ALTER TABLE `{$prefix}transaction`
                                ADD `coupon`     TEXT      NULL DEFAULT NULL AFTER `details`,
                                ADD `created_at` TIMESTAMP NULL DEFAULT NULL AFTER `coupon`,
                                ADD `updated_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;
                            ALTER TABLE `{$prefix}transaction`
                                CHANGE `seller_id` `user_id` TEXT NULL DEFAULT NULL,
                                CHANGE `status` `status` ENUM('pending','success','failed','cancel') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                                CHANGE `payment_id` `payment_id` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                                CHANGE `transaction_gatway` `transaction_gatway` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;"
                );
                DB::unprepared("UPDATE `{$prefix}transaction` SET `transaction_method` = 'membership' WHERE `transaction_method` = 'Subscription'");

                $transactions = DB::select("SELECT * FROM `{$prefix}transaction`");
                foreach ($transactions as $transaction) {
                    if(strlen($transaction->transaction_time) > 4){
                        $created = Carbon::createFromTimestamp($transaction->transaction_time);
                        DB::unprepared(
                            "UPDATE `{$prefix}transaction` SET `created_at` = '{$created}', `updated_at` = '{$created}' WHERE `id` = {$transaction->id}"
                        );
                    }
                }

                DB::unprepared(
                    "ALTER TABLE `{$prefix}upgrades`
                                CHANGE `interval` `interval` ENUM ('MONTHLY', 'YEARLY', 'LIFETIME') NULL DEFAULT NULL;"
                );

                /* update user type to user because it is not required here */
                DB::unprepared("UPDATE `{$prefix}user` SET `user_type` = 'user'");

                DB::unprepared(
                    "ALTER TABLE `{$prefix}user`
                                CHANGE `group_id` `group_id` VARCHAR(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'free',
                                CHANGE `user_type` `user_type` ENUM('user','admin') NULL DEFAULT 'user',
                                CHANGE `status` `status` TINYINT(1) NOT NULL DEFAULT '1',
                                CHANGE `password_hash` `password` VARCHAR(255)  NULL DEFAULT NULL,
                                CHANGE `image` `image` VARCHAR(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default_user.png';
                            ALTER TABLE `{$prefix}user`
                                ADD `email_verified_at` TIMESTAMP    NULL DEFAULT NULL AFTER `oauth_uid`,
                                ADD `remember_token`    VARCHAR(100) NULL DEFAULT NULL AFTER `email_verified_at`;"
                );

                DB::unprepared("UPDATE `{$prefix}user` SET `email_verified_at` = '".Carbon::now()."' WHERE `status` = '1';");
                DB::unprepared("UPDATE `{$prefix}user` SET `status` = '1' WHERE `status` = '0';");
                DB::unprepared("UPDATE `{$prefix}user` SET `status` = '0' WHERE `status` = '2';");

                if(!Schema::hasColumn('user', 'country_code')) {
                    DB::unprepared(
                        "ALTER TABLE `{$prefix}user`
                                ADD `country_code` CHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `country`;"
                    );
                }

                DB::unprepared(
                    "ALTER TABLE `{$prefix}reviews`
                                DROP `date`,
                                CHANGE `reviewID` `id` INT(11) NOT NULL AUTO_INCREMENT,
                                CHANGE `productID` `post_id` INT(11) NOT NULL,
                                CHANGE `comments` `comments` MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
                            ALTER TABLE `{$prefix}reviews`
                                ADD `created_at` TIMESTAMP NULL DEFAULT NULL AFTER `publish`,
                                ADD `updated_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`"
                );

                DB::unprepared("ALTER TABLE `{$prefix}product` DROP `expire_date`");
                DB::unprepared(
                    "ALTER TABLE `{$prefix}product`
                                ADD `expire_date` TIMESTAMP NULL DEFAULT NULL AFTER `updated_at`;"
                );

                DB::unprepared("UPDATE `{$prefix}product` SET `updated_at` = null");
                DB::unprepared("UPDATE `{$prefix}product` SET `featured_exp_date` = null");
                DB::unprepared("UPDATE `{$prefix}product` SET `urgent_exp_date` = null");
                DB::unprepared("UPDATE `{$prefix}product` SET `highlight_exp_date` = null");

                DB::unprepared(
                    "ALTER TABLE `{$prefix}product`
                                CHANGE `product_name` `title` VARCHAR(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                                CHANGE `category` `category_id` INT(11) NULL DEFAULT NULL,
                                CHANGE `sub_category` `sub_category_id` INT(11) NULL DEFAULT NULL,
                                CHANGE `screen_shot` `images` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                                CHANGE `city` `city_id` CHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                                CHANGE `state` `state_id` CHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                                CHANGE `country` `country_code` CHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
                                CHANGE `created_at` `created_at` TIMESTAMP NULL DEFAULT NULL,
                                CHANGE `updated_at` `updated_at` TIMESTAMP NULL DEFAULT NULL;"
                );

                DB::unprepared(
                    "RENAME TABLE `{$prefix}product` TO `{$prefix}posts`;"
                );

                $posts = DB::select("SELECT * FROM `{$prefix}posts`");
                foreach ($posts as $post) {
                    $created_at = $post->created_at;
                    $ad_duration = 30;
                    $expire_date = Carbon::parse($created_at)->addDays($ad_duration);

                    DB::unprepared(
                        "UPDATE `{$prefix}posts` SET `expire_date` = '{$expire_date}', `updated_at` = '{$created_at}' WHERE `id` = {$post->id}"
                    );
                }

                Option::updateOptions('lang', 'en');
                Option::updateOptions('default_user_plan', 'free');
                Option::updateOptions('email_sub_listing_rejected', 'Sorry! {SELLER_NAME} Your ad has been rejected');
                Option::updateOptions('email_message_listing_rejected', '<p>Sorry! Your ad to {ADTITLE} on {SITE_TITLE} has been rejected.</p><p>Thanks for your submission!</p><p>Regards,<br>{SITE_TITLE} Team</p>');

                DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }

        return true;
    }
}
