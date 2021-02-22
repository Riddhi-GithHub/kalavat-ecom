<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Sub_Category;

class Category extends Model
{

    protected $table = 'categories';
    protected $fillable = [
       'cat_name','id','image'
   ];

    public function product(){
        return $this->hasMany(Product::class,'cat_id');
    }

    public function subcategory(){
        return $this->hasMany(Sub_Category::class,'cat_id');
    }
}
