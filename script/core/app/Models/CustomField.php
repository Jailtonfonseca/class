<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'custom_fields';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'order',
        'icon',
        'translation_lang',
        'translation_name',
        'anycat',
        'category_id',
        'sub_category_id',
        'title',
        'type',
        'options',
        'required',
        'use_as_filter',
        'show_in_view',
        'active',
        'name',
        'default',
        'min',
        'max',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'translation_lang' => 'object',
    ];

    public function customData()
    {
        return $this->hasMany(CustomData::class,'field_id','id');
    }

    function get_translated_title(){
        return !empty($this->translation_lang->{get_lang()}->name)
            ? $this->translation_lang->{get_lang()}->name
            : $this->title;
    }
}
