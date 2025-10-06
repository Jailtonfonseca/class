<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory, Sluggable;

    const STATUS_ACTIVE = 'active';
    const STATUS_PENDING = 'pending';
    const STATUS_REJECTED = 'rejected';
    const STATUS_EXPIRE = 'expire';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class,'sub_category_id','id');
    }

    public function custom_data()
    {
        return $this->hasMany(CustomData::class, 'post_id');
    }

    public function custom_field_data()
    {
        return $this->belongsToMany(CustomField::class, 'custom_data','post_id', 'field_id')->withPivot(['id','field_data']);
    }

    public function options()
    {
        return $this->hasMany(PostOption::class);
    }

    public function city()
    {
        return $this->belongsTo(Cities::class);
    }

    public function state()
    {
        return $this->belongsTo(Regions::class,'state_id','code');
    }

    public function country()
    {
        return $this->belongsTo(Countries::class,'country_code','code');
    }

    public function hasFavorite(){
        $user = Auth::user();
        if ($user->favorites()->where('post_id', $this->id)->exists()) {
            return true;
        }else{
            return false;
        }
    }
}
