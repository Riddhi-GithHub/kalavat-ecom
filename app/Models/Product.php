<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Sub_Category;
use App\Models\product_images;
use App\Models\Rating;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
       'cat_id','sub_cat_id','product_name','description','img','price','quantity','offer','color','size','brand',
       'rating_count','sort_desc','size_and_fit','material_and_care','style_note'
   ];

   public function category(){
       return $this->belongsTo(Category::class,'cat_id');
   }

   public function subcategory(){
    return $this->belongsTo(Sub_Category::class,'sub_cat_id');
   }

   public function rating(){
    return $this->belongsTo(Rating::class,'product_id');
   }

   public function brand(){
        return $this->hasMany(Brand::class,'brand_product_id');
   }

    public function size(){
        return $this->hasMany(Size::class,'size_product_id');
    }

    public function color(){
        return $this->hasMany(Color::class,'color_product_id');
    }

   public function images()
   {
       return $this->hasMany('App\Models\product_images',"product_id");
   }            

   public function favourite()
   {
       return $this->hasMany('App\Models\Favourites',"product_id");
   }   

   public function cate()
   {
       return $this->belongsTo('App\Models\Category',"id","id");
   } 
   
   public function manufacturing()
   {
       return $this->hasMany('App\Models\Manufacturing',"product_id");
   }   
}
