<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regions extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "subadmin1";
    protected $primaryKey = "code";
    protected $keyType = 'string';

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'code',
        'country_code',
        'name',
        'active'
    ];

    /**
     * @param $value
     * @return mixed
     */
    public function getNameAttribute($value)
    {
        if (json_validate($value)) {
            $value = json_decode($value);
            if(!empty($value->{get_lang()})){
                return $value->{get_lang()};
            }else{
                return isset($value->en)? $value->en : $value;
            }
        }else{
            return $value;
        }
    }

    public function country()
    {
        return $this->belongsTo(Countries::class, 'country_code', 'code');
    }

    public function cities()
    {
        return $this->hasMany(Cities::class, 'subadmin1_code', 'code');
    }

    public function districts()
    {
        return $this->hasMany(Districts::class, 'subadmin1_code', 'code');
    }
}
