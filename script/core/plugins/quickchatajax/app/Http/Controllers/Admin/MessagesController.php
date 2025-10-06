<?php

namespace Plugins\quickchatajax\app\Http\Controllers\Admin;

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

class MessagesController extends Controller
{
    /**
     * Inbox Messages page
     *
     * @return Application|Factory|View
     */
    public function index(Request $request){

        if ($request->ajax()) {
            $params = $columns = $order = $totalRecords = $data = array();
            $params = $request;

            //define index of column
            $columns = array(
                0 =>'id',
                1 =>'from_id',
                2 =>'to_id',
                3 =>'message_content',
                4 =>'created_at',
                5 =>'recd'
            );

            if(!empty($params['search']['value'])){
                $q = $params['search']['value'];
                $messages = Message::where('message_content', 'like', '%' . $q . '%')
                    ->orWhere('message_type', 'like', '%' . $q . '%')
                    ->orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }else{
                $messages = Message::orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }

            $totalRecords = Message::count();
            foreach ($messages as $row) {

                if ($row->recd){
                    $recd_badge = '<span class="badge bg-success">'.___('Read').'</span>';
                }else{
                    $recd_badge = '<span class="badge bg-warning">'.___('Unread').'</span>';
                }

                $sender = User::find($row->from_id);
                if($sender){
                    $picname = $sender->image;
                    $from_fullname = (isset($sender->name)) ? $sender->name : $sender->username;
                    $fromuname = $sender->username;
                }else{
                    $picname = "default_image.png";
                    $from_fullname = "Anonymous";
                    $fromuname = "Anonymous";
                }


                $receiver = User::find($row->to_id);
                if($receiver){
                    $picname2 = $receiver->image;
                    $to_fullname = (isset($receiver->name)) ? $receiver->name : $receiver->username;
                    $touname = $receiver->username;
                }else{
                    $picname2 = "default_image.png";
                    $to_fullname = "Anonymous";
                    $touname = "Anonymous";
                }

                if($row->message_type == 'text')
                    $message_content = $row->message_content;
                else{
                    $content = json_decode($row->message_content);
                    if($content->file_type == 'image'){
                        $file_path = 'storage/user_files/'.$content->file_name;
                        $message_content = '<div class="avatar"><img src="'.asset($file_path).'"/></div>';
                    }else{
                        $message_content = $content->file_type.'/File';
                    }


                }



                $rows = array();
                $rows[] = '<td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-2">
                                        <img class="rounded-circle" alt="'.$fromuname.'" src="'.asset('storage/profile/'.$picname).'" />
                                    </div>
                                    <div>
                                        <span class="text-body fw-semibold text-truncate">'.$from_fullname.'</span>
                                        <p class="text-muted mb-0">@'.$fromuname.'</p>
                                    </div>
                                </div>
                            </td>';
                $rows[] = '<td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-2">
                                        <img class="rounded-circle" alt="'.$touname.'" src="'.asset('storage/profile/'.$picname2).'" />
                                    </div>
                                    <div>
                                        <span class="text-body fw-semibold text-truncate">'.$to_fullname.'</span>
                                        <p class="text-muted mb-0">@'.$touname.'</p>
                                    </div>
                                </div>
                            </td>';
                $rows[] = '<td><p>'.$message_content.'</p></td>';
                $rows[] = '<td>'.date_formating($row->created_at).'</td>';
                $rows[] = '<td>'.$recd_badge.'</td>';
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

        return view('quickchatajax::admin.messages');
    }

    /**
     * Remove multiple resources from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $ids = array_map('intval', $request->ids);
        $messages = Message::whereIn('id', $ids)->get();
        foreach ($messages as $message) {
            if ($message->message_type == "file") {
                $content = json_decode($message->message_content);
                $file_path = 'storage/user_files/'.$content->file_name;
                if (file_exists($file_path)) {
                    remove_file('storage/user_files/'.$content->file_name);
                }
            }
        }
        Message::whereIn('id', $ids)->delete();

        $result = array('success' => true, 'message' => ___('Deleted Successfully'));
        return response()->json($result, 200);
    }
}
