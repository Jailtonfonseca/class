<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function PHPUnit\Framework\isJson;

class Countries extends Model
{
    use HasFactory;

    protected $table = 'countries';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'object',
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

    public function cities()
    {
        return $this->hasMany(Cities::class, 'country_code', 'code');
    }

    public function regions()
    {
        return $this->hasMany(Regions::class, 'country_code', 'code');
    }
}
