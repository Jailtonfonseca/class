<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Models\Option;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
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
        $page_limit = "10";
        $user = User::where(array(
            'username' => $request->username
        ))->with('posts')->first();

        if($user){
            // querying the relationship
            $posts = $user->posts()->paginate($page_limit);
            return view($this->activeTheme . '.user.profile', compact(['user','posts']));
        }

        abort(404);
    }
}
