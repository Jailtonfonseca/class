<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mails\UserDetails;
use App\Models\Cities;
use App\Models\Countries;
use App\Models\Currencies;
use App\Models\CustomData;
use App\Models\CustomField;
use App\Models\Option;
use App\Models\Post;
use App\Models\PostOption;
use App\Models\PostView;
use App\Models\Review;
use App\Models\SubCategory;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
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
    public function index(Request $request)
    {
        abort(404);
    }

    /**
     * Get user all listings.
     *
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function myListing(Request $request)
    {
        if(!Auth::check()){
            abort(404);
        }
        $page_limit = 6;
        $page_title = ___('My Ads');
        $active_menu = 'my-ads';
        $posts = Post::where('user_id', $request->user()->id)
            ->with(['user','category','sub_category','custom_field_data','city','country'])
            ->orderbyDesc('id')
            ->paginate($page_limit);
        return view($this->activeTheme . '.user.posts.mylisting', compact('posts','page_title','active_menu'));
    }

    /**
     * Get user favorites listings.
     *
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function myFavorite(Request $request)
    {
        if(!Auth::check()){
            abort(404);
        }
        $page_limit = 6;
        $user = Auth::user();
        $posts = $user->favorites()
            ->with(['user','category','sub_category','custom_field_data','city','country'])
            ->orderbyDesc('id')
            ->paginate($page_limit);
        return view($this->activeTheme . '.user.posts.favorite', compact('posts',));
    }


    /**
     * Get listings with status.
     *
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function status(Request $request)
    {
        if(!Auth::check()){
            abort(404);
        }
        $page_limit = 6;
        $active_menu = $request->status.'-ads';
        if($request->status == 'hidden'){
            $page_title = ___('Hidden Ads');
            $where_array = array(
                'user_id' => $request->user()->id,
                'hide' => '1'
            );
        }elseif($request->status == Post::STATUS_ACTIVE){
            $page_title = ___('Active Ads');

            $where_array = array(
                'user_id' => $request->user()->id,
                'status' => $request->status
            );
        }
        elseif($request->status == Post::STATUS_PENDING){
            $page_title = ___('Pending Ads');
            $where_array = array(
                'user_id' => $request->user()->id,
                'status' => $request->status
            );
        }
        elseif($request->status == Post::STATUS_EXPIRE){
            $page_title = ___('Expire Ads');
            $where_array = array(
                'user_id' => $request->user()->id,
                'status' => $request->status
            );
        }
        elseif($request->status == Post::STATUS_REJECTED){
            $page_title = ___('Rejected Ads');
            $where_array = array(
                'user_id' => $request->user()->id,
                'status' => $request->status
            );
        }else{
            abort(404);
        }

        $posts = Post::where($where_array)
            ->with(['user','category','sub_category','custom_field_data','city','country'])
            ->orderbyDesc('id')
            ->paginate($page_limit);
        return view($this->activeTheme . '.user.posts.mylisting', compact('posts','page_title','active_menu'));
    }


    /**
     * Get listing detail.
     *
     * @param Request $request
     * @param Post $post
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function single(Request $request, Post $post)
    {
        if (Auth::check() && !request()->user()->isAdmin()) {
            if($post->status != Post::STATUS_ACTIVE){
                if(!Auth::check()){
                    abort(404);
                }else if($request->user()->id != $post->user_id){
                    abort(404);
                }
            }
        }

        $post = Post::where('id',$post->id)
            ->with(['user','category','sub_category','custom_field_data','city','country'])
            ->first();

        $last_view = PostView::where('post_id', $post->id)->orderBy('date', 'DESC')->first();
        if(empty($last_view) or Carbon::now()->diffInSeconds($last_view->date) > 30){
            PostView::create([
                'post_id' => $post->id,
                'ip' => request()->ip(),
                'date' => date('Y-m-d H:i:s')
            ]);
        }

        $postviews = PostView::where('post_id', $post->id)->count();

        $reviews = Review::where(array(
            'publish' => '1',
            'post_id' => $post->id
        ))->count();

        $map = explode(',' ,$post->latlong);
        $latitude = $map[0];
        $longitude = $map[1];

        $similarPosts = Post::where(
            array(
                'hide' => '0',
                'status' => Post::STATUS_ACTIVE,
                'country_code' => $post->country_code,
                'category_id' => $post->category_id,
                'sub_category_id' => $post->sub_category_id
            ))
            ->where('id', '!=' , $post->id)
            ->with(['user','category','sub_category','custom_field_data','city','country'])
            ->limit(6)->get();
        return view($this->activeTheme . '.user.posts.single', compact('post','similarPosts','latitude','longitude','reviews','postviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $country_code = get_user_country();
        $info = Countries::where('code', $country_code)
            ->first();

        if(!empty($info->latitude) && !empty($info->longitude)){
            $latitude     =  $info->latitude;
            $longitude    =  $info->longitude;
        }else{
            $latitude     =  config('settings.home_map_latitude');
            $longitude    =  config('settings.home_map_longitude');
        }

        $currency_code = $info->currency_code;
        $currency = Currencies::where('code', $currency_code)
            ->first();

        if(Auth::check()){
            $plan = Auth::user()->plan();
        }else{
            $plan = config('settings.free_membership_plan');
        }

        $custom_fields = CustomField::where('anycat', 'any')->get();
        return view($this->activeTheme . '.user.posts.create', compact('custom_fields','country_code','latitude','longitude','currency','plan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::check() && !config('settings.post_without_login')){
            if (!config('settings.non_active_allow') && !$request->user()->hasVerifiedEmail()) {
                $result = array('success' => false, 'message' => ___('Verify your email address to post any content.'));
                return response()->json($result, 200);
            }
        }

        $validator_array = [
                'category' => ['required', 'integer'],
                'sub_category' => ['required', 'integer'],
                'title' => ['required', 'string', 'min:5', 'max:150'],
                'description' => ['required', 'string'],
                'city' => ['required', 'integer', 'exists:cities,id'],
                'price' => ['nullable', 'numeric'],
                'agree_for_term' => ['required'],
            ];

        if(!Auth::check()){
            $validator_array = array_merge($validator_array, [
                'seller_name' => ['required', 'string', 'min:2', 'max:40'],
                'seller_username' => ['required', 'alpha_dash', 'min:2', 'max:16', 'unique:user,username'],
                'seller_email' => ['required', 'string', 'email', 'max:100', 'unique:user,email'],
                'seller_password' => ['required', 'string', 'min:6', 'max:20'],
            ]);
        }

        $validator = Validator::make($request->all(), $validator_array
            + validate_recaptcha() + validate_post_location() );
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[]['message'] = $error;
            }
            $result = array('status' => "error", 'errors' => $errors);
            return response()->json($result, 200);
        }

        if(!Auth::check()){
            $ipInfo = user_ip_info();

            $data = array_merge($request->all(), [
                'country_name' => $ipInfo->location->country,
                'country_code' => $ipInfo->location->country_code,
                'city' => $ipInfo->location->city,
            ]);

            $user = User::create([
                'name' => $data['seller_name'],
                'username' => $data['seller_username'],
                'email' => $data['seller_email'],
                'password' => Hash::make($data['seller_password']),
                'group_id' => config('settings.default_user_plan'),
                'country' => $data['country_name'],
                'country_code' => $data['country_code'],
            ]);
            if ($user) {
                /* Send user details email */
                $user->sendMail(new UserDetails($user));

                /* Add admin notification */
                $title = ___(':user_name has registered', ['user_name' => $user->name]);
                create_notification($title, 'new_user', route('admin.users.edit', $user->id));
                event(new Registered($user));
                Auth::login($user);
                $user_id = $user->id;
            }else{
                $errors[]['message'] = ___('Unexpected Error');
                $result = array('status' => "error", 'errors' => $errors);
                return response()->json($result, 200);
            }
        }else{
            $user_id = $request->user()->id;
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

        $mapLat = $request->latitude;
        $mapLong = $request->longitude;
        $latlong = $mapLat . "," . $mapLong;

        $citydata = Cities::find($request->city);
        $country = $citydata['country_code'];
        $state = $citydata['subadmin1_code'];

        if(config('settings.post_desc_editor') == 1)
            $description = $request->description;
        else
            $description = $request->description;

        //$post_title = removeEmailAndPhoneFromString($_POST['title']);

        $status = (config('settings.post_auto_approve')) ? 'active' : 'pending';

        if(Auth::check()){
            $plan = Auth::user()->plan();
        }else{
            $plan = config('settings.free_membership_plan');
        }
        $expire_date = Carbon::now()->addDays($plan->settings->ad_duration);
        $create = Post::create([
            'user_id' => $user_id,
            'status' => $status,
            'title' => $request->title,
            'slug' => SlugService::createSlug(Post::class, 'slug', $request->title),
            'description' => $description,
            'images' => $images,
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
            'expire_date' => $expire_date
        ]);

        if ($create) {
            $post_id = $create->id;
            if($request->has('custom')) {
                foreach($request->custom as $key=>$value){
                    if(is_array($value)){
                        $field_data = implode(',',$value);
                    }else{
                        $field_data = $value;
                    }

                    CustomData::updateOrCreate(
                        [
                            'post_id' => $post_id,
                            'field_id' => $key
                        ], [

                            'field_data' => $field_data
                        ]
                    );
                }
            }

            $amount = 0;
            $trans_desc = ___('Package');

            $featured_project_fee = $plan->settings->featured_project_fee;
            $urgent_project_fee = $plan->settings->urgent_project_fee;
            $highlight_project_fee = $plan->settings->highlight_project_fee;

            if ($request->has('featured') && $request->featured == 1) {
                $amount = $featured_project_fee;
                $trans_desc = $trans_desc ." ". ___('Featured');
            }
            if ($request->has('urgent') && $request->urgent == 1) {
                $amount = $amount + $urgent_project_fee;
                $trans_desc = $trans_desc ." ". ___('Urgent');
            }
            if ($request->has('highlight') && $request->highlight == 1) {
                $amount = $amount + $highlight_project_fee;
                $trans_desc = $trans_desc ." ". ___('Highlight');
            }

            if ($amount > 0) {
                $payment_type = "premium";
                $coupon = null;
                $applied_tax_ids = $applied_taxes = [];
                $user_options = user_options($user_id);

                /* Create transaction to store all the details for further actions */
                $transaction = Transaction::create([
                    'product_name' => $request->title.' (#'.$post_id.')',
                    'product_id' => $post_id,
                    'user_id' => $user_id,
                    'base_amount' => $amount,
                    'amount' => $amount,
                    'currency_code' => config('settings.currency_code'),
                    'transaction_method' => $payment_type,
                    'transaction_ip' => $request->ip(),
                    'transaction_time' => Carbon::now()->timestamp,
                    'transaction_description' => $trans_desc,
                    'details' => [
                        'payment_type' => $payment_type,
                        'trans_desc' => $trans_desc,
                        'featured' => $request->featured,
                        'urgent' => $request->urgent,
                        'highlight' => $request->highlight,
                    ],
                    'billing' => [
                        'type' => @$user_options->billing_details_type,
                        'tax_id' => @$user_options->billing_tax_id,
                        'name' => @$user_options->billing_name,
                        'address' => @$user_options->billing_address,
                        'city' => @$user_options->billing_city,
                        'state' => @$user_options->billing_state,
                        'zipcode' => @$user_options->billing_zipcode,
                        'country' => @$user_options->billing_country
                    ],
                ]);

                $redirect_url = route('payment.index', $transaction->id);

                $result = array(
                    'status' => "success",
                    'ad_type' => "package",
                    'redirect' => $redirect_url,
                    'message' => ___('Created Successfully')
                );
            } else {
                $result = array(
                    'status' => "success",
                    'ad_type' => "free",
                    'redirect' => route('posts.single', [$post_id,$create->slug]),
                    'message' => ___('Created Successfully')
                );
            }
            return response()->json($result, 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $user = request()->user();
        if ($post->user_id == $user->id) {
            $post = Post::with('category','sub_category','custom_field_data','city','country')->find($post->id);
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

            if(Auth::check()){
                $plan = Auth::user()->plan();
            }else{
                $plan = config('settings.free_membership_plan');
            }

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


            return view($this->activeTheme . '.user.posts.edit', compact(
                'user','post','country_code','latitude','longitude','currency','plan','custom_fields','images'
            ));
        } else {
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if ($post->user_id == request()->user()->id) {
            if (!config('settings.non_active_allow') && !$request->user()->hasVerifiedEmail()) {
                $result = array('success' => false, 'message' => ___('Verify your email address to post any content.'));
                return response()->json($result, 200);
            }

            $validator = Validator::make($request->all(), [
                'category' => ['required', 'integer'],
                'sub_category' => ['required', 'integer'],
                'title' => ['required', 'string', 'min:5', 'max:150'],
                'description' => ['nullable', 'string'],
                'city' => ['required', 'integer'],
                'price' => ['nullable', 'numeric'],
            ]);
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    $errors[] = $error;
                }
                $result = array('success' => false, 'message' => implode('<br>', $errors));
                return response()->json($result, 200);
            }

            $newImagesName = "";
            if($request->has('image')) {
                $new_files = [];
                $old_files = [];
                foreach ($request->input('image') as $file) {
                    if(Str::isUrl($file)){
                        $old_files[] = basename($file);
                    }else{
                        $newFilename = Str::after($file, 'tmp/');
                        File::move('storage/products/thumb/tmp/'.$newFilename, 'storage/products/thumb/'.$newFilename);
                        File::move('storage/products/tmp/'.$newFilename, 'storage/products/'.$newFilename);
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

            $citydata = Cities::find($request->city);
            $country = $citydata['country_code'];
            $state = $citydata['subadmin1_code'];
            $mapLat = $request->latitude;
            $mapLong = $request->longitude;
            $latlong = $mapLat . "," . $mapLong;

            if(config('settings.post_desc_editor') == 1)
                $description = $request->description;
            else
                $description = $request->description;


            if($request->has('custom')) {
                foreach($request->custom as $key=>$value){
                    if(is_array($value)){
                        $field_data = implode(',',$value);
                    }else{
                        $field_data = $value;
                    }

                    CustomData::updateOrCreate(
                        [
                            'post_id' => $post->id,
                            'field_id' => $key
                        ], [

                            'field_data' => $field_data
                        ]
                    );
                }
            }

            $update = $post->update([
                'title' => $request->title,
                'description' => $description,
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
            ]);

            if ($update) {

                $amount = 0;
                $trans_desc = ___('Package');

                if(Auth::check()){
                    $plan = Auth::user()->plan();
                }else{
                    $plan = config('settings.free_membership_plan');
                }

                $featured_project_fee = $plan->settings->featured_project_fee;
                $urgent_project_fee = $plan->settings->urgent_project_fee;
                $highlight_project_fee = $plan->settings->highlight_project_fee;

                if ($request->has('featured') && $request->featured == 1) {
                    $amount = $featured_project_fee;
                    $trans_desc = $trans_desc ." ". ___('Featured');
                }
                if ($request->has('urgent') && $request->urgent == 1) {
                    $amount = $amount + $urgent_project_fee;
                    $trans_desc = $trans_desc ." ". ___('Urgent');
                }
                if ($request->has('highlight') && $request->highlight == 1) {
                    $amount = $amount + $highlight_project_fee;
                    $trans_desc = $trans_desc ." ". ___('Highlight');
                }

                if ($amount > 0) {
                    $payment_type = "premium";
                    $coupon = null;
                    $applied_tax_ids = $applied_taxes = [];
                    $user_options = user_options($post->user_id);

                    /* Create transaction to store all the details for further actions */
                    $transaction = Transaction::create([
                        'product_name' => $request->title.' (#'.$post->id.')',
                        'product_id' => $post->id,
                        'user_id' => $post->user_id,
                        'base_amount' => $amount,
                        'amount' => $amount,
                        'currency_code' => config('settings.currency_code'),
                        'transaction_method' => $payment_type,
                        'transaction_ip' => $request->ip(),
                        'transaction_time' => Carbon::now()->timestamp,
                        'transaction_description' => $trans_desc,
                        'details' => [
                            'payment_type' => $payment_type,
                            'trans_desc' => $trans_desc,
                            'featured' => $request->featured,
                            'urgent' => $request->urgent,
                            'highlight' => $request->highlight,
                        ],
                        'billing' => [
                            'type' => @$user_options->billing_details_type,
                            'tax_id' => @$user_options->billing_tax_id,
                            'name' => @$user_options->billing_name,
                            'address' => @$user_options->billing_address,
                            'city' => @$user_options->billing_city,
                            'state' => @$user_options->billing_state,
                            'zipcode' => @$user_options->billing_zipcode,
                            'country' => @$user_options->billing_country
                        ],
                    ]);

                    $redirect_url = route('payment.index', $transaction->id);

                    $result = array(
                        'status' => "success",
                        'ad_type' => "package",
                        'redirect' => $redirect_url,
                        'message' => ___('Updated Successfully')
                    );
                } else {
                    $result = array(
                        'status' => "success",
                        'ad_type' => "free",
                        'redirect' => route('posts.single', [$post->id,$post->slug]),
                        'message' => ___('Updated Successfully')
                    );
                }

                return response()->json($result, 200);
            }
        }

        $result = array(
            'status' => "error",
            'message' => ___('Unexpected Error'),
        );
        return response()->json($result, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        return abort(404);
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
        $result = array(
            'success' => true,
            'message' => ___('File Removed')
        );
        return response()->json($result, 200);

    }

    /**
     * Add/Remove to favorites list.
     *
     * @param Request $request
     * @return JsonResponse|void
     */
    public function setFavorite(Request $request)
    {
        if(!Auth::check()) {
            $result = array('success' => false, 'message' => ___('Login Required.'));
            return response()->json($result, 200);
        }
        $post_id = $request->has('post_id') ? $request->get('post_id') : 0;

        if($post_id != 0) {
            $user = Auth::user();
            if ($user->favorites()->where('post_id', $post_id)->exists()) {
                $user->favorites()->detach($post_id);
                $result = array('success' => false, 'message' => ___('Removed to Favorites.'));
            }else{
                $user->favorites()->attach($post_id);
                $result = array('success' => true, 'message' => ___('Added to Favorites.'));
            }
            return response()->json($result, 200);
        }

        die();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function deleteMyListing(Request $request, $id)
    {
        if(!Auth::check()) {
            $result = array('success' => false, 'message' => ___('Login Required.'));
            return response()->json($result, 200);
        }

        $post = Post::find($request->id);

        if ($post->user_id == request()->user()->id) {
            if (!empty($post->images)) {
                $images = explode(',',$post->images);
                foreach($images as $image){
                    if(file_exists(public_path('storage/products/thumb/' . $image))){
                        remove_file('storage/products/thumb/' . $image);
                    }
                    if(file_exists(public_path('storage/products/'.$image))){
                        remove_file('storage/products/' . $image);
                    }
                }
            }
            Review::where('post_id', $post->id)->delete();
            CustomData::where('post_id', $post->id)->delete();
            PostOption::where('post_id', $post->id)->delete();
            $user = Auth::user();
            $user->favorites()->where('post_id', $post->id)->delete();
            $post->delete();
            $result = array(
                'success' => true,
                'message' => ___('Listing Deleted Successfully')
            );
        }else{
            $result = array(
                'success' => true,
                'message' => ___('This listing not belongs to you.')
            );
        }
        return response()->json($result, 200);
    }

    /**
     * Show/Hide listing.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function setShowHide(Request $request, $id)
    {
        if(!Auth::check()) {
            $result = array('success' => false, 'message' => ___('Login Required.'));
            return response()->json($result, 200);
        }

        $post_id = $request->id;

        $post = Post::find($post_id);

        if($post->hide == '0'){
            $update = $post->update([
                'hide' => '1',
            ]);
            $result = array('type' => 1, 'message' => ___('Post is hidden.'));
        }else{
            $update = $post->update([
                'hide' => '0',
            ]);
            $result = array('type' => 2, 'message' => ___('Post is visible.'));
        }
        return response()->json($result, 200);
    }

    /**
     * Get sub categories by main category id.
     *
     * @param Request $request
     * @return void
     */
    public function getsubcatbyidList(Request $request)
    {
        $id = $request->has('catid') ? $request->get('catid') : 0;
        $selectid = $request->has('selectid') ? $request->get('selectid') : null;

        $rows = SubCategory::where('category_id',$id)
            ->orderBy('order', 'asc')
            ->get();

        if (count($rows) > 0) {
            foreach ($rows as $info) {
                $sub_id = $info['id'];
                $photo_show = $info['photo_show'];
                $price_show = $info['price_show'];
                $selected_text = ($selectid == $sub_id) ? "link-active" : "";
                $name = (config('settings.userlangsel'))
                    ? $info->get_translated_title()
                    : $info['name'];

                echo '<li data-ajax-subcatid="'.$sub_id.'" data-photo-show="'.$photo_show.'" data-price-show="'.$price_show.'" class="'.$selected_text.'"><a href="#">'.$name.'</a></li>';
            }

        }else{
            echo 0;
        }
        die();
    }

}
