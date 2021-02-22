<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Sub_Category extends Model
{
    protected $table = 'sub_categories';
    protected $fillable = [
       'cat_id','sub_cat_name','image'
   ];

   public function category(){
       return $this->belongsTo(Category::class,'cat_id');
   }

   public function cate()
   {
       return $this->belongsTo('App\Models\Category',"id","id");
   } 
}
