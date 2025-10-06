<?php

namespace Plugins\quickchatajax\app\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Post;
use App\Models\PostOption;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use WpOrg\Requests\Auth;

class QuickchatController extends Controller
{

    public function index(Request $request){

        if ($request->has('action')) {

            if ($request->action == "get_postdata") { return $this->get_postdata($request); }
            if ($request->action == "updateSeenmsg") { return $this->updateSeenmsg($request); }
            if ($request->action == "checkMsgSeen") { return $this->checkMsgSeen($request); }
            if ($request->action == "lastseen") { return $this->lastseen($request); }
            if ($request->action == "userProfile") { return $this->userProfile($request); }
            if ($request->action == "chatfriendList") { return $this->chatfriendList($request); }
            if ($request->action == "get_all_msg") { return $this->get_all_msg($request); }
            if ($request->action == "chatheartbeat") { return $this->chatheartbeat($request); }
            if ($request->action == "sendchat") { return $this->sendchat($request); }
            if ($request->action == "closechat") { return $this->closechat($request); }
            if ($request->action == "startchatsession") { return $this->startchatsession($request); }
            if ($request->action == "uploadFile") { return $this->uploadFile($request); }

        }
    }

    public function lastseen(Request $request){
        return (is_user_online($request->userid))? "online" : "offline";
    }
    public function updateSeenmsg(Request $request){
        $userid = $request->userid;
        $postid = $request->postid;
        $update = Message::where(array(
            'to_id' => $request->user()->id,
            'from_id' => $userid,
            'post_id' => $postid,
        ))->update([
            'seen' => '1',
        ]);

        $result = array('success' => true);
        return response()->json($result, 200);
    }
    public function checkMsgSeen(Request $request){

        if($request->msgid == "last"){
            $message = Message::where(array(
                'to_id' => $request->userid,
                'from_id' => $request->user()->id,
            ))->first();
        }
        else{
            $message = Message::find($request->msgid);
        }
        if($message->seen)
            echo $seen = $message->seen;
        else
            echo $seen = "null";
        die();
    }
    public function get_postdata(Request $request){
        $post_id = $request->postid;
        $post = Post::find($post_id);
        $result = [
            'post_title' => $post->title,
            'post_link' => route('posts.single', [$post_id,$post->slug])
        ];
        return response()->json($result, 200);
    }
    public function userProfile(Request $request){
        $user = User::find($request->userid);

        $item = array();
        $item['username']   = $user->username;
        $item['name']       = ($user->name != '')? $user->name : $user->username;
        $item['email']      = $user->email;
        $item['sex']     = $user->sex;
        $item['about']   = $user->description;
        $item['image']   = asset('storage/profile/'.$user->image);

        return response()->json($item, 200);
    }
    public function chatfriendList(Request $request){
        $user = $request->user();

        $start = $request->limitStart;
        $perPage = 6; // Set how much data you have to fetch on each request

        $searchKey = ($request->has('searchKey'))? $request->searchKey : '';
        if($searchKey != ''){
            $where = "";
        }else{
            $where = "";
        }

        $conversations = Message::selectRaw('max(id) as id, max(to_id) as to_id, max(from_id) as from_id, max(created_at), post_id')
            ->where('to_id',$user->id)
            ->orWhere('from_id',$user->id)
            ->groupBy('post_id')
            ->get();

        $messages = Message::selectRaw('max(id) as id, max(to_id) as to_id, max(from_id) as from_id, max(created_at), post_id')
            ->where('to_id',$user->id)
            ->orWhere('from_id',$user->id)
            ->groupBy('post_id')
            ->orderbyDesc('id')
            ->limit($perPage)->offset($start)->get();

        $result = [];
        $result['contact_count'] = $conversations->count();
        $result['page_limit'] = $start;
        foreach($messages as $message)
        {
            $chat = Message::where('id',$message->id)->with('post')->first();
            $chat_user_id = ($request->user()->id != $chat->to_id) ? $chat->to_id : $chat->from_id;
            if(User::where('id', $chat_user_id)->count())
            {
                $chat_user = User::find($chat_user_id);

                if($chat_user)
                {
                    if(empty($chat_user->lastactive) or Carbon::now()->diffInSeconds($chat_user->lastactive) > 30){
                        $status = "offline";
                    }else{
                        $status = "online";
                    }

                    $unread_msg = Message::where(array(
                        'to_id' => $user->id,
                        'from_id' => $chat->from_id,
                        'post_id' => $chat->post_id,
                        'recd' => '0'
                    ))->count();

                    $result['data'][] = [
                        'from_id' => $chat->from_id,
                        'to_id' => $chat->to_id,
                        "chatid"=> $chat_user->id."_".$chat->post_id,
                        "userid"=> $chat_user->id,
                        "username"=> $chat_user->username,
                        "fullname"=> $chat_user->name,
                        "userimage"=> asset('storage/profile/'.$chat_user->image),
                        "userstatus"=> $status,
                        "unread_msg"=> $unread_msg,
                        "postid"=> $chat->post_id,
                        "post_title"=> $chat->post->title,
                        'created_at'=> $chat->created_at,
                    ];
                }
            }
            else
            {
                $result['contact_count'] = $result['contact_count']-1;
            }
        }

        return response()->json($result, 200);
    }
    public function get_all_msg(Request $request){
        $perPage = 10;
        $page = 1;
        if(!empty($request->page)) {
            $page = $request->page;
            session(['chatpage' => $page]);
        }

        $start = ($page-1)*$perPage;
        if($start < 0) $start = 0;

        $count = Message::where(array(
            'to_id' => $request->user()->id,
            'from_id' => $request->client,
            'post_id' => $request->postid,
            'recd' => '1'
        ))->orWhere(function ($query) use ($request) {
            return $query->where('from_id', '=', $request->user()->id)
                ->where('to_id', '=', $request->client)
                ->where('post_id', '=', $request->postid);
        })->orderbyDesc('id')->count();

        $message = Message::where(array(
            'to_id' => $request->user()->id,
            'from_id' => $request->client,
            'post_id' => $request->postid,
            'recd' => '1'
        ))->orWhere(function ($query) use ($request) {
            return $query->where('from_id', '=', $request->user()->id)
                ->where('to_id', '=', $request->client)
                ->where('post_id', '=', $request->postid);
        })->orderbyDesc('id')->limit($perPage)->offset($start)
            ->get();

        if(empty($request->rowcount)) {
            $rowcount = $count;
        }

        $pages  = ceil($rowcount/$perPage);

        $items = array();

        foreach ($message as $chat) {

            $from_userdata = User::find($chat->from_id);
            $to_id = $from_userdata->id;
            $picname = asset('storage/profile/'.$from_userdata->image);
            $status = $from_userdata->online;

            $picname = ($picname == "")? "default_user.png" : $picname;
            $status  = ($status == "0")? "Offline" : "Online";

            $to_userdata = User::find($chat->to_id);
            $picname2 = asset('storage/profile/'.$to_userdata->image);

            $picname2 = ($picname2 == "")? "default_user.png" : $picname2;


            $chat['message_content'] = $chat->message_content;

            if($chat->from_id == $request->user()->id)
            {
                $position = 'odd';
                $chatid = $chat->to_id.'_'.$chat->post_id;
            }
            else{
                $position = 'even';
                $chatid = $chat->from_id.'_'.$chat->post_id;
            }

            if (strpos($chat->message_content, 'file_name') !== false) {

            }
            else{
                // The Regular Expression filter
                $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,10}(\/\S*)?/";

                // Check if there is a url in the text
                if (preg_match($reg_exUrl, $chat->message_content, $url)) {

                    // make the urls hyper links
                    $chat['message_content'] = preg_replace($reg_exUrl, "<a href='{$url[0]}'>{$url[0]}</a>", $chat->message_content);

                } else {
                    // The Regular Expression filter
                    $reg_exUrl = "/(www)\.[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,10}(\/\S*)?/";

                    // Check if there is a url in the text
                    if (preg_match($reg_exUrl, $chat->message_content, $url)) {

                        // make the urls hyper links
                        $chat['message_content'] = preg_replace($reg_exUrl, "<a href='{$url[0]}'>{$url[0]}</a>", $chat->message_content);

                    }
                }
            }
            $msgtime = date('d M, H:i A', strtotime($chat->created_at));
            $msgdate = date('F d, Y', strtotime($chat->created_at));

            $items[] =  array(
                "s"=> '0',
                "chatid"=> $chatid,
                "page"=> $page,
                "pages"=> $pages,
                "mtype"=> $chat->message_type,
                "message"=> $chat['message_content'],
                "seen"=> $chat->seen,
                "recd"=> $chat->recd,
                "time"=> $msgtime,
                "date"=> $msgdate,
                "position"=> $position
            );
        }
        return response()->json($items, 200);
    }
    public function chatheartbeat(Request $request){
        $message = Message::where(array(
            'to_id' => $request->user()->id,
            'recd' => '0'
        ))->orderby('id')->get();

        $items = array();
        foreach ($message as $chat) {
            $from_id = $chat->from_id;
            $from_userdata = User::find($chat->from_id);
            $from_name = ($from_userdata->name != '')? $from_userdata->name : $from_userdata->username;
            $picname = asset('storage/profile/'.$from_userdata->image);
            $picname = ($picname == "")? "default_user.png" : $picname;
            $status = $from_userdata->online;
            $status  = ($status == "0")? "offline" : "online";
            $postid = $chat->post_id;
            $chatid = $chat->from_id."_".$chat->post_id;
            $message_content = $chat->message_content;
            if (strpos($chat->message_content, 'file_name') !== false) {

            }
            else{
                // The Regular Expression filter
                $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,10}(\/\S*)?/";

                // Check if there is a url in the text
                if (preg_match($reg_exUrl, $chat->message_content, $url)) {

                    // make the urls hyper links
                    $message_content = preg_replace($reg_exUrl, "<a href='{$url[0]}'>{$url[0]}</a>", $chat->message_content);

                } else {
                    // The Regular Expression filter
                    $reg_exUrl = "/(www)\.[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,10}(\/\S*)?/";

                    // Check if there is a url in the text
                    if (preg_match($reg_exUrl, $chat->message_content, $url)) {

                        // make the urls hyper links
                        $message_content = preg_replace($reg_exUrl, "<a href='{$url[0]}'>{$url[0]}</a>", $chat->message_content);

                    }
                }
            }

            $msgtime = date('d M, H:i A',strtotime($chat['message_date']));
            $items[] = array(
                "s"=> 0,
                "postid"=> $postid,
                "chatid"=> $chatid,
                "from_name"=> $from_name,
                "from_id"=> $from_id,
                "picname"=> $picname,
                "status"=> $status,
                "message"=> $message_content,
                "message_type"=> $chat->message_type,
                "time"=> $msgtime
            );

            $chatHistory = session()->get('chatHistory');
            if(!$request->has('wchat')) {
                if (session()->has('chatHistory.'.$chatid))
                {
                    session()->push('chatHistory.'.$chatid, array(
                        "s" => "1",
                        "chatid" => $chatid,
                        "postid" => $postid,
                        "fullname" => $from_name,
                        "userid" => $from_id,
                        "picname" => $picname,
                        "status" => $status
                    ));

                } else {
                    session()->put('chatHistory.'.$chatid, array(
                        "s" => "1",
                        "chatid" => $chatid,
                        "postid" => $postid,
                        "fullname" => $from_name,
                        "userid" => $from_id,
                        "picname" => $picname,
                        "status" => $status
                    ));
                }
                Session::forget('tsChatBoxes.'.$chatid);
                session()->put('openChatBoxes.'.$chatid, $chat->created_at);
            }
        }

        if (!empty(session()->get('openChatBoxes')) && !$request->has('wchat'))
        {
            foreach (session()->get('openChatBoxes') as $chatbox => $time) {

                if (!session()->has('tsChatBoxes.'.$chatbox))
                {
                    $now = time()-strtotime($time);
                    $timenow = date('M d, g:i A', strtotime($time));

                    $message = $timenow;
                    if ($now > 30)
                    {
                        $items[] = array(
                            "s"=> 2,
                            "chatid"=> $chatbox,
                            "message"=> $message
                        );

                        if (!session()->has('chatHistory.'.$chatbox)){
                            session()->put('chatHistory.'.$chatbox, array());
                        }

                        session()->push('chatHistory.'.$chatbox, array(
                            "s"=> 2,
                            "chatid"=> $chatbox,
                            "message"=> $message
                        ));
                        session()->put('tsChatBoxes.'.$chatbox, 1);
                    }
                }
            }
        }

        $update = Message::where(array(
            'to_id' => $request->user()->id,
            'recd' => '0',
        ))->update([
            'recd' => '1',
        ]);

        return response()->json($items, 200);
    }
    public function sendchat(Request $request){

        if(isset($request->user()->id)){
            $from_id = $request->user()->id;
            $to_id = $request->to_id;
            $postid = $request->postid;

            $message = $request->message;
            $timenow = date('Y-m-d H:i:s');
            $to_userdata = User::find($to_id);
            if($to_userdata){
                $to_name = ($to_userdata->name != '')? $to_userdata->name : $to_userdata->username;
                $picname = asset('storage/profile/'.$to_userdata->image);
                $status = $to_userdata->online;
                $picname = ($picname == "")? "default_user.png" : $picname;
                $status  = ($status == "0")? "offline" : "online";
                $chatid = $to_id.'_'.$postid;

                if(!$request->has('wchat')) {
                    if (session()->has('chatHistory.'.$chatid)) {
                        session()->push('chatHistory.'.$chatid, array(
                            "s" => "1",
                            "chatid" => $chatid,
                            "postid" => $postid,
                            "fullname" => $to_name,
                            "userid" => $to_id,
                            "picname" => $picname,
                            "status" => $status
                        ));
                    } else {
                        session()->put('chatHistory.'.$chatid, array(
                            "s" => "1",
                            "chatid" => $chatid,
                            "postid" => $postid,
                            "fullname" => $to_name,
                            "userid" => $to_id,
                            "picname" => $picname,
                            "status" => $status
                        ));
                    }


                    Session::forget('tsChatBoxes.'.$chatid);
                    session()->put('openChatBoxes.'.$chatid, date('Y-m-d H:i:s', time()));

                    if (!session()->has('chatHistory.'.$chatid)) {
                        session()->put('chatHistory.'.$chatid, array());
                    }
                }

                $create = Message::create([
                    'from_id' => $from_id,
                    'to_id' => $to_id,
                    'message_content' => $message,
                    'message_type' => 'text',
                    'post_id' => $postid,
                ]);
                if($create)
                    $result = array('success' => true);
            }
            else{
                $result = array('success' => false);
            }

        }
        else{
            $result = array('success' => false);
        }
        return response()->json($result, 200);
    }
    public function closechat(Request $request){
        $openChatBoxes = session()->get('openChatBoxes.'.$request->chatbox);
        Session::forget('openChatBoxes.'.$request->chatbox);
        $result = array('success' => true);
        return response()->json($result, 200);
    }
    public function startchatsession(Request $request){

        $items = array();
        if (!empty(session()->get('openChatBoxes'))) {
            foreach (session()->get('openChatBoxes') as $chatbox => $void) {
                if (session()->has('chatHistory.'.$chatbox)) {
                    $items[] = session()->get('chatHistory.'.$chatbox);
                }
            }
        }
        return response()->json($items, 200);
    }
    public function uploadFile(Request $request){

        $post_id = $request->has('post_id') ? $request->post_id : 0;
        $chatid = $request->has('chatid') ? $request->chatid : 0;
        $to_id = $request->has('to_id') ? $request->to_id : 0;

        $target_dir = 'storage/user_files/';
        // Create target dir
        if (!file_exists($target_dir)) {
            @mkdir($target_dir);
        }

        if ($request->has('file') && !empty($request->file)) {
            // Validate the uploaded file
            $request->validate([
                'file' => 'required|file|mimes:jpg,png,pdf|max:2048',
            ]);
            // Check if the file is valid
            if ($request->file('file')->isValid()) {
                // Store the file in the 'target' directory on the 'storage' disk
                $filename = image_upload($request->file('file'), $target_dir);
                if ($filename) {
                    $fileUpload['success'] = true;
                    $fileUpload['file_name'] = $filename;
                }
            }else {
                $fileUpload['success'] = false;
                $fileUpload['error'] = ___('Error: File not valid');
            }
        } else {
            $fileUpload['success'] = false;
            $fileUpload['error'] = ___('Error: File upload');
        }


        // Check if file has been uploaded
        if($fileUpload['success']){
            $fileName = $fileUpload['file_name'];

            $extensions = explode(".",$fileName);
            $extension = $extensions[count($extensions)-1];
            $file_type = "file";

            if ($extension=="jpg" || $extension=="jpeg" || $extension=="gif" || $extension == "png") {
                $file_type = "image";
            }
            elseif ($extension=="mp4" || $extension=="MP4" || $extension=="flv") {
                $file_type = "video";
            }
            elseif($extension=="doc" || $extension=="pdf") {
                $file_type = "document";
            }

            $filePath = $target_dir . $fileName;
            $result = array("file_name"=>$fileName,"file_path"=>$filePath,"file_type"=>$file_type);


            $from_user_id = $request->user()->id;
            $message_content = json_encode($result);

            $create = Message::Create([
                'from_id' => $from_user_id,
                'to_id' => $to_id,
                'message_content' => $message_content,
                'message_type' => 'file',
                'post_id' => $post_id,
            ]);

            $last_id = $create->id;

            // Return Success JSON-RPC response
            $result = [
                'status' => "success",
                'chatid' => $chatid,
                'id' => $last_id,
                'file_name' => $fileName,
                'file_path' => $filePath,
                'file_type' => $file_type
            ];
        }else{
            $result = [
                'status' => "error",
                'chatid' => $chatid,
                'message' => $fileUpload['error']
            ];
        }

        return response()->json($result, 200);
    }
}
