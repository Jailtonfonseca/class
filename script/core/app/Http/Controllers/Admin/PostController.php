<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Countries;
use App\Models\Cities;
use App\Models\Currencies;
use App\Models\CustomData;
use App\Models\CustomField;
use App\Models\Favorite;
use App\Models\Post;
use App\Models\PostOption;
use App\Models\Review;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $status = null)
    {

        $page_title = __('All Ads');

        // Determine the page title accordingly
        if ($status != null) {
            switch ($status) {
                case Post::STATUS_ACTIVE:
                    $page_title = __('Approved Ads');
                    break;
                case Post::STATUS_PENDING:
                    $page_title = __('Pending Ads');
                    break;
                case Post::STATUS_EXPIRE:
                    $page_title = __('Expire Ads');
                    break;
                case Post::STATUS_REJECTED:
                    $page_title = __('Rejected Ads');
                    break;
                default:
                    abort(404);
            }
        }

        if ($request->ajax()) {
            $status = $request->get('status');
            $params = $columns = $order = $totalRecords = $data = array();
            $params = $request;

            $columns = array(
                'id',
                'title',
                'created_at'
            );
            $totalRecordsQuery = Post::when($status, function($query) use ($status) {
                return $query->where('status', $status);
            });

            $totalRecords = $totalRecordsQuery->count();

            if (!empty($params['search']['value'])) {
                $q = $params['search']['value'];
                $posts = Post::when($status, function($query) use ($status) {
                    return $query->where('status', $status);
                })
                    ->where(function($query) use ($q) {
                        $query->where('title', 'like', '%' . $q . '%')
                            ->orWhere('description', 'like', '%' . $q . '%');
                    })
                    ->with(['user', 'category', 'sub_category'])
                    ->orderBy($columns[$params['order'][0]['column']], $params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();

                $totalRecords = Post::when($status, function($query) use ($status) {
                    return $query->where('status', $status);
                })
                    ->where(function($query) use ($q) {
                        $query->where('title', 'like', '%' . $q . '%')
                            ->orWhere('description', 'like', '%' . $q . '%');
                    })
                    ->count();
            }else {
                $posts = Post::when($status, function($query) use ($status) {
                    return $query->where('status', $status);
                })
                    ->with(['user', 'category', 'sub_category'])
                    ->orderBy($columns[$params['order'][0]['column']], $params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }

            foreach ($posts as $row) {
                $picture = explode(',' ,$row->images);
                if($picture[0] != ""){
                    $image = $picture[0];
                }else{
                    $image = "default.png";
                }
                $approved_button = $reject_button = "";
                if ($row->status == Post::STATUS_PENDING) {
                    $approved_button = '<a href="#" class="btn btn-icon btn-info me-1 item-ajax-button" title="'.___('Approve').'" data-ajax-action="approveListing" data-alert-message="'.___('Are you sure?').'" data-tippy-placement="top"><i class="icon-feather-check"></i></a>';

                    $reject_button = '<a href="#" class="btn btn-icon btn-danger me-1 item-ajax-button" title="'.___('Reject').'" data-ajax-action="rejectListing" data-alert-message="'.___('Are you sure?').'" data-tippy-placement="top"><i class="icon-feather-x"></i></a>';

                    $status_badge = '<span class="badge bg-info">' . ___('Pending') . '</span>';
                } elseif ($row->status == Post::STATUS_ACTIVE) {
                    $status_badge = '<span class="badge bg-success">' . ___('Approved') . '</span>';
                } elseif ($row->status == Post::STATUS_EXPIRE) {
                    $status_badge = '<span class="badge bg-danger">' . ___('Expire') . '</span>';
                } elseif ($row->status == Post::STATUS_REJECTED) {
                    $status_badge = '<span class="badge bg-warning">' . ___('Rejected') . '</span>';
                }

                $rows = array();
                $rows[] = '<td>'.$row->id.'</td>';
                $rows[] = '<td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-2 min-w-38">
                                        <a href="'.route('posts.single', [$row->id,$row->slug]).'" target="_blank">
                                            <img alt="'.$row->title.'"
                                            src="'.asset('storage/products/thumb/'.$image).'" />
                                        </a>
                                    </div>
                                    <div>
                                        <a class="text-body fw-semibold text-one-line word-break" target="_blank"
                                            href="'.route('posts.single', [$row->id,$row->slug]).'">
                                            '.$row->title.'
                                        </a>
                                        <p class="text-muted mb-0">
                                            '.$row->category->name.' -
                                            '.$row->sub_category->name.'
                                        </p>
                                    </div>
                                </div>
                            </td>';
                $rows[] = '<td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-2 min-w-38">
                                        <a href="'.route('admin.users.edit', $row->user->id).'">
                                            <img alt="'.$row->user->username.'" src="'.asset('storage/profile/'.$row->user->image).'" />
                                        </a>
                                    </div>
                                    <div>
                                        <a class="text-body fw-semibold text-one-line word-break"
                                            href="'.route('admin.users.edit', $row->user->id).'">'.$row->user->name.'</a>
                                        <p class="text-muted mb-0">@'.$row->user->username.'</p>
                                    </div>
                                </div>
                            </td>';
                $rows[] = '<td>'.$status_badge.'</td>';
                $rows[] = '<td>'.date_formating($row->created_at).'</td>';
                $rows[] = '<td>
                                <div class="d-flex">
                                <a href="'.route('admin.posts.edit', ['id' => $row->id]).'" title="'.___('Edit').'"  class="btn btn-icon btn-default me-1" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>

                                <a href="'.route('admin.reviews.index', ['id' => $row->id]).'" title="'.___('Review').'"  class="btn btn-icon btn-primary me-1" data-tippy-placement="top"><i class="icon-feather-star"></i></a>

                                '.$approved_button.' '.$reject_button.'
                                </div>
                            </td>';
                $rows[] = '<td>
                                <div class="checkbox">
                                <input type="checkbox" id="check_'.$row->id.'" value="'.$row->id.'" class="quick-check">
                                <label for="check_'.$row->id.'"><span class="checkbox-icon"></span></label>
                            </div>
                           </td>';
                $rows['DT_RowId'] = $row->id;
                $data[] = $rows;
            }

            $json_data = array(
                "draw"            => intval( $params['draw'] ),
                "recordsTotal"    => intval( $totalRecords ),
                "recordsFiltered" => intval($totalRecords),
                "data"            => $data   // total data array
            );
            return response()->json($json_data, 200);
        }

        return view('admin.posts.index', compact('status', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $country_code = get_user_country();
        $info = Countries::select('currency_code')
            ->where('code', $country_code)
            ->first();
        $currency_code = $info->currency_code;
        $latitude     =  config('settings.home_map_latitude');
        $longitude    =  config('settings.home_map_longitude');
        $custom_fields = CustomField::where('anycat', 'any')->get();
        return view('admin.posts.create', compact('custom_fields', 'country_code', 'currency_code', 'latitude', 'longitude'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post, $id)
    {
        $user = request()->user();
        $post = Post::with('category','sub_category','custom_field_data','city','state','country')->find($id);
        $country_code = get_user_country();

        $images = explode(',', $post->images);
        $map = explode(',', $post->latlong);
        $latitude     =  ($map[0] != "")? $map[0] : config('settings.home_map_latitude');
        $longitude    =  ($map[1] != "")? $map[1] : config('settings.home_map_longitude');

        $info = Countries::select('currency_code')
            ->where('code', $country_code)
            ->first();
        $currency_code = $info->currency_code;
        $currency = Currencies::where('code', $currency_code)
            ->first();

        $fields = array();
        $data = array();

        $customdata = CustomData::where('post_id',$post->id)
            ->get();

        foreach ($customdata as $value){
            $fields[] = $value->field_id;
            $data[] = $value->field_data;
        }

        $custom_fields = CustomField::whereRaw("find_in_set($post->sub_category_id , sub_category_id)")->get();
        foreach($custom_fields as $info){
            foreach($fields as $key=>$value)
            {
                if($value != '')
                {
                    if($value == $info->id){
                        $info->default = $data[$key];
                        break;
                    }
                }
            }
        }
        return view('admin.posts.edit', compact(
            'user','post','country_code','latitude','longitude','currency','custom_fields','images'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => ['required', 'integer'],
            'sub_category' => ['required', 'integer'],
            'title' => ['required', 'string', 'min:5', 'max:150'],
            'slug' => ['nullable', 'alpha_dash', 'unique:posts,slug'],
            'description' => ['nullable', 'string'],
            'city' => ['required', 'integer'],
            'price' => ['nullable', 'numeric']
        ] + validate_post_location());

        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            quick_alert_error(implode('<br>', $errors));
            return back()->withInput();
        }

        $newImagesName = [];
        if($request->has('image')) {
            foreach ($request->input('image') as $file) {
                $newFilename = Str::after($file, 'tmp/');
                if(file_exists(public_path('storage/products/thumb/tmp/'.$newFilename))){
                    File::move('storage/products/thumb/tmp/'.$newFilename, 'storage/products/thumb/'.$newFilename);
                }
                if(file_exists(public_path('storage/products/tmp/'.$newFilename))){
                    File::move('storage/products/tmp/'.$newFilename, 'storage/products/'.$newFilename);
                }
                $newImagesName[] = $newFilename;
            }
        }
        $images = implode(',',$newImagesName);
        $phone = $request->has('phone') ? $request->phone : '0';
        $negotiable = $request->has('negotiable') ? '1' : '0';
        $hide_phone = $request->has('hide_phone') ? '1' : '0';
        $location = $request->has('location') ? $request->location : '';
        $price = $request->has('price') ? $request->price : '0';
        $price = !empty($price) ? $price : '0';

        $citydata = Cities::find($request->city);
        $country = $citydata['country_code'];
        $state = $citydata['subadmin1_code'];
        $mapLat = $request->latitude;
        $mapLong = $request->longitude;
        $latlong = $mapLat . "," . $mapLong;

        $plan = Auth::user()->plan();
        $expire_date = Carbon::now()->addDays($plan->settings->ad_duration);
        $create = Post::create([
            'user_id' => request()->user()->id,
            'title' => $request->title,
            'slug' => !empty($request->slug)
                ? $request->slug
                : SlugService::createSlug(Post::class, 'slug', $request->title),
            'description' => $request->description,
            'images' => $images ?? null,
            'category_id' => $request->category,
            'sub_category_id' => $request->sub_category,
            'city_id' => $request->city,
            'state_id' => $state,
            'status' => $request->status,
            'country_code' => $country,
            'location' => $location,
            'latlong' => $latlong,
            'price' => $price,
            'negotiable' => $negotiable,
            'phone' => $phone,
            'hide_phone' => $hide_phone,
            'tag' => $request->tags,
            'expire_date' => $expire_date,
            'highlight' => $request->has('highlight') ? $request->highlight : '0',
            'featured' => $request->has('featured') ? $request->featured : '0',
            'urgent' => $request->has('urgent') ? $request->urgent : '0',
        ]);

        if($request->has('custom')) {
            foreach($request->custom as $key=>$value){
                if(is_array($value)){
                    $field_data = implode(',',$value);
                }else{
                    $field_data = $value;
                }

                CustomData::updateOrCreate(
                    [
                        'post_id' => $create->id,
                        'field_id' => $key
                    ], [

                        'field_data' => $field_data
                    ]
                );
            }
        }

        quick_alert_success(___('Created Successfully'));
        return redirect(route('admin.posts.index'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (request()->user()->isAdmin()) {
            $post = Post::find($id);
            $validator = Validator::make($request->all(), [
                'category' => ['required', 'integer'],
                'sub_category' => ['required', 'integer'],
                'title' => ['required', 'string', 'min:5', 'max:150'],
                'slug' => ['nullable', 'alpha_dash', 'unique:posts,slug,' . $post->id],
                'description' => ['nullable', 'string'],
                'city' => ['required', 'integer'],
                'price' => ['nullable', 'numeric'],
            ] + validate_post_location());

            if ($validator->fails()) {
                $errors = [];
                foreach ($validator->errors()->all() as $error) {
                    $errors[] = $error;
                }
                quick_alert_error(implode('<br>', $errors));
                return back()->withInput();
            }

            $citydata = Cities::find($request->city);
            if($citydata){
                $country = $citydata['country_code'];
                $state = $citydata['subadmin1_code'];
            }else{
                quick_alert_error(___('Selected city not installed in Database.'));
                return back()->withInput();
            }

            $newImagesName = "";
            if($request->has('image')) {
                $new_files = [];
                $old_files = [];
                foreach ($request->input('image') as $file) {
                    if(Str::isUrl($file)){
                        if(file_exists(public_path('storage/products/thumb/'.basename($file))))
                            $old_files[] = basename($file);
                    }else{
                        $newFilename = Str::after($file, 'tmp/');
                        if(file_exists(public_path('storage/products/thumb/tmp/'.$newFilename))){
                            File::move('storage/products/thumb/tmp/'.$newFilename, 'storage/products/thumb/'.$newFilename);
                        }
                        if(file_exists(public_path('storage/products/tmp/'.$newFilename))){
                            File::move('storage/products/tmp/'.$newFilename, 'storage/products/'.$newFilename);
                        }
                        $new_files[] = $newFilename;
                    }
                }
                $images = array_merge($new_files,$old_files);
                $newImagesName = implode(',',$images);

                $old_screens = explode(',', $post->images);
                $unusedImages = array_diff($old_screens,$old_files);
                foreach($unusedImages as $imgname){
                    remove_file('storage/products/thumb/'.$imgname);
                    remove_file('storage/products/'.$imgname);
                }
            }


            $phone = $request->has('phone') ? $request->phone : '0';
            $negotiable = $request->has('negotiable') ? '1' : '0';
            $hide_phone = $request->has('hide_phone') ? '1' : '0';
            $location = $request->has('location') ? $request->location : '';
            $price = $request->has('price') ? $request->price : '0';
            $price = !empty($price) ? $price : '0';

            $mapLat = $request->latitude;
            $mapLong = $request->longitude;
            $latlong = $mapLat . "," . $mapLong;

            $update = $post->update([
                'status' => $request->status,
                'title' => $request->title,
                'slug' => !empty($request->slug)
                    ? $request->slug
                    : SlugService::createSlug(Post::class, 'slug', $request->title),
                'description' => $request->description,
                'images' => $newImagesName,
                'category_id' => $request->category,
                'sub_category_id' => $request->sub_category,
                'city_id' => $request->city,
                'state_id' => $state,
                'country_code' => $country,
                'location' => $location,
                'latlong' => $latlong,
                'price' => $price,
                'negotiable' => $negotiable,
                'phone' => $phone,
                'hide_phone' => $hide_phone,
                'tag' => $request->tags,
                'highlight' => $request->has('highlight') ? $request->highlight : '0',
                'featured' => $request->has('featured') ? $request->featured : '0',
                'urgent' => $request->has('urgent') ? $request->urgent : '0',
            ]);

            if ($update) {
                quick_alert_success(___('Updated Successfully'));
                return redirect(route('admin.posts.index'));
            }
        }

        quick_alert_error(___('Unable to upload the image, please try again.'));
        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $ids = array_map('intval', $request->ids);
        $posts = Post::whereIn('id',$ids)->get();
        foreach($posts as $post){
            if (!empty($post->images)) {
                $images = explode(',',$post->images);
                foreach($images as $image){
                    remove_file('storage/products/thumb/' . $image);
                    remove_file('storage/products/' . $image);
                }
            }
            Review::where('post_id', $post->id)->delete();
            CustomData::where('post_id', $post->id)->delete();
            PostOption::where('post_id', $post->id)->delete();
            Favorite::where('post_id', $post->id)->delete();
        }
        Post::whereIn('id',$ids)->delete();
        $result = array('success' => true, 'message' => ___('Listing Deleted Successfully'));
        return response()->json($result, 200);
    }

    /**
     * Upload file.
     *
     * @param Request $request
     * @return string
     */
    public function upload(Request $request)
    {
        if ($request->file('image')) {
            foreach ($request->file('image') as $file) {
                $filename = uniqid().time();
                $path = image_upload($file, 'storage/products/thumb/tmp/', '200',$filename);
                image_upload($file, 'storage/products/tmp/', '1024',$filename);
            }
        }
        return 'tmp/'.$path;
    }

    /**
     * Remove file.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function revert(Request $request)
    {
        remove_file('storage/products/thumb/'.$request->getContent());
        remove_file('storage/products/'.$request->getContent());
        $result = array('success' => true, 'message' => ___('File Removed'));
        return response()->json($result, 200);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getSubCategories(Request $request)
    {
        $categoryId = $request->get('category_id');
        $category = Category::find($categoryId);
        $subCategories = $category->subcategories()->get();

        return response()->json(['sub_categories' => $subCategories]);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function getCustomFieldByCatID(Request $request)
    {
        $maincatid = $request->has('catid') ? $request->get('catid') : 0;
        $subcatid = $request->has('subcatid') ? $request->get('subcatid') : 0;

        if ($subcatid > 0) {
            $custom_fields = CustomField::whereRaw("find_in_set($subcatid , sub_category_id)")->get();
        } else {
            die();
        }
        $tpl = '';
        if (count($custom_fields) > 0) {
            foreach ($custom_fields as $row) {
                $id = $row['id'];
                $type = $row['type'];
                $default = $row['default'];
                $required = $row['required'];
                $name = (config('settings.userlangsel'))
                    ? $row->get_translated_title()
                    : $row['title'];

                if($type == "text-field"){
                    $tpl .= '<div class="row form-group">
                            <label class="col-sm-3 form-label">'.$name.' '.($required === "1" ? '<span class="required">*</span>' : "").'*</label>
                            <div class="col-sm-9">
                                <input name="custom['.$id.']" id="custom['.$id.']" class="form-control with-border quick-text"  type="text" value="'.$default.'" placeholder="'.$name.'" data-name="'.$id.'" data-req="'.$required.'"/>
                                <div class="quick-error">'.___('This field is required.').'</div>
                            </div>
                        </div>';
                }
                elseif($type == "textarea"){
                    $tpl .= '<div class="row form-group">
                                <label class="col-sm-3 form-label">'.$name.' '.($required === "1" ? '<span class="required">*</span>' : "").' *</label>
                                <div class="col-sm-9">
                                    <textarea class="materialize-textarea form-control with-border quick-textArea" name="custom['.$id.']" id="custom['.$id.']" placeholder="'.$name.'" data-name="'.$id.'" data-req="'.$required.'">'.$default.'</textarea>
                                    <div class="quick-error">'.___('This field is required.').'</div>
                                    <p class="help-block">'.___('Html tags are allow.').'</p>
                                </div>
                            </div>';
                }
                elseif($type == "drop-down"){
                    ob_start();
                    $options = explode(',',$row['options']);
                    foreach($options as $key3=>$value3) {
                        $option = get_customOptions_by_id($value3);
                        if($option) {
                            $option_title = (config('settings.userlangsel'))
                                ? $option->get_translated_title()
                                : $option->title;

                            if ($value3 == $default) {
                                echo '<option value="' . $value3 . '" selected>' . $option_title . '</option>';
                            } else {
                                echo '<option value="' . $value3 . '">' . $option_title . '</option>';
                            }
                        }
                    }
                    $option_php_output = ob_get_contents();
                    ob_end_clean();
                    $tpl .= '<div class="row form-group">
                                <label class="col-sm-3 form-label">'.$name.' '.($required === "1" ? '<span class="required">*</span>' : "").'*</label>
                                <div class="col-sm-9">
                                    <select class="form-control selectpicker with-border quick-select" name="custom['.$id.']" data-name="'.$id.'" data-req="'.$required.'">
                                        <option value="" selected>'.___('Select').' '.$name.'</option>
                                        '.$option_php_output.'
                                    </select>
                                    <div class="quick-error">'.___('This field is required.').'</div>
                                </div>
                            </div>';
                }
                elseif($type == "radio-buttons"){
                    ob_start();
                    $options = explode(',',$row['options']);
                    $i = 0;
                    foreach($options as $key3=>$value3) {
                        $option = get_customOptions_by_id($value3);
                        if($option) {
                            $option_title = (config('settings.userlangsel'))
                                ? $option->get_translated_title()
                                : $option->title;
                            $checked = ($value3 == $default) ? "checked" : "";

                            echo '<div class="radio radio-primary radio-inline"><input class="with-gap" type="radio" name="custom[' . $id . ']" id="' . $value3 . $i . '" value="' . $value3 . '" data-name="' . $id . '" ' . $checked . ' />
                            <label for="' . $value3 . $i . '" class="form-label"><span class="radio-label"></span>' . $option_title . ' *</label></div><br>';

                            $i++;
                        }
                    }
                    $option_php_output = ob_get_contents();
                    ob_end_clean();

                    $tpl .= '<div class="row form-group">
                                <label class="col-sm-3 form-label">'.$name.' '.($required === "1" ? '<span class="required">*</span>' : "").' *</label>
                                <div class="col-sm-9">
                                    '.$option_php_output.'
                                    <input type="hidden" class="quick-radioCheck" data-name="'.$id.'" data-req="'.$required.'">
                                    <div class="quick-error">'.___('This field is required.').'</div>
                                </div>
                            </div>';
                }
                elseif($type == "checkboxes"){
                    ob_start();
                    $options = explode(',',$row['options']);
                    $j = 0;
                    $selected = "";
                    foreach($options as $key4=>$value4)
                    {
                        $option = get_customOptions_by_id($value4);
                        if($option) {
                            $option_title = (config('settings.userlangsel'))
                                ? $option->get_translated_title()
                                : $option->title;

                            $default_checkbox = $default;
                            if (is_array($default_checkbox)) {
                                $checked = $default;
                            } else {
                                $checked = explode(',', $default);
                            }

                            foreach ($checked as $val) {
                                if ($value4 == $val) {
                                    $selected = "checked";
                                    break;
                                } else {
                                    $selected = "";
                                }
                            }

                            echo '<div class="checkbox"><input type="checkbox" name="custom[' . $id . '][]" id="' . $value4 . $j . '" value="' . $value4 . '" ' . $selected . ' data-name="' . $id . '" />
                            <label for="' . $value4 . $j . '" class="form-label"><span class="checkbox-icon"></span>' . $option_title . '*</label></div><br>';

                            $j++;
                        }
                    }

                    $option_php_output = ob_get_contents();
                    ob_end_clean();

                    $tpl .= '<div class="row form-group">
                                <label class="col-sm-3 label-title">'.$name.' '.($required === "1" ? '<span class="required">*</span>' : "").'</label>
                                <div class="col-sm-9">
                                    '.$option_php_output.'
                                    <input type="hidden" class="quick-radioCheck" data-name="'.$id.'" data-req="'.$required.'">
                                    <div class="quick-error">'.___('This field is required.').'</div>
                                </div>
                            </div>';
                }
            }
            echo $tpl;
            die();
        } else {
            echo 0;
            die();
        }
    }
}
