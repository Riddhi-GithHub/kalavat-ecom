<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\product_images;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
       'cat_id','product_name','description','img','price','quantity','offer','color','size','brand'
   ];

   public function category(){
       return $this->belongsTo(Category::class,'cat_id');
   }

   public function images()
   {
       return $this->hasMany('App\Models\product_images',"product_id");
   }             

   public function cate()
   {
       return $this->belongsTo('App\Models\Category',"id","id");
   } 
   
}
