<?php

use Illuminate\Support\Facades\Route;

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

    /* FRONTEND LOGIN REQUIRED */
    Route::group(['namespace' => 'User', 'middleware' => ['auth']], function () {
        Route::get('message', 'InboxController@index')->name('message.index');
        Route::post('quickchat-ajaxurl', 'QuickchatController@index')->name('quickchat-ajaxurl');
    });

    /* ADMIN ROUTES */
    Route::name('admin.')->prefix(admin_url())->namespace('Admin')->middleware(['admin', 'demo'])->group(function () {
        Route::get('messages', 'MessagesController@index')->name('messages.index');
        Route::post('messages/delete', 'MessagesController@delete')->name('messages.delete');
        Route::get('plugins/quickchatajax', 'SettingsController@index')->name('quickchatajax.index');
        Route::post('plugins/quickchatajax', 'SettingsController@update');
    });
});
