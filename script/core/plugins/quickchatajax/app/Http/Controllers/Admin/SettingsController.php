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
        // Purchase code removed - plugin works without verification
        return view('quickchatajax::admin.settings');
    }

    /**
     * Update settings
     *
     * @param  Request  $request
     */
    public function update(Request $request)
    {
        // Purchase code validation removed - plugin works without verification
        
        foreach ($request->except(['_token', 'quickchat_purchase_code']) as $key => $value) {
            Option::updateOptions($key, $value);
        }

        $result = array('success' => true, 'message' => ___('Updated Successfully'));
        return response()->json($result, 200);
    }
}
