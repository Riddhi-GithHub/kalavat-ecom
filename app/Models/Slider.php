<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = 'sliders';
    protected $fillable = [
        'slider_name','slider_image','type','type_id','offer','discount'
    ];
 
}
