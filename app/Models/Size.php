<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Category;

class Size extends Model
{
    protected $table = 'sizes';
    protected $fillable = [
       'size_cat_id','size_product_id','size'
   ];

   public function product(){
        return $this->belongsTo(Product::class,'size_product_id');
   }
   public function category(){
        return $this->belongsTo(Category::class,'size_cat_id');
    }
    
}
