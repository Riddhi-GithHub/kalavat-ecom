<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sub_Category;

class Catalog extends Model
{
    protected $table = 'catalogs';
    protected $fillable = ['category_id','sub_category_id',
        'catalog_title','catalog_description','catalog_amount'
        ,'catalog_size','catalog_brand','catalog_unique_id','catalog_image','product_id'
    ];

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function subcategory(){
        return $this->belongsTo(Sub_Category::class,'sub_category_id');
    }
    
}
