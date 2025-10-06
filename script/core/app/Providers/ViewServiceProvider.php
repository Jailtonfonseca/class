<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Cities;
use App\Models\Language;
use App\Models\Notification;
use App\Models\Option;
use App\Models\Page;
use App\Models\Plan;
use App\Models\Post;
use App\Models\Regions;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\ViewServiceProvider as ConcreteViewServiceProvider;

class ViewServiceProvider extends ConcreteViewServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $activeTheme = active_theme();

        if (env('APP_INSTALLED')) {

            view()->composer('*', function ($view) {
                $settings = Option::all()->pluck('option_value', 'option_name');
                foreach ($settings as $key => $value) {
                    $settings[$key] = Str::isJson($value) ? json_decode($value) : $value;
                }
                $view->with([
                    'settings' => array_to_object($settings),
                    'activeTheme' => active_theme(),
                    'activeThemeAssets' => active_theme(true)
                ]);
            });

            if (is_admin_url()) {

                /* Admin pages */
                view()->composer('*', function ($view) {
                    $admin_languages = Language::where('active', 1)->orderBy('position')->get();
                    $view->with('admin_languages', $admin_languages);
                });

                view()->composer('admin.includes.header', function ($view) {
                    $notifications = Notification::orderbyDesc('id')->limit(20)->get();
                    $totalUnreadNotifications = Notification::where('status', 0)->get()->count();
                    $view->with([
                        'notifications' => $notifications,
                        'totalUnreadNotifications' => $totalUnreadNotifications,
                    ]);
                });

                view()->composer('admin.includes.sidebar', function ($view) {
                    $totalUnapprovedComments = BlogComment::where('active', 0)->count();
                    $view->with([
                        'totalUnapprovedComments' => ($totalUnapprovedComments > 50) ? "50+" : $totalUnapprovedComments,
                    ]);
                });

                view()->composer('admin.users.userdetails', function ($view) {
                    $plans = Plan::where('status', 1)->get();
                    $view->with([
                        'plans' => $plans,
                    ]);
                });

            } else {
                /* Frontend pages */

                view()->composer('*', function ($view) {
                    $languages = Language::where('active', 1)->orderBy('position', 'asc')->get();
                    $view->with(['languages' => $languages, 'session_country' => get_user_country()]);
                });

                view()->composer($activeTheme . 'blog.sidebar', function ($view) {
                    $blogCategories = BlogCategory::all();
                    $recentBlogs = Blog::where('status', 'publish')->orderbyDesc('id')->limit(3)->get();

                    $tags = [];
                    $data = Blog::where('status', 'publish')->select('tags')->get();
                    foreach ($data as $value) {
                        if (!empty($value->tags)) {
                            $tag = explode(',', $value->tags);
                            $tags = array_merge($tags, $tag);
                        }
                    }
                    $tags = array_unique($tags);

                    $testimonials = Testimonial::limit(5)->get();

                    $view->with(['blogCategories' => $blogCategories, 'recentBlogs' => $recentBlogs, 'blogTags' => $tags, 'testimonials' => $testimonials]);
                });

                view()->composer($activeTheme . 'layouts.includes.footer', function ($view) {
                    $pages = Page::where('active', 1)->where(
                        function ($query) {
                            $query->where('translation_lang', get_lang())
                                ->orWhereNull('translation_lang');
                        }
                    )->get();
                    $view->with('pages', $pages);
                });

                view()->composer($activeTheme . 'layouts.includes.header', function ($view) {

                    $popularCities = Cities::select('id','name')
                        ->where(array(
                            'country_code' => get_user_country(),
                            'active' => '1'
                        ))
                        ->orderbyDesc('population')->limit(18)->get();

                    $regions = Regions::select('id','code','name')
                        ->where(array(
                            'country_code' => get_user_country(),
                            'active' => '1'
                        ))
                        ->orderBy('name')->get();

                    $view->with(['popularCities' => $popularCities, 'regions' => $regions]);
                });

                view()->composer($activeTheme . 'user.includes.dashboard-sidebar', function ($view) {
                    $totalMyPosts = Post::where(array(
                        'user_id' => request()->user()->id
                    ))->count();

                    $totalActivePosts = Post::where(array(
                        'user_id' => request()->user()->id,
                        'status' => Post::STATUS_ACTIVE
                    ))->count();

                    $totalPendingPosts = Post::where(array(
                        'user_id' => request()->user()->id,
                        'status' => Post::STATUS_PENDING
                    ))->count();

                    $totalExpirePosts = Post::where(array(
                        'user_id' => request()->user()->id,
                        'status' => Post::STATUS_EXPIRE
                    ))->count();

                    $totalRejectedPosts = Post::where(array(
                        'user_id' => request()->user()->id,
                        'status' => Post::STATUS_REJECTED
                    ))->count();

                    $totalHiddenPosts = Post::where(array(
                        'user_id' => request()->user()->id,
                        'hide' => '1'
                    ))->count();

                    $user = Auth::user();
                    $totalFavPosts = $user->favorites()->count();

                    $view->with([
                        'totalMyPosts' => $totalMyPosts,
                        'totalActivePosts' => $totalActivePosts,
                        'totalPendingPosts' => $totalPendingPosts,
                        'totalExpirePosts' => $totalExpirePosts,
                        'totalRejectedPosts' => $totalRejectedPosts,
                        'totalHiddenPosts' => $totalHiddenPosts,
                        'totalFavPosts' => $totalFavPosts,
                    ]);
                });

            }

        }
    }
}
