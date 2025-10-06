<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mails\ContactSeller;
use App\Mails\ListingApprove;
use App\Mails\ListingReject;
use App\Models\Category;
use App\Models\Cities;
use App\Models\Countries;
use App\Models\CustomData;
use App\Models\CustomField;
use App\Models\Districts;
use App\Models\Post;
use App\Models\PostOption;
use App\Models\Regions;
use App\Models\Review;
use App\Models\SubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserAjaxController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->activeTheme = active_theme();

        if (request()->action == "installCountry" || request()->action == "uninstallCountry" || request()->action == "approveListing" || request()->action == "rejectListing") {
            $this->middleware('demo');
        }
    }

    public function index(Request $request)
    {
        if ($request->has('action')) {
            if ($request->action == "installCountry") { return $this->installCountry($request); }
            if ($request->action == "uninstallCountry") { return $this->uninstallCountry($request); }
            if ($request->action == "approveListing") { return $this->approveListing($request); }
            if ($request->action == "rejectListing") { return $this->rejectListing($request); }

            if ($request->action == "emailContactSeller") { return $this->emailContactSeller($request); }
            if ($request->action == "getCityidByCityName") { return $this->getCityidByCityName($request); }
            if ($request->action == "searchStateCountry") { return $this->searchStateCountry($request); }
            if ($request->action == "searchCityFromCountry") { return $this->searchCityFromCountry($request); }
            if ($request->action == "ModelGetCityByStateID") { return $this->ModelGetCityByStateID($request); }
            if ($request->action == "ModelGetStateByCountryID") { return $this->ModelGetStateByCountryID($request); }
            if ($request->action == "getCustomFieldByCatID") { return $this->getCustomFieldByCatID($request); }
            if ($request->action == "ajaxHomeSearch") { return $this->ajaxHomeSearch($request); }

            if ($request->action == "getlocHomemap") { return $this->getlocHomemap($request); }
            if ($request->action == "openlocatoionPopup") { return $this->openlocatoionPopup($request); }

        }
    }

    /**
     * Install Country By Country Code
     * @param Request $request
     * @return false|JsonResponse
     * @throws \Exception
     */
    public function installCountry(Request $request)
    {
        $country = Countries::find($request->id);
        $country_code = $country->code;
        // Default Country SQL File
        $filePath = storage_path('database/geonames/countries/' . strtolower($country_code) . '.sql');
        if (!File::exists($filePath)) {
            return false;
        }
        // Import the SQL file
        importSqlFile(DB::connection()->getPdo(), $filePath, DB::getTablePrefix());

        $update = $country->update(['active' => '1',]);

        $result = array('success' => true, 'message' => ___('Installed Successfully'));
        return response()->json($result, 200);
    }

    /**
     * Uninstall Country By Country Code
     * @param Request $request
     * @return false|JsonResponse
     */
    public function uninstallCountry(Request $request)
    {
        $country = Countries::find($request->id);
        $country_code = $country->code;

        // Delete all SubAdmin1
        $admin1s = Regions::where('country_code',$country_code);
        if ($admin1s->count() > 0) {
            foreach ($admin1s->cursor() as $admin1) {
                $admin1->delete();
            }
        }

        // Delete all SubAdmin2
        $admin2s = Districts::where('country_code',$country_code);
        if ($admin2s->count() > 0) {
            foreach ($admin2s->cursor() as $admin2) {
                $admin2->delete();
            }
        }

        // Delete all Cities
        $cities = Cities::where('country_code',$country_code);
        if ($cities->count() > 0) {
            foreach ($cities->cursor() as $city) {
                $city->delete();
            }
        }

        // Delete all Posts
        $posts = Post::where('country_code',$country_code);
        if ($posts->count() > 0) {
            foreach ($posts->cursor() as $post) {
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
            }
        }

        $update = $country->update(['active' => '0',]);
        $result = array('success' => true, 'message' => ___('Unistalled Successfully'));
        return response()->json($result, 200);
    }

    /**
     * Send email to listing owner for inquiry.
     * @param Request $request
     * @return false|JsonResponse
     */
    public function emailContactSeller(Request $request)
    {
        if($request->has('id')){
            $post = Post::find($request->id);
            $user = $post->user;
            /* Send contact to seller email */
            $short_codes = [
                'post_title' => $post->title,
                'post_link' => route('posts.single', [$post->id,$post->slug]),
                'seller_name' => $user->name,
                'seller_email' => $user->email,
                'sender_name' => $request->name,
                'sender_email' => $request->email,
                'sender_phone' => $request->phone,
                'message' => $request->message,
            ];
            $user->sendMail(new ContactSeller($short_codes));

            $result = array('success' => true, 'message' => ___('Email send successfully'));
            return response()->json($result, 200);
        }else{
            $result = array('success' => false, 'message' => ___('Email sending failed'));
            return response()->json($result, 200);
        }
    }

    /**
     * Approve pending listing by admin user
     * @param Request $request
     * @return false|JsonResponse
     */
    public function approveListing(Request $request)
    {
        if (request()->user()->isAdmin()) {
            $post = Post::find($request->id);
            $update = $post->update(['status' => Post::STATUS_ACTIVE]);
            if ($update) {

                $user = $post->user;
                /* Send email to user : Listing is approved. */
                $short_codes = [
                    'post_title' => $post->title,
                    'post_link' => route('posts.single', [$post->id,$post->slug]),
                    'seller_name' => $user->name,
                    'seller_email' => $user->email,
                ];
                $user->sendMail(new ListingApprove($short_codes));

                $result = array('success' => true, 'message' => ___('Approved Successfully'));
            }else{
                $result = array('success' => false, 'message' => ___('Error'));
            }
        }else{
            $result = array('success' => false, 'message' => ___('Only admin user can approve listings.'));
        }

        return response()->json($result, 200);
    }

    /**
     * Reject pending listing by admin user
     * @param Request $request
     * @return false|JsonResponse
     */
    public function rejectListing(Request $request)
    {
        if (request()->user()->isAdmin()) {
            $post = Post::find($request->id);
            $update = $post->update(['status' => Post::STATUS_REJECTED]);
            if ($update) {
                $user = $post->user;
                /* Send email to user : Listing is rejected. */
                $short_codes = [
                    'post_title' => $post->title,
                    'post_link' => route('posts.single', [$post->id,$post->slug]),
                    'seller_name' => $user->name,
                    'seller_email' => $user->email,
                ];
                $user->sendMail(new ListingReject($short_codes));

                $result = array('success' => true, 'message' => ___('Listing Rejected'));
            }else{
                $result = array('success' => false, 'message' => ___('Error'));
            }
        }else{
            $result = array('success' => false, 'message' => ___('Only admin user can reject listings.'));
        }

        return response()->json($result, 200);
    }

    /**
     * Get city id by city name
     * @param Request $request
     * @return JsonResponse
     */
    public function getCityidByCityName(Request $request)
    {
        $country_code = ($request->has('country')) ? $request->country : "";
        $state = ($request->has('state')) ? $request->state : "";
        $city_name = ($request->has('city')) ? $request->city : "";

        $city = Cities::where(array(
            'country_code' => $country_code,
            'active' => '1'
        ))->whereRaw('(`name` = ? OR `name` = ?)', array($city_name, $city_name))
            ->first();


        if($city){
            if ($city->id) {
                $id = $city->id;
            }
        }else{
            $id = "";
        }
        $result = array('success' => true, 'id' => $id);
        return response()->json($result, 200);
    }

    /**
     * Search regions(states) by keyword search.
     * @param Request $request
     * @return JsonResponse
     */
    public function searchStateCountry(Request $request){
        $dataString = $request->dataString;
        $country_code = get_user_country();

        $cities = Cities::where(array(
            'country_code' => $country_code,
            'active' => '1'
        ))->Where('name', 'like', '%' . $dataString . '%');

        $case1 = $dataString;
        $case2 = $dataString . '%';
        $case3 = '%' . $dataString . '%';

        $cities->orderByRaw("CASE
                WHEN name LIKE '$case1' THEN 1
                WHEN name LIKE '$case2' THEN 2
                WHEN name LIKE '$case3' THEN 3
                ELSE 4
                END");

        $cities = $cities->with(['region','country'])
            ->paginate(5)
            ->appends(request()->query());

        $html = '<ul class="searchResgeo"><li><a href="#" class="title selectme" data-id="" data-name="" data-type="">'.___('Any City').'</span></a></li>';
        if (count($cities)){
            foreach ($cities as $city) {
                $cityid = $city->id;
                $cityname = $city->name;
                $stateid = $city->subadmin1_code;
                $statename = $city->region->name;

                $html .= '<li><a href="#" class="title selectme" data-id="'.$cityid.'" data-name="'.$cityname.'" data-type="city">'.$cityname.', <span class="color-9">'.$statename.'</span></a></li>';
            }
            $html .= '</ul>';
        }
        else{
            $html = '<ul class="searchResgeo"><li><span class="noresult">'.___('No Results Found').'</span></li>';
        }

        $result = array('success' => true, 'data' => $html);
        return response()->json($result, 200);
    }

    /**
     * Search cities by keyword search.
     * @param Request $request
     * @return JsonResponse
     */
    public function searchCityFromCountry(Request $request)
    {
        if (Auth::check() && request()->user()->isAdmin()) {
            $conditions = [
                'active' => '1'
            ];
        }else{
            $conditions = [
                'country_code' => get_user_country(),
                'active' => '1'
            ];
        }


        $dataString = $request->has('q') ? $request->get('q') : "";

        $total = Cities::where($conditions)
            ->where('name', 'like', '' . $dataString . '%')
            ->count();

        $cities = Cities::where($conditions);

        if ($dataString != null) {
            $cities->where(function ($q) use ($dataString) {
                foreach (explode(' ', trim($dataString)) as $word) {
                    $q->where('name', 'like', '%' . $word . '%');
                }
            });

            $case1 = $dataString . '%';
            $case2 = '%' . $dataString . '%';

            $cities->orderByRaw("CASE
                WHEN name LIKE '$case1' THEN 1
                WHEN name LIKE '$case2' THEN 2
                ELSE 3
                END");
        }

        $rows = $cities->with(['region','country'])
            ->paginate(10)
            ->appends(request()->query());

        $i = 0;
        $MyCity = array();

        foreach ($rows as $row) {
            $cityid = $row['id'];
            $cityname = $row['name'];
            $latitude = $row['latitude'].'000';
            $longitude = $row['longitude'].'000';
            $statename = $row->region->name;
            $countryname = $row->country->name;

            $MyCity[$i]["id"]   = $cityid;
            $MyCity[$i]["text"] = $cityname.", ".$statename.", ".$countryname;
            $MyCity[$i]["latitude"]   = $latitude;
            $MyCity[$i]["longitude"]   = $longitude;
            $i++;
        }

        $result = array(
            'success' => true,
            'items' => $MyCity,
            'totalEntries' => $total
        );
        return response()->json($result, 200);

    }

    /**
     * Get city by state id for location search modal.
     * @param Request $request
     * @return JsonResponse
     */
    public function ModelGetCityByStateID(Request $request)
    {
        $state_id = ($request->has('id')) ? $request->id : "";
        $country_code = substr($state_id,0,2);
        $state = Regions::where('code',$state_id)->first();
        $stateName = $state->name;

        $cities = Cities::where(array(
            'country_code' => $country_code,
            'subadmin1_code' => $state_id,
            'active' => '1'
        ))->orderBy('name')->get();

        $total = count($cities);
        $list = '<ul class="column col-md-12 col-sm-12 cities">';
        $count = 1;
        if ($total > 0) {
            foreach ($cities as $city) {
                $name = $city->name;
                $id = $city->id;
                if($count == 1)
                {
                    $list .=  '<li class="selected"><a id="changeState"><strong><i class="fa fa-arrow-left"></i>'.___('Change region').'</strong></a></li>';
                    $list .=  '<li class="selected"><a class="selectme" data-id="'.$state_id.'" data-name="'.$stateName.', '.___('Region').'" data-type="state"><strong>'.___('Whole').' '.$stateName.'</strong></a></li>';
                }

                $list .= '<li class=""><a id="region'.$id.'" class="selectme" data-id="'.$id.'" data-name="'.$name.', '.___('City').'" data-type="city"><span>'.$name.' <i class="fa fa-angle-right"></i></span></a></li>';
                $count++;
            }

            $list .= "</ul>";
        }else{
            $list = '<ul class="column col-md-12 col-sm-12 cities">
            <li class="selected"><a id="changeState"><strong><i class="fa fa-arrow-left"></i>'.___('Change region').'</strong></a></li>
            <li><a> '.___('No city available').'</a></li>
            </ul>';
        }
        $result = array('success' => true, 'data' => $list);
        return response()->json($result, 200);
    }

    /**
     * Get state by country code for location search modal.
     * @param Request $request
     * @return JsonResponse
     */
    public function ModelGetStateByCountryID(Request $request){
        $country_code = ($request->has('id')) ? $request->id : "";
        $countryName = get_country_name($country_code);
        $rows = Regions::where(array(
            'country_code' => $country_code,
            'active' => '1'
        ))->orderBy('name')->get();

        $list = '<ul class="column col-md-12 col-sm-12 cities">';
        $count = 1;
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $name = $row->name;
                $id = $row->code;
                if($count == 1) {
                    $list .=  '<li class="selected"><a class="selectme" data-id="'.$country_code.'" data-name="'.___('ALL').' '.$countryName.'" data-type="country"><strong>'.___('ALL').' '.$countryName.'</strong></a></li>';
                }
                $list .= '<li class=""><a id="region'.$id.'" class="statedata" data-id="'.$id.'" data-name="'.$name.'"><span>'.$name.' <i class="fa fa-angle-right"></i></span></a></li>';

                $count++;
            }
            $list .= "</ul>";
        }
        $result = array('success' => true, 'data' => $list);
        return response()->json($result, 200);
    }

    /**
     * Get custom fields by category id.
     *
     * @param Request $request
     * @return void
     */
    public function getCustomFieldByCatID(Request $request)
    {
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
                    if(active_theme() == 'classic-theme'){
                        $inputClass = "default-input quick-text";
                    }
                    else {
                        $inputClass = "form-control with-border quick-text";
                    }
                    $tpl .= '<div class="row form-group">
                            <label class="col-sm-3 label-title">'.$name.' '.($required === "1" ? '<span class="required">*</span>' : "").'</label>
                            <div class="col-sm-9">
                                <input name="custom['.$id.']" id="custom['.$id.']" class="'.$inputClass.'"  type="text" value="'.$default.'" placeholder="'.$name.'" data-name="'.$id.'" data-req="'.$required.'"/>
                                <div class="quick-error">'.___('This field is required.').'</div>
                            </div>
                        </div>';
                }
                elseif($type == "textarea"){
                    if(active_theme() == 'classic-theme'){
                        $inputClass = "default-textarea quick-textArea";
                    }
                    else {
                        $inputClass = "materialize-textarea form-control with-border quick-textArea";
                    }
                    $tpl .= '<div class="row form-group">
                                <label class="col-sm-3 label-title">'.$name.' '.($required === "1" ? '<span class="required">*</span>' : "").'</label>
                                <div class="col-sm-9">
                                    <textarea class="'.$inputClass.'" name="custom['.$id.']" id="custom['.$id.']" placeholder="'.$name.'" data-name="'.$id.'" data-req="'.$required.'">'.$default.'</textarea>
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
                    if(active_theme() == 'classic-theme'){
                        $inputClass = "default-select quick-select";
                    }
                    else {
                        $inputClass = "form-control selectpicker with-border quick-select";
                    }
                    $tpl .= '<div class="row form-group">
                                <label class="col-sm-3 label-title">'.$name.' '.($required === "1" ? '<span class="required">*</span>' : "").'</label>
                                <div class="col-sm-9">
                                    <select class="'.$inputClass.'" name="custom['.$id.']" data-name="'.$id.'" data-req="'.$required.'">
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

                            if(active_theme() == 'classic-theme'){
                                echo '<div class="radio"><input class="Radio-input" type="radio" name="custom[' . $id . ']" id="' . $value3 . $i . '" value="' . $value3 . '" data-name="' . $id . '" ' . $checked . ' />
                            <label for="' . $value3 . $i . '" class="Radio-label">' . $option_title . '</label></div>';
                            }
                            else {
                                echo '<div class="radio radio-primary radio-inline form-check margin-right-5"><input class="with-gap form-check-input" type="radio" name="custom[' . $id . ']" id="' . $value3 . $i . '" value="' . $value3 . '" data-name="' . $id . '" ' . $checked . ' />
                            <label for="' . $value3 . $i . '" class="form-check-label"><span class="radio-label"></span>' . $option_title . '</label></div>';
                            }


                            $i++;
                        }
                    }
                    $option_php_output = ob_get_contents();
                    ob_end_clean();

                    $tpl .= '<div class="row form-group">
                                <label class="col-sm-3 label-title">'.$name.' '.($required === "1" ? '<span class="required">*</span>' : "").'</label>
                                <div class="col-sm-9">
                                    '.$option_php_output.'
                                    <input type="hidden" class="form-control quick-radioCheck" data-name="'.$id.'" data-req="'.$required.'">
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

                            if(active_theme() == 'classic-theme'){
                                echo '<div class="checkbox"><input class="Checkbox-input" type="checkbox" name="custom[' . $id . '][]" id="' . $value4 . $j . '" value="' . $value4 . '" ' . $selected . ' data-name="' . $id . '" />
                            <label class="Checkbox-label" for="' . $value4 . $j . '">' . $option_title . '</label></div>';
                            }
                            else {
                                echo '<div class="checkbox"><input type="checkbox" name="custom[' . $id . '][]" id="' . $value4 . $j . '" value="' . $value4 . '" ' . $selected . ' data-name="' . $id . '" />
                            <label for="' . $value4 . $j . '"><span class="checkbox-icon"></span>' . $option_title . '</label></div><br>';
                            }



                            $j++;
                        }
                    }

                    $option_php_output = ob_get_contents();
                    ob_end_clean();

                    $tpl .= '<div class="row form-group">
                                <label class="col-sm-3 label-title">'.$name.' '.($required === "1" ? '<span class="required">*</span>' : "").'</label>
                                <div class="col-sm-9">
                                    '.$option_php_output.'
                                    <input type="hidden" class="form-control quick-radioCheck" data-name="'.$id.'" data-req="'.$required.'">
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
    /**
     * Home page ajax keyword search.
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxHomeSearch(Request $request){
        $searchmode = "titlematch";
        $qString      = '';
        $qString      = $request->tagID;
        $qString      = strtolower($qString);
        $output       = array();
        $TAGOutput    = array();
        $CATOutput    = array();
        $TagCatOutput = array();
        $TitleOutput  = array();
        $lpsearchMode = "titlematch";
        $catIcon_type = "icon";

        if( isset($searchmode) ){
            if( !empty($searchmode) && $searchmode=="keyword" ){
                $lpsearchMode = "keyword";
            }
        }

        if (empty($qString)) {
            $categories = Category::get();
            $catIcon    = '';
            foreach ($categories as $category) {
                if (!empty($category->icon) OR !empty($category->picture)) {
                    if($category->picture != "")
                        $catIcon = '<img src="' . $category->picture . '" />';
                    else
                        $catIcon = '<i class="' . $category->icon . '" ></i>';
                }
                $cats[$category->id] = '<li class="lp-default-cats" data-catid="' . $category->id . '">' . $catIcon . '<span class="qucikad-as-cat">' . $category->name . '</span></li>';
            }
            $output = array(
                'cats' => $cats,
                'tag' => '',
                'tagsncats' => '',
                'titles' => '',
                'more' => ''
            );
            $query_suggestion = json_encode(array(
                "tagID" => $qString,
                "suggestions" => $output
            ));
            die($query_suggestion);
        }
        else {
            if( $lpsearchMode == "keyword" ){

                $categories = Category::where('name', 'like', '%' . $qString . '%');

                $case1 = $qString;
                $case2 = $qString . '%';
                $case3 = '%' . $qString . '%';

                $categories = $categories->orderByRaw("CASE
                WHEN name LIKE '$case1' THEN 1
                WHEN name LIKE '$case2' THEN 2
                WHEN name LIKE '$case3' THEN 3
                ELSE 4
                END")->get();

            }else{

                $categories = Category::where('name', 'like', '%' . $qString . '%');

                $case1 = $qString;
                $case2 = $qString . '%';
                $case3 = '%' . $qString . '%';

                $categories = $categories->orderByRaw("CASE
                WHEN name LIKE '$case1' THEN 1
                WHEN name LIKE '$case2' THEN 2
                WHEN name LIKE '$case3' THEN 3
                ELSE 4
                END")->get();

            }

            foreach ($categories as $category) {
                $catTerms[$category->id]['id'] = $category->id;
                $catTerms[$category->id]['icon'] = $category->icon;
                $catTerms[$category->id]['picture'] = $category->picture;
                $catTerms[$category->id]['name'] = $category->get_translated_title();
                $catTerms[$category->id]['slug'] = $category->get_translated_slug();
            }


            if( $lpsearchMode == "keyword" ){
                $subcategories = SubCategory::where('name', 'like', '%' . $qString . '%');

                $case1 = $qString;
                $case2 = $qString . '%';
                $case3 = '%' . $qString . '%';

                $subcategories->orderByRaw("CASE
                WHEN name LIKE '$case1' THEN 1
                WHEN name LIKE '$case2' THEN 2
                WHEN name LIKE '$case3' THEN 3
                ELSE 4
                END");

                $subcategories = $subcategories->with('categories')->get();

            }else{

                $subcategories = SubCategory::where('name', 'like', '%' . $qString . '%');

                $case1 = $qString;
                $case2 = $qString . '%';
                $case3 = '%' . $qString . '%';

                $subcategories->orderByRaw("CASE
                WHEN name LIKE '$case1' THEN 1
                WHEN name LIKE '$case2' THEN 2
                WHEN name LIKE '$case3' THEN 3
                ELSE 4
                END");

                $subcategories = $subcategories->with('categories')->get();

            }
            foreach ($subcategories as $subcategory) {
                $subcatTerms[$subcategory->id]['id'] = $subcategory->id;
                $subcatTerms[$subcategory->id]['category_id'] = $subcategory->category_id;
                $subcatTerms[$subcategory->id]['name'] = $subcategory->get_translated_title();
                $subcatTerms[$subcategory->id]['slug'] =  $subcategory->get_translated_slug();
                $get_main = Category::where('id', $subcategory->category_id)->first();
                $subcatTerms[$subcategory->id]['main_cat_name'] = $get_main->cat_name;
                $subcatTerms[$subcategory->id]['main_cat_icon'] = $get_main->icon;
                $subcatTerms[$subcategory->id]['main_cat_pic'] = $get_main->picture;

            }

            $catName  = '';
            $catIcon  = '';
            if (!empty($catTerms) && !empty($subcatTerms)) {
                foreach ($catTerms as $cat) {
                    $catIcon = $cat['icon'];
                    $catPicture = $cat['picture'];
                    if (!empty($catIcon) OR !empty($catPicture)) {
                        if($catPicture != "")
                            $catIcon = '<img src="' . $cat['picture'] . '" />';
                        else
                            $catIcon = '<i class="' . $cat['icon'] . '" ></i>';
                    }

                    $catTermMatch = false;

                    $catTernName  = $cat['name'];
                    $catTernName  = strtolower($catTernName);
                    if( $lpsearchMode == "keyword" ){
                        preg_match("/[$qString]/", "$catTernName", $lpMatches, PREG_OFFSET_CAPTURE);
                        $lpresCnt = count($lpMatches);
                        if( $lpresCnt > 0 ){
                            $catTermMatch = true;
                        }

                    }else{
                        $catTermMatch = strpos($catTernName, $qString);
                    }

                    if ( $catTermMatch !== false ) {
                        $CATOutput[$cat['id']] = '<li class="qucikad-ajaxsearch-li-cats" data-catid="' . $cat['id'] . '">' . $catIcon . '<span class="qucikad-as-cat">' . $cat['name'] . '</span></li>';
                    }
                }
                foreach ($subcatTerms as $subcat) {

                    $tagTermMatch = false;
                    $tagTernName  = strtolower($subcat['name']);

                    if( $lpsearchMode == "keyword" ){
                        preg_match("/[$qString]/", "$tagTernName", $lpMatches, PREG_OFFSET_CAPTURE);
                        $lpresCnt = count($lpMatches);
                        if( $lpresCnt > 0 ){
                            $tagTermMatch = true;
                        }
                    }else{
                        $tagTermMatch = strpos($tagTernName, $qString);
                    }

                    if ( $tagTermMatch !== false ) {
                        $TAGOutput[$subcat['id']] = '<li class="qucikad-ajaxsearch-li-tags" data-tagid="' . $subcat['id'] . '"><span class="qucikad-as-tag">' . $subcat['name'] . '</span></li>';
                    }
                }

            }
            else {

                if( !empty($catTerms) ){
                    foreach ($catTerms as $cat) {

                        $catIcon = $cat['icon'];
                        $catPicture = $cat['picture'];
                        if (!empty($catIcon) OR !empty($catPicture)) {
                            if($catPicture != "")
                                $catIcon = '<img src="' . $cat['picture'] . '" />';
                            else
                                $catIcon = '<i class="' . $cat['icon'] . '" ></i>';
                        }

                        $catTermMatch = false;

                        $catTernName  = $cat['name'];
                        $catTernName  = strtolower($catTernName);
                        if( $lpsearchMode == "keyword" ){
                            preg_match("/[$qString]/", "$catTernName", $lpMatches, PREG_OFFSET_CAPTURE);
                            $lpresCnt = count($lpMatches);
                            if( $lpresCnt > 0 ){
                                $catTermMatch = true;
                            }

                        }else{
                            $catTermMatch = strpos($catTernName, $qString);
                        }

                        if ( $catTermMatch !== false ) {
                            $CATOutput[$cat['id']] = '<li class="qucikad-ajaxsearch-li-cats" data-catid="' . $cat['id'] . '">' . $catIcon . '<span class="qucikad-as-cat">' . $cat['name'] . '</span></li>';
                        }
                    }
                }

                if( !empty($subcatTerms) ) {

                    foreach ($subcatTerms as $subcat) {

                        $catIcon = $subcat['main_cat_icon'];
                        $catPicture = $subcat['main_cat_pic'];
                        if (!empty($catIcon) OR !empty($catPicture)) {
                            if($catPicture != "")
                                $catIcon = '<img src="' . $catPicture . '" />';
                            else
                                $catIcon = '<i class="' . $catIcon . '" ></i>';
                        }

                        $tagTermMatch = false;
                        $tagTernName  = strtolower($subcat['name']);

                        if( $lpsearchMode == "keyword" ){
                            preg_match("/[$qString]/", "$tagTernName", $lpMatches, PREG_OFFSET_CAPTURE);
                            $lpresCnt = count($lpMatches);
                            if( $lpresCnt > 0 ){
                                $tagTermMatch = true;
                            }
                        }else{
                            $tagTermMatch = strpos($tagTernName, $qString);
                        }

                        if ( $tagTermMatch !== false ) {
                            $TagCatOutput[] = '<li class="cats-n-tags" data-tagid="' . $subcat['id'] . '" data-catid="' . $subcat['category_id'] . '">' . $catIcon . '<span class="qucikad-as-tag">' . $subcat['name'] . '</span><span> in </span><span class="qucikad-as-cat">' . $subcat['main_cat_name'] . '</span></li>';
                        }
                    }

                }
            }

            $machTitles = false;
            $country_code = get_user_country();

            if( $lpsearchMode == "keyword" ){

                $posts = Post::where(array(
                    'status' => Post::STATUS_ACTIVE,
                    'country_code' => $country_code,
                    'hide' => '0'
                ))->where('title', 'like', '%' . $qString . '%');

                $case1 = $qString . '%';
                $case2 = '%' . $qString . '%';

                $posts->orderByRaw("CASE
                WHEN title LIKE '$case1' THEN 1
                WHEN title LIKE '$case2' THEN 2
                ELSE 3
                END");

                $posts = $posts->with(['user','city','country'])
                    ->paginate(25)
                    ->appends(request()->query());

            }else{

                $posts = Post::where(array(
                    'status' => Post::STATUS_ACTIVE,
                    'country_code' => $country_code,
                    'hide' => '0'
                ))->where('title', 'like', '%' . $qString . '%');

                $case1 = $qString . '%';
                $case2 = '%' . $qString . '%';

                $posts->orderByRaw("CASE
                WHEN title LIKE '$case1' THEN 1
                WHEN title LIKE '$case2' THEN 2
                ELSE 3
                END");

                $posts = $posts->with(['user','city','country'])
                    ->paginate(25)
                    ->appends(request()->query());

            }


            if (count($posts) > 0) {
                $machTitles = true;      // output data of each row
                foreach ($posts as $post) {

                    // Get usergroup details
                    $group_id = $post->group_id;
                    $listTitle  = $post->title;
                    $listTitle  = strtolower($listTitle);
                    $permalink = route('posts.single', [$post->id,$post->slug]);
                    $cityname = @$post->city->name;
                    $countryname = @$post->country->name;


                    $listThumb = '';
                    $picture =   explode(',' ,$post->images);
                    $image = asset('storage/products/thumb/default.png');
                    if (!empty($picture[0])) {
                        if(file_exists(public_path('storage/products/thumb/'.$picture[0]))){
                            $image = asset('storage/products/thumb/'.$picture[0]);
                        }
                    }
                    $listThumb = '<img src="'.$image.'" width="50" height="50"/>';
                    $TitleOutput[] = '<li class="qucikad-ajaxsearch-li-title" data-url="' . $permalink . '">' . $listThumb . '<span class="qucikad-as-title"><a href="' . $permalink . '">' . $listTitle . ' <span class="lp-loc">' . $cityname . ', ' . $countryname . '</span></a></span></li>';

                }
            }

            $TAGOutput    = array_unique($TAGOutput);
            $CATOutput    = array_unique($CATOutput);
            $TagCatOutput = array_unique($TagCatOutput);
            $TitleOutput  = array_unique($TitleOutput);
            if ((!empty($TAGOutput) && count($TAGOutput) > 0) || (!empty($CATOutput) && count($CATOutput) > 0) || (!empty($TagCatOutput) && count($TagCatOutput) > 0) || (!empty($TitleOutput) && count($TitleOutput) > 0)) {
                $output = array(
                    'tag' => $TAGOutput,
                    'cats' => $CATOutput,
                    'tagsncats' => $TagCatOutput,
                    'titles' => $TitleOutput,
                    'more' => '',
                    'matches' => $machTitles
                );
            } else {
                $moreResult = array();
                $mResults   = '<strong>' . ___('More results for') . '</strong>';
                $mResults .= $qString;
                $moreResult[] = '<li class="qucikad-ajaxsearch-li-more-results" data-moreval="' . $qString . '">' . $mResults . '</li>';
                $output       = array(
                    'tag' => '',
                    'cats' => '',
                    'tagsncats' => '',
                    'titles' => '',
                    'more' => $moreResult
                );
            }
            $query_suggestion = json_encode(array(
                "tagID" => $qString,
                "suggestions" => $output
            ));
            die($query_suggestion);
        }
    }

    public function getlocHomemap(Request $request)
    {
        if (config('settings.home_map_marker_limit')) {
            $page_limit = config('settings.home_map_marker_limit');
        }else{
            $page_limit = 20;
        }

        $conditions = [
            'status' => Post::STATUS_ACTIVE,
            'country_code' => get_user_country()
        ];

        $serachStr = $request->has('serachStr') ? $request->get('serachStr') : null;
        $searchBox = $request->has('searchBox') ? $request->get('searchBox') : null;
        $subcat = $request->has('subcat') ? $request->get('subcat') : null;
        $state = $request->has('state') ? $request->get('state') : null;

        if(!empty($request->city)){
            $city = $request->get('city');
        }
        else{
            if(!empty($request->locality)){
                $city = $request->get('locality');
            }else{
                $city = null;
            }
        }



        if ($searchBox != null) {
            $conditions = array_merge($conditions, ['category_id' => $searchBox]);
        }

        if ($subcat != null) {
            $conditions = array_merge($conditions, ['sub_category_id' => $subcat]);
        }


        if ($serachStr != null) {
            $posts = Post::where('title', 'like', '%' . $serachStr . '%')->where($conditions);
        }else{
            $posts = Post::where($conditions);
        }
        $posts = $posts->with(['user','category','sub_category','custom_field_data','city','country'])
            ->limit($page_limit)->get();

        $mapData = array();
        $i = 0;
        if (count($posts) > 0) {
            foreach($posts as $post){

                $url = route('posts.single', [$post->id,$post->slug]);

                $map = explode(',' ,$post->latlong);
                $latitude = $map[0];
                $longitude = $map[1];

                $picture = explode(',',(string) $post->images);
                $pic_count = count($picture);
                if($picture[0] != ""){
                    $pic = $picture[0];
                    $pic = asset('storage/products/thumb/'.$pic);
                }else{
                    $pic = "";
                }

                $price = "";
                if($post->price != 0){
                    $price = price_format_by_country($post->price,$post->country_code);
                }

                ob_start();
                if($post->custom_field_data->count() > 0){
                    foreach ($post->custom_field_data as $customdata){
                        if(Str::isUrl($customdata->icon))
                            $icon = '<img src="'.$customdata->icon.'" width="24"/>';
                        else
                            $icon = '<i class="'.$customdata->icon.' me-1 fs-lg text-muted"></i>';

                        if($customdata->type == 'drop-down' || $customdata->type == 'radio-buttons'){
                            $option = get_customOptions_by_id($customdata->pivot->field_data);
                            if($option){
                                echo "<span class='d-flex align-items-center fs-sm'>".$icon." ".$option->title."</span>";
                            }
                        }elseif($customdata->type == 'text-field'){
                            echo "<span class='d-flex align-items-center fs-sm'>".$icon." ".$customdata->pivot->field_data."</span>";
                        }
                    }
                }
                $option_php_output = ob_get_contents();
                ob_end_clean();

                $icon = ($post->category->icon != "") ? "icon-feather-map-pin" : $post->category->icon;
                $mapData[$i]['marker_color'] = "#c92e2e";
                $mapData[$i]['marker_icon'] = $icon;
                $mapData[$i]['iconUrl'] = "";
                $mapData[$i]['id'] = $post->id;
                $mapData[$i]['title'] = $post->title;
                $mapData[$i]['address'] = $post->location;
                $mapData[$i]['latitude'] = $latitude;
                $mapData[$i]['longitude'] = $longitude;
                $mapData[$i]['coordinates'] = [$latitude, $longitude];
                $mapData[$i]['popup'] = "<div class='card border-0'><a href='".$url."' class='d-block'><img src='".$pic."' src='Image'></a><div class='card-body position-relative'><h4 class='mb-1 fs-xs fw-normal'>".$post->property_size." ".___('sqft')."</h4><h3 class='h6 mb-2 fs-sm'><a href='".$url."' class='nav-link stretched-link p-0 fw-bold'>".$post->title."</a></h3><p class='my-2 fs-sm text-muted'>".$post->location."</p><div class='h6 fs-sm mb-2'>".$price."</div><div class='d-flex align-items-center flex-wrap gap-2'>".$option_php_output."</div></div></div>";

                $mapData[$i]['popup'] = view($this->activeTheme . '.user.posts.inc.omapbox')->with(compact('post'))->render();
                    $i++;
            }
        }
        return response()->json($mapData, 200);
    }

    public function openlocatoionPopup(Request $request)
    {
        $post = Post::with(['user','category','sub_category','custom_field_data','city','country'])
            ->find($request->id);

        $data = array();
        $i = 0;
        if (!empty($post)) {
            echo view($this->activeTheme . '.user.posts.inc.gmapbox')->with(compact('post'))->render();
        } else {
            echo false;
        }
        die();
    }
}
