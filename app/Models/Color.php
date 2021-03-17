<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Category;

class Color extends Model
{
    protected $table = 'colors';
    protected $fillable = [
       'color_cat_id','color_subcat_id','color_product_id','color'
    ];

   public function product(){
        return $this->belongsTo(Product::class,'color_product_id');
   }

   public function category(){
        return $this->belongsTo(Category::class,'color_cat_id');
    }
    
}
