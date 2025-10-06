<?php

use App\Models\Adsense;
use App\Models\Countries;
use App\Models\Language;
use App\Models\Notification;
use App\Models\PlanOption;
use App\Models\PostOption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Jenssegers\Date\Date;
use Session;

/* Include all the other helpers here */
include 'PluginHelper.php';
include 'AppHelper.php';
/**
 * Set env
 *
 * @param $key
 * @param $value
 * @param  false  $quote
 */
function set_env($key, $value, $quote = false)
{
    $path = app()->environmentFilePath();
    $value = ($quote) ? '"'.$value.'"' : $value;

    if (is_bool(env($key))) {
        $old = env($key) ? 'true' : 'false';
    } elseif (env($key) === null) {
        $old = 'null';
    } else {
        $old = ($quote) ? '"'.env($key).'"' : env($key);
    }

    if (file_exists($path)) {
        $str = file_get_contents($path);
        if (str_contains($str, "$key=".$old)) {
            file_put_contents($path, str_replace(
                "$key=".$old, "$key=".$value, $str
            ));
        } else {
            file_put_contents($path, $str."\n$key=".$value);
        }
    }
}

function change_theme($theme)
{
    Cookie::queue(Cookie::forget('Quick_theme'));
    Cookie::queue('Quick_theme', $theme,60);
    session()->put('quick_template', trim($theme));
}

/**
 * Active theme path
 *
 * @param  false  $asset
 * @return string
 * @throws \Psr\Container\ContainerExceptionInterface
 * @throws \Psr\Container\NotFoundExceptionInterface
 */
function active_theme($asset = false)
{
    $template = env('THEME_NAME');
    $sess = request()->cookie('Quick_theme');
    if (trim((string) $sess)) {
        $template = $sess;
    }

    if ($asset) {
        return 'assets/templates/'.$template.'/';
    }
    return 'templates.'.$template.'.';
}

/**
 * Get active theme name
 *
 * @return mixed|object
 * @throws \Psr\Container\ContainerExceptionInterface
 * @throws \Psr\Container\NotFoundExceptionInterface
 */
function active_theme_name()
{
    $template = env('THEME_NAME');
    $sess = request()->cookie('Quick_theme');
    if (trim($sess)) {
        $template = $sess;
    }
    return $template;
}

/**
 * Get page title
 *
 * @param $env
 * @return string
 */
function page_title($env)
{
    if ($env->yieldContent('title')) {
        $title = $env->yieldContent('title').' - '.config('settings.site_title');
    } else {
        $title = config('settings.site_title');
    }
    return $title;
}

/**
 * Get post options
 *
 * @param $postId
 * @param  null  $key
 * @return false|mixed
 */
function post_options($postId, $key = null)
{
    if (!empty($key)) {
        return PostOption::getPostOption($postId, $key);
    }
    $options = PostOption::where('post_id', $postId)->pluck('option_value', 'option_name');
    return array_to_object($options);
}

/**
 * Get user options
 *
 * @param $userId
 * @param  null  $key
 * @return false|mixed
 */
function user_options($userId, $key = null)
{
    if (!empty($key)) {
        return \App\Models\UserOption::getUserOption($userId, $key);
    }
    $options = \App\Models\UserOption::where('user_id', $userId)->pluck('option_value', 'option_name');
    return array_to_object($options);
}

/**
 * Get Plan Options
 *
 * @param $id
 * @return mixed
 */
function plan_option($id)
{
    return PlanOption::find($id);
}

/**
 * Get plan interval text
 *
 * @param $interval
 * @return string
 */
function plan_interval_text($interval)
{
    if ($interval == 'MONTHLY') {
        return ___('Monthly');
    } else {
        if ($interval == 'YEARLY') {
            return ___('Yearly');
        } else {
            if ($interval == 'LIFETIME') {
                return ___('Lifetime');
            } else {
                return '-';
            }
        }
    }
}

/**
 * Price decimal format
 *
 * @param $price
 * @return string
 */
function price_format($price)
{
    return number_format((float) $price, 2);
}

/**
 * Price decimal format with currency symbol
 *
 * @param $price
 * @return string
 */
function price_symbol_format($price)
{
    if (config('settings.currency_pos') == 1) {
        return config('settings.currency_sign').price_format($price);
    } else {
        return price_format($price).config('settings.currency_sign');
    }
}

