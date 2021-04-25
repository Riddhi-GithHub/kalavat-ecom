<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Rating_images;
use App\User;

class Catalog_rating extends Model
{
    protected $table="catalog_rating";
    protected $primaryKey="id";
    protected $fillable=['id','rating_catalog_id','rating_user_id','catalog_rating_avg',
    'catalog_rating_description','catalog_rating_images','catalog_rating_status'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at','updated_at'
    ];

     public function product(){
        return $this->belongsTo(Product::class,'rating_catalog_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'rating_user_id');
    }

    public function ratingimages()
   {
       return $this->hasMany('App\Models\Rating_images',"catalog_rating_id");
   } 
  
   
}
