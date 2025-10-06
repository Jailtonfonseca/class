<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Clear Cache */
Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    quick_alert_success('Cache cleared.');
    return back();
});

// Install routes
Route::prefix('install')->group(function () {
    Route::middleware('notInstalled')->group(function () {
        Route::get('/', 'InstallController@index')->name('install');
        Route::get('/requirements', 'InstallController@requirements')->name('install.requirements');
        Route::get('/permissions', 'InstallController@permissions')->name('install.permissions');
        Route::get('/database', 'InstallController@database')->name('install.database');
        Route::post('/database', 'InstallController@updateEnv');
        Route::get('/update-database', 'InstallController@updateDatabase')->name('install.update_database');
        Route::get('/admin', 'InstallController@admin')->name('install.admin');
        Route::post('/admin', 'InstallController@createAdmin');
    });

    Route::get('/complete', 'InstallController@complete')->name('install.complete');
});

/* Update routes */
Route::prefix('update')->middleware('installed')->group(function () {
    Route::get('/', 'UpdateController@index')->name('update');
    Route::post('/run', 'UpdateController@run')->name('update.run');
    Route::get('/complete', 'UpdateController@complete')->name('update.complete');
});

/* Routs With Laravel Localization */
if (!config('settings.include_language_code')) {
    $middlewares = [
        'middleware' => ['installed', 'checkUserIsBanned', 'quickcms.localize'],
    ];
} else {
    $middlewares = [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['installed', 'checkUserIsBanned', 'localize', 'localizationRedirect', 'localeSessionRedirect'],
    ];
}

