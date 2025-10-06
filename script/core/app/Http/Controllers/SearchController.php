<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CustomField;
use App\Models\Post;
use App\Models\SubCategory;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->activeTheme = active_theme();
    }

    /**
     * Display listings of the resource.
     */
    public function index(Request $request, $category_id = null, $subcategory_id = null, $city_id = null)
    {
        $page_limit = 12;
        $order_by = "desc";
        $filter = "";
        $page_title = ___('Search Ads Listing');

        $keywords = $request->keywords;
        $min_price = $request->min_price;
        $max_price = $request->max_price;
        $sort_by = $request->sort;
        $order_by = $request->order;
        $category = array();
        $subCategory = array();
        $catTitle = "";
        $subCatTitle = "";

        if ($category_id == null)
            $category_id = $request->cat;
        if ($subcategory_id == null)
            $subcategory_id = $request->subcat;

        $conditions = [
            'status' => Post::STATUS_ACTIVE
        ];

        if ($subcategory_id != null) {
            $subCategory = SubCategory::where('id',$subcategory_id)->first();
            $subCatTitle = !empty($subCategory->translations()->{get_lang()}->title)
                ? $subCategory->translations()->{get_lang()}->title
                : $subCategory->name;

            $category_id = $subCategory->category_id;
            $category = Category::where('id',$category_id)->first();
            $catTitle = !empty($category->translations()->{get_lang()}->title)
                ? $category->translations()->{get_lang()}->title
                : $category->name;

            $conditions = array_merge($conditions, ['sub_category_id' => $subcategory_id]);
            $custom_fields = CustomField::where(['use_as_filter' => 1, 'active' => 1])->whereRaw("find_in_set($subcategory_id , sub_category_id)")->orderBy('order')->get();
        }
        else if ($category_id != null) {
            $category = Category::where('id',$category_id)->first();

            $catTitle = !empty($category->translations()->{get_lang()}->title)
                ? $category->translations()->{get_lang()}->title
                : $category->name;

            $conditions = array_merge($conditions, ['category_id' => $category_id]);
            $custom_fields = CustomField::where(['use_as_filter' => 1, 'active' => 1])->whereRaw("find_in_set($category_id , category_id)")->orderBy('order')->get();
        }
        else {
            $category = categories();
            $subCategory = array();
            $custom_fields = CustomField::where(['anycat' => 'any', 'use_as_filter' => 1, 'active' => 1])->orderBy('order')->get();
        }

        if ($city_id != null) {
            $conditions = array_merge($conditions, ['city_id' => $city_id]);
        }
        else if(!empty($request->location) && $city_id == null)
        {
            $placetype = $request->placetype;
            $placeid = $request->placeid;

            if($placetype == "country"){
                $conditions = array_merge($conditions, ['country_code' => $placeid]);
            }elseif($placetype == "state"){
                $conditions = array_merge($conditions, ['state_id' => $placeid]);
            }else{
                $conditions = array_merge($conditions, ['city_id' => $placeid]);
            }
        }
        else{
            $country_code = get_user_country();
            $conditions = array_merge($conditions, ['country_code' => $country_code]);
        }

        $posts = Post::where($conditions);

        if ($request->has('custom')) {
            $selected_attribute_values = $request->custom;
            $posts->where(function ($query) use ($selected_attribute_values) {
                foreach ($selected_attribute_values as $key => $value) {
                    if(!empty($value)){
                        if(is_array($value)){
                            foreach ($value as $checkbox) {
                                $query->whereHas('custom_data', function ($q) use ($key,$checkbox) {
                                    $q->where('field_id', $key)
                                        ->whereRaw("find_in_set($checkbox , field_data)");
                                });
                            }
                        }else{
                            $query->whereHas('custom_data', function ($q) use ($key,$value) {
                                $q->where(array(
                                    'field_id' => $key,
                                    'field_data' => $value
                                ));
                            });
                        }
                    }
                }
            });
        }

        if ($keywords != null) {
            $posts->where(function ($q) use ($keywords) {
                foreach (explode(' ', trim($keywords)) as $word) {
                    $q->where('title', 'like', '%' . $word . '%')
                        ->orWhere('tag', 'like', '%' . $word . '%')
                        ->orWhere('description', 'like', '%' . $word . '%');
                }
            });

            $case1 = $keywords . '%';
            $case2 = '%' . $keywords . '%';

            $posts->orderByRaw("CASE
                WHEN title LIKE '$case1' THEN 1
                WHEN title LIKE '$case2' THEN 2
                ELSE 3
                END");
        }

        switch ($sort_by) {
            case 'newest':
                $posts->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $posts->orderBy('created_at', 'asc');
                break;
            case 'title-asc':
                $posts->orderBy('title', 'asc');
                break;
            case 'price-asc':
                $posts->orderBy('price', 'asc');
                break;
            case 'price-desc':
                $posts->orderBy('price', 'desc');
                break;
            default:
                $posts->orderBy('created_at', 'desc');
                break;
        }

        if ($min_price != null && $max_price != null) {
            $posts->where('price', '>=', $min_price)->where('price', '<=', $max_price);
        }

        $posts = $posts->with(['user','category','sub_category','custom_field_data','city','country'])
            ->paginate($page_limit)
            ->appends(request()->query());

        return view($this->activeTheme . '.user.posts.search', compact('page_title',
            'posts', 'custom_fields', 'min_price', 'max_price', 'category_id', 'subcategory_id', 'category', 'subCategory', 'catTitle', 'subCatTitle', 'keywords', 'sort_by', 'order_by', 'filter'));
    }

    public function listingByCategory(Request $request, $category_slug)
    {
        $category_id = Category::get_category_id_by_slug($category_slug);
        if ($category_id) {
            return $this->index($request, $category_id);
        }
        abort(404);
    }

    public function listingBySubcategory(Request $request, $category_slug, $subcategory_slug)
    {
        $subcategory_id = SubCategory::get_subcategory_id_by_slug($subcategory_slug);
        if ($subcategory_id) {
            return $this->index($request, null, $subcategory_id);
        }
        abort(404);
    }

    public function listingByCity(Request $request, $city, $id)
    {
        if ($id) {
            return $this->index($request, null, null, $id);
        }
        abort(404);
    }

}
