<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Sub_Category;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use App\Models\Catalog;

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

    public function color(){
        return $this->hasMany(Color::class,'color_cat_id');
    }

    public function brand(){
        return $this->hasMany(Brand::class,'brand_cat_id');
    }

    public function size(){
        return $this->hasMany(Size::class,'size_cat_id');
    }

    public function catalog(){
        return $this->hasMany(Catalog::class,'category_id');
    }
}
