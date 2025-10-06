<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function PHPUnit\Framework\isJson;

class Cities extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "cities";

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'country_code',
        'name',
        'latitude',
        'longitude',
        'feature_class',
        'feature_code',
        'subadmin1_code',
        'subadmin2_code',
        'population',
        'time_zone',
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

    public function region()
    {
        return $this->belongsTo(Regions::class, 'subadmin1_code', 'code');
    }

    public function district()
    {
        return $this->belongsTo(Districts::class, 'subadmin2_code', 'code');
    }
}
