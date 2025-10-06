<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\CategoryTranslation;
use App\Models\Language;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $categories = Category::orderBy('order')->get();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:2', 'max:255'],
            'slug' => ['nullable', 'alpha_dash', 'unique:categories,slug'],
            'icon' => ['required'],
        ]);
        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        $slug = !empty($request->slug)
            ? $request->slug
            : SlugService::createSlug(Category::class, 'slug', $request->name);

        $category = Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'order' => Category::get()->count() + 1,
            'icon' => $request->icon,
            'picture' => $request->picture,
        ]);

        if ($category) {
            foreach($request->translations as $lang_code => $value){
                $createTranslation = CategoryTranslation::Create([
                    'translation_id' => $category->id,
                    'lang_code' => $lang_code,
                    'category_type' => "main",
                    'title' => !empty($value['name']) ? $value['name'] : $request->name,
                    'slug' => !empty($value['slug']) ? $value['slug'] : $slug."-".$lang_code,
                ]);
            }
            $result = array(
                'id' => $category->id,
                'name' => $request->name,
                'icon' => $request->icon,
                'slug' => $slug,
                'getsubcategories_route' => route('admin.categories.getsubcategories', $category->id),
                'delete_route' => route('admin.categories.destroy', $category->id),
                'success' => true,
                'message' => ___('Updated Successfully'));
            return response()->json($result, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     */
    public function show()
    {
        abort(404);
    }

    /**
     * Display edit form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit()
    {
        abort(404);
    }

    /**
     * Update Main Category
     *
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:2', 'max:255'],
            'slug' => ['nullable', 'alpha_dash', 'unique:categories,slug,' . $category->id.',id'],
            'icon' => ['required'],
        ]);
        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        $slug = !empty($request->slug)
            ? $request->slug
            : SlugService::createSlug(Category::class, 'slug', $request->name);

        $update = $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'icon' => $request->icon,
            'picture' => $request->picture,
        ]);
        if ($update) {
            foreach($request->translations as $lang_code => $value){
                $update = CategoryTranslation::updateOrCreate(
                    [
                        'translation_id' => $category->id,
                        'lang_code' => $lang_code,
                        'category_type' => "main"
                    ], [
                        'title' => !empty($value['name']) ? $value['name'] : $request->name,
                        'slug' => !empty($value['slug']) ? $value['slug'] : $slug."-".$lang_code,
                    ]
                );
            }

            $result = array(
                'id' => $category->id,
                'name' => $request->name,
                'icon' => $request->icon,
                'success' => true,
                'message' => ___('Updated Successfully'));
            return response()->json($result, 200);
        }
    }


    /**
     * Remove the main category.
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        CategoryTranslation::where('translation_id', $category->id)
            ->where('category_type', "main")
            ->delete();

        $subcategories = SubCategory::where('category_id', $category->id)->get();
        foreach ($subcategories as $subcategory) {
            CategoryTranslation::where('translation_id', $subcategory->id)
                ->where('category_type', "sub")
                ->delete();
        }
        SubCategory::where('category_id',$category->id)->delete();

        $result = array('success' => true, 'message' => ___('Deleted Successfully'));
        return response()->json($result, 200);
    }

    /**
     * Add subCategories
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subCategoriesAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:2', 'max:255'],
            'slug' => ['nullable', 'alpha_dash', 'unique:catagory_sub,slug'],
        ]);
        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        $slug = !empty($request->slug)
            ? $request->slug
            : SlugService::createSlug(SubCategory::class, 'slug', $request->name);

        $subcategory = SubCategory::create([
            'name' => $request->name,
            'category_id' => $request->id,
            'slug' => $slug,
            'order' => SubCategory::get()->count() + 1,
        ]);

        if ($subcategory) {
            foreach($request->translations as $lang_code => $value) {
                $createTranslation = CategoryTranslation::Create([
                    'translation_id' => $subcategory->id,
                    'lang_code' => $lang_code,
                    'category_type' => "sub",
                    'title' => !empty($value['name']) ? $value['name'] : $request->name,
                    'slug' => !empty($value['slug']) ? $value['slug'] : $slug."-".$lang_code,
                ]);
            }
            $result = array(
                'id' => $subcategory->id,
                'name' => $request->name,
                'slug' => $slug,
                'success' => true,
                'message' => ___('Updated Successfully'));
            return response()->json($result, 200);
        }
    }

    /**
     * Update subCategories
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subCategoriesUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:2', 'max:255'],
            'slug' => ['nullable', 'alpha_dash', 'unique:catagory_sub,slug,' . $id.',id'],
            'picture' => ['nullable']
        ]);
        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        $slug = !empty($request->slug)
            ? $request->slug
            : SlugService::createSlug(SubCategory::class, 'slug', $request->name);

        $update = SubCategory::where('id', $id)->update([
            'name' => $request->name,
            'slug' => $slug,
            'picture' => $request->picture,
            'photo_show' => $request->photo_show,
            'price_show' => $request->price_show,
        ]);

        foreach($request->translations as $lang_code => $value){
            $update = CategoryTranslation::updateOrCreate(
                [
                    'translation_id' => $id,
                    'lang_code' => $lang_code,
                    'category_type' => "sub"
                ], [
                    'title' => !empty($value['name']) ? $value['name'] : $request->name,
                    'slug' => !empty($value['slug']) ? $value['slug'] : $slug."-".$lang_code,
                ]
            );
        }

        $result = array('success' => true, 'message' => ___('Updated Successfully'));
        return response()->json($result, 200);
    }

    /**
     * Remove the multiple sub categories.
     * @return \Illuminate\Http\Response
     */
    public function subCategoriesDelete(Request $request)
    {
        $ids = array_map('intval', $request->subCatids);
        SubCategory::whereIn('id',$ids)->delete();
        CategoryTranslation::whereIn('translation_id', $ids)
            ->where('category_type', "sub")
            ->delete();
        $result = array('success' => true, 'message' => ___('Deleted Successfully'));
        return response()->json($result, 200);
    }

    /**
     * Reorder main category position.
     *
     * @return \Illuminate\Http\Response
     */
    public function reorder(Request $request)
    {
        $position = $request->position;
        if (is_array($request->position)) {
            $count = 0;
            foreach($position as $id){
                $update = Category::where('id',$id)->update([
                    'order' => $count,
                ]);

                $count++;
            }
            if ($update) {
                $result = array('success' => true, 'message' => ___('Updated Successfully'));
                return response()->json($result, 200);
            }
        }

        $result = array('success' => true, 'message' => ___('Updated Successfully'));
        return response()->json($result, 200);
    }

    /**
     * Reorder main category position.
     *
     * @return \Illuminate\Http\Response
     */
    public function subCategoriesReorder(Request $request)
    {
        $position = $request->position;
        if (is_array($request->position)) {
            $count = 0;
            foreach($position as $id){
                $update = SubCategory::where('id',$id)->update([
                    'order' => $count,
                ]);

                $count++;
            }
            if ($update) {
                $result = array('success' => true, 'message' => ___('Updated Successfully'));
                return response()->json($result, 200);
            }
        }

        $result = array('success' => true, 'message' => ___('Updated Successfully'));
        return response()->json($result, 200);
    }


    /**
     * Get Sub categories by id
     *
     * @return \Illuminate\Http\Response as JSON
     */
    public function getSubCategories(Request $request, $id)
    {
        if($id > 0){
            $SubCategories = SubCategory::where('category_id', $id)->orderBy('order')->get();
        }else{
            $SubCategories = SubCategory::orderBy('order')->get();
        }

        if ($SubCategories->count() > 0) {
            $admin_languages = Language::where('active', 1)->orderBy('position')->get();
            ob_start();
            foreach ($admin_languages as $language) {
                echo '<option value="' . $language->code . '">' . $language->name . '</option>';
            }
            $lang_php_output = ob_get_contents();
            ob_end_clean();

            $tags = '<div class="panel-group ui-sortable" id="services_list" role="tablist" aria-multiselectable="true"  data-action="'.route('admin.categories.subcategories.reorder').'">';
            foreach ($SubCategories as $subCategory){
                $name = $subCategory->name;
                $slug = $subCategory->slug;
                $sub_id = $subCategory->id;
                $picture = $subCategory->picture;
                $photo_show = $subCategory->photo_show;
                $price_show = $subCategory->price_show;
                $photo_hide_selected = ($photo_show == 0)? "selected" :  "";
                $price_hide_selected = ($price_show == 0)? "selected" :  "";
                $userlangselect = (config('settings.userlangsel'))? "show" :  "hidden";

                ob_start();
                foreach ($admin_languages as $language){
                    $catTitle = !empty($subCategory->translations()->{$language->code}->title)
                        ? $subCategory->translations()->{$language->code}->title
                        : $name;

                    echo '<div class="translate-fields translate-fields-'.$language->code.'" style="display: none">
                        <input type="text" class="form-control" name="translations['.$language->code.'][name]"
                        value="'.$catTitle.'">
                    </div>';
                }
                $title_php_output = ob_get_contents();
                ob_end_clean();

                ob_start();
                foreach ($admin_languages as $language){
                    $catSlug = !empty($subCategory->translations()->{$language->code}->slug)
                        ? $subCategory->translations()->{$language->code}->slug
                        : $slug;

                    echo '<div class="translate-fields translate-fields-'.$language->code.'" style="display: none">
                        <input type="text" class="form-control" name="translations['.$language->code.'][slug]"
                        value="'.$catSlug.'">
                    </div>';
                }
                $slug_php_output = ob_get_contents();
                ob_end_clean();

                $tags .= '<div class="panel panel-default quickad-js-collapse" data-service-id="' . $sub_id . '">
            <div class="panel-heading" role="tab" id="s_' . $sub_id . '">
            <div class="row">
            <div class="col-sm-8 col-xs-10">
            <div class="quickad-flexbox">
            <div class="quickad-flex-cell quickad-vertical-middle" style="width: 1%">
            <i class="icon-feather-menu quickad-js-handle quickad-icon-draghandle quickad-margin-right-sm quickad-cursor-move ui-sortable-handle"
            title="'.___('Reorder').'"></i>
            </div>
            <div class="quickad-flex-cell quickad-vertical-middle">
            <a role="button"
            class="panel-title collapsed quickad-js-service-title"
            data-bs-toggle="collapse"
            data-bs-target="#service_' . $sub_id . '" aria-expanded="false"
            aria-controls="service_' . $sub_id . '">
            '.$name.' </a>
            </div>
            </div>
            </div>
            <div class="col-sm-4 col-xs-2">
            <div class="quickad-flexbox">
            <div class="quickad-flex-cell quickad-vertical-middle text-right"
            style="width: 10%">
            <label class="css-input css-checkbox css-checkbox-default m-t-0 m-b-0">
            <input type="checkbox" id="checkbox'.$sub_id.'" name="check-all" value="'.$sub_id.'"  class="service-checker"><span></span>
            </label>
            </div>
            </div>
            </div>
            </div>
            </div>

            <div id="service_' . $sub_id . '" class="panel-collapse collapse" data-bs-parent="#services_list" role="tabpanel" style="height: 0">
            <div class="panel-body">
            <form method="post" class="edit-subcategory-form" id="' . $sub_id . '" action="'.route('admin.categories.subcategories.update', $sub_id).'">
            '.csrf_field().'
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label d-flex align-items-center">
                                '.___("Name").'
                                <div class="d-flex align-items-center translate-picker">
                                    <i class="fa fa-language"></i>
                                    <select class="custom-select custom-select-sm ml-1">
                                        <option value="default">'.___("Default").'</option>
                                        '.$lang_php_output.'
                                    </select>
                                </div>
                            </label>
                            <div class="translate-fields translate-fields-default">
                                <input class="form-control" type="text" name="name" value="'.$name.'">
                            </div>
                            '.$title_php_output.'
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label d-flex align-items-center">
                                '.___("Slug").'
                                <div class="d-flex align-items-center translate-picker">
                                    <i class="fa fa-language"></i>
                                    <select class="custom-select custom-select-sm ml-1">
                                        <option value="default">'.___("Default").'</option>
                                        '.$lang_php_output.'
                                    </select>
                                </div>
                            </label>
                            <div class="translate-fields translate-fields-default">
                                <input class="form-control" type="text" name="slug" value="'.$slug.'">
                            </div>
                            '.$slug_php_output.'
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label">'.___("Photo field Enable/Disable").'</label>
                            <select name="photo_show" class="form-control">
                               <option value="1">'.___("Enable").'</option>
                                <option value="0" '.$photo_hide_selected.'>'.___("Disable").'</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label">'.___("Price Enable/Disable").'</label>
                            <select name="price_show" class="form-control">
                                <option value="1">'.___("Enable").'</option>
                                <option value="0" '.$price_hide_selected.'>'.___("Disable").'</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label">'.___("Icon Image Url").'</label>
                            <input name="picture" value="'.$picture.'" class="form-control" type="text">
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <input name="id" value="' . $sub_id . '" type="hidden">
                    <button type="submit" class="btn btn-success confirm">'.___("Save").'</button>
                    <button class="btn btn-default js-reset" type="reset">'.___("Reset").'</button>
                </div>
            </form>
            </div>
            </div>
            </div>';

            }

            $tags .= '</div>';
            return response($tags,200);
        } else {
            $result = array('success' => false, 'message' => ___('No Sub categories found'));
            return response()->json($result, 200);
        }
    }
}
