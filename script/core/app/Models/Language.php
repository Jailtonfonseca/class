<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App;

class Language extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'code',
        'direction',
        'active',
    ];

    public static function set_language($code){
        $language = Language::where(array(
            'code' => $code,
            'active' => '1',
        ))->first();
        if($language){
            App::setLocale($code);
            session()->forget('locale');
            session(['locale' => $code]);
        }
    }
}
