<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "subadmin2";
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
        'subadmin1_code',
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

    public function region()
    {
        return $this->belongsTo(Regions::class, 'subadmin1_code', 'code');
    }

    public function cities()
    {
        return $this->hasMany(Cities::class, 'subadmin2_code', 'code');
    }
}
