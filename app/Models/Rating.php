<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Rating_images;
use App\User;

class Rating extends Model
{
    protected $table="ratings";
    protected $primaryKey="id";
    protected $fillable=['id','product_id','user_id','rating_avg','rating_description','rating_images'];
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

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function ratingimages()
   {
       return $this->hasMany('App\Models\Rating_images',"rating_id");
   }     
}