/**
 * Price decimal format with currency code
 *
 * @param $price
 * @return string
 */
function price_code_format($price)
{
    if (config('settings.currency_pos') == 1) {
        return config('settings.currency_code').' '.price_format($price);
    } else {
        return price_format($price).' '.config('settings.currency_code');
    }
}

/**
 * Get countries list array
 *
 * @return \Illuminate\Database\Eloquent\Collection
 */
function countries($active = false){
    if($active){
        return Countries::where('active','1')->get();
    }else{
        return Countries::all();
    }
}

function get_language_list(){
    return Language::all();
}

function startsWith($haystack, $needles){
    foreach ((array) $needles as $needle) {
        if ($needle !== '' && substr($haystack, 0, strlen($needle)) === (string) $needle) {
            return true;
        }
    }
    return false;
}

/**
 * Get admin panel path
 *
 * @return mixed|string
 */
function admin_url()
{
    return env('APP_ADMIN') ?? 'admin';
}

/**
 * Check is this admin path or not
 *
 * @return bool
 */
function is_admin_url()
{
    if (str_contains(request()->path(), admin_url().'/')) {
        return true;
    }
    return false;
}

/**
 * Create Admin notifications
 * @param $title
 * @param $type
 * @param  null  $link
 */
function create_notification($title, $type, $link = null)
{
    $notify = new Notification();
    $notify->title = $title;
    $notify->type = $type;
    $notify->link = $link;
    $notify->save();
}

/**
 * Get notification icons
 *
 * @param $type
 * @return string
 */
function notification_icon($type)
{
    return match ($type) {
        'new_user' => '<span class="avatar-initial rounded bg-label-success"><i class="fas fa-user-plus"></i></span>',
        'new_comment' => '<span class="avatar-initial rounded bg-label-warning"><i class="fas fa-comment"></i></span>',
        'new_payment' => '<span class="avatar-initial rounded bg-label-info"><i class="fas fa-receipt"></i></span>',
        default => ''
    };
}

/**
 * Get Lang URL
 * @param $lang
 * @return string
 */
function lang_url($lang)
{
    if (config('settings.include_language_code')) {
        return LaravelLocalization::getLocalizedURL($lang, null, [], true);
    } else {
        return route('localize', $lang);
    }
}

/**
 * Get language
 * @return mixed
 */
function get_lang()
{
    return App::getLocale();
}

/**
 * Get current language
 *
 * @return mixed
 */
function current_language()
{
    return Language::where('code', get_lang())->first();
}

/**
 * Get active languages
 *
 * @return array
 */
function get_active_languages()
{
    $langs = [];
    foreach (Language::where('active', 1)->get() as $language) {

        $langs[$language->code] = [
            'name' => $language->name,
        ];
    }
    return $langs;
}

/**
 * Translate the given message
 *
 * @param $key
 * @param  array  $replace
 * @return string|array|null
 */
function ___($key, array $replace = [])
{
    $trans_slug = Str::slug($key, '_');

    if (Lang::has('lang.'.$trans_slug)) {
        return trans('lang.'.$trans_slug, $replace, get_lang());
    }

    /* Add Language key to all files if not exist */
    $allLanguages = File::directories(base_path('lang'));
    foreach ($allLanguages as $language) {
        $filePath = $language.'/'.'lang.php';

        if (File::exists($filePath)) {
            $translations = include $filePath;
        } else {
            $translations = [];
        }

        if (!array_key_exists($trans_slug, $translations)) {
            $translations[$trans_slug] = $key;
            File::put($filePath, "<?php\n\nreturn ".var_export($translations, true).";\n");
        }
    }

    return $key;
}

/**
 * Check demo mode is enabled or disabled
 *
 * @return bool
 */
function demo_mode()
{
    if (Auth::user() && Auth::user()->id == 1) {
        return false;
    }
    if (env('DEMO_MODE')) {
        return true;
    }
    return false;
}

/**
 * Get user location data with ip address
 *
 * @param  null  $ip
 * @return array
 */
