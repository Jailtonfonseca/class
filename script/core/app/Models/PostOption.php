<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostOption extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'post_options';
    public $timestamps = false;

    /**
     * Relationships
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get PostOption by key
     */
    public static function getPostOption($postId, $key, $default = null)
    {
        $option = PostOption::where([['post_id', $postId], ['option_name', $key]])->first();
        if ($option) {
            return $option->option_value;
        }
        return (!empty($default)) ? $default : false;
    }

    /**
     * Update PostOption from table.
     */
    public static function updatePostOption($postId, $key, $value)
    {
        $option = PostOption::where([['post_id', $postId], ['option_name', $key]])->first();
        if ($option) {
            $option->option_value = $value;
            return $option->save();
        } else {
            $option = new PostOption();
            $option->post_id = $postId;
            $option->option_name = $key;
            $option->option_value = $value;
            return $option->save();
        }
    }

}
