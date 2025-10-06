<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request, $reviewId = null)
    {
        if ($request->ajax()) {
            $reviewId = $request->get('reviewId');
            $params = $request->all();
            $columns = ['id', 'post_id', 'rating', 'publish'];

            $reviewsQuery = Review::with('post')
                ->orderBy($columns[$params['order'][0]['column']], $params['order'][0]['dir']);

            if ($reviewId !== null) {
                $reviewsQuery->where('id', $reviewId);
            }

            if (!empty($params['search']['value'])) {
                $q = $params['search']['value'];
                $reviewsQuery->where(function ($query) use ($q) {
                    $query->where('rating', 'like', '%' . $q . '%')
                        ->orWhere('post_id', 'like', '%' . $q . '%')
                        ->orWhere('publish', 'like', '%' . $q . '%');
                });
            }

            $totalRecordsQuery = clone $reviewsQuery;
            $totalRecords = $totalRecordsQuery->count();

            $reviews = $reviewsQuery->limit($params['length'])->offset($params['start'])->get();

            $data = [];
            foreach ($reviews as $row) {

                if ($row->publish == 1){
                    $status_badge = '<span class="badge bg-success">'.___('Published').'</span>';
                }else{
                    $status_badge = '<span class="badge bg-danger">'.___('Disabled').'</span>';
                }

                $rows = array();
                $rows[] = '<td>'.$row->id.'</td>';
                $rows[] = '<td>'.Str::limit($row->post->title ?? 'N/A', 20) .'</td>';
                $rows[] = '<td>'.$row->rating.' '.___('Star').'</td>';
                $rows[] = '<td>'.Str::limit($row->comments, 25).'</td>';
                $rows[] = '<td>'.$status_badge.'</td>';
                $rows[] = '<td>
                                <div class="d-flex">
                                    <a href="#" data-url="'.route('admin.reviews.edit', $row->id).'" data-toggle="slidePanel" title="'.___('Edit').'" class="btn btn-default btn-icon" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
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

        return view('admin.reviews.index', compact('reviewId'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $review = Review::find($id);
        return view('admin.reviews.edit',compact('review'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'comments' => ['required'],
            'publish' => ['required'],
            'rating' => ['required', 'numeric']
        ]);

        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        $review = Review::find($id);

        $update = $review->update([
            'user_id' => $review->user_id,
            'publish' => $request->publish,
            'comments' => $request->comments,
            'post_id' => $review->post_id,
            'rating' => $request->rating,
        ]);

        if ($update){
            $result = array('success' => true, 'message' => ___('Updated Successfully'));
            return response()->json($result, 200);
        }
        else {
            quick_alert_error(___('Something Went Wrong'));
            return back();
        }
    }

    /**
     * Remove the multiple resources from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $ids = array_map('intval', $request->ids);
        Review::whereIn('id', $ids)->delete();
        $result = array('success' => true, 'message' => ___('Deleted Successfully'));
        return response()->json($result, 200);
    }
}
