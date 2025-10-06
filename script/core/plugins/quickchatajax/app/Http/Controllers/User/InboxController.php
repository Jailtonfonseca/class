<?php

namespace Plugins\quickchatajax\app\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Post;
use App\Models\PostOption;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class InboxController extends Controller
{
    /**
     * Inbox Messages page
     *
     * @return Application|Factory|View
     */
    public function index(Request $request){

        if(!Auth::check()){
            abort(404);
        }

        if($request->has('postid')){
            $postid = $request->postid;
        }else{
            $postid = '';
        }
        $userid = '';
        $chatid = '';
        $chat_username = '';
        $chat_fullname = '';
        $chat_userimg = '';
        $chat_userstatus = '';

        if($request->has('userid')){
            $userid = $request->userid;
            $userdata = User::find($userid);
            if($userdata){
                $chatid = $userid.'_'.$postid;
                $chat_username = $userdata->username;
                $chat_fullname = ($userdata->name != '')? $userdata->name : $userdata->username;
                $chat_userimg = ($userdata->image == "")? "default_user.png" : $userdata->image;
                if(empty($userdata->lastactive) or Carbon::now()->diffInSeconds($userdata->lastactive) > 30){
                    $chat_userstatus = "offline";
                }else{
                    $chat_userstatus = "online";
                }
            }
        }

        return view('quickchatajax::user.inbox',compact('chatid','postid','userid','chat_username','chat_fullname','chat_userimg','chat_userstatus'));
    }
}
