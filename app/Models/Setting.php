<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [

        'shipping_fee',
        'free_shipping',

        'hero_image_1',
        'hero_image_2',
        'hero_image_3',

        'hero_title',
        'hero_subtitle',
        'hero_description',
    ];
}
