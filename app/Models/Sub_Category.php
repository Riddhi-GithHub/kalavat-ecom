<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;

class Sub_Category extends Model
{
    protected $table = 'sub_categories';
    protected $fillable = [
       'cat_id','sub_cat_name',
   ];

   public function category(){
       return $this->belongsTo(Category::class,'cat_id');
   }

   public function product(){
    return $this->hasMany(Product::class,'sub_cat_id');
   }

   public function cate()
   {
       return $this->belongsTo('App\Models\Category',"id","id");
   } 
   public function brand(){
         return $this->hasMany(Brand::class,'brand_subcat_id');
   }
}
