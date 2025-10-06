<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "currencies";

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'code',
        'name',
        'html_entity',
        'font_arial',
        'font_code2000',
        'unicode_decimal',
        'unicode_hex',
        'in_left',
        'decimal_places',
        'decimal_separator',
        'thousand_separator'
    ];
}
