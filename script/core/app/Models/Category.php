<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Sluggable;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'order',
        'icon',
        'picture',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/
    public function posts()
    {
        if (is_admin_url()) {
            return $this->hasMany(Post::class, 'category_id','id');
        } else {
            return $this->hasMany(Post::class, 'category_id','id')
                ->where(array(
                    'status' => Post::STATUS_ACTIVE,
                    'country_code' => get_user_country()
                ));
        }
    }

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    /**
     * Get category's translations
     *
     * @return mixed
     */
    public function translations()
    {
        $translations = CategoryTranslation::where('translation_id',$this->id)
            ->where('category_type','main')
            ->get();
        $array = [];
        foreach($translations as $translation){
            $array[$translation->lang_code]['title'] = $translation->title;
            $array[$translation->lang_code]['slug'] = $translation->slug;
        }
        return array_to_object($array);
    }

    public function get_translated_title(){
        return !empty($this->translations()->{get_lang()}->title)
            ? $this->translations()->{get_lang()}->title
            : $this->name;
    }

    public function get_translated_slug(){
        return !empty($this->translations()->{get_lang()}->slug)
            ? $this->translations()->{get_lang()}->slug
            : $this->slug;
    }

    public static function get_category_id_by_slug($slug){
        $info = Category::where('slug',$slug)->first();
        if($info){
            return $info->id;
        }else{
            $info = CategoryTranslation::where(array(
                    'slug' => $slug,
                    'category_type' => 'main',
                ))->first();

            if($info){
                Language::set_language($info->lang_code);
                return $info->translation_id;
            }
            else
                return 0;
        }
    }
}