function user_ip_lookup($ip = null)
{
    $ip = $ip ?: request()->ip();
    if (Cache::has($ip)) {
        $ipInfo = Cache::get($ip);
    } else {
        $ipInfo = (object) json_decode(curl_get_file_contents("http://ip-api.com/json/{$ip}?fields=status,country,countryCode,city,zip,lat,lon,timezone,query"),
            true);
        Cache::forever($ip, $ipInfo);
    }
    $result['ip'] = $ipInfo->query ?? $ip;
    $result['location']['country'] = $ipInfo->country ?? "Other";
    $result['location']['country_code'] = $ipInfo->countryCode ?? "Other";
    $result['location']['timezone'] = $ipInfo->timezone ?? "Other";
    $result['location']['city'] = $ipInfo->city ?? "Other";
    $result['location']['postal_code'] = $ipInfo->zip ?? "Unknown";
    $result['location']['latitude'] = $ipInfo->lat ?? "Unknown";
    $result['location']['longitude'] = $ipInfo->lon ?? "Unknown";
    return $result;
}


/**
 * Get user location, operating system, web browser details
 *
 * @return mixed
 */
function user_ip_info()
{
    $lookupData = user_ip_lookup();
    $lookupData['system']['os'] = user_os_info();
    $lookupData['system']['browser'] = user_browser_info();
    return array_to_object($lookupData);
}

/**
 * Get user operating system
 *
 * @return string
 */
function user_os_info()
{
    $operating_systems = [
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile',
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
    ];

    $os = "Other";
    foreach ($operating_systems as $key => $value) {
        if (preg_match($key, $_SERVER['HTTP_USER_AGENT'])) {
            $os = $value;
        }
    }
    return $os;
}

/**
 * Get user web browser details
 *
 * @return string
 */
function user_browser_info()
{
    $browsers = [
        '/msie/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/edge/i' => 'Edge',
        '/opera/i' => 'Opera',
        '/mobile/i' => 'Handheld Browser',
    ];

    $browser = "Other";
    foreach ($browsers as $key => $value) {
        if (preg_match($key, $_SERVER['HTTP_USER_AGENT'])) {
            $browser = $value;
        }
    }
    return $browser;
}


/**
 * @param $URL
 * @return bool|string
 */
function curl_get_file_contents($URL)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $URL);
    $contents = curl_exec($c);
    curl_close($c);
    if ($contents) {
        return $contents;
    } else {
        return false;
    }
}

/**
 * Image Uploading
 * @param $file
 * @param $path
 * @param  null  $size
 * @param  null  $filename
 * @param  null  $oldfilename
 * @return string
 */
