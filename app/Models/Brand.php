<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Category;


class Brand extends Model
{
    protected $table = 'brands';
    protected $fillable = [
       'brand_cat_id','brand_product_id','brand'
   ];

   public function product(){
        return $this->belongsTo(Product::class,'brand_product_id');
   }
   public function category(){
        return $this->belongsTo(Category::class,'brand_cat_id');
    }
    
}
