<?php

namespace Plugins\quickchatajax\app\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{

    /**
     * Settings page
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $code = config('settings.quickchat_purchase_code');
        if($code){
            $code = substr($code, 0,4);
            $code .= '****-****-****-****-************';
        }

        return view('quickchatajax::admin.settings', compact('code'));
    }

    /**
     * Update settings
     *
     * @param  Request  $request
     */
    public function update(Request $request)
    {

        if (!empty($request->get('quickchat_purchase_code'))) {
            $plugin = get_plugin('quickchatajax');

            try {
                $response = Http::get('https://bylancer.com/api/api.php', [
                    "verify-purchase" => $request->input('quickchat_purchase_code'),
                    "ip" => $request->ip(),
                    "site_url" => route('home'),
                    "version" => $plugin->version,
                    "script" => $plugin->id,
                    "email" => $request->input('email')
                ]);

                if ($response->ok()) {
                    $result = $response->json();

                    if ($result['success']) {
                        Option::updateOptions('quickchat_purchase_code', $request->input('quickchat_purchase_code'));
                    } else {
                        $result = array('success' => false, 'message' => $result['error']);
                        return response()->json($result, 200);
                    }

                } else {
                    $result = array('success' => false, 'message' => ___('Invalid purchase code.'));
                    return response()->json($result, 200);
                }
            } catch (\Exception $e) {
                $result = array('success' => false, 'message' => $e->getMessage());
                return response()->json($result, 200);
            }
        } else {
            if (!config('settings.quickchat_purchase_code')) {
                /* Purchase code is required if it is not available */
                $result = array('success' => false, 'message' => ___('Purchase code is required.'));
                return response()->json($result, 200);
            }
        }

        foreach ($request->except(['_token', 'quickchat_purchase_code']) as $key => $value) {
            Option::updateOptions($key, $value);
        }

        $result = array('success' => true, 'message' => ___('Updated Successfully'));
        return response()->json($result, 200);
    }
}