function image_upload($file, $path, $size = null, $filename = null, $oldfilename = null)
{
    ini_set('memory_limit', '256M');
    $filename = empty($filename) ? uniqid().time().'.'.$file->getClientOriginalExtension() : $filename.'.'.$file->getClientOriginalExtension();

    if ($oldfilename) {
        remove_file($path.$oldfilename);
    }

    if (!file_exists($path)) {
        @mkdir($path);
    }

    $image = Image::make($file);
    if ($size) {
        $size = explode('x', strtolower($size));
        if(isset($size[1])){
            $image->resize($size[0], $size[1]);
        } else {
            $image->resize($size[0], null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

    }
    $image->save($path.$filename);

    return $filename;
}

/**
 * Remove file
 * @param $path
 * @return bool
 */
function remove_file($path)
{
    return file_exists($path) && is_file($path) && @unlink($path);
}

/**
 * Date format
 * @param $date
 * @param $format
 * @return string
 */
function date_formating($date, $format = 'd, M Y')
{
    Date::setLocale(get_lang());
    return Date::parse($date)->format($format);
}

/**
 * @param $text
 * @param $chars_limit
 * @return string
 */
function text_shorting($text, $chars_limit)
{
    return Str::limit($text, $chars_limit);
}

/**
 * Convert a number into a readable one
 *
 * @param $number
 * @return string
 */
function format_number_count($number)
{
    $suffix = ["", "K", "M", "B"];
    $precision = 1;
    for ($i = 0; $i < count($suffix); $i++) {
        $divide = $number / pow(1000, $i);
        if ($divide < 1000) {
            return round($divide, $precision).$suffix[$i];
        }
    }

    return $number;
}

/**
 * @param $array
 * @return mixed
 */
function array_to_object($array)
{
    return json_decode(json_encode($array));
}

/**
 * @return null
 */
function google_captcha()
{
    $script = null;
    if (config('settings.recaptcha_mode')) {
        $script = NoCaptcha::renderJs(get_lang());
    }
    return $script;
}

/**
 * @return string|null
 */
function display_captcha()
{
    $script = null;
    if (config('settings.recaptcha_mode')) {
        $script = '<div class="margin-bottom-15">'.app('captcha')->display().'</div>';
    }
    return $script;
}

/**
 * Validate captcha requests
 *
 * @return array|string[]
 */
function validate_recaptcha()
{
    if (config('settings.recaptcha_mode')) {
        return ['g-recaptcha-response' => 'required|captcha'];
    }
    return [];
}

function validate_post_location()
{
    if (config('settings.post_address_mode')) {
        return ['location' => 'required|string'];
    }
    return [];
}

/**
 * @param $slug
 * @return null
 */
function ads($slug)
{
    $ad = Adsense::where([['slug', $slug], ['status', 1]])->first();
    if (auth()->check()) {
        if (@auth()->user()->plan()->settings->advertisements) {
            return $ad;
        } else {
            return null;
        }
    } else {
        return $ad;
    }
}

/**
 * Head code for ads
 */
function head_code()
{
    if ($ad = ads('head_code')) {
        return $ad->code;
    }
    return null;
}

/**
 * Home page top ad
 *
 * @return string|void
 */
function ads_on_top()
{
    if ($ad = ads('top')) {
        return '<center>
           <div class="google-ads-728x90 margin-top-30 margin-bottom-30 my-4">'.$ad->code.'</div>
        </center>';
    }
    return null;
}

/**
 * Home page bottom ad
 *
 * @return string|void
 */
function ads_on_bottom()
{
    if ($ad = ads('bottom')) {
        return '<center>
           <div class="google-ads-728x90 margin-top-30 margin-bottom-30 my-4">'.$ad->code.'</div>
        </center>';
    }
    return null;
}

/**
 * Dashboard page top ad
 *
 * @return string|void
 */
function ads_on_dashboard_top()
{
    if ($ad = ads('dashboard_top')) {
        return '<center>
           <div class="google-ads-728x90 margin-top-30 margin-bottom-30 my-4">'.$ad->code.'</div>
        </center>';
    }
    return null;
}

/**
 * Dashboard page bottom ad
 *
 * @return string|void
 */
function ads_on_dashboard_bottom()
{
    if ($ad = ads('dashboard_bottom')) {
        return '<center>
           <div class="google-ads-728x90 margin-top-30 margin-bottom-30 my-4">'.$ad->code.'</div>
        </center>';
    }
    return null;
}

/**
 * @return string|void
 */
function ads_on_home_1()
{
    if ($ad = ads('home_page_1')) {
        return '<center>
           <div class="google-ads-728x90 margin-top-30 margin-bottom-30 my-4">'.$ad->code.'</div>
        </center>';
    }
    return null;
}

/**
 * @return string|void
 */
function ads_on_home_2()
{
    if ($ad = ads('home_page_2')) {
        return '<center>
           <div class="google-ads-728x90 margin-top-30 margin-bottom-30 my-4">'.$ad->code.'</div>
        </center>';
    }
    return null;
}

/**
 * @return string|void
 */
function theme_switcher()
{
    if (config('settings.theme_switcher')) {
        return '<div class="styleswitch">
    <div class="styleswitch-lover">
        <a href="#" class="toggler"><i class="fa fa-cog fa-spin"></i></a>
        <h4>'.___('Change Color').'</h4>
        <ul class="preset-list clearfix" id="styleswitch">
            <li><a href="javascript: void(0)" title="switch styling" id="color1">#f44336</a></li>
            <li><a href="javascript: void(0)" title="switch styling" id="color2">#E91E63</a></li>
            <li><a href="javascript: void(0)" title="switch styling" id="color3">#9C27B0</a></li>
            <li><a href="javascript: void(0)" title="switch styling" id="color4">#673AB7</a></li>
            <li><a href="javascript: void(0)" title="switch styling" id="color5">#3F51B5</a></li>
            <li><a href="javascript: void(0)" title="switch styling" id="color6">#2196F3</a></li>
            <li><a href="javascript: void(0)" title="switch styling" id="color7">#03A9F4</a></li>
            <li><a href="javascript: void(0)" title="switch styling" id="color8">#00BCD4</a></li>
            <li><a href="javascript: void(0)" title="switch styling" id="color9">#009688</a></li>
            <li><a href="javascript: void(0)" title="switch styling" id="color10">#4CAF50</a></li>
            <li><a href="javascript: void(0)" title="switch styling" id="color11">#8BC34A</a></li>
            <li><a href="javascript: void(0)" title="switch styling" id="color12">#CDDC39</a></li>
            <li><a href="javascript: void(0)" title="switch styling" id="color13">#4611a7</a></li>
            <li><a href="javascript: void(0)" title="switch styling" id="color14">#FFC107</a></li>
            <li><a href="javascript: void(0)" title="switch styling" id="color15">#FF9800</a></li>
            <li><a href="javascript: void(0)" title="switch styling" id="color16">#FF5722</a></li>
            <li><a href="javascript: void(0)" title="switch styling" id="color17">#795548</a></li>
            <li><a href="javascript: void(0)" title="switch styling" id="color18">#9E9E9E</a></li>
            <li><a href="javascript: void(0)" title="switch styling" id="color19">#607D8B</a></li>
            <li><a href="javascript: void(0)" title="switch styling" id="color20">#776B26</a></li>
        </ul>
        <br>
        <h4>'.___('Change Theme').'</h4>

        <div class="dropdown theme-dropdown" id="theme-dropdown">
            <button class="btn dropdown-toggle btn-default-lite" type="button" id="dropdownMenu1" data-toggle="dropdown"
                    aria-expanded="false"><span id="selected_theme">'.active_theme_name().'</span><span class="caret"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">
                <li role="presentation" data-theme="thenext-theme"><a role="menuitem" tabindex="-1" rel="alternate" href="#">Next Theme</a></li>
                <li role="presentation" data-theme="classic-theme"><a role="menuitem" tabindex="-1" rel="alternate" href="#">Classic Theme</a></li>
            </ul>
        </div>

    </div>
</div>';
    }
    return null;
}

/**
 * XOR encrypt/decrypt.
 *
 * @param  string  $str
 * @param  string  $password
 * @return string
 */
function quick_xor($str, $password = '')
{
    $len = strlen($str);
    $gamma = '';
    $n = $len > 100 ? 8 : 2;
    while (strlen($gamma) < $len) {
        $gamma .= substr(pack('H*', sha1($password.$gamma)), 0, $n);
    }

    return $str ^ $gamma;
}

/**
 * XOR encrypt with Base64 encode.
 *
 * @param  string  $str
 * @param  string  $password
 * @return string
 */
function quick_xor_encrypt($str, $password = '')
{
    return base64_encode(quick_xor($str, $password));
}

/**
 * XOR decrypt with Base64 decode.
 *
 * @param  string  $str
 * @param  string  $password
 * @return string
 */
function quick_xor_decrypt($str, $password = '')
{
    return quick_xor(base64_decode($str), $password);
}

/**
 * Print switch button for admin
 *
 * @param $title
 * @param $id
 * @param  false  $checked
 * @param  string  $hint
 * @return string
 */
function quick_switch($title, $id, $checked = false, $hint = '')
{
    $check = ($checked) ? 'checked' : '';

    if (!empty($hint)) {
        $hint = '<small class="form-text">'.$hint.'</small>';
    }

    echo '<div class="form-group">
        <label class="form-label" for="'.$id.'">'.$title.'</label>
        <div class="form-toggle-option">
            <div>
                <label for="'.$id.'">'.___("Enable").'</label>
            </div>
            <div>
                <input type="hidden" name="'.$id.'" value="0">
                <label class="switch switch-sm">
                    <input name="'.$id.'" type="checkbox" id="'.$id.'" value="1" '.$check.'>
                    <span class="switch-state"></span>
                </label>
            </div>
        </div>
        '.$hint.'
    </div>';
    return '';
}

/**
 * Custom Toastr Alert
 *
 * @param $message
 * @param  string  $type
 */
function quick_alert($message, $type = 'success')
{
    session()->flash('quick_alert_message', $message);
    session()->flash('quick_alert_type', $type);
}

/**
 * Success Toastr Alert
 *
 * @param $message
 */
function quick_alert_success($message)
{
    quick_alert($message, 'success');
}

/**
 * Error Toastr Alert
 *
 * @param $message
 */
function quick_alert_error($message)
{
    quick_alert($message, 'error');
}

/**
 * Info Toastr Alert
 *
 * @param $message
 */
function quick_alert_info($message)
{
    quick_alert($message, 'info');
}
