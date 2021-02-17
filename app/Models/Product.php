<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
       'cat_id','product_name','description','images','price','quantity','offer','color','size','brand'
   ];

   public function category(){
       return $this->belongsTo(Category::class,'cat_id');
   }
   
}