Route::group($middlewares, function () {

    /* AUTH ROUTES */
    require __DIR__.'/auth.php';

    Route::get('fake', 'FakeController@index')->name('fakedata');

    /* FRONTEND ROUTES */
    Route::controller('HomeController')->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('faq', 'faqs')->name('faqs');
        Route::get('testimonials', 'testimonials')->name('testimonials');
        Route::get('contact', 'contact')->name('contact');
        Route::post('contact', 'contactSend')->name('contact');
        Route::get('feedback', 'feedback')->name('feedback');
        Route::post('feedback', 'feedbackSend')->name('feedback');
        Route::get('pricing', 'pricing')->name('pricing');
        Route::get('page/{slug}', 'page')->name('page');
        Route::post('newsletter', 'newsletter')->name('newsletter');
        Route::get('theme/{theme}', 'changetheme')->name('changetheme');

        if (!config('settings.include_language_code')) {
            Route::get('{lang}/{country_code?}', 'localize')->where('lang', '^[a-z]{2}$')->name('localize');
        }
    });

    Route::controller('BlogController')->group(function () {
        Route::get('/blog', 'index')->name('blog.index');
        Route::get('blog/category/{slug}', 'category')->name('blog.category');
        Route::get('blog/tags/{slug}', 'tag')->name('blog.tag');
        Route::get('blog/{id}/{slug?}', 'single')->name('blog.single');
        Route::post('blog/{id}/{slug?}', 'comment')->name('blog.comment');
    });

    Route::post('ajaxurl', 'UserAjaxController@index')->name('ajaxurl');

    Route::get('profile/{username}', 'ProfileController@index')->name('profile');

    Route::controller('PostController')->group(function () {
        Route::post('posts/upload', 'upload')->name('posts.upload');
        Route::delete('posts/revert', 'revert')->name('posts.revert');
        Route::post('posts/getsubcatbyidList', 'getsubcatbyidList')->name('posts.getsubcatbyidList');
        Route::post('posts/getCustomFieldByCatID', 'getCustomFieldByCatID')->name('posts.getCustomFieldByCatID');
        Route::post('posts/searchCityFromCountry', 'searchCityFromCountry')->name('posts.searchCityFromCountry');
        Route::get('ad/{post}/{slug?}', 'single')->name('posts.single');
    });
    Route::resource('posts', 'PostController')->except(['show']);

    // Search
    Route::controller('SearchController')->group(function () {
        Route::get('/listing', 'index')->name('search.index');
        Route::get('/search?keywords={search}', 'index')->name('suggestion.search');
        Route::get('/category/{category_slug}', 'listingByCategory')->name('search.category');
        Route::get('/category/{category_slug}/{subcategory_slug}', 'listingBySubcategory')->name('search.subcategory');
        Route::get('/location/{city}/{id}', 'listingByCity')->name('search.city');
    });

    Route::controller('ReviewController')->group(function () {
        Route::post('reviews/{post_id}', 'index')->name('review.index');
        Route::post('reviews/average/{post_id}', 'averageRating')->name('review.average');
        Route::post('saveRating/{post_id}', 'saveRating')->name('review.saveRating');
    });

    /* FRONTEND LOGIN REQUIRED */
    Route::group([ 'middleware' => ['auth']], function () {
        Route::controller('PostController')->group(function () {
            Route::get('posts/my-listing', 'myListing')->name('posts.myListing');
            Route::get('posts/status/{status}', 'status')->name('posts.status');
            Route::get('posts/my-favorite', 'myFavorite')->name('posts.myFavorite');
            Route::post('posts/setFavorite', 'setFavorite')->name('posts.setFavorite');
            Route::post('posts/setShowHide/{id}', 'setShowHide')->name('posts.setShowHide');
            Route::post('posts/deleteMyListing/{id}', 'deleteMyListing')->name('posts.deleteMyListing');
        });
    });

    Route::group(['namespace' => 'User', 'middleware' => ['auth']], function () {
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');
        Route::get('transactions', 'TransactionController@index')->name('transactions');
        Route::get('invoice/{transaction}', 'TransactionController@invoice')->name('invoice');
        Route::get('subscription', 'SubscribeController@index')->name('subscription');
        Route::post('subscription/cancel', 'SubscribeController@cancelSubscription')->name('subscription.cancel');

        Route::controller('SettingsController')->group(function () {
            Route::get('settings', 'index')->name('settings');
            Route::post('settings/edit-profile', 'editProfile')->name('settings.editProfile')->middleware('demo');
            Route::post('settings/edit-billing', 'editBilling')->name('settings.editBilling');
        });

        Route::controller('CheckoutController')->group(function () {
            Route::get('checkout', 'index')->name('checkout.index');
            Route::post('checkout', 'index');
        });
    });

    /* PAYMENT ROUTES */
    Route::get('payment/{transaction}', 'User\PaymentController@index')->name('payment.index');
    Route::post('payment/{transaction}/pay', 'User\PaymentController@pay')->name('payment.pay');
    Route::any('ipn/{gateway}', 'User\PaymentMethods\PaymentController@ipn')->name('ipn');
    Route::post('webhook/{gateway}', 'User\PaymentMethods\PaymentController@webhook')->name('webhook');

    /* ADMIN ROUTES */
    Route::name('admin.')->prefix(admin_url())->namespace('Admin')->middleware(['admin', 'demo'])->group(function () {

        Route::redirect('/', 'admin/dashboard');

        Route::get('dashboard', 'DashboardController@index')->name('dashboard');

        Route::controller('NotificationController')->group(function () {
            Route::get('/notifications', 'index')->name('notifications.index');
            Route::get('notifications/view/{id}', 'view')->name('notifications.view');
            Route::get('notifications/markasread', 'markAsRead')->name('notifications.markasread');
            Route::delete('notifications/deleteallread', 'deleteAllRead')->name('notifications.deleteallread');
        });

        Route::controller('UserController')->group(function () {
            Route::post('users/delete', 'delete')->name('users.delete');
            Route::delete('users/{user}/edit/delete/avatar', 'deleteAvatar')->name('users.deleteAvatar');
            Route::post('users/{user}/edit/sentmail', 'sendMail')->name('users.sendmail');
            Route::get('users/{user}/edit/password', 'password')->name('users.password');
            Route::post('users/{user}/edit/password', 'updatePassword')->name('users.password');
            Route::post('users/{user}/edit/updateplan', 'updatePlan')->name('users.plan');
            Route::post('users/{user}/login', 'loginAsUser')->name('users.login');
        });
        Route::resource('users', 'UserController');

        Route::controller('TemplateController')->group(function () {
            Route::get('templates', 'index')->name('templates.index');
            Route::post('templates', 'templatesActive')->name('templates.active');
        });

        Route::resource('taxes', 'TaxController');
        Route::post('taxes.delete', 'TaxController@delete')->name('taxes.delete');

        Route::resource('transactions', 'TransactionController');
        Route::post('transactions.delete', 'TransactionController@delete')->name('transactions.delete');

        Route::resource('plans', 'PlanController');
        Route::post('plans.delete', 'PlanController@delete')->name('plans.delete');
        Route::post('plans.reorder', 'PlanController@reorder')->name('plans.reorder');

        Route::resource('planoption', 'PlanOptionController');
        Route::post('planoption.delete', 'PlanOptionController@delete')->name('planoption.delete');
        Route::post('planoption.reorder', 'PlanOptionController@reorder')->name('planoption.reorder');

        Route::resource('coupons', 'CouponController');
        Route::post('coupons.delete', 'CouponController@delete')->name('coupons.delete');

        Route::resource('testimonials', 'TestimonialController');
        Route::post('testimonials.delete', 'TestimonialController@delete')->name('testimonials.delete');

        Route::resource('advertisements', 'AdsController');

        Route::resource('pages', 'PageController');

        Route::resource('faqs', 'FaqController');

        Route::controller('PaymentGatewayController')->group(function () {
            Route::get('/payment-gateways', 'index')->name('gateways.index');
            Route::get('payment-gateways/{gateway}/edit', 'edit')->name('gateways.edit');
            Route::post('payment-gateways/{gateway}', 'update')->name('gateways.update');
        });

        Route::controller('EmailTemplateController')->group(function () {
            Route::get('email-templates', 'index')->name('mailtemplates.index');
            Route::post('email-templates/update', 'update')->name('mailtemplates.update');
        });

        Route::resource('subscriber', 'SubscriberController');

        Route::controller('LanguageController')->group(function () {
            Route::post('languages/reorder', 'reorder')->name('languages.reorder');
            Route::get('languages/translate/{code}', 'translate')->name('languages.translates');
            Route::post('languages/{language}/translate', 'translateUpdate')->name('languages.translates.update');
        });
        Route::resource('languages', 'LanguageController');

        Route::get('settings', 'SettingsController@index')->name('settings.index');
        Route::post('settings', 'SettingsController@update')->name('settings.update');

        Route::resource('blogs', 'BlogController');
        Route::post('blog/delete', 'BlogController@delete')->name('blogs.delete');

        Route::resource('blog/categories', 'BlogCategoryController')->names('blog.category');
        Route::post('blog/categories/reorder', 'BlogCategoryController@reorder')->name('blog.category.reorder');
        Route::post('blog/categories/delete', 'BlogCategoryController@delete')->name('blog.category.delete');

        Route::get('blog/comments', 'BlogCommentController@index')->name('blog.comments.index');
        Route::post('blog/comments/delete', 'BlogCommentController@delete')->name('blog.comments.delete');
        Route::post('blog/comments/{id}/approve', 'BlogCommentController@approve')->name('blog.comments.approve');

        Route::resource('plugins', 'PluginsController');
        Route::post('plugin/{id}/enable', 'PluginsController@enable')->name('plugins.enable');
        Route::post('plugin/{id}/disable', 'PluginsController@disable')->name('plugins.disable');

        ///////////////////////////
        /// Quickad Classified ///
        /////////////////////////

        Route::controller('PostController')->group(function () {
            Route::get('posts', 'index')->name('posts.index');
            Route::get('posts/create', 'create')->name('posts.create');
            Route::post('posts/store', 'store')->name('posts.store');
            Route::get('posts/edit/{id}', 'edit')->name('posts.edit');
            Route::put('post/update/{id}', 'update')->name('posts.update');
            Route::post('posts.delete', 'delete')->name('posts.delete');
            Route::post('posts/approve/{id}', 'approve')->name('posts.approve');
            Route::post('posts/upload', 'upload')->name('posts.upload');
            Route::delete('/posts/revert', 'revert')->name('posts.revert');
            Route::get('posts/status/{status?}', 'index')->name('posts.status');
            Route::post('posts/searchCityFromCountry', 'searchCityFromCountry')->name('posts.searchCityFromCountry');
            Route::post('posts/getCustomFieldByCatID', 'getCustomFieldByCatID')->name('posts.getCustomFieldByCatID');
            Route::get('posts/get-sub-categories', 'getSubCategories')->name('posts.get-sub-categories');
        });

        Route::controller('ReviewController')->group(function () {
            Route::get('posts/reviews/{id?}', 'index')->name('reviews.index');
            Route::get('posts/reviews/edit/{id}', 'edit')->name('reviews.edit');
            Route::post('posts/reviews/update/{id}', 'update')->name('reviews.update');
            Route::post('posts/reviews/delete', 'delete')->name('reviews.delete');
        });

        Route::resource('currencies', 'CurrencyController');
        Route::controller('CurrencyController')->group(function () {
            Route::post('currencies/delete', 'delete')->name('currencies.delete');
        });

        Route::resource('timezones', 'TimezoneController');
        Route::controller('TimezoneController')->group(function () {
            Route::post('timezones/delete', 'delete')->name('timezones.delete');
        });
        // countries route
        Route::resource('countries', 'CountryController');
        Route::controller('CountryController')->group(function () {
            Route::post('countries/delete', 'delete')->name('countries.delete');
        });

        // Regions routes
        Route::resource('regions', 'RegionController')->except('index');
        Route::controller('RegionController')->group(function () {
            Route::get('countries/{countryCode}/admins1', 'index')->name('countries.regions.index');
            Route::post('regions/delete', 'delete')->name('regions.delete');
        });

        // District routes
        Route::resource('districts', 'DistrictController')->except('index');
        Route::controller('DistrictController')->group(function () {
            Route::get('admins1/{admin1Code}/admins2', 'index')->name('regions.districts.index');
            Route::post('districts/delete', 'delete')->name('districts.delete');
        });

        // Cities route
        Route::resource('cities', 'CitiesController')->except('index');
        Route::controller('CitiesController')->group(function () {
            Route::get('country/{code}/cities', 'index')->name('cities.index');
            Route::get('admins1/{code}/cities', 'index')->name('admins1.cities.index');
            Route::get('admins2/{code}/cities', 'index')->name('admins2.cities.index');
            Route::get('regions/{regionCode}/districts', 'getDistricts')->name('regions.districts');
            Route::post('cities/delete', 'delete')->name('cities.delete');
        });

        // Categories route
        Route::resource('categories', 'CategoryController');
        Route::controller('CategoryController')->group(function () {
            Route::post('categories/reorder', 'reorder')->name('categories.reorder');
            Route::post('subcategories/add', 'subCategoriesAdd')->name('categories.subcategories.add');
            Route::post('subcategories/{id}/update', 'subCategoriesUpdate')->name('categories.subcategories.update');
            Route::post('subcategories/delete', 'subCategoriesDelete')->name('categories.subcategories.delete');
            Route::post('subcategories/reorder', 'subCategoriesReorder')->name('categories.subcategories.reorder');
            Route::get('categories/{id}/getsubcategories', 'getSubCategories')->name('categories.getsubcategories');
        });


        Route::resource('customfields','CustomFieldController');
        Route::controller('CustomFieldController')->group(function () {
            Route::post('customfields/delete', 'delete')->name('customfields.delete');
        });

    });
});
