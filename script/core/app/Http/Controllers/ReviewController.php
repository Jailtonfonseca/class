<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->activeTheme = active_theme();
    }

    /**
     * Display the page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $post_id = $request->has('post_id') ? $request->get('post_id') : 0;

        // show reviews
        $reviews = Review::where(array(
                'publish' => '1',
                'post_id' => $post_id
            ))
            ->with('user')
            ->orderBy('created_at', 'DESC')
            ->get();
        $html = '';
        if(count($reviews)){
            foreach ($reviews as $review) {
                $fullname = $review->user->name;
                $image = $review->user->image;

                $html = '<div class="review"  id="'.$review->id.'">
                            <div class="image">
                                <div class="bg-transfer">
                                    <img src="'.asset('storage/profile/'.$image).'" alt="'.$fullname.'">
                                </div>
                            </div>
                            <div class="description">
                                <figure>
                                    <div class="rating-passive" data-rating="'.$review->rating.'">
                                        <span class="stars"></span>
                                    </div>
                                    <span class="date">'.date_formating($review->created_at).'</span>
                                    <p class="t-body -size-m h-m0 -decoration-reversed">'.$fullname.'</p>
                                </figure>
                                <p>'.$review->comments.'</p>
                            </div>
                        </div>
                    <!--end review-->';
            }
        }else{
            $html = '<p>'.___('There are currently no reviews for this post.').'</p>';
        }
        $result = array('success' => true, 'data' => $html);
        return response()->json($result, 200);
    }


    public function averageRating(Request $request)
    {
        $post_id = $request->has('post_id') ? $request->get('post_id') : 0;
        $star1_result = Review::where(array(
                'rating' => '1', 'publish' => '1', 'post_id' => $post_id
            ))->count();
        $star2_result = Review::where(array(
            'rating' => '2', 'publish' => '1', 'post_id' => $post_id
        ))->count();
        $star3_result = Review::where(array(
            'rating' => '3', 'publish' => '1', 'post_id' => $post_id
        ))->count();
        $star4_result = Review::where(array(
            'rating' => '4', 'publish' => '1', 'post_id' => $post_id
        ))->count();
        $star5_result = Review::where(array(
            'rating' => '5', 'publish' => '1', 'post_id' => $post_id
        ))->count();

        $total = $star1_result + $star2_result + $star3_result + $star4_result + $star5_result;

        if ($total != 0) {
            $rating = ($star1_result*1 + $star2_result*2 + $star3_result*3 + $star4_result*4 + $star5_result*5) / $total;
        } else {
            $rating = 0;
        }

        $rating = round($rating * 2) / 2;

        $html = '<h3>'.___('Average rating').'</h3><p><small><strong>'.$rating.'</strong> '.___('average based on').' <strong>'.$total.'</strong> '.___('Reviews').'.</small></p>
            <div class="rating-passive" data-rating="'.$rating.'">
                <span class="stars"></span>
            </div>';

        $result = array('success' => true, 'data' => $html);
        return response()->json($result, 200);
    }

    public function saveRating(Request $request)
    {
        $post_id = $request->has('post_id') ? $request->get('post_id') : 0;


        $login_error_msg = '<p><strong><font color="red">'.___('Error').':</font></strong> '.___('RATING_LOGIN_EROR').'</p>';
        $error_msg = '<p><strong><font color="red">'.___('Error').':</font></strong> '.___('RATING_SAVE_ERROR').'</p>';
        $success_msg = '<div style="background:#B6FABE; border:solid 1px #82D18B; padding-left:10px;"><p class="saved-success"><strong>'.___('THANKS_YOU').'!</strong> '.___('RATING_SAVED').'<p></div>';

        if(Auth::check()){
            $user_id = request()->user()->id;
            if($post_id != 0 && $user_id != 0) {
                $update = Review::updateOrCreate(
                    [
                        'post_id' => $post_id,
                        'user_id' => $user_id
                    ], [
                        'comments' => $request->message,
                        'rating' => $request->rating,
                        'publish' => '0'
                    ]
                );

                if($update){
                    $result = array('success' => true, 'message' => $success_msg);
                    return response()->json($result, 200);
                }else{
                    $result = array('success' => false, 'message' => $error_msg);
                    return response()->json($result, 200);
                }
            }
        }
        else{
            $result = array('success' => false, 'message' => $login_error_msg);
            return response()->json($result, 200);
        }

        die();
    }
}
