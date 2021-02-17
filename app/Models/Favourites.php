<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Favourites extends Model
{
    protected $table="favourites";
    protected $primaryKey="fav_id";
    protected $fillable=['fav_id','product_id'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at','updated_at'
    ];

     public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
